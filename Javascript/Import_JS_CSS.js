class TfcImportJavascripts {
  
  static loadedCSSUrl = []; // Array to store the loaded CSS URLs

  static loadCSS(cssUrl, querySelectors) {
    // Check if the cssUrl is already present in the loadedCSSUrl array
    if (TfcImportJavascripts.loadedCSSUrl.includes(cssUrl)) {
      return; // Do nothing if the CSS is already loaded
    }

    if (Array.isArray(querySelectors) && querySelectors.length > 0) {
      let shouldLoad = false;
      for (const selector of querySelectors) {
        if (selector === "" || document.querySelectorAll(selector).length > 0) {
          shouldLoad = true;
          break;
        }
      }

      if (shouldLoad) {
        var cssLink = document.createElement('link');
        cssLink.href = cssUrl;
        cssLink.rel = 'preload';
        cssLink.as = 'style';
        cssLink.onload = function () {
          this.rel = 'stylesheet';
        };
        document.head.appendChild(cssLink);

        console.log("Loaded CSS " + cssUrl);

        // Add the cssUrl to the loadedCSSUrl array
        TfcImportJavascripts.loadedCSSUrl.push(cssUrl);
      }
    }
  }



  static loadedJsUrl = []; // Array to store the loaded JavaScript URLs

  static loadJS(jsUrl, querySelector) {
    // Check if the jsUrl is already present in the loadedJsUrl array
    if (TfcImportJavascripts.loadedJsUrl.includes(jsUrl)) {
      return; // Do nothing if the JavaScript is already loaded
    }

    if (querySelector == "" || document.querySelectorAll(querySelector).length > 0) {
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

  static isAdmin() {
    return window.location.href.indexOf('/wp-admin/') !== -1;
  }
  
  static isCheckoutSummaryPage() {
    return window.location.href.indexOf('/checkout/order-received/') !== -1;
  }

  static openVideoOverviewOnDesktop() {
    try{
      if (window.innerWidth >= 768) {
        document.querySelectorAll("details.video-overview").forEach(function (el) {
          el.setAttribute("open", "");
        });
      }
    }catch(e){
      console.error("Error in openVideoOverviewOnDesktop: " + e.message);
    }    
  }

}

// Set the initial values
TfcImportJavascripts.dropboxScriptLoaded = false;

//This method is called on page load
window.addEventListener('load', function () {
//window.addEventListener('pageshow', function () {

  TfcImportJavascripts.openVideoOverviewOnDesktop();

  //TfcImportJavascripts.importDropboxScript();

  //Import Jquery UI
  //TfcImportJavascripts.loadCSS("https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css",new Array(".single_add_to_cart_button"));
  //TfcImportJavascripts.loadJS("https://code.jquery.com/ui/1.12.1/jquery-ui.js",".single_add_to_cart_button");

  //Details Block (Gutenberg accordian)
  TfcImportJavascripts.loadCSS(TfcGlobal.getFullFileUrl("Css/DetailsBlock.css"), new Array('.wp-block-details'));

  //OR-DIVIDER
  TfcImportJavascripts.loadCSS(TfcGlobal.getFullFileUrl("Css/ORDivider.css"), new Array('.or-divider'));
  
  //Buttons
  TfcImportJavascripts.loadCSS(TfcGlobal.getFullFileUrl("Css/Buttons.css"), 
    new Array(
      '.wp-element-button', 
      'a.whatsapp-block__button')
      );

  TfcImportJavascripts.loadCSS(TfcGlobal.getFullFileUrl("Css/HorizontalScroll.css"), new Array(".tfcScrollHorizRow", ".tfcScrollHorizRowIcons"));
  TfcImportJavascripts.loadCSS(TfcGlobal.getFullFileUrl("Css/VisualLinkPreview.css"), new Array(".vlp-link-summary"));
//  TfcImportJavascripts.loadCSS(TfcGlobal.getFullFileUrl("Css/UserProfile.css"), new Array(".uwp-profile-extra-div"));

  // (frontend only)
  // WP is undefined in frontend, 
  // but if user is logged in as admin and try to see frontend then wp is defined.
  // So we check both wp and wp.element
  // NOTE: Since 21 Jan 2024, after updating woocommerce, the above checks are not working properly, so 
  // introduced isAdmin() method more accuracy.
  if (typeof wp === 'undefined' || typeof wp.element === 'undefined' || !TfcImportJavascripts.isAdmin()) {
    TfcImportJavascripts.loadCSS(TfcGlobal.getFullFileUrl("Css/Tiles3d.css"), new Array('.tfcTileRow'));

    TfcImportJavascripts.loadCSS(TfcGlobal.getFullFileUrl("Css/ImageGallery.css"), new Array('.wp-block-gallery'));

    TfcImportJavascripts.loadCSS(TfcGlobal.getFullFileUrl("Css/Testimonial.css"), new Array('.tfc-review-slider'));

    //KiokenAccordionFix
    TfcImportJavascripts.loadCSS(TfcGlobal.getFullFileUrl("Css/KiokenAccordionFix.css"), new Array('.wp-block-kioken-accordion-item'));
    TfcImportJavascripts.loadJS(TfcGlobal.getFullFileUrl("Javascript/KiokenAccordionFix.js"), '.wp-block-kioken-accordion-item');    

    //KiokenTabsFix
    TfcImportJavascripts.loadCSS(TfcGlobal.getFullFileUrl("Css/KiokenTabFix.css"),new Array(".wp-block-kioken-tabs"));
    TfcImportJavascripts.loadJS(TfcGlobal.getFullFileUrl("Javascript/KiokenTabsJSFix.js"),".wp-block-kioken-tabs");

    //only load autoclick if page is checkout summary.
    //dont load this script on pages like account order summary.
    if(TfcImportJavascripts.isCheckoutSummaryPage()){
      //Auto click link
      TfcImportJavascripts.loadJS(TfcGlobal.getFullFileUrl("Javascript/AutoClickLink.js"),".auto-click-link");
    }

    //Scroll Utility JS(No need to import in all pages)
    TfcImportJavascripts.loadJS(TfcGlobal.getFullFileUrl('Javascript/ScrollUtils.js'), '');   
  }
});
