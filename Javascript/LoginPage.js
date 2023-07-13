window.addEventListener('load', function() {
    try {
        var formGroup = document.querySelector('.form-group.text-center.mb-0.p-0');
        var cardTitle = document.querySelector('.card-title.text-center.mb-4');
        if (formGroup && cardTitle) {
            cardTitle.parentNode.insertBefore(formGroup, cardTitle.nextSibling);
            var newElement = document.createElement('h4');
            newElement.innerHTML = 'OR';
			newElement.className = "card-title text-center mb-4";
            formGroup.parentNode.insertBefore(newElement, formGroup.nextSibling);
        } else {
            throw new Error('Could not find the specified elements on the page.');
        }
    } catch (error) {
        console.error(error);
    }
});
