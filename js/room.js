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
var both_joined = false;
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
	$("\
	<div class='chat-box-container' style='margin-left:auto;'>\
		<div class='text-right'>\
			<div class='chat-timestamp'>3:36 PM</div>\
			<div class='chat-username'>Evan Carlson</div>\
		</div>\
		<div class='overflow'>\
			<img src='images/evan.jpg' class='chat-profile'>\
			<div class='chat-bubble-right'>" + escape_html(message) + "</div>\
		</div>\
	</div>\
	").hide().appendTo("#chatroom-box").fadeIn(500);
	$("#chatroom-box").scrollTop($("#chatroom-box")[0].scrollHeight);
}
function accept_chat_message(message){
	$("\
	<div class='chat-box-container' style='margin-right:auto;'>\
		<div class='text-right'>\
			<div class='chat-timestamp'>3:36 PM</div>\
			<div class='chat-username'>Evan Carlson</div>\
		</div>\
		<div class='overflow'>\
			<img src='images/evan.jpg' class='chat-profile'>\
			<div class='chat-bubble-left'>" + escape_html(message) + "</div>\
		</div>\
	</div>\
	").hide().appendTo("#chatroom-box").fadeIn(500);
	$("#chatroom-box").scrollTop($("#chatroom-box")[0].scrollHeight);
}

// Connection opened
ws.onopen = event => {
	
	send_chat_message("You have joined the room.");
	
	//lets the server know who the sender and acceptor are
	ws.send(JSON.stringify({
		"sender_id": sender_id,
		"acceptor_id": acceptor_id,
		"room_id": room_id,
	}));
}

// Listen for messages
ws.onmessage = event => {
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
		if(!both_joined){			
			accept_chat_message("Other person has joined the room.");
			both_joined = true;
		}
	}
	else if(json_parse.num_clients){
		var num_clients = json_parse.num_clients;
		
		pc = new RTCPeerConnection(configuration);
		
		pc.onicecandidate = e => {
			if (e.candidate) {
				var message = JSON.stringify({'candidate': e.candidate});
				console.log("Message to server: " + message);
				ws.send(message);
			}
		}
		
		pc.onnegotiationneeded = () => {
			
			//The second person to join the room creates the offer
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
			setTimeout(() => {
				$("#remote-video").removeClass("effect-video")
			}, 1000);
		};
		
		navigator.mediaDevices.getUserMedia({
			/* video: {
				mediaSource: "screen", // whole screen sharing
				width: {max: '1920'},
				height: {max: '1080'}
			}, */
			video: {
				aspectRatio: 1 / 0.7
			},
			audio: true
		}).then(stream => {
			// Display your local video in #localVideo element
			localVideo.srcObject = stream;
			// Add your stream to be sent to the conneting peer
			stream.getTracks().forEach(track => pc.addTrack(track, stream));
		}, on_error);
	}
	else if(json_parse.chat_message){
		accept_chat_message(json_parse.chat_message);
	}
}