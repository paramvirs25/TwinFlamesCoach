class TfcImportJavascripts {
  
  static loadedCSSUrl = []; // Array to store the loaded CSS URLs

  static loadCSS(cssUrl, querySelector) {
    // Check if the cssUrl is already present in the loadedCSSUrl array
    if (TfcImportJavascripts.loadedCSSUrl.includes(cssUrl)) {
      return; // Do nothing if the CSS is already loaded
    }

    if (querySelector == "" || document.querySelectorAll(querySelector).length > 0) {
      var cssLink = document.createElement('link');
      cssLink.href = cssUrl;
      cssLink.rel = 'preload';
      cssLink.as = 'style';
      cssLink.onload = function () {
        this.rel = 'stylesheet';
      };
      document.head.appendChild(cssLink);

      console.log("Loaded CSS " +cssUrl);

      // Add the cssUrl to the loadedCSSUrl array
      TfcImportJavascripts.loadedCSSUrl.push(cssUrl);
    }
  }


  static loadedJsUrl = []; // Array to store the loaded JavaScript URLs

  static loadJS(jsUrl, querySelector) {
    // Check if the jsUrl is already present in the loadedJsUrl array
    if (TfcImportJavascripts.loadedJsUrl.includes(jsUrl)) {
      return; // Do nothing if the JavaScript is already loaded
    }

    var jsItems = document.querySelectorAll(querySelector);
    if (jsItems.length > 0) {
      var script = document.createElement('script');
      script.src = jsUrl;
      script.defer = true;
      document.head.appendChild(script);

      console.log("Loaded Js " + jsUrl);

      // Add the jsUrl to the loadedJsUrl array
      TfcImportJavascripts.loadedJsUrl.push(jsUrl);
    }
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

}

// Set the initial values
TfcImportJavascripts.dropboxScriptLoaded = false;

window.addEventListener('load', function () {
  // Call the methods on page load (frontend only)
  // WP is undefined in frontend, 
  // but if user is logged in as admin and try to see frontend then wp is defined.
  // So we check both wp and wp.element
  if (typeof wp === 'undefined' || typeof wp.element === 'undefined') {
    TfcImportJavascripts.importDropboxScript();

    //Scroll Utility JS
    TfcImportJavascripts.loadJS('https://paramvirs25.github.io/TwinFlamesCoach/Javascript/ScrollUtils.js', '');    

    TfcImportJavascripts.loadCSS("https://paramvirs25.github.io/TwinFlamesCoach/Css/Tiles3d.css", '.tfcTileRow');

    //Details Block (Gutenberg accordian)
    TfcImportJavascripts.loadCSS("https://paramvirs25.github.io/TwinFlamesCoach/Css/DetailsBlock.css", '.wp-block-details');

    //KiokenAccordionFix
    TfcImportJavascripts.loadCSS("https://paramvirs25.github.io/TwinFlamesCoach/Css/KiokenAccordionFix.css", '.wp-block-kioken-accordion-item');
    TfcImportJavascripts.loadJS('https://paramvirs25.github.io/TwinFlamesCoach/Javascript/KiokenAccordionFix.js', '.wp-block-kioken-accordion-item');    

    //KiokenTabsFix
    TfcImportJavascripts.loadCSS("https://paramvirs25.github.io/TwinFlamesCoach/Css/KiokenTabFix.css",".wp-block-kioken-tabs");
    TfcImportJavascripts.loadJS("https://paramvirs25.github.io/TwinFlamesCoach/Javascript/KiokenTabsJSFix.js",".wp-block-kioken-tabs");
    
    TfcImportJavascripts.loadCSS("https://paramvirs25.github.io/TwinFlamesCoach/Css/Buttons.css", 'a.wp-block-button__link.wp-element-button');
    TfcImportJavascripts.loadCSS("https://paramvirs25.github.io/TwinFlamesCoach/Css/HorizontalScroll.css", ".tfcScrollHorizRow");
    TfcImportJavascripts.loadCSS("https://paramvirs25.github.io/TwinFlamesCoach/Css/VisualLinkPreview.css", ".vlp-link-summary");
  }
});
