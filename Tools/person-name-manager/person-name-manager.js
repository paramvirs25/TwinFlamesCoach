class PersonNameManager {
    constructor(storageKey = 'TFCDB') {
        this.storageKey = storageKey;
        this.namesCollapsed = true; // Initialize collapsed state
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
        // Create the main container
        this.container = document.createElement('div');
        this.container.style.display = 'flex';
        this.container.style.flexDirection = 'column';
        this.container.style.alignItems = 'center';
        this.container.style.justifyContent = 'center';
        this.container.style.height = '100vh';

        // Create the input box
        this.inputBox = document.createElement('input');
        this.inputBox.setAttribute('type', 'text');
        this.inputBox.setAttribute('placeholder', 'Enter a name');
        this.inputBox.style.marginBottom = '10px';

        // Create the save button
        this.saveButton = document.createElement('button');
        this.saveButton.textContent = 'Save Name';
        this.saveButton.style.marginBottom = '20px';

        // Create the auto-complete list
        this.autoCompleteList = document.createElement('ul');
        this.autoCompleteList.style.listStyleType = 'none';
        this.autoCompleteList.style.padding = '0';
        this.autoCompleteList.style.margin = '0';
        this.autoCompleteList.style.position = 'absolute';
        this.autoCompleteList.style.backgroundColor = 'white';
        this.autoCompleteList.style.border = '1px solid #ccc';
        this.autoCompleteList.style.display = 'none';

        // Create the toggle button for the name list
        this.toggleButton = document.createElement('button');
        this.toggleButton.textContent = 'All Person Names';
        this.toggleButton.style.marginBottom = '10px';

        // Create the sorted name list container
        this.nameListContainer = document.createElement('div');
        this.nameListContainer.style.display = 'none';

        // Create the button to delete all names
        this.deleteAllButton = document.createElement('button');
        this.deleteAllButton.textContent = 'Delete All Names';
        this.deleteAllButton.style.marginTop = '20px';

        // Append elements to the container
        this.container.appendChild(this.inputBox);
        this.container.appendChild(this.saveButton);
        this.container.appendChild(this.autoCompleteList);
        this.container.appendChild(this.toggleButton);
        this.container.appendChild(this.nameListContainer);
        this.container.appendChild(this.deleteAllButton);

        // Append the container to the document body
        document.body.appendChild(this.container);

        // Render the sorted name list
        this.renderNameList();
    }

    attachEventListeners() {
        this.inputBox.addEventListener('input', (e) => this.onInput(e));
        this.saveButton.addEventListener('click', () => this.saveName());
        this.toggleButton.addEventListener('click', () => this.toggleNameList());
        this.deleteAllButton.addEventListener('click', () => this.deleteAllNames());
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

    toggleNameList() {
        this.namesCollapsed = !this.namesCollapsed;
        this.nameListContainer.style.display = this.namesCollapsed ? 'none' : 'block';
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

            const deleteButton = document.createElement('button');
            deleteButton.textContent = 'Delete';
            deleteButton.addEventListener('click', () => this.deleteName(name));

            li.appendChild(deleteButton);
            ul.appendChild(li);
        });

        this.nameListContainer.appendChild(ul);
    }
}

// Instantiate the PersonNameManager
const personNameManager = new PersonNameManager();
