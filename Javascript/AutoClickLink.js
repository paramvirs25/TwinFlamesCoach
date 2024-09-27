function autoClickLinkTFC() {
    console.log('AutoClickLink.js Start');

    // Get the first anchor tag with the class 'auto-click-link'
    const firstAutoClickLink = document.querySelector('a.auto-click-link');

    // Check if the element exists
    if (firstAutoClickLink) {
        console.log("Auto-click link found:", firstAutoClickLink);
        
        // Add a short delay before clicking (optional)
        setTimeout(function() {
            firstAutoClickLink.click();
            console.log("Clicked the auto-click link.");
        }, 500); // Delay of 500ms
    } else {
        console.log("No auto-click link found.");
    }

    console.log('AutoClickLink.js End');
}

autoClickLinkTFC();