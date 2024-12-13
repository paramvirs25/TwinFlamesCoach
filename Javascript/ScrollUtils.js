class ScrollUtils {
    static scrollToTargetAdjusted(elements) {
        if (elements.length > 0) {
            const HEADER_HEIGHT = 0; //set 60 for floating header;
            const elementPosition = elements[0].getBoundingClientRect().top;
            const offsetPosition = elementPosition - HEADER_HEIGHT;

            window.scrollBy({
                top: offsetPosition,
                behavior: "smooth"
            });
        }
    }

    static scrollToTop() {
        var scrollToElementName = "h1";
        if(TfcGlobalScroll.ScrollTo != null){
            scrollToElementName = TfcGlobalScroll.ScrollTo;
        }

        ScrollUtils.scrollToTargetAdjusted(document.querySelectorAll(scrollToElementName));
        //document.getElementsByClassName('pageViewCount')
    }
}

try{
    // If page URL does not contains '#'
    if (!window.location.href.includes('#')) {
        ScrollUtils.scrollToTop();
    }    
}catch(e){
    console.log(e);
}