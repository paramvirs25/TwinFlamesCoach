class Popup_TFC {
    constructor(popupId) {
        this.popupId = popupId;
    }
    showPopup() {
        var popup = document.getElementById(this.popupId);
        if (!popup.classList.contains("show")) {
            popup.classList.add("show");
        }
    }

    hidePopup() {
        var popup = document.getElementById(this.popupId);
        popup.classList.remove("show");
    }


    setPopupWidth(inputWidth) {
        var popup = document.getElementById(this.popupId);
        popup.style.width = inputWidth;
    }
}