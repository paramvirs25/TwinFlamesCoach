escapeHTMLPolicy = trustedTypes.createPolicy("forceInner", {
  createHTML: (to_escape) => to_escape
});

var autoSubmitResponse_tfc = true;


function cannedResponseClicked(element) {
  setTimeout(function () {
    if(autoSubmitResponse_tfc){
      //When canned response is selected, auto submit the comment
      const submitButton = document.querySelector('#submit-button');
      submitButton.click();
    }

    //like comment
    const commentActionsDiv = element.parentElement.parentElement;
    const likeButton = commentActionsDiv.querySelector('#like-button');
    likeButton.click();
  }, 500);
}

function addTextboxAndFilter(element, qTipId) {
  try {
    const targetDiv = document.querySelector('#qtip-' + qTipId + '-content .tb-comment-filter-studio-comment-menu-header-text');

    targetDiv.innerHTML = escapeHTMLPolicy.createHTML(
      '<input type="text" id="searchCannedResponse-' + qTipId + '" placeholder="Search"> '+
      '<input type="checkbox" alt="Submit reply?" id="autoSubmitCannedResponse-' + qTipId + '" checked=' + autoSubmitResponse_tfc + '>'
    );

    const menuBody = document.querySelector('#qtip-' + qTipId + '-content .tb-comment-filter-studio-comment-menu-body');
    const cannedResponses = menuBody.querySelectorAll('.tb-comment-filter-studio-menu-cannedResponse');

    document.querySelector('#searchCannedResponse-' + qTipId).addEventListener('input', function () {
      const value = this.value.toLowerCase().trim();
      cannedResponses.forEach(function (cannedResponse) {
        const text = cannedResponse.querySelectorAll('.tb-inline-block')[1].textContent.toLowerCase();
        if (text.includes(value)) {
          cannedResponse.style.display = '';
        } else {
          cannedResponse.style.display = 'none';
        }
      });
    });

    document.querySelector('#autoSubmitCannedResponse-' + qTipId).addEventListener('change', function () {
      autoSubmitResponse_tfc = this.checked;
      console.log(autoSubmitResponse_tfc);
    });


    //if (autoSubmitResponse_tfc) {
      //add click handler on canned response
      cannedResponses.forEach(function (cannedResponse) {
        if (!cannedResponse.onclick || cannedResponse.onclick.toString().indexOf('cannedResponseClicked') === -1) {
          cannedResponse.addEventListener('click', () => {
            cannedResponseClicked(element);
          });
        }
      });
    //}

    document.querySelector('#searchCannedResponse-' + qTipId).focus();
  } catch (e) {
    console.log(e);
  }
}

function onTubeBuddyClick(element) {
  const parentDiv = element.parentElement;
  const qTip = parentDiv.getAttribute('data-hasqtip');

  setTimeout(() => {
    addTextboxAndFilter(element, qTip);
  }, 500); // delay of 0.5 seconds (500 milliseconds)
}


const elements = document.querySelectorAll('.tb-comment-filter-studio-menu-container-down');

elements.forEach(element => {
  console.log(element.onclick);
  
  if (element.onclick === null || element.onclick.toString().indexOf('onTubeBuddyClick') === -1) {
    element.insertAdjacentHTML('afterend', escapeHTMLPolicy.createHTML('✓'));
    element.onclick = () => {
      onTubeBuddyClick(element);      
    };
  }
});

