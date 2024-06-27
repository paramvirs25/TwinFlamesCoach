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
            button.addEventListener('click', () => this.checkHealingValues());
        });
    }

    checkHealingValues() {
        setTimeout(() => {
            const table = document.getElementById(this.tableId);
            const rows = table.getElementsByTagName('tr');
            let reikiHealingValue = 0;
            let sacredHealingValue = 0;

            for (let row of rows) {
                if (row.cells[0].textContent.trim() === 'Reiki Healing') {
                    const resultDiv = row.cells[1].getElementsByTagName('div')[1];
                    reikiHealingValue = parseInt(resultDiv.textContent.trim(), 10);
                } else if (row.cells[0].textContent.trim() === 'Sacred Healing') {
                    const resultDiv = row.cells[1].getElementsByTagName('div')[1];
                    sacredHealingValue = parseInt(resultDiv.textContent.trim(), 10);
                }
            }

            if (reikiHealingValue >= TfcGlobal.AngelsSayYes || sacredHealingValue >= TfcGlobal.AngelsSayYes) {
                const name = prompt("Enter the person's name for saving in Reiki/Sacred Healing List:");
                if (name) {
                    if (reikiHealingValue >= TfcGlobal.AngelsSayYes) {
                        this.reikiNameManager.addEntry(name, reikiHealingValue);
                    }

                    if (sacredHealingValue >= TfcGlobal.AngelsSayYes) {
                        this.sacredHealNameManager.addEntry(name, sacredHealingValue);
                    }
                }
            }
        }, 1000); // Wait for 1 second
    }
}
