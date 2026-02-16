// --- Trusted Types Policy ---
const escapeHTMLPolicy = trustedTypes.createPolicy("forceInner", {
  createHTML: (to_escape) => to_escape
});

let autoSubmitResponse_tfc = true;

// --- Helper: Wait for element to appear in DOM ---
function waitForElement(selector, timeout = 3000) {
  return new Promise((resolve, reject) => {
    const element = document.querySelector(selector);
    if (element) return resolve(element);

    const observer = new MutationObserver(() => {
      const el = document.querySelector(selector);
      if (el) {
        observer.disconnect();
        resolve(el);
      }
    });

    observer.observe(document.body, { childList: true, subtree: true });
    setTimeout(() => {
      observer.disconnect();
      reject('Timeout waiting for ' + selector);
    }, timeout);
  });
}

// --- Helper: Safe click with wait ---
function clickWhenReady(selector, maxWait = 2000) {
  const start = Date.now();
  const timer = setInterval(() => {
    const btn = document.querySelector(selector);
    if (btn) {
      clearInterval(timer);
      btn.click();
    } else if (Date.now() - start > maxWait) {
      clearInterval(timer);
      console.warn('Timeout: button not found for', selector);
    }
  }, 200);
}

// --- Main click handler for canned response ---
function cannedResponseClicked(element) {
  setTimeout(() => {
    if (autoSubmitResponse_tfc) {
      clickWhenReady('#submit-button');
    }
    const commentActionsDiv = element.parentElement?.parentElement;
    const likeButton = commentActionsDiv?.querySelector('#like-button');
    likeButton?.click();
  }, 500);
}

// --- Adds search + filter box in TubeBuddy canned reply menu ---
async function addTextboxAndFilter(element, qTipId) {
  try {
    const headerSelector = `#qtip-${qTipId}-content .tb-comment-filter-studio-comment-menu-header-text`;
    const bodySelector = `#qtip-${qTipId}-content .tb-comment-filter-studio-comment-menu-body`;

    const targetDiv = await waitForElement(headerSelector);
    const menuBody = await waitForElement(bodySelector);

    targetDiv.innerHTML = escapeHTMLPolicy.createHTML(`
      <input type="text" id="searchCannedResponse-${qTipId}" placeholder="Search"> 
      <label style="margin-left:8px;">
        <input type="checkbox" id="autoSubmitCannedResponse-${qTipId}" ${autoSubmitResponse_tfc ? 'checked' : ''}>
        
      </label>
    `);

    const cannedResponses = menuBody.querySelectorAll('.tb-comment-filter-studio-menu-cannedResponse');

    // Search filter
    document.querySelector(`#searchCannedResponse-${qTipId}`).addEventListener('input', function () {
      const value = this.value.toLowerCase().trim();
      cannedResponses.forEach(cannedResponse => {
        const textEl = cannedResponse.querySelectorAll('.tb-inline-block')[1];
        const text = textEl ? textEl.textContent.toLowerCase() : '';
        cannedResponse.style.display = text.includes(value) ? '' : 'none';
      });
    });

    // Checkbox change event
    document.querySelector(`#autoSubmitCannedResponse-${qTipId}`).addEventListener('change', function () {
      autoSubmitResponse_tfc = this.checked;
      console.log('Auto-submit set to:', autoSubmitResponse_tfc);
    });

    // Add click handler to each canned response
    cannedResponses.forEach(cannedResponse => {
      if (!cannedResponse._hasHandler) {
        cannedResponse.addEventListener('click', () => cannedResponseClicked(element));
        cannedResponse._hasHandler = true;
      }
    });

    document.querySelector(`#searchCannedResponse-${qTipId}`).focus();
  } catch (e) {
    console.error('Error in addTextboxAndFilter:', e);
  }
}

// --- When TubeBuddy menu icon is clicked ---
function onTubeBuddyClick(element) {
  const parentDiv = element.parentElement;
  const qTip = parentDiv.getAttribute('data-hasqtip');
  setTimeout(() => {
    addTextboxAndFilter(element, qTip);
  }, 500);
}

