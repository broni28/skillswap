var origin = "wss://ecarlson10.webfactional.com:22316";
var ws = new WebSocket(origin);
var sender_id = "you";
var acceptor_id = "me";

function send_message(){
	var message = $("#new-message").val();
	$("#new-message").val("");
	ws.send(message);
}

ws.onopen = event => {
	ws.send(JSON.stringify({
		"sender_id": sender_id,
		"acceptor_id": acceptor_id,
	}));
}
ws.onmessage = event => {
	console.log(event);
}

console.log("sender_id: " + sender_id + ", acceptor_id: " + acceptor_id);