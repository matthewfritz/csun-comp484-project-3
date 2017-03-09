/*
 * barista.js
 * Handles the dynamic functionality for the barista screens
 *
 * Author: Matthew Fritz <mattf@burbankparanormal.com>
 */

// load up SocketIO
var io = io('http://localhost:3000', {path: '/socket-io-coffee'});

$(document).ready(function() {
	// delegated event handler on the Mark Complete buttons
	$("#pending-orders").on("click", ".btn-item-complete", function() {
		let productId = $(this).prevAll(".product-id").first().val();
		let orderId = $(this).prevAll(".order-id").first().val();
		let userId = $(this).prevAll(".user-id").first().val();

		// define a reference to this button for scoping purposes
		let btn = $(this);

		// fire off the AJAX request
		$.ajax({
			method: 'POST',
			url: 'api/completeOrderItem.php',
			data: 'completed=1&product-id=' + productId + '&order-id=' + orderId,
			dataType: 'json',
			success: function(data) {
				// replace the button with a success badge if the update was successful
				if(data.success == "true") {
					btn.parent(".item-status").html(
						"<span class=\"badge badge-success\">Complete!</span>"
					);

					// fire off the socket message to the server to mark the item as complete
					io.emit("markOrderItemComplete", {
						order_id: orderId,
						product_id: productId,
						user_id: userId
					});
				}
				else
				{
					alert("An error occurred. Please try again");
				}
			}
		});
	});
});