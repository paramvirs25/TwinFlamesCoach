class ReikiHealingChecker {
    constructor(tableId, buttonClass, personNameManager) {
        this.tableId = tableId;
        this.buttonClass = buttonClass;
        this.personNameManager = personNameManager;
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

            for (let row of rows) {
                if (row.cells[0].textContent.trim() === 'Reiki Healing') {
                    const resultDiv = row.cells[1].getElementsByTagName('div')[1];
                    reikiHealingValue = parseInt(resultDiv.textContent.trim(), 10);
                    break;
                }
            }

            if (reikiHealingValue > 62) {
                this.personNameManager.saveName();
                // const name = prompt("Enter the person's name:");
                // if (name) {
                //     this.personNameManager.addName(name);
                //     alert(`${name} has been saved!`);
                // }
            } 
            // else {
            //     alert('Reiki Healing result is not greater than 62.');
            // }
        }, 2000); // Wait for 1 second
    }
}

// Instantiate the PersonNameManager
//const personNameManager = new PersonNameManager();

// Instantiate the ReikiHealingChecker
//const reikiHealingChecker = new ReikiHealingChecker('randomPersonTableBody', 'btnRandomPersonChart', personNameManager);
