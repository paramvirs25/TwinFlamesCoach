class TfcImportJavascripts {
    static importDropboxScript() {
      if (!TfcImportJavascripts.dropboxScriptLoaded) {
        // Check if there are any dropbox-saver links on the page
        var dropboxSaverLinks = document.querySelectorAll('a.dropbox-saver');
        if (dropboxSaverLinks.length > 0) {
          var script = document.createElement('script');
          script.src = 'https://www.dropbox.com/static/api/2/dropins.js';
          script.id = 'dropboxjs';
          script.setAttribute('data-app-key', 'z2xhg87mpzhvs3n');
          script.defer = true;
          document.head.appendChild(script);
          TfcImportJavascripts.dropboxScriptLoaded = true;
        }
      }
    }
  
    static importKiokenAccordionFixScript() {
      // Check if there are any elements with the class 'wp-block-kioken-accordion-item' on the page
      var kiokenAccordionItems = document.querySelectorAll('.wp-block-kioken-accordion-item');
      if (kiokenAccordionItems.length > 0 && !TfcImportJavascripts.kiokenAccordionFixScriptLoaded) {
        var script = document.createElement('script');
        script.src = 'https://paramvirs25.github.io/TwinFlamesCoach/Javascript/KiokenAccordionFix.js';
        script.defer = true;
        document.head.appendChild(script);
        TfcImportJavascripts.kiokenAccordionFixScriptLoaded = true;
        console.log("importKiokenAccordionFixScript");
      }
    }
  }
  
  // Set the initial values
  TfcImportJavascripts.dropboxScriptLoaded = false;
  TfcImportJavascripts.kiokenAccordionFixScriptLoaded = false;
  
  window.addEventListener('load', function () {
    // Call the methods on page load (frontend only)
    if (typeof wp.element === 'undefined') {
      TfcImportJavascripts.importDropboxScript();
      TfcImportJavascripts.importKiokenAccordionFixScript();
    }
  });
  