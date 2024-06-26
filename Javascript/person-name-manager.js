class PersonNameManager {
    constructor(storageKey = 'TFCDB') {
        this.storageKey = storageKey;
        this.init();
    }

    init() {
        this.names = this.getNamesFromStorage();
        this.createUI();
        this.attachEventListeners();
    }

    getNamesFromStorage() {
        const names = localStorage.getItem(this.storageKey);
        return names ? JSON.parse(names) : [];
    }

    saveNamesToStorage() {
        localStorage.setItem(this.storageKey, JSON.stringify(this.names));
    }

    createUI() {
        this.container = document.createElement('div');
        this.container.style.margin = '10px';

        // Create the input box
        this.inputBox = document.createElement('input');
        this.inputBox.setAttribute('type', 'text');
        this.inputBox.setAttribute('placeholder', 'Enter a name');
        this.inputBox.style.marginRight = '10px';

        // Create the save button
        this.saveButton = document.createElement('button');
        this.saveButton.textContent = 'Save Name';
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
        this.accordionHeader.textContent = 'All Person Names';
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

        // Create the sorted name list container
        this.nameListContainer = document.createElement('div');

        // Create the button to delete all names
        this.deleteAllButton = document.createElement('button');
        this.deleteAllButton.textContent = 'Delete All Names';
        this.deleteAllButton.style.marginTop = '10px';

        // Append elements to the container
        this.container.appendChild(this.inputBox);
        this.container.appendChild(this.saveButton);
        this.container.appendChild(this.autoCompleteList);
        this.accordionContent.appendChild(this.nameListContainer);
        this.accordionContent.appendChild(this.deleteAllButton);
        this.container.appendChild(this.accordionHeader);
        this.container.appendChild(this.accordionContent);

        // Check for the div with id 'divPersonNameManager'
        const targetDiv = document.getElementById('divPersonNameManager');
        if (targetDiv) {
            targetDiv.appendChild(this.container);
        } else {
            document.body.appendChild(this.container);
        }

        // Render the sorted name list
        this.renderNameList();
    }

    attachEventListeners() {
        this.inputBox.addEventListener('input', (e) => this.onInput(e));
        this.saveButton.addEventListener('click', () => this.saveName());
        this.accordionHeader.addEventListener('click', () => this.toggleAccordion());
        this.deleteAllButton.addEventListener('click', () => this.confirmDeleteAll());
    }

    onInput(event) {
        const query = event.target.value.toLowerCase();
        this.autoCompleteList.innerHTML = '';

        if (query) {
            const filteredNames = this.names.filter(name => name.toLowerCase().includes(query));
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

    saveName() {
        const name = this.inputBox.value.trim();
        if (name && !this.names.includes(name)) {
            this.names.push(name);
            this.names.sort();
            this.saveNamesToStorage();
            this.renderNameList();
            this.inputBox.value = '';
            this.autoCompleteList.style.display = 'none';
        }
    }

    toggleAccordion() {
        this.accordionContent.style.display = this.accordionContent.style.display === 'none' ? 'block' : 'none';
    }

    confirmDeleteAll() {
        if (confirm('Are you sure you want to delete all names?')) {
            this.deleteAllNames();
        }
    }

    deleteName(name) {
        this.names = this.names.filter(n => n !== name);
        this.saveNamesToStorage();
        this.renderNameList();
    }

    deleteAllNames() {
        this.names = [];
        this.saveNamesToStorage();
        this.renderNameList();
    }

    renderNameList() {
        this.nameListContainer.innerHTML = '';
        const ul = document.createElement('ul');
        ul.style.listStyleType = 'none';
        ul.style.padding = '0';
        ul.style.margin = '0';

        this.names.forEach(name => {
            const li = document.createElement('li');
            li.textContent = name;

            const deleteButton = document.createElement('span');
            deleteButton.textContent = ' X';
            deleteButton.style.color = 'red';
            deleteButton.style.cursor = 'pointer';
            deleteButton.style.marginLeft = '10px';
            deleteButton.addEventListener('click', () => this.deleteName(name));

            li.appendChild(deleteButton);
            ul.appendChild(li);
        });

        this.nameListContainer.appendChild(ul);
    }
}

// Instantiate the PersonNameManager
const personNameManager = new PersonNameManager();
