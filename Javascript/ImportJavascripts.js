class TfcImportJavascripts {
    constructor() {
      this.dropboxScriptLoaded = false;
    }
  
    importDropboxScript() {
      if (!this.dropboxScriptLoaded) {
        var script = document.createElement('script');
        script.src = 'https://www.dropbox.com/static/api/2/dropins.js';
        script.id = 'dropboxjs';
        script.setAttribute('data-app-key', 'z2xhg87mpzhvs3n');
        script.defer = true;
        document.head.appendChild(script);
        this.dropboxScriptLoaded = true;
      }
    }
  }