class ScrollUtils {
    static scrollToTargetAdjusted(cssClass) {
        const elements = document.getElementsByClassName(cssClass);

        if (elements.length > 0) {
            const HEADER_HEIGHT = 60;
            const elementPosition = elements[0].getBoundingClientRect().top;
            const offsetPosition = elementPosition - HEADER_HEIGHT;

            window.scrollBy({
                top: offsetPosition,
                behavior: "smooth"
            });
        }
    }

    static scrollToTop() {
        ScrollUtils.scrollToTargetAdjusted('pageViewCount');
    }
}