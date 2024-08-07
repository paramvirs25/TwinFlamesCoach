export class Accordion {
    constructor(headerText, parentElementId) {
        this.headerText = headerText;
        this.parentElementId = parentElementId;
        this.init();
    }

    init() {
        this.createUI();
        this.attachEventListeners();
    }

    createUI() {
        this.container = document.createElement('div');

        // Create the accordion header
        this.accordionHeader = document.createElement('div');
        this.accordionHeader.textContent = this.headerText;
        this.accordionHeader.style.cursor = 'pointer';
        this.accordionHeader.style.backgroundColor = '#f1f1f1';
        this.accordionHeader.style.padding = '10px';
        this.accordionHeader.style.border = '1px solid #ccc';
        this.accordionHeader.style.marginTop = '10px';
        this.accordionHeader.style.marginBottom = '10px';

        //create accordian body
        this.accordionBody = document.createElement('div');
        this.accordionBody.style.display = 'none';
        this.accordionBody.style.padding = '10px';
        this.accordionBody.style.border = '1px solid #ccc';
        this.accordionBody.style.borderTop = 'none';

        // Create the accordion content
        this.accordionContent = document.createElement('div');
        // this.accordionContent.style.display = 'none';
        // this.accordionContent.style.padding = '10px';
        // this.accordionContent.style.border = '1px solid #ccc';
        // this.accordionContent.style.borderTop = 'none';

        // Create the close button
        this.closeButton = document.createElement('button');
        this.closeButton.textContent = 'Close';
        this.closeButton.style.marginTop = '10px';

        this.accordionBody.appendChild(this.accordionContent);
        this.accordionBody.appendChild(this.closeButton);

        //this.accordionContent.appendChild(this.closeButton);
        this.container.appendChild(this.accordionHeader);
        this.container.appendChild(this.accordionBody);
        

        const targetDiv = document.getElementById(this.parentElementId);
        if (targetDiv) {
            targetDiv.appendChild(this.container);
        } else {
            document.body.appendChild(this.container);
        }
    }

    attachEventListeners() {
        this.accordionHeader.addEventListener('click', () => this.toggleAccordion());
        this.closeButton.addEventListener('click', () => this.closeAccordion());
    }

    toggleAccordion() {
        if (this.accordionBody.style.display === 'none') {
            this.accordionBody.style.display = 'block';
        } else {
            this.accordionBody.style.display = 'none';
        }
    }

    closeAccordion() {
        this.accordionBody.style.display = 'none';
        this.accordionHeader.scrollIntoView({ behavior: 'smooth' });
    }

    setContent(htmlContent) {
        // Ensure the close button is always at the end
        this.accordionContent.innerHTML = htmlContent;
        //this.accordionContent.insertAdjacentHTML('afterbegin', htmlContent);
        //this.accordionContent.appendChild(this.closeButton);
    }

    appendContent(htmlContent) {
        this.accordionContent.insertAdjacentHTML('afterbegin', htmlContent);
        //this.accordionContent.appendChild(this.closeButton);
    }

    getContent() {
        return this.accordionContent.innerHTML;
    }
}
