
const emotions = [
    "Anger", "Mad", "Guilt", "Sadness", "Fear", "Rejected", "Pity", "Disgust / Awful", "Disapproval",
    "Expectation", "Hope", "Surprise / Startled / Excited", "Joy / Optimistic", "Proud", "Trust"
];

// Initialize the table with emotion names
const tableBody = document.getElementById("emotionTableBody");
emotions.forEach((emotion) => {
    const newRow = document.createElement("tr");
    const emotionCell = document.createElement("td");
    emotionCell.textContent = emotion;
    newRow.appendChild(emotionCell);
    newRow.appendChild(createGradientCell());
    newRow.appendChild(createGradientCell());
    tableBody.appendChild(newRow);
});

function createGradientCell() {
    const gradientCell = document.createElement("td");
    const gradientSpan = document.createElement("div");
    gradientSpan.className = "gradient-cell"; // Set the class directly
    gradientCell.appendChild(gradientSpan);
    return gradientCell;
}


function fillRandomNumbers() {
    const loadingBar = document.getElementById("loadingBar");
    loadingBar.style.display = "block"; // Show loading bar

    setTimeout(() => {
        // Update existing rows with random numbers
        const rows = tableBody.querySelectorAll("tr");
        rows.forEach((row) => {
            const cells = row.querySelectorAll("td");
            if (cells.length > 1) {
                const mySideValue = getRandomNumber();
                const theirSideValue = getRandomNumber();

                const mySideGradient = cells[1].querySelector(".gradient-cell");
                const theirSideGradient = cells[2].querySelector(".gradient-cell");

                mySideGradient.style.width = `${mySideValue}%`;
                theirSideGradient.style.width = `${theirSideValue}%`;

                if (mySideValue > 63) {
                    mySideGradient.innerHTML = `<div class="tick">${mySideValue}</div>`;
                } else {
                    mySideGradient.innerHTML = `<div class="cross">${mySideValue}</div>`;
                }

                if (theirSideValue > 63) {
                    theirSideGradient.innerHTML = `<div class="tick">${theirSideValue}</div>`;
                } else {
                    theirSideGradient.innerHTML = `<div class="cross">${theirSideValue}</div>`;
                }
            }
        });

        loadingBar.style.display = "none"; // Hide loading bar
    }, 1000); // Wait for 1 second
}

function getRandomNumber() {
    return Math.floor(Math.random() * 100) + 1;
}
