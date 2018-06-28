/*
	npm init
	npm install ws
*/

function transmit(data, acceptor_id){
	wss.clients.forEach(ws => {
		
		//once we've found the right user to send to
		if(ws.sender_id && ws.sender_id == acceptor_id){
			ws.send(data);
			return true;
		}
	});
}
function get_num_clients(room_id){
	var num_clients = 0;
	
	wss.clients.forEach(ws => {
		if(ws.room_id == room_id){
			num_clients++;
		}
	});
	
	return num_clients;
}

const fs = require('fs');
const https = require('https');
const WebSocket = require('../../nodejs/node_modules/ws');
 
const server = new https.createServer({
  cert: fs.readFileSync('/home/ecarlson10/mycerts/ecarlson10.webfactional.com_cert.pem'),
  key: fs.readFileSync('/home/ecarlson10/mycerts/ecarlson10.webfactional.com_key.pem'),
});
const wss = new WebSocket.Server({ server });
 
//this function is ran everytime a user connects
wss.on('connection', ws => {
	ws.on('message', data => {
		if(data){			
			try{
				var init_info = JSON.parse(data);
				if(init_info.sender_id && init_info.acceptor_id && init_info.room_id){
					ws.sender_id = init_info.sender_id;
					ws.acceptor_id = init_info.acceptor_id;
					ws.room_id = init_info.room_id;
					ws.send(JSON.stringify({
						num_clients: get_num_clients(ws.room_id),
					}));
					return true;
				}
			}
			catch(e){}
			transmit(data, ws.acceptor_id);
		}
	});
});
 
server.listen(22316, "ecarlson10.webfactional.com");