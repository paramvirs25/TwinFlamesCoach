class TfcImportJavascripts {
    static importDropboxScript() {
        if (!TfcImportJavascripts.dropboxScriptLoaded) {
            var script = document.createElement('script');
            script.src = 'https://www.dropbox.com/static/api/2/dropins.js';
            script.id = 'dropboxjs';
            script.setAttribute('data-app-key', 'z2xhg87mpzhvs3n');
            script.defer = true;
            document.head.appendChild(script);
            TfcImportJavascripts.dropboxScriptLoaded = true;
        }
    }

    static checkAndImportDropboxScript() {
        var dropboxSaverLinks = document.querySelectorAll('a.dropbox-saver');
        if (dropboxSaverLinks.length > 0) {
            TfcImportJavascripts.importDropboxScript();
        }
    }
}

// Set the initial value for dropboxScriptLoaded property
TfcImportJavascripts.dropboxScriptLoaded = false;

window.addEventListener('load', function () {
    // Call the method on page load (frontend only)
    if (typeof wp.element === 'undefined') {
        TfcImportJavascripts.checkAndImportDropboxScript();
    }
});

