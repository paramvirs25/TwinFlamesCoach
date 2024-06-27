class PersonNameManager {
    constructor(storageKey = 'TFCDB', parentElementId = null, nameIdentifier = '', isSortNames = true, isSortByValue = false) {
        this.storageKey = storageKey;
        this.nameIdentifier = nameIdentifier;
        this.isSortNames = isSortNames;
        this.isSortByValue = isSortByValue;
        this.parentElementId = parentElementId;
        this.init();
    }

    init() {
        this.entries = this.getEntriesFromStorage();
        this.createUI();
        this.attachEventListeners();
    }

    getEntriesFromStorage() {
        const entries = localStorage.getItem(this.storageKey);
        return entries ? JSON.parse(entries) : [];
    }

    saveEntriesToStorage() {
        localStorage.setItem(this.storageKey, JSON.stringify(this.entries));
    }

    createUI() {
        this.container = document.createElement('div');

        // Create the input box
        this.inputBox = document.createElement('input');
        this.inputBox.setAttribute('type', 'text');
        this.inputBox.setAttribute('placeholder', `Enter a ${this.nameIdentifier} name`);
        this.inputBox.style.marginRight = '10px';

        // Create the value input box
        this.valueInputBox = document.createElement('input');
        this.valueInputBox.setAttribute('type', 'number');
        this.valueInputBox.setAttribute('placeholder', `Enter the healing value`);
        this.valueInputBox.style.marginRight = '10px';

        // Create the save button
        this.saveButton = document.createElement('button');
        this.saveButton.textContent = `Save`;
        this.saveButton.style.marginRight = '10px';

        // Create the auto-complete list
        this.autoCompleteList = document.createElement('ul');
        this.autoCompleteList.style.listStyleType = 'none';
        this.autoCompleteList.style.padding = '0';
        this.autoCompleteList.style.margin = '0';
        this.autoCompleteList.style.position = 'absolute';
        this.autoCompleteList.style.backgroundColor = 'white';
        this.autoCompleteList.style.border = '1px solid #ccc';
        this.autoCompleteList.style.display = 'none';

        // Create the accordion header
        this.accordionHeader = document.createElement('div');
        this.accordionHeader.textContent = `All ${this.nameIdentifier} Person Entries`;
        this.accordionHeader.style.cursor = 'pointer';
        this.accordionHeader.style.backgroundColor = '#f1f1f1';
        this.accordionHeader.style.padding = '10px';
        this.accordionHeader.style.border = '1px solid #ccc';
        this.accordionHeader.style.marginTop = '10px';
        this.accordionHeader.style.marginBottom = '10px';

        // Create the accordion content
        this.accordionContent = document.createElement('div');
        this.accordionContent.style.display = 'none';
        this.accordionContent.style.padding = '10px';
        this.accordionContent.style.border = '1px solid #ccc';
        this.accordionContent.style.borderTop = 'none';

        // Create the sorted entry list container
        this.entryListContainer = document.createElement('div');

        // Create the button to delete all entries
        this.deleteAllButton = document.createElement('button');
        this.deleteAllButton.textContent = `Delete All ${this.nameIdentifier} Entries`;
        this.deleteAllButton.style.marginTop = '10px';

        // Append elements to the container
        this.container.appendChild(this.inputBox);
        this.container.appendChild(this.valueInputBox);
        this.container.appendChild(this.saveButton);
        this.container.appendChild(this.autoCompleteList);
        this.accordionContent.appendChild(this.entryListContainer);
        this.accordionContent.appendChild(this.deleteAllButton);
        this.container.appendChild(this.accordionHeader);
        this.container.appendChild(this.accordionContent);

        // Check for the div with id 'divPersonNameManager'
        const targetDiv = document.getElementById(this.parentElementId);
        if (targetDiv) {
            targetDiv.appendChild(this.container);
        } else {
            document.body.appendChild(this.container);
        }

        // Render the sorted entry list
        this.renderEntryList();
    }

    attachEventListeners() {
        this.inputBox.addEventListener('input', (e) => this.onInput(e));
        this.saveButton.addEventListener('click', () => this.saveEntry());
        this.accordionHeader.addEventListener('click', () => this.toggleAccordion());
        this.deleteAllButton.addEventListener('click', () => this.confirmDeleteAll());
    }

    onInput(event) {
        const query = event.target.value.toLowerCase();
        this.autoCompleteList.innerHTML = '';

        if (query) {
            const filteredEntries = this.entries.filter(entry => entry.name.toLowerCase().includes(query));
            filteredEntries.forEach(entry => {
                const listItem = document.createElement('li');
                listItem.textContent = entry.name;
                listItem.style.cursor = 'pointer';
                listItem.addEventListener('click', () => this.onAutoCompleteSelect(entry.name));
                this.autoCompleteList.appendChild(listItem);
            });
            this.autoCompleteList.style.display = filteredEntries.length ? 'block' : 'none';
        } else {
            this.autoCompleteList.style.display = 'none';
        }
    }

    onAutoCompleteSelect(name) {
        this.inputBox.value = name;
        this.autoCompleteList.style.display = 'none';
    }

    saveEntry() {
        const name = this.inputBox.value.trim();
        const value = parseInt(this.valueInputBox.value.trim(), 10);

        if (name && !isNaN(value) && !this.entries.some(entry => entry.name === name)) {
            this.entries.push({ name, value });
            this.sortEntries();
            this.saveEntriesToStorage();
            this.renderEntryList();
            this.inputBox.value = '';
            this.valueInputBox.value = '';
            this.autoCompleteList.style.display = 'none';
        }
    }

    addEntry(name, value) {
        if (!this.entries.some(entry => entry.name === name)) {
            this.entries.push({ name, value });
            this.sortEntries();
            this.saveEntriesToStorage();
            this.renderEntryList();
        }
    }

    sortEntries() {
        if (this.isSortNames) {
            this.entries.sort((a, b) => a.name.localeCompare(b.name));
        } else if (this.isSortByValue) {
            this.entries.sort((a, b) => b.value - a.value);
        }
    }

    toggleAccordion() {
        this.accordionContent.style.display = this.accordionContent.style.display === 'none' ? 'block' : 'none';
    }

    confirmDeleteAll() {
        if (confirm(`Are you sure you want to delete all ${this.nameIdentifier} entries?`)) {
            this.deleteAllEntries();
        }
    }

    deleteEntry(name) {
        this.entries = this.entries.filter(entry => entry.name !== name);
        this.saveEntriesToStorage();
        this.renderEntryList();
    }

    deleteAllEntries() {
        this.entries = [];
        this.saveEntriesToStorage();
        this.renderEntryList();
    }

    renderEntryList() {
        this.entryListContainer.innerHTML = '';
        const ol = document.createElement('ol');

        this.entries.forEach(entry => {
            const li = document.createElement('li');
            li.textContent = `${entry.name} (Value: ${entry.value})`;

            const deleteButton = document.createElement('span');
            deleteButton.textContent = ' X';
            deleteButton.style.color = 'red';
            deleteButton.style.cursor = 'pointer';
            deleteButton.style.marginLeft = '10px';
            deleteButton.addEventListener('click', () => this.deleteEntry(entry.name));

            li.appendChild(deleteButton);
            ol.appendChild(li);
        });

        this.entryListContainer.appendChild(ol);
    }
}
