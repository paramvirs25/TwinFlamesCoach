export class PersonNameManager {
    constructor(storageKey = 'TFCDB', parentElementId = null, nameIdentifier = '', isSortNames = true, isSortByValue = false) {
        this.storageKey = storageKey;
        this.nameIdentifier = nameIdentifier;
        this.isSortNames = isSortNames;
        this.isSortByValue = isSortByValue;
        this.parentElementId = parentElementId;
        this.accordion = null;
        this.init();
    }

    async init() {
        const accordionJsUrl = TfcGlobal.getFullFileUrl('Javascript/accordion.js');
        console.log(accordionJsUrl);
        const { Accordion } = await import(accordionJsUrl);
        this.accordion = new Accordion(`All ${this.nameIdentifier} Person Entries`, this.parentElementId);
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
        // Create the input box
        this.inputBox = document.createElement('input');
        this.inputBox.setAttribute('type', 'text');
        this.inputBox.setAttribute('placeholder', `Enter a ${this.nameIdentifier} name`);
        this.inputBox.style.marginRight = '10px';

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

        // Create the sorted entry list container
        this.entryListContainer = document.createElement('div');

        // Create the button to delete all entries
        this.deleteAllButton = document.createElement('button');
        this.deleteAllButton.textContent = `Delete All ${this.nameIdentifier} Entries`;
        this.deleteAllButton.style.marginTop = '10px';

        // Create the export to clipboard button
        this.exportButton = document.createElement('button');
        this.exportButton.textContent = `Export To Clipboard`;
        this.exportButton.style.marginTop = '10px';

        // Create the import names with commas button
        this.importButton = document.createElement('button');
        this.importButton.textContent = `Import Names with Commas`;
        this.importButton.style.marginTop = '10px';

        // Append elements to the accordion content
        this.accordion.accordionContent.appendChild(this.autoCompleteList);
        this.accordion.accordionContent.appendChild(this.entryListContainer);
        this.accordion.accordionContent.appendChild(this.deleteAllButton);
        this.accordion.accordionContent.appendChild(document.createElement('br'));
        this.accordion.accordionContent.appendChild(this.inputBox);
        this.accordion.accordionContent.appendChild(this.saveButton);
        this.accordion.accordionContent.appendChild(document.createElement('br'));
        this.accordion.accordionContent.appendChild(this.exportButton);
        this.accordion.accordionContent.appendChild(document.createElement('br'));
        this.accordion.accordionContent.appendChild(this.importButton);

        this.renderEntryList();
    }

    attachEventListeners() {
        this.inputBox.addEventListener('input', (e) => this.onInput(e));
        this.saveButton.addEventListener('click', () => this.saveEntry());
        this.deleteAllButton.addEventListener('click', () => this.confirmDeleteAll());
        this.exportButton.addEventListener('click', () => this.exportToClipboard());
        this.importButton.addEventListener('click', () => this.importFromTextbox());
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
        const value = 0; // Set default value to 0

        if (name && !this.entries.some(entry => entry.name === name)) {
            this.entries.push({ name, value });
            this.sortEntries();
            this.saveEntriesToStorage();
            this.renderEntryList();
            this.inputBox.value = '';
            this.autoCompleteList.style.display = 'none';
        }
    }

    addEntry(name, value = 0) {
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

    exportToClipboard() {
        const names = this.entries.map(entry => entry.name).join(', ');
        navigator.clipboard.writeText(names).then(() => {
            console.log(`Copied to clipboard: ${names}`);
        }).catch(err => {
            console.error('Failed to copy to clipboard', err);
        });
        console.log(`Exported Names: ${names}`);
    }

    importFromTextbox() {
        const names = this.inputBox.value.split(',').map(name => name.trim()).filter(name => name);
        names.forEach(name => this.addEntry(name));
        this.saveEntriesToStorage();
        this.renderEntryList();
        this.inputBox.value = '';
    }
}
