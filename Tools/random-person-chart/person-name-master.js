export class PersonNameMaster {
    constructor() {
        this.storageKey = 'TFCNameStorage';
        this.names = this.getNamesFromStorage();
        this.createModal();
        this.init();
    }

    async init() {
        const { Accordion } = await import(TfcGlobal.AccordionJsUrl);
        this.accordion = new Accordion('Stored Names', this.modalContent.id);
        this.renderAccordionContent();
        this.createToolsSection();
        this.attachToolsEventListeners();
    }

    getNamesFromStorage() {
        const names = localStorage.getItem(this.storageKey);
        return names ? JSON.parse(names) : [];
    }

    saveNamesToStorage() {
        localStorage.setItem(this.storageKey, JSON.stringify(this.names));
    }

    addName(name) {
        const normalizedName = name.trim().toLowerCase();
        if (!this.names.some(n => n.trim().toLowerCase() === normalizedName)) {
            this.names.push(name.trim());
            this.saveNamesToStorage();
            this.renderAccordionContent();
        }
    }

    createModal() {
        // Create modal elements
        this.modal = document.createElement('div');
        this.modal.style.display = 'none';
        this.modal.style.position = 'fixed';
        this.modal.style.zIndex = '1000';
        this.modal.style.left = '0';
        this.modal.style.top = '0';
        this.modal.style.width = '100%';
        this.modal.style.height = '100%';
        this.modal.style.overflow = 'auto';
        this.modal.style.backgroundColor = 'rgba(0, 0, 0, 0.4)';

        this.modalContent = document.createElement('div');
        this.modalContent.id = 'modalContent';
        this.modalContent.style.backgroundColor = '#fefefe';
        this.modalContent.style.margin = 'auto';
        this.modalContent.style.padding = '20px';
        this.modalContent.style.border = '1px solid #888';
        this.modalContent.style.width = '80%';
        this.modalContent.style.position = 'relative';
        this.modalContent.style.top = '50%';
        this.modalContent.style.transform = 'translateY(-50%)';

        this.inputBox = document.createElement('input');
        this.inputBox.setAttribute('type', 'text');
        this.inputBox.setAttribute('placeholder', 'Search or enter name');
        this.inputBox.style.width = 'calc(100% - 20px)';
        this.inputBox.style.marginBottom = '10px';

        this.autoCompleteList = document.createElement('ul');
        this.autoCompleteList.style.listStyleType = 'none';
        this.autoCompleteList.style.padding = '0';
        this.autoCompleteList.style.margin = '0';
        this.autoCompleteList.style.maxHeight = '200px';
        this.autoCompleteList.style.overflowY = 'auto';
        this.autoCompleteList.style.border = '1px solid #ccc';
        this.autoCompleteList.style.display = 'none';

        const buttonContainer = document.createElement('div');
        buttonContainer.style.textAlign = 'right';

        this.okButton = document.createElement('button');
        this.okButton.textContent = 'OK';

        this.cancelButton = document.createElement('button');
        this.cancelButton.textContent = 'Cancel';

        buttonContainer.appendChild(this.okButton);
        buttonContainer.appendChild(this.cancelButton);

        this.modalContent.appendChild(this.inputBox);
        this.modalContent.appendChild(this.autoCompleteList);
        this.modalContent.appendChild(buttonContainer);
        this.modal.appendChild(this.modalContent);
        document.body.appendChild(this.modal);

        this.attachEventListeners();
    }

    attachEventListeners() {
        this.inputBox.addEventListener('input', () => this.onInput());
        this.okButton.addEventListener('click', () => this.onOk());
        this.cancelButton.addEventListener('click', () => this.closeModal());

        document.addEventListener('click', (event) => {
            if (event.target === this.modal) {
                this.closeModal();
            }
        });
    }

    onInput() {
        const query = this.inputBox.value.trim().toLowerCase();
        this.autoCompleteList.innerHTML = '';

        if (query) {
            const filteredNames = this.names.filter(name => name.trim().toLowerCase().includes(query));
            filteredNames.forEach(name => {
                const listItem = document.createElement('li');
                listItem.textContent = name;
                listItem.style.cursor = 'pointer';
                listItem.addEventListener('click', () => this.onAutoCompleteSelect(name));
                this.autoCompleteList.appendChild(listItem);
            });
            this.autoCompleteList.style.display = filteredNames.length ? 'block' : 'none';
        } else {
            this.autoCompleteList.style.display = 'none';
        }
    }

    onAutoCompleteSelect(name) {
        this.inputBox.value = name;
        this.autoCompleteList.style.display = 'none';
    }

    onOk() {
        const name = this.inputBox.value.trim();
        if (name) {
            this.addName(name);
            if (this.callback) {
                this.callback(name);
            }
            this.closeModal();
        }
    }

    openModal(callback) {
        this.callback = callback;
        this.inputBox.value = '';
        this.autoCompleteList.innerHTML = '';
        this.autoCompleteList.style.display = 'none';
        this.modal.style.display = 'block';
        this.renderAccordionContent();
    }

    closeModal() {
        this.modal.style.display = 'none';
    }

    renderAccordionContent() {
        // Clear existing content
        this.autoCompleteList.innerHTML = '';
    
        // Create the content string for the accordion
        let content = '<ol>';
        this.names.forEach(name => {
            content += `<li>${name}</li>`;
        });
        content += '</ol>';
    
        // Update the accordion content
        if (this.accordion) {
            this.accordion.setContent(content);
        }
    
        // Re-attach the scroll functionality
        if (this.autoCompleteList.scrollTop !== 0) {
            this.autoCompleteList.scrollTop = 0; // Reset scroll position to the top
        }
    }
    

    createToolsSection() {
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

        // Create the input box
        this.toolsInputBox = document.createElement('input');
        this.toolsInputBox.setAttribute('type', 'text');
        this.toolsInputBox.setAttribute('placeholder', 'Enter a name');
        this.toolsInputBox.style.marginRight = '10px';

        // Create the save button
        this.toolsSaveButton = document.createElement('button');
        this.toolsSaveButton.textContent = 'Save';
        this.toolsSaveButton.className = 'wp-block-button__link wp-element-button';
        this.toolsSaveButton.style.marginRight = '10px';

        // Create the auto-complete list
        this.toolsAutoCompleteList = document.createElement('ul');
        this.toolsAutoCompleteList.style.listStyleType = 'none';
        this.toolsAutoCompleteList.style.padding = '0';
        this.toolsAutoCompleteList.style.margin = '0';
        this.toolsAutoCompleteList.style.position = 'absolute';
        this.toolsAutoCompleteList.style.backgroundColor = 'white';
        this.toolsAutoCompleteList.style.border = '1px solid #ccc';
        this.toolsAutoCompleteList.style.display = 'none';

        // Create the button to delete all entries
        this.deleteAllButton = document.createElement('button');
        this.deleteAllButton.textContent = 'Delete All Names';
        this.deleteAllButton.className = 'wp-block-button__link wp-element-button';
        this.deleteAllButton.style.marginTop = '10px';

        // Create the export to clipboard button
        this.exportButton = document.createElement('button');
        this.exportButton.textContent = 'Export To Clipboard';
        this.exportButton.className = 'wp-block-button__link wp-element-button';
        this.exportButton.style.marginTop = '10px';

        // Create the import names with commas button
        this.importButton = document.createElement('button');
        this.importButton.textContent = 'Import Names with Commas';
        this.importButton.className = 'wp-block-button__link wp-element-button';
        this.importButton.style.marginTop = '10px';

        // Append elements to the accordion content
        this.accordion.accordionContent.appendChild(this.toolsToggleLink);
        this.accordion.accordionContent.appendChild(this.toolsContainer);

        this.toolsContainer.appendChild(this.toolsAutoCompleteList);
        this.toolsContainer.appendChild(this.toolsInputBox);
        this.toolsContainer.appendChild(this.toolsSaveButton);
        this.toolsContainer.appendChild(document.createElement('br'));
        this.toolsContainer.appendChild(this.deleteAllButton);
        this.toolsContainer.appendChild(document.createElement('br'));
        this.toolsContainer.appendChild(this.exportButton);
        this.toolsContainer.appendChild(document.createElement('br'));
        this.toolsContainer.appendChild(this.importButton);
    }

    attachToolsEventListeners() {
        this.toolsInputBox.addEventListener('input', (e) => this.onToolsInput(e));
        this.toolsSaveButton.addEventListener('click', () => this.saveEntryFromTools());
        this.deleteAllButton.addEventListener('click', () => this.confirmDeleteAllNames());
        this.exportButton.addEventListener('click', () => this.exportNames());
        this.importButton.addEventListener('click', () => this.importNames());
        this.toolsToggleLink.addEventListener('click', (e) => {
            e.preventDefault();
            this.toolsContainer.style.display = this.toolsContainer.style.display === 'none' ? 'block' : 'none';
        });
    }

    onToolsInput() {
        const query = this.toolsInputBox.value.trim().toLowerCase();
        this.toolsAutoCompleteList.innerHTML = '';

        if (query) {
            const filteredNames = this.names.filter(name => name.trim().toLowerCase().includes(query));
            filteredNames.forEach(name => {
                const listItem = document.createElement('li');
                listItem.textContent = name;
                listItem.style.cursor = 'pointer';
                listItem.addEventListener('click', () => this.onToolsAutoCompleteSelect(name));
                this.toolsAutoCompleteList.appendChild(listItem);
            });
            this.toolsAutoCompleteList.style.display = filteredNames.length ? 'block' : 'none';
        } else {
            this.toolsAutoCompleteList.style.display = 'none';
        }
    }

    onToolsAutoCompleteSelect(name) {
        this.toolsInputBox.value = name;
        this.toolsAutoCompleteList.style.display = 'none';
    }

    saveEntryFromTools() {
        const name = this.toolsInputBox.value.trim();
        if (name) {
            this.addName(name);
            this.toolsInputBox.value = '';
            this.toolsAutoCompleteList.innerHTML = '';
            this.toolsAutoCompleteList.style.display = 'none';
            this.renderAccordionContent();
        }
    }

    confirmDeleteAllNames() {
        if (window.confirm('Are you sure you want to delete all names?')) {
            this.deleteAllNames();
        }
    }

    deleteAllNames() {
        this.names = [];
        this.saveNamesToStorage();
        this.renderAccordionContent();
    }

    exportNames() {
        const namesString = this.names.join(', ');
        navigator.clipboard.writeText(namesString)
            .then(() => alert('Names exported to clipboard!'))
            .catch(err => alert('Failed to export names to clipboard.'));
    }

    importNames() {
        const namesString = prompt('Enter names separated by commas:');
        if (namesString) {
            const importedNames = namesString.split(',').map(name => name.trim()).filter(name => name);
            this.names = [...new Set([...this.names, ...importedNames])];
            this.saveNamesToStorage();
            this.renderAccordionContent();
        }
    }
}
