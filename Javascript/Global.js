class TfcGlobal {
    static AngelsSayYes = 63; //63 and above is considered yes

    static CssJsPath = "https://paramvirs25.github.io/TwinFlamesCoach"; // URL path

    static AccordionJsUrl = TfcGlobal.getFullFileUrl('Javascript/accordion.js');

    static ShuffleToolsListPath = "HTML/Shuffle/ShuffleToolsList.html";

    static EmotionsChartPath = "Tools/emotions-chart/index.html";
    
    static GaugeChartRootPath = "Tools/gauge-chart";
    static GaugeChartPath = `${TfcGlobal.GaugeChartRootPath}/index.html`;

    static MultipleOptionsRootPath = "Tools/multiple-options-chart";
    static MultipleOptionsChartPath = `${TfcGlobal.MultipleOptionsRootPath}/index.html`;

    static PercentGaugeRootPath = "Tools/percent-gauge";
    static PercentGaugePath = `${TfcGlobal.PercentGaugeRootPath}/index.html`;

    static RandomPersonChartRootPath = "Tools/random-person-chart";
    static RandomPersonChartPath = `${TfcGlobal.RandomPersonChartRootPath}/index.html`;

    static SacredHealingChartRootPath = "Tools/sacred-healing-chart";
    static SacredHealingChartPath = `${TfcGlobal.SacredHealingChartRootPath}/index.html`;

    static SacredHealingChartMaleRootPath = "Tools/sacred-healing-male-chart";
    static SacredHealingChartMalePath = `${TfcGlobal.SacredHealingChartMaleRootPath}/index.html`;

    static FamilyKriyaDeekshaChartPath = `Tools/family-kriya-deeksha-chart/index.html`;

    static isTabluarChartAlreadyLoaded = false;
    static TabularChartRootPath = "Tools/tabular-charts";
    
    static YoutubeChannelSearchPath = `YoutubeChannelSearch/YoutubeChannelSearch.html`;

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

    static scriptLoadPromise = null;
    static loadTabularChartScript() {
        if (!this.scriptLoadPromise) {
            const tabularChartJsUrl = this.getFullFileUrlFromParts(this.TabularChartRootPath, "tablular-charts.js");
            this.scriptLoadPromise = jQuery.getScript(tabularChartJsUrl);
        }
        return this.scriptLoadPromise;
    }

}