/*
 * customer.js
 * Handles the dynamic functionality for the customer screens
 *
 * Author: Matthew Fritz <mattf@burbankparanormal.com>
 */

// load up SocketIO
var io = io('http://localhost:3000', {path: '/socket-io-coffee'});

$(document).ready(function() {
	// send a message to join the appropriate room
	let uid = $("html").attr("data-user-id");
	io.emit('joinRoom', {room_id: uid});

	// an order item has been marked as complete
	io.on('orderItemComplete', function(data) {
		console.log("Barista has marked an order item as complete");

		let row = $("#order-" + data.order_id + "-product-" + data.product_id);
		row.css("background-color", "#ddffdd");
		row.find(".badge").removeClass('badge-default').addClass('badge-success').html("Complete");
	});
});