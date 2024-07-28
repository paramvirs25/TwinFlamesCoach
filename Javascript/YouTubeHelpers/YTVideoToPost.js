// Function to generate a random number between min and max (inclusive)
function getRandomNumber(min, max) {
  return Math.floor(Math.random() * (max - min + 1)) + min;
}

// Get all anchor tags with id="video-title"
const videoTitles = document.querySelectorAll('a#video-title');

// Create an array to store title texts and their corresponding random numbers
const titlesWithNumbers = [];

// Iterate over each anchor tag
videoTitles.forEach(anchor => {
  // Get the text content of the anchor tag
  const titleText = anchor.textContent.trim();
  // Generate a random number between 0 and 100
  const randomNumber = getRandomNumber(0, 100);
  // Add the title text and random number to the array
  titlesWithNumbers.push({ titleText, randomNumber });

  console.log(`${randomNumber} - ${titleText}`);
});

// Sort the array based on the random numbers in descending order
titlesWithNumbers.sort((a, b) => b.randomNumber - a.randomNumber);

// Select the top three elements from the sorted array
const topThreeTitles = titlesWithNumbers.slice(0, 3);

console.log('-----Highest Ones----');
// Log the top three title texts with their corresponding random numbers to the console
topThreeTitles.forEach(({ titleText, randomNumber }) => {
    console.log(`${randomNumber} - ${titleText}`);
});
