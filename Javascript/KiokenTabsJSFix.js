function kiokenTabsScript() {
    const tabBlocks = document.querySelectorAll('.wp-block-kioken-tabs');
  
    tabBlocks.forEach((tabBlock) => {
      // Select the tab buttons and content within each tab block
      const tabButtons = tabBlock.querySelectorAll('.kioken-tabs-buttons-item');
      const tabContent = tabBlock.querySelectorAll('.wp-block-kioken-tab');
  
      // Set the first tab as active by default
      tabButtons[0].classList.add('active');
      tabContent.forEach((content, index) => {
        if (index !== 0) {
          content.style.display = 'none';
        }
      });
  
      // Add a click event listener to each tab button
      tabButtons.forEach((button, index) => {
        button.addEventListener('click', () => {
          // Set all tab buttons to inactive
          tabButtons.forEach((button) => {
            button.classList.remove('active');
          });
  
          // Set all tab content to hidden
          tabContent.forEach((content) => {
            content.style.display = 'none';
          });
  
          // Set the clicked tab button as active
          button.classList.add('active');
  
          // Show the corresponding tab content
          tabContent[index].style.display = 'block';
        });
      });
    });
  }
  
  kiokenTabsScript();