function handleReplyProcess(gButton) {

  const MESSAGE = "God Bless You.\n- Team Twin Flames Coach";
  console.log("G-Reply: Waiting for reply dialog...");

  const interval = setInterval(() => {

    const replyDialog = document.querySelector('#reply-dialog-container');
    if (!replyDialog) return;

    const textarea = replyDialog.querySelector('textarea#textarea');
    if (!textarea) return;

    clearInterval(interval);

    console.log("G-Reply: Reply dialog ready, inserting message");

    // focus first (important for YouTube composer)
    textarea.focus();

    // use native setter (YouTube requires this)
    const nativeSetter = Object.getOwnPropertyDescriptor(
      window.HTMLTextAreaElement.prototype,
      "value"
    ).set;

    nativeSetter.call(textarea, MESSAGE);

    // notify YouTube UI
    textarea.dispatchEvent(new Event('input', { bubbles: true }));
    textarea.dispatchEvent(new Event('change', { bubbles: true }));

    console.log("G-Reply: Message inserted");

    // now use the SAME submission flow as canned responses
    setTimeout(() => {

      console.log("G-Reply: Calling cannedResponseClicked");

      // find the correct row container
      const rowContainer = gButton.closest('#row-container');

      if (!rowContainer) {
        console.warn("G-Reply: row-container not found");
        return;
      }

      // fabricate a compatible element so cannedResponseClicked works
      const fakeElement = {
        parentElement: {
          parentElement: rowContainer
        }
      };

      cannedResponseClicked(fakeElement);

    }, 700); // allow composer to enable submit

  }, 300);
}



function triggerGButton(btn) {

  if (!btn) return;

  // look only inside the same container
  const container = btn.parentElement;
  if (!container) return;

  // YouTube internal menu button
  const ytButton = container.querySelector(
    'button[aria-label][class*="ytcpButtonShapeImplHost"]'
  );

  if (!ytButton) {
    console.log('Target YouTube button not found');
    return;
  }

  // simulate real user press (more reliable than .click())
  ytButton.dispatchEvent(new PointerEvent('pointerdown', { bubbles: true }));
  ytButton.dispatchEvent(new MouseEvent('mousedown', { bubbles: true }));
  ytButton.dispatchEvent(new MouseEvent('mouseup', { bubbles: true }));
  ytButton.dispatchEvent(new MouseEvent('click', { bubbles: true }));
}


function createGButton(element) {

  if (!element || !element.parentElement) return;

  // prevent duplicate button
  if (element.parentElement.querySelector('.g-proxy-btn')) return;

  const btn = document.createElement('button');
  btn.type = 'button';
  btn.textContent = 'G';
  btn.className = 'g-proxy-btn';

  // simple styling (optional)
  btn.style.marginLeft = '6px';
  btn.style.cursor = 'pointer';
  btn.style.padding = '4px 8px';
  btn.style.borderRadius = '6px';
  btn.style.border = '1px solid #888';
  btn.style.background = '#202124';
  btn.style.color = '#fff';
  btn.style.fontSize = '12px';

  // click → call separate method
  btn.addEventListener('click', function(e) {
    triggerGButton(e.currentTarget);

    // wait for dialog and auto-reply
    handleReplyProcess(e.currentTarget);
  });

  // place button after your element
  element.parentElement.insertAdjacentElement('afterend', btn);
}


// --- Attach click handlers to TubeBuddy menu icons ---
function attachHandlerToElement(element) {
  if (!element.onclick || element.onclick.toString().indexOf('onTubeBuddyClick') === -1) {
    element.insertAdjacentHTML('afterend', escapeHTMLPolicy.createHTML('✓'));
    createGButton(element);
    element.onclick = () => onTubeBuddyClick(element);
  }
}

function initHandlers() {
  const elements = document.querySelectorAll('.tb-comment-filter-studio-menu-container-down');
  elements.forEach(attachHandlerToElement);
}

// Run once on page load
initHandlers();

// Watch for dynamically added TubeBuddy elements
const observer = new MutationObserver((mutationsList) => {
  for (const mutation of mutationsList) {
    mutation.addedNodes.forEach(node => {
      if (node.nodeType === 1) {
        if (node.matches && node.matches('.tb-comment-filter-studio-menu-container-down')) {
          attachHandlerToElement(node);
        } else {
          const innerElements = node.querySelectorAll?.('.tb-comment-filter-studio-menu-container-down');
          innerElements.forEach(attachHandlerToElement);
        }
      }
    });
  }
});
observer.observe(document.body, { childList: true, subtree: true });

console.log('✅ TubeBuddy Canned Response Enhancer Loaded');
