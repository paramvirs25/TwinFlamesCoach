class ScrollUtils {
    static scrollToTargetAdjusted(elements) {
        if (elements.length > 0) {
            const HEADER_HEIGHT = 0; // set 60 for floating header;
            const elementPosition = elements[0].getBoundingClientRect().top;
            const offsetPosition = elementPosition - HEADER_HEIGHT;

            window.scrollBy({
                top: offsetPosition,
                behavior: "smooth"
            });
        }
    }

    static scrollToTop() {
        const targetTag = "TfcScrollHere"; // Tag to look for
        let elementToScrollTo;

        // Find the target element with the tag
        const targetElement = document.querySelector(targetTag);
        if (targetElement) {
            // Get the previous sibling if it exists
            elementToScrollTo = [targetElement.previousElementSibling || targetElement];
        }else{
            elementToScrollTo = document.querySelectorAll("h1");
        }

        if (elementToScrollTo) {
            ScrollUtils.scrollToTargetAdjusted(elementToScrollTo);
        }
    }
}

try {
    // Check if the page URL does not contain '#' and the page has not been scrolled
    if (!window.location.href.includes('#') && window.scrollY === 0) {
        ScrollUtils.scrollToTop();
    }    
} catch (e) {
    console.log(e);
}