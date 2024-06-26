class ReikiAndSacredHealingChecker {
    constructor(tableId, buttonClass, reikiNameManager, sacredHealNameManager) {
        this.tableId = tableId;
        this.buttonClass = buttonClass;
        this.reikiNameManager = reikiNameManager;
        this.sacredHealNameManager = sacredHealNameManager;
        this.attachEventToButton();
    }

    attachEventToButton() {
        const buttons = document.querySelectorAll(`.${this.buttonClass}`);
        buttons.forEach(button => {
            button.addEventListener('click', () => this.checkReikiHealing());
        });
    }

    checkReikiHealing() {

        setTimeout(() => {
            const table = document.getElementById(this.tableId);
            const rows = table.getElementsByTagName('tr');
            let reikiHealingValue = 0;
            let sacredHealingValue = 0;

            for (let row of rows) {
                if (row.cells[0].textContent.trim() === 'Reiki Healing') {
                    const resultDiv = row.cells[1].getElementsByTagName('div')[1];
                    reikiHealingValue = parseInt(resultDiv.textContent.trim(), 10);
                    //break;
                } else if (row.cells[0].textContent.trim() === 'Sacred Healing') {
                    const resultDiv = row.cells[1].getElementsByTagName('div')[1];
                    sacredHealingValue = parseInt(resultDiv.textContent.trim(), 10);
                    //break;
                }
            }

            if(reikiHealingValue >= TfcGlobal.AngelsSayYes || sacredHealingValue >= TfcGlobal.AngelsSayYes)
            {
                const name = prompt("Enter the person's name for saving in Reiki/Sacred Healing List:");
                if (name) {
                    if(reikiHealingValue >= TfcGlobal.AngelsSayYes){
                        this.reikiNameManager.addName(name);
                    } 
                    
                    if(sacredHealingValue >= TfcGlobal.AngelsSayYes){
                        this.sacredHealNameManager.addName(name);
                    }
                    
                    //alert(`${name} has been saved!`);
                }
            }

            // if (reikiHealingValue >= TfcGlobal.AngelsSayYes) {
            //     //this.personNameManager.saveName();
            //     const name = prompt("Enter the person's name for saving in Reiki Healing List:");
            //     if (name) {
            //         this.personNameManager.addName(name);
            //         alert(`${name} has been saved!`);
            //     }
            // } 
            // else {
            //     alert('Reiki Healing result is not greater than 62.');
            // }
        }, 1000); // Wait for 1 second
    }
}

// Instantiate the PersonNameManager
//const personNameManager = new PersonNameManager();

// Instantiate the ReikiHealingChecker
//const reikiHealingChecker = new ReikiHealingChecker('randomPersonTableBody', 'btnRandomPersonChart', personNameManager);
