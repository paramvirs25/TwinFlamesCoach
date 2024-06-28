export class HealingLogger {
    constructor(tabularCharts, buttonClass, logStorageKey, parentElementId) {
        this.tabularCharts = tabularCharts;
        this.buttonClass = buttonClass;
        this.logStorageKey = logStorageKey;
        this.parentElementId = parentElementId;
        this.accordion = null;
        this.init();
    }

    async init() {        
        const { Accordion } = await import(TfcGlobal.getFullFileUrl('Javascript/accordion.js'));
        this.accordion = new Accordion('Log', this.parentElementId);
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
        const name = prompt("Enter the person's name for saving in Log:");
        if (name) {
            const logHtml = this.tabularCharts.generateHtmlLog(name);
            this.appendLog(logHtml, name);
        }
    }

    appendLog(logHtml, name) {
        const newLogItem = this.createLogEntry(logHtml, name);
        this.accordion.appendContent(newLogItem);
        this.saveLogToStorage();
    }

    createLogEntry(logHtml, name) {
        const timestamp = new Date().toLocaleString();
        return `
            <div class="log-entry">
                <div class="log-header">${name} at ${timestamp}</div>
                <div class="log-body">${logHtml}</div>
            </div>
        `;
    }

    saveLogToStorage() {
        localStorage.setItem(this.logStorageKey, this.accordion.getContent());
    }

    loadLogFromStorage() {
        const logHtml = localStorage.getItem(this.logStorageKey);
        if (logHtml) {
            this.accordion.setContent(logHtml);
        }
    }
}
