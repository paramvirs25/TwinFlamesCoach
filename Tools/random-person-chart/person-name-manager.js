export class PersonNameManager {
    constructor(storageKey = 'TFCDB', parentElementId = null, nameIdentifier = '', isSortNames = true, isSortByValue = false, personNameMaster = null) {
        this.storageKey = storageKey;
        this.nameIdentifier = nameIdentifier;
        this.isSortNames = isSortNames;
        this.isSortByValue = isSortByValue;
        this.parentElementId = parentElementId;
        this.accordion = null;
        this.personNameMaster = null;
        this.init(personNameMaster);
    }

    async init(personNameMaster) {
        const { Accordion } = await import(TfcGlobal.AccordionJsUrl);
        this.accordion = new Accordion(`All ${this.nameIdentifier} Person Entries`, this.parentElementId);
        this.personNameMaster = personNameMaster;

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
        this.saveButton.className = 'wp-block-button__link wp-element-button';
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

        // Create the button to randomize values
        this.randomizeButton = document.createElement('button');
        this.randomizeButton.textContent = `Randomize Values`;
        this.randomizeButton.className = 'wp-block-button__link wp-element-button';
        this.randomizeButton.style.marginTop = '10px';

        // Create the tools toggle link
        this.toolsToggleLink = document.createElement('a');
        this.toolsToggleLink.href = '#';
        this.toolsToggleLink.textContent = 'Tools';
        this.toolsToggleLink.style.display = 'block';
        this.toolsToggleLink.style.marginTop = '10px';
        this.toolsToggleLink.style.cursor = 'pointer';

        // Create the tools container
        this.toolsContainer = document.createElement('div');
        this.toolsContainer.style.display = 'none';

        // Create the button to delete all entries
        this.deleteAllButton = document.createElement('button');
        this.deleteAllButton.textContent = `Delete All ${this.nameIdentifier} Entries`;
        this.deleteAllButton.className = 'wp-block-button__link wp-element-button';
        this.deleteAllButton.style.marginTop = '10px';

        // Create the export to clipboard button
        this.exportButton = document.createElement('button');
        this.exportButton.textContent = `Export To Clipboard`;
        this.exportButton.className = 'wp-block-button__link wp-element-button';
        this.exportButton.style.marginTop = '10px';

        // Create the import names with commas button
        this.importButton = document.createElement('button');
        this.importButton.textContent = `Import Names with Commas`;
        this.importButton.className = 'wp-block-button__link wp-element-button';
        this.importButton.style.marginTop = '10px';

        // Append elements to the accordion content
        this.accordion.accordionContent.appendChild(this.randomizeButton);
        this.accordion.accordionContent.appendChild(this.entryListContainer);
        this.accordion.accordionContent.appendChild(this.toolsToggleLink);
        this.accordion.accordionContent.appendChild(this.toolsContainer);

        this.toolsContainer.appendChild(this.autoCompleteList);
        this.toolsContainer.appendChild(this.inputBox);
        this.toolsContainer.appendChild(this.saveButton);
        this.toolsContainer.appendChild(document.createElement('br'));
        this.toolsContainer.appendChild(this.deleteAllButton);
        this.toolsContainer.appendChild(document.createElement('br'));
        this.toolsContainer.appendChild(this.exportButton);
        this.toolsContainer.appendChild(document.createElement('br'));
        this.toolsContainer.appendChild(this.importButton);

        this.renderEntryList();
    }

    attachEventListeners() {
        this.inputBox.addEventListener('input', (e) => this.onInput(e));
        this.saveButton.addEventListener('click', () => this.saveEntry());
        this.randomizeButton.addEventListener('click', () => this.randomizeValues());
        this.deleteAllButton.addEventListener('click', () => this.confirmDeleteAll());
        this.exportButton.addEventListener('click', () => this.exportToClipboard());
        this.importButton.addEventListener('click', () => this.importFromTextbox());
        this.toolsToggleLink.addEventListener('click', (e) => {
            e.preventDefault();
            this.toggleTools();
        });
    }

    toggleTools() {
        this.toolsContainer.style.display = this.toolsContainer.style.display === 'none' ? 'block' : 'none';
    }

    onInput(event) {
        const query = event.target.value.trim().toLowerCase();
        this.autoCompleteList.innerHTML = '';

        if (query) {
            const filteredEntries = this.personNameMaster.names.filter(name => name.trim().toLowerCase().includes(query));
            filteredEntries.forEach(name => {
                const listItem = document.createElement('li');
                listItem.textContent = name;
                listItem.style.cursor = 'pointer';
                listItem.addEventListener('click', () => this.onAutoCompleteSelect(name));
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

    normalizeAndAddEntry(name, value = 0) {
        const normalizedName = name.trim().toLowerCase();

        // Remove existing entry with the same name (case-insensitive and trimmed)
        this.entries = this.entries.filter(entry => entry.name.trim().toLowerCase() !== normalizedName);

        // Add new entry
        this.entries.push({ name: name.trim(), value });
        this.sortEntries();
        this.saveEntriesToStorage();
        this.renderEntryList();

        // Add to master storage
        this.personNameMaster.addName(name);
    }

    saveEntry() {
        const name = this.inputBox.value.trim();
        if (name) {
            this.normalizeAndAddEntry(name);
            this.inputBox.value = '';
            this.autoCompleteList.style.display = 'none';
        }
    }

    addEntry(name, value = 0) {
        if (name) {
            this.normalizeAndAddEntry(name, value);
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
        const normalizedName = name.trim().toLowerCase();
        this.entries = this.entries.filter(entry => entry.name.trim().toLowerCase() !== normalizedName);
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
        names.forEach(name => this.normalizeAndAddEntry(name));
        this.saveEntriesToStorage();
        this.renderEntryList();
        this.inputBox.value = '';
    }

    randomizeValues() {
        this.entries = this.entries.map(entry => ({
            ...entry,
            value: Math.floor(Math.random() * 100) + 1
        }));
        this.sortEntries();
        this.saveEntriesToStorage();
        this.renderEntryList();
        
        const highestValueEntry = this.entries.reduce((max, entry) => entry.value > max.value ? entry : max, this.entries[0]);
        alert(`${highestValueEntry.name} (Value: ${highestValueEntry.value})`);
    }
}
