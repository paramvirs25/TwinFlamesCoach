jQuery(document).ready(function($) {
	// Function to open the magical window on button click
	$("body").on("click", ".single_add_to_cart_button", function() {
		
		event.preventDefault(); // Prevent the default form submission
		
		// Customize the content inside the magical window here
		var magicalContent = "<p>Are you sure you want to proceed?</p>";

		// Create the magical window
		$("<div>").html(magicalContent).dialog({
			modal: true,
			title: "Confirmation",
			buttons: {
				"PROCEED": function() {
					// Perform the "Add to Cart" action here
					// You can put your WooCommerce code here
					//alert("Item added to cart!");
					$(this).dialog("close");
					
					// Now, you can trigger the form submission
              		$(".single_add_to_cart_button").unbind('click').click();
				},
				"CANCEL": function() {
					// Close the magical window without any action
					$(this).dialog("close");
				}
			}
		});
	});
});