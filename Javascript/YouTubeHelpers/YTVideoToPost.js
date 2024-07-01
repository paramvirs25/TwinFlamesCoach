// Function to generate a random number between min and max (inclusive)
function getRandomNumber(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
  }
  
  // Get all anchor tags with id="video-title"
  const videoTitles = document.querySelectorAll('a#video-title');
  
  // Iterate over each anchor tag
  videoTitles.forEach(anchor => {
    // Get the text content of the anchor tag
    const titleText = anchor.textContent.trim();
    // Generate a random number between 0 and 100
    const randomNumber = getRandomNumber(0, 100);
    // Print the random number and title text in the console
    console.log(`${randomNumber} - ${titleText}`);
  });
  