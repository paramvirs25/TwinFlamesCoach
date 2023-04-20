function tfc_processCertificateLinks(){
    tfc_createCertificationLinks("chakra_balancing_certificate_url", "Chakra Healing & Balancing");				
}

function tfc_createCertificationLinks(fieldId, linkLabel){
    try{
        var field = document.getElementById(fieldId);

        if(field != undefined){
            var linkUrl = field.value;			

            //always hide this input field for user as it is being relaced with hyperlink
            field.style.display = 'none';

            //if field have value then create a hyperlink using it
            if(linkUrl != ""){
                var link = document.createElement("a");
                link.href = linkUrl;
                link.target = "_new";
                link.innerHTML = "Download " + linkLabel + " Certificate";
                field.insertAdjacentElement("afterend", link);
            }
        }		
    }
    catch(e){
        console.log("Exception while creating certificate links in user account screen - " + e);
    }
}

window.onload = tfc_processCertificateLinks();