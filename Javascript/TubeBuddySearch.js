function cannedResponseClicked(element) {
    setTimeout(function() {
      //When canned response is selected, auto submit the comment
      const submitButton = document.querySelector('#submit-button');
      submitButton.click();
  
      //div comment-actions
      const commentActionsDiv = element.parentElement.parentElement;
      const likeButton = commentActionsDiv.querySelector('#like-button');
      likeButton.click();
    }, 500);
  }
  
  function addTextboxAndFilter(element, qTipId) {
    try {
      const targetDiv = document.querySelector('#qtip-' + qTipId + '-content .tb-comment-filter-studio-comment-menu-header-text');
      targetDiv.innerHTML = '<input type="text" id="searchCannedResponse-' + qTipId + '" placeholder="Search">';
  
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
  
      //add click handler on canned response
      cannedResponses.forEach(function(cannedResponse) {
        if (!cannedResponse.onclick || cannedResponse.onclick.toString().indexOf('cannedResponseClicked') === -1) {
          cannedResponse.addEventListener('click', () => {
            cannedResponseClicked(element);
          });
        }
      });

      document.querySelector('#searchCannedResponse-' + qTipId).focus();
    } catch (e) {
      console.log(e);
    }
  }
  
  const elements = document.querySelectorAll('.tb-comment-filter-studio-menu-container-down');
  
  elements.forEach(element => {
    element.addEventListener('click', () => {
      const parentDiv = element.parentElement;
      const qTip = parentDiv.getAttribute('data-hasqtip');
  
      setTimeout(() => {
        addTextboxAndFilter(element, qTip);
      }, 500); // delay of 0.5 seconds (500 milliseconds)
    });
  });
  