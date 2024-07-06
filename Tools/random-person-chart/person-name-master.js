export class PersonNameMaster {
    constructor() {
        this.storageKey = 'TFCNameStorage';
        this.names = this.getNamesFromStorage();
        this.createModal();
        this.init();
        //this.accordion = new Accordion('Stored Names', this.modalContent.id);
    }

    async init() {
        const { Accordion } = await import(TfcGlobal.AccordionJsUrl);
        this.accordion = new Accordion(`Stored Names`, this.modalContent.id);
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
        let content = '<ul>';
        this.names.forEach(name => {
            content += `<li>${name}</li>`;
        });
        content += '</ul>';
        this.accordion.setContent(content);
    }
}
