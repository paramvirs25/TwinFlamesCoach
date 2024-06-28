export class HealingLogger {
    constructor(tabularCharts, buttonClass, logStorageKey = 'healingLog') {
        this.tabularCharts = tabularCharts;
        this.buttonClass = buttonClass;
        this.logStorageKey = logStorageKey;
        this.attachEventToButton();
        this.loadLogFromStorage();
    }

    attachEventToButton() {
        const buttons = document.querySelectorAll(`.${this.buttonClass}`);
        buttons.forEach(button => {
            button.addEventListener('click', () => this.logHealingValues());
        });
    }

    logHealingValues() {
        const name = prompt("Enter the person's name for saving in Healing Log:");
        if (name) {
            const logHtml = this.tabularCharts.generateHtmlLog(name);
            this.saveLogToStorage(logHtml);
            this.displayLog(logHtml);
        }
    }

    displayLog(logHtml) {
        const logContainer = document.getElementById('healingLogContainer'); // Ensure this element exists in your HTML
        logContainer.innerHTML = logHtml;
    }

    saveLogToStorage(logHtml) {
        localStorage.setItem(this.logStorageKey, logHtml);
    }

    loadLogFromStorage() {
        const logHtml = localStorage.getItem(this.logStorageKey);
        if (logHtml) {
            this.displayLog(logHtml);
        }
    }
}
