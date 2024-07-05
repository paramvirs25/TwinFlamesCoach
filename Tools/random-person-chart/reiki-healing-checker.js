//import { PersonNameMaster } from './PersonNameMaster.js';

export class ReikiAndSacredHealingChecker {
    constructor(tabularCharts, buttonClass, reikiNameManager, sacredHealNameManager) {
        this.tabularCharts = tabularCharts;
        this.buttonClass = buttonClass;
        this.reikiNameManager = reikiNameManager;
        this.sacredHealNameManager = sacredHealNameManager;

        this.init();
    }

    async init() {
        const personNameMasterJsUrl = TfcGlobal.getFullFileUrl('Tools/random-person-chart/person-name-master.js');
        console.log(personNameMasterJsUrl);
        const { PersonNameMaster } = await import(personNameMasterJsUrl);
        this.personNameMaster = new PersonNameMaster();
        
        this.attachEventToButton();
    }

    attachEventToButton() {
        const buttons = document.querySelectorAll(`.${this.buttonClass}`);
        buttons.forEach(button => {
            button.addEventListener('click', () => this.checkHealingValues());
        });
    }

    checkHealingValues() {
        setTimeout(() => {
            this.personNameMaster.openModal((name) => {
                const reikiHealingValue = this.tabularCharts.getCellValue('Reiki Healing', 'Result');
                const sacredHealingValue = this.tabularCharts.getCellValue('Sacred Healing', 'Result');

                if (reikiHealingValue >= TfcGlobal.AngelsSayYes) {
                    this.reikiNameManager.addEntry(name, reikiHealingValue);
                } else {
                    this.reikiNameManager.deleteEntry(name);
                }

                if (sacredHealingValue >= TfcGlobal.AngelsSayYes) {
                    this.sacredHealNameManager.addEntry(name, sacredHealingValue);
                } else {
                    this.sacredHealNameManager.deleteEntry(name);
                }
            });
        }, 1000); // Wait for 1 second
    }
}
