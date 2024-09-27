console.log('AutoClickLink.js Start');

// Wait for the DOM to fully load
document.addEventListener("DOMContentLoaded", function() {
    // Get the first anchor tag with the class 'auto-click-link'
    const firstAutoClickLink = document.querySelector('a.auto-click-link');

    // If the link exists, trigger a click on it
    if (firstAutoClickLink) {
        firstAutoClickLink.click();
    }
});

console.log('AutoClickLink.js End');