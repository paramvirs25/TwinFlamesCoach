window.addEventListener('load', () => {
  // Get all accordion items
  const accordionItems = document.querySelectorAll('.wp-block-kioken-accordion-item');

  // Loop through each accordion item
  accordionItems.forEach(item => {
    const heading = item.querySelector('.kioken-accordion-item-heading');
    const content = item.querySelector('.kioken-accordion-item-content');

    // Add click event listener to the heading
    heading.addEventListener('click', () => {
      // Toggle the visibility of the content
      content.classList.toggle('active');

      // Toggle the icon between plus and cross
      const icon = heading.querySelector('svg');
      icon.classList.toggle('open');

      // Toggle the active class on the accordion item's div
      item.classList.toggle('kioken-accordion-item-active');
    });
  });


});
