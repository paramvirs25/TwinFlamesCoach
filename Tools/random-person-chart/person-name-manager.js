export class PersonNameManager {
    constructor(storageKey = 'TFCDB', parentElementId = null, nameIdentifier = '', isSortNames = true, isSortByValue = false) {
        this.storageKey = storageKey;
        this.nameIdentifier = nameIdentifier;
        this.isSortNames = isSortNames;
        this.isSortByValue = isSortByValue;
        this.parentElementId = parentElementId;
        this.accordion = null;
        this.personNameMaster = null;
        this.init();
    }

    async init() {
        const accordionJsUrl = TfcGlobal.getFullFileUrl('Javascript/accordion.js');
        console.log(accordionJsUrl);
        const { Accordion } = await import(accordionJsUrl);
        this.accordion = new Accordion(`All ${this.nameIdentifier} Person Entries`, this.parentElementId);

        const personNameMasterJsUrl = TfcGlobal.getFullFileUrl('Tools/random-person-chart/person-name-master.js');
        console.log(personNameMasterJsUrl);
        const { PersonNameMaster } = await import(personNameMasterJsUrl);
        this.personNameMaster = new PersonNameMaster();

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
        // (UI creation code remains the same)
    }

    attachEventListeners() {
        this.inputBox.addEventListener('input', (e) => this.onInput(e));
        this.saveButton.addEventListener('click', () => this.saveEntry());
        this.deleteAllButton.addEventListener('click', () => this.confirmDeleteAll());
        this.exportButton.addEventListener('click', () => this.exportToClipboard());
        this.importButton.addEventListener('click', () => this.importFromTextbox());
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

    // (rest of the methods remain the same)
}
