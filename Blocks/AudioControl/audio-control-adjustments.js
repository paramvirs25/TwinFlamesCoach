document.addEventListener('DOMContentLoaded', function () {

    // Get all audio tags on the page
    var audioTags = document.querySelectorAll('audio');

    audioTags.forEach(function (audioTag) {
        // Extract the ID from the src URL using a regex
        var match = audioTag.src.match(/id=([^&]+)/);

        if (match && match[1]) {
            var fileId = match[1];

            // Create an iframe element
            var iframe = document.createElement('iframe');
            iframe.width = '100%';
            iframe.height = '170';
            iframe.allow = 'autoplay';
            
            // Set the src attribute of the iframe
            iframe.src = 'https://drive.google.com/file/d/' + fileId + '/preview';

            // Insert the iframe after the audio tag
            audioTag.parentNode.insertBefore(iframe, audioTag.nextSibling);

            // Hide the original audio tag
            audioTag.style.display = 'none';
        }
    });

    //--Hide Dropbox button

    // Select all anchor tags with the class 'dropbox-saver'
    const dropboxLinks = document.querySelectorAll('a.dropbox-saver');

    // Loop through the selected anchor tags
    dropboxLinks.forEach(link => {
    // Find the parent paragraph element
    const parentParagraph = link.closest('p');

    // If a parent paragraph exists, hide it
    if (parentParagraph) {
        parentParagraph.style.display = 'none';
    }
    });

});
