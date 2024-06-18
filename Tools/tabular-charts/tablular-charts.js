class TabularCharts {
    constructor(tableId, columnNames, rowNames) {        
        this.tableId = tableId;
        this.columnNames = columnNames;
        this.rowNames = rowNames;
        this.initializeTable();
    }

    initializeTable() {
        const tableBody = document.getElementById(this.tableId);

        // Create table header
        const thead = tableBody.createTHead();
        const headerRow = thead.insertRow();
        this.columnNames.forEach(columnName => {
            const th = document.createElement("th");
            th.textContent = columnName;
            headerRow.appendChild(th);
        });

        // Create table rows based on rowNames array
        const tbody = document.createElement("tbody");
        tableBody.appendChild(tbody);

        this.rowNames.forEach(rowName => {
            const newRow = document.createElement("tr");
            const rowNameCell = document.createElement("td");
            rowNameCell.textContent = rowName;
            newRow.appendChild(rowNameCell);

            // Create gradient cells
            for (let i = 1; i < this.columnNames.length; i++) {
                newRow.appendChild(this.createGradientCell());
            }

            tbody.appendChild(newRow);
        });
    }

    createGradientCell() {
        const gradientCell = document.createElement("td");
        const gradientSpan = document.createElement("div");
        gradientSpan.className = "gradient-cell";
        gradientCell.appendChild(gradientSpan);
        return gradientCell;
    }

    fillRandomNumbers() {
        const tableBody = document.getElementById(this.tableId).querySelector("tbody");

        setTimeout(() => {
            const rows = tableBody.querySelectorAll("tr");
            rows.forEach(row => {
                const cells = row.querySelectorAll("td");

                // Loop through each cell that contains a gradient-cell
                for (let i = 1; i < cells.length; i++) {
                    const gradientCell = cells[i].querySelector(".gradient-cell");
                    const randomValue = this.getRandomNumber();
                    
                    gradientCell.style.width = `${randomValue}%`;

                    if (randomValue > 63) {
                        gradientCell.innerHTML = `<div class="tick">${randomValue}</div>`;
                    } else {
                        gradientCell.innerHTML = `<div class="cross">${randomValue}</div>`;
                    }
                }
            });
        }, 1000); // Wait for 1 second
    }

    getRandomNumber() {
        return Math.floor(Math.random() * 100) + 1;
    }
}

// Example usage
// const tableId = "emotionTableBody";
// const columnNames = ["Emotion", "My Side", "Their Side"];
// const rowNames = [
//     "Anger", "Mad", "Guilt", "Sadness", "Fear", "Rejected", "Pity", "Disgust / Awful", "Disapproval",
//     "Expectation", "Hope", "Surprise / Startled / Excited", "Joy / Optimistic", "Proud", "Trust"
// ];

// const tabularCharts = new TabularCharts(tableId, columnNames, rowNames);
// tabularCharts.fillRandomNumbers(); // Call this to fill the table with random numbers