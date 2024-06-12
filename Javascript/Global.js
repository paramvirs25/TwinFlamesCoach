class TfcGlobal {
    static CssJsPath = "https://paramvirs25.github.io/TwinFlamesCoach"; // URL path
    static ShuffleToolsListPath = "HTML/Shuffle/ShuffleToolsList.html";
    
    static GaugeChartRootPath = "Tools/gauge-chart";
    static GaugeChartPath = `${GaugeChartRootPath}/index.html`;

    static EmotionsChartPath = "Tools/emotions-chart/index.html";

    static getFullFileUrl(fileUrl) {
        return `${TfcGlobal.CssJsPath}/${fileUrl}`;
    }

    static getFullFileUrlFromParts(...urlParts) {
        // Base URL path from global settings
        let fileUrl = TfcGlobal.CssJsPath;
    
        // Loop through each part in the urlParts arguments
        for (const urlPart of urlParts) {
            if (urlPart) {
                // Append each part to the base URL with a slash separator
                fileUrl = `${fileUrl}/${urlPart}`;
            }
        }
        
        // Return the constructed full URL
        return fileUrl;
    }
    

    static loadFile(divToLoadHtml, htmlFilePath) {
        var fullFileUrl = TfcGlobal.getFullFileUrl(htmlFilePath);
        jQuery(`#${divToLoadHtml}`).load(fullFileUrl);
        console.log("Loaded HTML file " + fullFileUrl);
    }
}