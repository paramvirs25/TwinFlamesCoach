class TabularCharts {
    constructor(tableId, columnNames, rowNames, buttonCssClass, isShowCopyFilteredRowButton = false, copyFilteredRowSeparator = ", ") {
        this.tableId = tableId;
        this.columnNames = columnNames;
        this.rowNames = rowNames;
        this.buttonCssClass = buttonCssClass;
        this.isShowCopyFilteredRowButton = isShowCopyFilteredRowButton;
        this.copyFilteredRowSeparator = copyFilteredRowSeparator;
        this.uniqueId = `${tableId}-${Date.now()}`; // Unique ID for each instance
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

        if(this.isShowCopyFilteredRowButton){
            // Add the new copy to clipboard button
            this.addCopyButton();
        }
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
                    gradientCell.innerHTML = `<div class="tick">✅ <span class="number">${randomValue}</span></div>`;
                } else {
                    gradientCell.innerHTML = `<div class="cross">❌ <span class="number">${randomValue}</span></div>`;
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

    // New method to copy filtered names to clipboard
    copyFilteredNamesToClipboard(dropdownId) {
        const appendHeader = dropdownId && document.getElementById(dropdownId)?.value === 'yes';

        const tableBody = document.getElementById(this.tableId).querySelector("tbody");
        const rows = tableBody.querySelectorAll("tr");
        let names = [];
    
        let currentHeaderText = ''; // Keeps track of the current header-row text
    
        rows.forEach(row => {
            if (row.classList.contains("header-row")) {
                // Update the current header text for subsequent rows
                currentHeaderText = row.querySelector("td").textContent.trim();
            } else {
                const cells = row.querySelectorAll("td");
                const rowName = cells[0].textContent.trim();
                const firstCellValue = parseInt(cells[1]?.querySelector(".gradient-cell div")?.textContent.trim() || "0", 10);
    
                if (firstCellValue >= TfcGlobal.AngelsSayYes) {
                    // Append the current header text if required
                    const fullRowName = appendHeader ? `${currentHeaderText} - ${rowName}` : rowName;
                    names.push(fullRowName);
                }
            }
        });
    
        // Copy the filtered names to clipboard
        const namesString = names.join(this.copyFilteredRowSeparator);
        navigator.clipboard.writeText(namesString).then(() => {
            console.log('Copied to clipboard:', namesString);
        }).catch(err => {
            console.error('Could not copy text: ', err);
        });
    }

    // Method to add the copy button to the UI
    addCopyButton() {
        // Dropdown ID and Button ID specific to this instance
        const dropdownId = `appendRowHeader-${this.uniqueId}`;
        
        // Create Dropdown
        const dropdownLabel = document.createElement("label");
        dropdownLabel.setAttribute("for", dropdownId);
        dropdownLabel.textContent = "Append Row Header:";

        const dropdown = document.createElement("select");
        dropdown.id = dropdownId;
        dropdown.innerHTML = `
            <option value="no">No</option>
            <option value="yes" selected>Yes</option>
        `;

        const button = document.createElement('button');
        button.textContent = 'Copy Filtered Row Names to Clipboard';
        button.className = this.buttonCssClass;
        button.style.marginTop = '10px';
    
        button.addEventListener('click', () => this.copyFilteredNamesToClipboard(dropdownId));

        
    
        const tableElement = document.getElementById(this.tableId);
        //tableElement.insertAdjacentElement('afterend', button);
        // tableElement.insertAdjacentElement('beforebegin', dropdownLabel);
        // tableElement.insertAdjacentElement('beforebegin', dropdown);
        // tableElement.insertAdjacentElement('beforebegin', button);

        const container = document.createElement("div");
        container.className = "copy-container";
        container.appendChild(dropdownLabel);
        container.appendChild(dropdown);
        container.appendChild(button);
        tableElement.parentNode.insertBefore(container, tableElement);

    }
    

    // Method to get cell value
    getCellValue(rowName, columnName) {
        const tableBody = document.getElementById(this.tableId).querySelector("tbody");
        const rows = tableBody.querySelectorAll("tr:not(.header-row)");

        for (let row of rows) {
            const cells = row.querySelectorAll("td");
            if (cells[0].textContent.trim() === rowName) {
                for (let i = 0; i < this.columnNames.length; i++) {
                    if (this.columnNames[i] === columnName) {
                        const gradientCell = cells[i].querySelector(".gradient-cell div");
                        return parseInt(gradientCell.textContent.trim(), 10);
                    }
                }
            }
        }
        return null;
    }

    // Method to generate HTML log
    generateHtmlLog(name) {
        const tableBody = document.getElementById(this.tableId).querySelector("tbody");
        const rows = tableBody.querySelectorAll("tr:not(.header-row)");

        let logHtml = '<span>'; //`<b>${name}</b>: <span>`;

        rows.forEach(row => {
            const cells = row.querySelectorAll("td");
            const rowName = cells[0].textContent.trim();

            for (let i = 1; i < cells.length; i++) {
                const gradientCell = cells[i].querySelector(".gradient-cell div");
                if (gradientCell) {
                    const value = parseInt(gradientCell.textContent.trim(), 10);
                    if (value >= TfcGlobal.AngelsSayYes) {
                        logHtml += `${rowName}: ${value},`;
                    }
                }
            }
        });

        logHtml += `</span>`;
        return logHtml;
    }

    // Method to clear all UI elements
    clearUI() {
        const tableElement = document.getElementById(this.tableId);

        // Clear table header and body
        while (tableElement.firstChild) {
            tableElement.removeChild(tableElement.firstChild);
        }

        // Remove the copy container
        const copyContainer = document.querySelector(".copy-container");
        if (copyContainer) {
            copyContainer.remove();
        }

        console.log("All UI elements created by TabularCharts have been cleared.");
    }
}
