//import { PersonNameMaster } from './PersonNameMaster.js';

export class ReikiAndSacredHealingChecker {
    constructor(tabularCharts, buttonClass, reikiNameManager, sacredHealNameManager, personNameMaster) {
        this.tabularCharts = tabularCharts;
        this.buttonClass = buttonClass;
        this.reikiNameManager = reikiNameManager;
        this.sacredHealNameManager = sacredHealNameManager;

        this.init(personNameMaster);
    }

    async init(personNameMaster) {
        this.personNameMaster = personNameMaster;
        
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
                const considerPersonValue = this.tabularCharts.getCellValue('To Consider this person?', 'Result');
                const reikiHealingValue = this.tabularCharts.getCellValue('Reiki Healing', 'Result');
                const sacredHealingValue = this.tabularCharts.getCellValue('Sacred Healing', 'Result');

                //if person is to be considered
                if(considerPersonValue >= TfcGlobal.AngelsSayYes){
                    if (reikiHealingValue >= TfcGlobal.AngelsSayYes) {
                        this.reikiNameManager.addEntry(name, reikiHealingValue);
                    } 

                    if (sacredHealingValue >= TfcGlobal.AngelsSayYes) {
                        this.sacredHealNameManager.addEntry(name, sacredHealingValue);
                    } 
                } else {
                    this.reikiNameManager.deleteEntry(name);
                    this.sacredHealNameManager.deleteEntry(name);
                }
                
            });
        }, 1000); // Wait for 1 second
    }
}
