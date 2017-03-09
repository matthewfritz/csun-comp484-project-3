let app = require('http').createServer(); // create HTTP server
let io = require('socket.io')(app, {path: '/socket-io-coffee'}); // bind Socket to HTTP server
app.listen(3000); // listen on port 3000
console.log('Listening for connections on port 3000');
io.on('connection', function(socket) {
   console.log('Socket connected');

   // allow the customer to join a room
   socket.on('joinRoom', function(data) {
   	socket.join(data.room_id);
   	console.log("Customer joined room " + data.room_id);
   });

   // barista will send messages that mark order items as complete and then
   // the customer will receive a message called orderItemComplete in response
   socket.on('markOrderItemComplete', function(data) {
   	console.log("Barista marked order item complete. Order: " + data.order_id + "; Product: " + data.product_id);
   	socket.in(data.user_id).emit('orderItemComplete', data);
   });
});