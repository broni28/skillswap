const configuration = {
	"iceServers":[
		{"urls":[
			"stun:64.233.169.127:19302",
			"stun:[2607:f8b0:4003:c08::7f]:19302"
		]},
		{"urls":[
			"turn:64.233.169.127:19305?transport=udp",
			"turn:[2607:f8b0:4003:c08::7f]:19305?transport=udp",
			"turn:64.233.169.127:19305?transport=tcp",
			"turn:[2607:f8b0:4003:c08::7f]:19305?transport=tcp"],
			"username":"CIif/9kFEgYHQFzPVHUYzc/s6OMTIICjBQ",
			"credential":"ox66ZJmDefjUSGsNAHyCcW7y2Ho="
		}
	]
};
var pc;
var local_video = document.getElementById("local-video");
var remote_video = document.getElementById("remote-video");
var sender_id = $("#sender_id").val();
var acceptor_id = $("#acceptor_id").val();
var room_id = $("#room_id").val();
var num_clients = 0;
var both_joined = false;
var offer_created = false;
var toggle_streaming = true;
var ws = new WebSocket("wss://ecarlson10.webfactional.com:25812");
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
			console.log("Settings local description: ", message);
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
			<div class='chat-timestamp'>" + get_timestamp() + "</div>\
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
			<div class='chat-timestamp'>" + get_timestamp() + "</div>\
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
function get_timestamp(){
	var date = new Date();
	var hours = date.getHours();
	var minutes = date.getMinutes();
	var ampm;
	if(hours > 12){
		hours -= 12;
		ampm = "PM";
	}
	else{
		ampm = "AM";
	}
	if(minutes < 10){
		minutes = "0" + minutes;
	}
	
	return hours + ":" + minutes + " " + ampm;
}
function get_user_media(){
	navigator.mediaDevices.getUserMedia({
		/* video: {
			mediaSource: "screen", // whole screen sharing
			width: {max: '1920'},
			height: {max: '1080'}
		}, */
		video: true,
		audio: true
	}).then(stream => {
		// Display your local video in #local_video element
		local_video.srcObject = stream;
		// Add your stream to be sent to the conneting peer
		stream.getTracks().forEach(track => pc.addTrack(track, stream));
	}, on_error);
}

/*----BUTTONS----*/
function toggle_connect(){
	
	//enable or disable stream depending on the global toggle_streaming variable
	if(local_video.srcObject){		
		var tracks = local_video.srcObject.getTracks();
		if(toggle_streaming == true){
			toggle_streaming = false;
			tracks.forEach(track => {
				track.stop();
			});
			
			$("#toggle").addClass("toggle-off");
			$("#toggle-inner").addClass("toggle-off-inner");
		}
		else{
			toggle_streaming = true;
			offer_created = false;
			get_user_media();
			
			$("#toggle").removeClass("toggle-off");
			$("#toggle-inner").removeClass("toggle-off-inner");
		}
	}
}
function toggle_fullscreen(){
	var video = $("#remote-video");
	if(video.hasClass("fullscreen")){
		video.removeClass("fullscreen");
	}
	else{
		video.addClass("fullscreen");
	}
}

// Connection opened
ws.onopen = event => {
	
	accept_chat_message("You have joined the room.");
	
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
			if(pc.remoteDescription.type === 'offer'){
				console.log("Creating answer");
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
			$("#loading-message").fadeOut(() => {
				$("#loading-message-success").fadeIn(800).fadeOut(800).fadeIn(800).fadeOut(800).fadeIn(800).fadeOut(800);
			});
			both_joined = true;
		}
	}
	else if(json_parse.num_clients){
		num_clients = json_parse.num_clients;
		
		console.log("Num Clients: " + num_clients);
		
		pc = new RTCPeerConnection(configuration);
		
		pc.onicecandidate = e => {
			console.log("onicecandidate: ", e);
			if(e.candidate){
				var message = JSON.stringify({'candidate': e.candidate});
				ws.send(message);
			}
			else{
				console.log("All candidates have been sent");
			}
		}
		
		pc.onsignalingstatechange = event => {
			console.log("onsignalingstatechange", event);
		}
		
		pc.onnegotiationneeded = () => {
			console.log("onnegotiationneeded");
			
			//The second person to join the room creates the offer
			if(num_clients == 2){
				if(!offer_created){
					offer_created = true;
					pc.createOffer(on_offer_created, on_error);
				}
			}
		}
		
		// When a remote stream arrives display it in the #remote_video element
		pc.ontrack = event => {
			console.log("ontrack:", event);
			
			const stream = event.streams[0];
			remote_video.srcObject = stream;
			setTimeout(() => {
				$("#remote-video").removeClass("effect-video")
			}, 1000);
		}
		
		get_user_media();
	}
	else if(json_parse.chat_message){
		accept_chat_message(json_parse.chat_message);
	}
}