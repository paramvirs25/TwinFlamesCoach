/* Adds Eligibility column in users grid and
* shows user eligibility status to become support coach.
*/
function addEligibilityColumn() {
  const REQUIRED_ROLES = ["Basic IW 1", "TfcIw", "Advanced Twin Flame Healings 1", "Certified Coach", "Apprentice Basic IW"];
  const SUPPORT_ROLE = "Support";

  // Function to calculate the date difference in months
  function calculateMonthDifference(year) {
    const today = new Date();
    const targetDate = new Date(year, 6, 1); // Month is 0-indexed, so July is 6
    const diff = (today - targetDate) / (1000 * 60 * 60 * 24 * 30); // Approximate month difference
    return Math.floor(diff);
  }

  // Find the table element
  const table = document.querySelector(".wp-list-table.widefat.fixed.striped.table-view-list.users");

  // Check if the table element exists
  if (!table) {
    return;
  }

  // Create the new header cell
  const headerCell = document.createElement("th");
  headerCell.textContent = "Is Eligible for Support Coach?";
  table.querySelector("thead tr").appendChild(headerCell);

  // Loop through each row of the table
  const rows = table.querySelectorAll("tbody tr");
  rows.forEach(row => {
    // Find the role column
    const roleColumn = row.querySelector(".role.column-role");

    // Check if the role column exists
    if (!roleColumn) {
      return;
    }

    // Split the roles by comma
    const roles = roleColumn.textContent.split(", ");

    // Find a role that starts with "Group Life Coach "
    const groupLifeCoachRole = roles.find(role => role.startsWith("Group Life Coach "));

    // Check if the row is eligible for support coach
    const isEligibleRoles = REQUIRED_ROLES.every(role => roles.includes(role));
    const isEligibleDate = groupLifeCoachRole ? calculateMonthDifference(parseInt(groupLifeCoachRole.slice(-4))) >= 12 : false;

    // Create the new cell with the eligibility status
    const eligibilityCell = document.createElement("td");
    if (roles.includes(SUPPORT_ROLE)) {
      eligibilityCell.textContent = "✅✅Already a Support Coach";
      eligibilityCell.style.color = "blue";
    } else if (isEligibleRoles && isEligibleDate) {
      eligibilityCell.textContent = "✅Eligible";
      eligibilityCell.style.color = "green";
    } else {
      var message = `Not eligible | Required`;
      if (!isEligibleRoles) {
        const missingRoles = REQUIRED_ROLES.filter(role => !roles.includes(role));
        const missingRolesText = missingRoles.join("<br/>❌");
        message += `<br/>Course(s)<div style="color:purple;">❌${missingRolesText}</div>`;        
      }

      if (!isEligibleDate) {
        message += `<br/>Experience<div style="color:purple;">❌1 Year of Life Coaching</div>`; // Not enough time has passed.        
      }

      eligibilityCell.innerHTML = message;
      eligibilityCell.style.color = "red";
    }

    row.appendChild(eligibilityCell);
  });
}

window.addEventListener('load', () => {
  // Check if the current URL is 'Users screen displaying all apprentices'
  if (window.location.href == "https://members.twinflamescoach.com/wp-admin/users.php?role=apprentice_basic_iw") {
    addEligibilityColumn();
  }
});
