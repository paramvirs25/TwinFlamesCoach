function tfcChromeRequired() {
    // Create the <div> element
    var div = document.createElement("div");
    div.className = "tfc-footer";
  
    // Create the <p> element
    var paragraph = document.createElement("p");
    paragraph.textContent = "Attention: This website works best in Google Chrome App.";
  
    // Append the <p> element to the <div> element
    div.appendChild(paragraph);
  
    // Append the <div> element to the document body
    document.body.appendChild(div);
  }

  
window.addEventListener('load', () => {
    var isChromium = !!window.chrome;
    console.log("isChromium=" + isChromium);
    
    if(!isChromium){
        tfcChromeRequired();
    }
});