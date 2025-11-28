(function() {

  const threads = Array.from(document.querySelectorAll(
    "ytcp-comment-thread.style-scope.ytcp-comments-section"
  ));

  console.log("Found threads:", threads.length);

  let index = 0;

  function processNextThread() {
    if (index >= threads.length) {
      console.log("Finished all threads.");
      return;
    }

    const thread = threads[index];
    console.log("Processing thread", index + 1, "/", threads.length);

    // ⭐ NEW CHECK → skip if button already exists
    if (thread.querySelector(".tfc-track-btn")) {
      console.log("Tracking button already present → skipping thread");
      index++;
      setTimeout(processNextThread, 500);
      return;
    }

    // Get all Reply buttons inside this thread
    const replyButtons = Array.from(
      thread.querySelectorAll(".ytcpButtonShapeImpl__button-text-content")
    ).filter(el => el.textContent.trim() === "Reply");

    if (replyButtons.length === 0) {
      console.log("No reply button found in this thread.");
      index++;
      setTimeout(processNextThread, 1000);
      return;
    }

    // Use the last Reply button as anchor
    const lastReplyBtn = replyButtons[replyButtons.length - 1];

    // ===== Create tracking button next to last Reply button (if not present) =====
    try {
      // Some buttons are nested inside spans - find a stable container to append into
      const anchor = lastReplyBtn.parentElement || lastReplyBtn;

      // Only add if not already present inside the same parent
      if (!anchor.querySelector || !anchor.querySelector(".tfc-track-btn")) {
        const markBtn = document.createElement("button");
        markBtn.innerText = "Tracked";
        markBtn.className = "tfc-track-btn";
        markBtn.title = "This thread is tracked / will be processed";
        // style (small, non-intrusive)
        markBtn.style.marginLeft = "6px";
        markBtn.style.padding = "2px 6px";
        markBtn.style.border = "1px solid #999";
        markBtn.style.borderRadius = "4px";
        markBtn.style.background = "#f3f7e8";
        markBtn.style.cursor = "default";
        markBtn.style.fontSize = "12px";
        markBtn.style.lineHeight = "20px";
        // append to anchor; if anchor is a text node, fallback to thread element
        if (anchor.appendChild) {
          anchor.appendChild(markBtn);
        } else {
          thread.appendChild(markBtn);
        }
        console.log("Added tracking button next to last Reply button.");
      } else {
        console.log("Anchor already has tracking button; skipping creation.");
      }
    } catch (e) {
      console.warn("Could not add tracking button (falling back).", e);
      // fallback: add to thread root
      if (!thread.querySelector(".tfc-track-btn")) {
        const fallbackBtn = document.createElement("button");
        fallbackBtn.innerText = "Tracked";
        fallbackBtn.className = "tfc-track-btn";
        fallbackBtn.style.margin = "6px";
        thread.appendChild(fallbackBtn);
        console.log("Added fallback tracking button on thread root.");
      }
    }

    // Click last reply button
    lastReplyBtn.click();
    console.log("Clicked reply");

    // Step 2: Wait for the textarea to appear
    waitForElement(
      'ytcp-commentbox textarea[placeholder="Add a reply..."]',
      20,
      function(textarea) {
        if (!textarea) {
          console.log("Textarea not found, skipping thread");
          index++;
          setTimeout(processNextThread, 1500);
          return;
        }

        textarea.focus();
        textarea.value = "God bless you";
        textarea.dispatchEvent(new Event("input", { bubbles: true }));
        console.log("Typed message");

        // Step 3: Wait for submit (Reply) button
        waitForElement(
          'ytcp-commentbox #submit-button button',
          20,
          function(submitBtn) {
            if (submitBtn && submitBtn.innerText.trim() === "Reply") {
              submitBtn.click();
              console.log("Clicked final Reply");
            } else {
              console.log("Final Reply button not valid or not found");
            }

            // Move to next
            index++;
            setTimeout(processNextThread, 2000);
          }
        );
      }
    );
  }

  // helper → waits repeatedly until element found
  function waitForElement(selector, attempts, callback) {
    let count = 0;

    function check() {
      const el = document.querySelector(selector);
      if (el) {
        callback(el);
      } else if (count < attempts) {
        count++;
        setTimeout(check, 300);
      } else {
        console.log("Element not found:", selector);
        callback(null);
      }
    }

    check();
  }

  // Start
  processNextThread();

})();
