class TabularCharts {
    constructor(tableId, columnNames, rowNames, buttonCssClass) {
        this.tableId = tableId;
        this.columnNames = columnNames;
        this.rowNames = rowNames;
        this.buttonCssClass = buttonCssClass;
        this.initializeTable();
    }

    initializeTable() {
        this.loadCss();

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
            if (typeof rowName === 'string' && rowName.startsWith('header:')) {
                const newRow = document.createElement("tr");
                const headerCell = document.createElement("td");
                headerCell.textContent = rowName.replace('header:', '').trim();
                headerCell.colSpan = this.columnNames.length;
                newRow.appendChild(headerCell);
                newRow.classList.add("header-row");
                tbody.appendChild(newRow);
            } else {
                const newRow = document.createElement("tr");
                const rowNameCell = document.createElement("td");
                rowNameCell.textContent = rowName;
                newRow.appendChild(rowNameCell);

                // Create gradient cells
                for (let i = 1; i < this.columnNames.length; i++) {
                    newRow.appendChild(this.createGradientCell());
                }

                tbody.appendChild(newRow);
            }
        });

        // Add event listener to buttons with the specified CSS class
        const buttons = document.querySelectorAll(`.${this.buttonCssClass}`);
        buttons.forEach(button => {
            button.addEventListener('click', () => this.fillRandomNumbers());
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

        const rows = tableBody.querySelectorAll("tr:not(.header-row)");
        rows.forEach(row => {
            const cells = row.querySelectorAll("td");

            // Loop through each cell that contains a gradient-cell
            for (let i = 1; i < cells.length; i++) {
                const gradientCell = cells[i].querySelector(".gradient-cell");
                const randomValue = this.getRandomNumber();

                gradientCell.style.width = `${randomValue}%`;

                if (randomValue >= TfcGlobal.AngelsSayYes) {
                    gradientCell.innerHTML = `<div class="tick">${randomValue}</div>`;
                } else {
                    gradientCell.innerHTML = `<div class="cross">${randomValue}</div>`;
                }
            }
        });
    }

    getRandomNumber() {
        return Math.floor(Math.random() * 100) + 1;
    }

    loadCss() {
        const tabularChartCssUrl = TfcGlobal.getFullFileUrlFromParts(TfcGlobal.TabularChartRootPath, "tabular-charts.css");
        TfcImportJavascripts.loadCSS(tabularChartCssUrl, new Array(".tbl-tabular-chart"));
    }
}
