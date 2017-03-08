/*
 * barista.js
 * Handles the dynamic functionality for the barista screens
 *
 * Author: Matthew Fritz <mattf@burbankparanormal.com>
 */

$(document).ready(function() {
	// delegated event handler on the Mark Complete buttons
	$("#pending-orders").on("click", ".btn-item-complete", function() {
		let productId = $(this).prevAll(".product-id").first().val();
		let orderId = $(this).prevAll(".order-id").first().val();

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
				}
				else
				{
					alert("An error occurred. Please try again");
				}
			}
		});
	});
});