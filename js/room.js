var creating_offer = true;
$("#offer").text(creating_offer);
const configuration = {
  iceServers: [{
    urls: 'stun:stun.l.google.com:19302'
  }]
};
var localVideo = document.getElementById("local-video");
var remoteVideo = document.getElementById("remote-video");
var sender_id = $("#sender_id").val();
var acceptor_id = $("#acceptor_id").val();
var ws = new WebSocket("wss://ecarlson10.webfactional.com:22316");
function onOfferCreated(desc){
	pc.setLocalDescription(
		desc,
		//if local description is successfully created
		() => {
			var message = JSON.stringify({"sdp": pc.localDescription});
			ws.send(message);
		},
		onError
	);
}
function onError(err){
	console.log("Error: " + err);
}

// Connection opened
ws.addEventListener('open', function (event) {
	
	//lets the server know who the sender and acceptor are
	ws.send(JSON.stringify({
		"sender_id": sender_id,
		"acceptor_id": acceptor_id,
	}));
	
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
		if(creating_offer){
			console.log("Creating offer");
			pc.createOffer(onOfferCreated, onError);
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
	}, onError);
	
	
});

// Listen for messages
ws.addEventListener('message', function (event) {
	json_parse = JSON.parse(event.data);
	
	if(json_parse.sdp){
		pc.setRemoteDescription(new RTCSessionDescription(json_parse.sdp), () => {
			if (pc.remoteDescription.type === 'offer') {
			  pc.createAnswer().then(onOfferCreated).catch(onError);
			}
		}, onError);
	}
	else if(json_parse.candidate){
		// Add the new ICE candidate to our connections remote description
		console.log("Adding ICE candidate:", json_parse.candidate);
		pc.addIceCandidate(
			new RTCIceCandidate(json_parse.candidate), function(){}, onError
		);
	}
});