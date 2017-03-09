/*
 * customer.js
 * Handles the dynamic functionality for the customer screens
 *
 * Author: Matthew Fritz <mattf@burbankparanormal.com>
 */

// load up SocketIO
var io = io('http://localhost:3000', {path: '/socket-io-coffee'});

// provide a function from which to spawn notifications (seems only to work in Chrome)
function spawnNotification(theBody, theTitle) {
	console.log("Displaying notification");
  var options = {
    body: theBody,
    icon: ""
  };

  // spawn the notification and then set a four-second timeout after which
  // to close the notification
  var n = new Notification(theTitle, options);
  setTimeout(n.close.bind(n), 4000);
}

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

		// spawn the notification
		spawnNotification("One of your items is complete!", "Order " + data.order_id + " updated");
	});

	// request notification permissions for the HTML5 Notifications API
	// using the "promise" syntax
	Notification.requestPermission().then(function(result) {
	  console.log("Notifications allowed? " + result);
	});
});