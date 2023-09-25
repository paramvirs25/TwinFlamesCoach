jQuery(document).ready(function($) {
    //Import Jquery UI
  TfcImportJavascripts.loadCSS("https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css",new Array(".single_add_to_cart_button"));
  TfcImportJavascripts.loadJS("https://code.jquery.com/ui/1.12.1/jquery-ui.js",".single_add_to_cart_button");
  
	// Function to open the magical window on button click
	$("body").on("click", ".single_add_to_cart_button", function() {

        // Check if there's an element with class "confirmationPopup"
      if ($(".confirmationPopup").length) {
		
		event.preventDefault(); // Prevent the default form submission
		
		// Customize the content inside the magical window here
		var magicalContent = $(".confirmationPopup").html();

		// Create the magical window
		$("<div>").html(magicalContent).dialog({
			modal: true,
			title: "Confirmation",
			buttons: {
				"PROCEED": {
                    text: "PROCEED",
                    class: "confirmButton",
                    click: function() {
                        // Perform the "Add to Cart" action here
                        // You can put your WooCommerce code here
                        $(this).dialog("close");
					
                        // Now, you can trigger the form submission
                        $(".single_add_to_cart_button").unbind('click').click();
                    }
				},
				"CANCEL": function() {
					// Close the magical window without any action
					$(this).dialog("close");
				}
			}
		});
      }
    });
});