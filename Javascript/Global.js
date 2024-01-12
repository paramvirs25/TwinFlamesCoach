class TfcGlobal {
    static CssJsPath = "https://paramvirs25.github.io/TwinFlamesCoach"; // URL path
    static ShuffleToolsListPath = "HTML/Shuffle/ShuffleToolsList.html";
    static GaugeChartPath = "gauge-chart/index.html";

    static getFullFileUrl(fileUrl) {
        return `${TfcGlobal.CssJsPath}/${fileUrl}`;
    }

    static loadFile(divToLoadHtml, htmlFilePath) {
        var fullFileUrl = TfcGlobal.getFullFileUrl(htmlFilePath);
        jQuery(`#${divToLoadHtml}`).load(fullFileUrl);
        console.log("Loaded HTML file " + fullFileUrl);
    }
}