class PageIcon {
    static setIcon() {
        const targetElement = document.querySelector("page-icon");
        
        if (targetElement) {
            // Use getAttribute to grab the URL from the tag
            const newIconUrl = targetElement.getAttribute('icon-url');
            
            if (!newIconUrl) return;

            const selectors = [
                "link[rel='icon']", 
                "link[rel='shortcut icon']", 
                "link[rel='apple-touch-icon']"
            ];
            
            const links = document.querySelectorAll(selectors.join(','));

            if (links.length > 0) {
                links.forEach(link => link.href = newIconUrl);
            } else {
                const link = document.createElement('link');
                link.rel = 'icon';
                link.href = newIconUrl;
                document.head.appendChild(link);
            }
        }
    }
}

// Run it
PageIcon.setIcon();