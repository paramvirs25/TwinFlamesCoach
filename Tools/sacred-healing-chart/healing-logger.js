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
            this.appendLog(logHtml, name);
        }
    }

    appendLog(logHtml, name) {
        const logContainer = document.getElementById('healingLogBody');
        const newLogItem = this.createLogEntry(logHtml, name);

        logContainer.insertAdjacentHTML('afterbegin', newLogItem);
        this.saveLogToStorage();
    }

    createLogEntry(logHtml, name) {
        const timestamp = new Date().toLocaleString();
        return `
            <div class="log-entry">
                <div class="log-header">Log for ${name} at ${timestamp}</div>
                <div class="log-body">${logHtml}</div>
            </div>
        `;
    }

    saveLogToStorage() {
        const logContainer = document.getElementById('healingLogBody');
        localStorage.setItem(this.logStorageKey, logContainer.innerHTML);
    }

    loadLogFromStorage() {
        const logHtml = localStorage.getItem(this.logStorageKey);
        if (logHtml) {
            const logContainer = document.getElementById('healingLogBody');
            logContainer.innerHTML = logHtml;
        }
    }
}
