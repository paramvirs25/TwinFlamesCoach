class TfcImportJavascripts {
  static loadCSS(cssUrl) {
    var cssLink = document.createElement('link');
    cssLink.href = cssUrl;
    cssLink.rel = 'preload';
    cssLink.as = 'style';
    cssLink.onload = function () {
      this.rel = 'stylesheet';
    };
    document.head.appendChild(cssLink);
  }

  static loadJS(jsUrl) {
    var script = document.createElement('script');
    script.src = jsUrl;
    script.defer = true;
    document.head.appendChild(script);
  }

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

  static importKiokenAccordionFixScriptCss() {
    // Check if there are any elements with the class 'wp-block-kioken-accordion-item' on the page
    var kiokenAccordionItems = document.querySelectorAll('.wp-block-kioken-accordion-item');
    if (kiokenAccordionItems.length > 0 && !TfcImportJavascripts.kiokenAccordionFixScriptLoaded) {

      this.loadCSS('https://paramvirs25.github.io/TwinFlamesCoach/Css/KiokenAccordionFix.css');
      this.loadJS('https://paramvirs25.github.io/TwinFlamesCoach/Javascript/KiokenAccordionFix.js');

      TfcImportJavascripts.kiokenAccordionFixScriptLoaded = true;
      console.log("importKiokenAccordionFixScript");
    }
  }

  static importKiokenTabsFixScriptCss() {
    // Check if there are any elements with the class 'wp-block-kioken-tabs' on the page
    var kiokenTabsItems = document.querySelectorAll('.wp-block-kioken-tabs');
    if (kiokenTabsItems.length > 0 && !TfcImportJavascripts.kiokenTabsFixScriptLoaded) {
      this.loadCSS('https://paramvirs25.github.io/TwinFlamesCoach/Css/KiokenTabFix.css');
      this.loadJS('https://paramvirs25.github.io/TwinFlamesCoach/Javascript/KiokenTabsJSFix.js');

      TfcImportJavascripts.kiokenTabsFixScriptLoaded = true;
      console.log("importKiokenTabsFixScriptCss");
    }
  }
}

// Set the initial values
TfcImportJavascripts.dropboxScriptLoaded = false;
TfcImportJavascripts.kiokenAccordionFixScriptLoaded = false;
TfcImportJavascripts.kiokenTabsFixScriptLoaded = false;

window.addEventListener('load', function () {
  // Call the methods on page load (frontend only)
  if (typeof wp.element === 'undefined') {
    TfcImportJavascripts.importDropboxScript();
    TfcImportJavascripts.importKiokenAccordionFixScriptCss();
    TfcImportJavascripts.importKiokenTabsFixScriptCss();
  }
});
