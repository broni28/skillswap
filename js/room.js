const configuration = {
  iceServers: [{
    urls: 'stun:stun.l.google.com:19302'
  }]
};
var localVideo = document.getElementById("local-video");
var remoteVideo = document.getElementById("remote-video");
var sender_id = $("#sender_id").val();
var acceptor_id = $("#acceptor_id").val();
var room_id = $("#room_id").val();
var ws = new WebSocket("wss://ecarlson10.webfactional.com:22316");
function escape_html(text) {
  var map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;'
  };

  return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}
function on_offer_created(desc){
	pc.setLocalDescription(
		desc,
		//if local description is successfully created
		() => {
			var message = JSON.stringify({"sdp": pc.localDescription});
			ws.send(message);
		},
		on_error
	);
}
function on_error(err){
	console.log("Error: " + err);
}
function get_key(e){
	if(e.keyCode == 13){
		var message = $("#chat-textarea").val();
		if(message.trim()){			
			send_chat_message(message);
			return false;
		}
		else{
			return false;
		}
	}
}
function send_chat_message(message){
	ws.send(JSON.stringify({
		chat_message: message,
	}));
	$("#chat-textarea").val("");
	$("#chatroom-box").append("\
	<div style='width:92%;margin-left:auto;margin-bottom:15px;'>\
		<div style='text-align:right;'>\
			<div style='display:inline-block;color:#ccc;'>3:36 PM</div>\
			<div style='display:inline-block;'>Evan Carlson</div>\
		</div>\
		<div style='padding:8px;border-radius:4px;background:#deebf7;'>" + escape_html(message) + "</div>\
	</div>\
	");
}

// Connection opened
ws.addEventListener('open', function (event) {
	
	send_chat_message("You have joined the room.");
	
	//lets the server know who the sender and acceptor are
	ws.send(JSON.stringify({
		"sender_id": sender_id,
		"acceptor_id": acceptor_id,
		"room_id": room_id,
	}));
	
});

// Listen for messages
ws.addEventListener('message', function (event) {
	var json_parse = JSON.parse(event.data);
	
	if(json_parse.sdp){
		pc.setRemoteDescription(new RTCSessionDescription(json_parse.sdp), () => {
			if (pc.remoteDescription.type === 'offer') {
			  pc.createAnswer().then(on_offer_created).catch(on_error);
			}
		}, on_error);
	}
	else if(json_parse.candidate){
		// Add the new ICE candidate to our connections remote description
		console.log("Adding ICE candidate:", json_parse.candidate);
		pc.addIceCandidate(
			new RTCIceCandidate(json_parse.candidate), function(){}, on_error
		);
	}
	else if(json_parse.num_clients){
		var num_clients = json_parse.num_clients;
		$("#num-clients").text(num_clients);
		
		pc = new RTCPeerConnection(configuration);
		
		pc.onicecandidate = e => {
			if (e.candidate) {
				var message = JSON.stringify({'candidate': e.candidate});
				console.log("Message to server: " + message);
				ws.send(message);
			}
		}
		
		pc.onnegotiationneeded = () => {
			
			//false then true
			if(num_clients == 2){
				console.log("Creating offer");
				pc.createOffer(on_offer_created, on_error);
			}
		}
		
		// When a remote stream arrives display it in the #remoteVideo element
		pc.ontrack = event => {
			console.log("Remote stream has arrived:", event);
			const stream = event.streams[0];
			if (!remoteVideo.srcObject || remoteVideo.srcObject.id !== stream.id) {
				console.log("ADDING: ", stream);
				remoteVideo.srcObject = stream;
			}
		};
		
		navigator.mediaDevices.getUserMedia({
			/* video: {
				mediaSource: "screen", // whole screen sharing
				width: {max: '1920'},
				height: {max: '1080'}
			}, */
			video: true,
			audio: true
		}).then(stream => {
			// Display your local video in #localVideo element
			localVideo.srcObject = stream;
			// Add your stream to be sent to the conneting peer
			stream.getTracks().forEach(track => pc.addTrack(track, stream));
		}, on_error);
	}
	else if(json_parse.chat_message){
		$("#chatroom-box").append("\
		<div style='width:92%;margin-right:auto;margin-bottom:15px;'>\
			<div style='text-align:right;'>\
				<div style='display:inline-block;color:#ccc;'>3:36 PM</div>\
				<div style='display:inline-block;'>Brandon Lalonde</div>\
			</div>\
			<div style='padding:8px;border-radius:4px;background:#f5dede;'>" + escape_html(json_parse.chat_message) + "</div>\
		</div>\
		");
	}
});