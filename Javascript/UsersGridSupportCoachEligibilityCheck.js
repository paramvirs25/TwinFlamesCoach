/*Adds Eligibility column in users grid and
* shows user eligibility status to become support coach.
*/
function addEligibilityColumn() {
  const REQUIRED_ROLES = ["Basic IW 1", "TfcIw", "Advanced Twin Flame Healings 1", "Certified Coach", "Apprentice Basic IW"];
  const SUPPORT_ROLE = "Support";

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

    // Check if the row is eligible for support coach
    const isEligible = REQUIRED_ROLES.every(role => roles.includes(role));

    // Create the new cell with the eligibility status
    const eligibilityCell = document.createElement("td");
    if (roles.includes(SUPPORT_ROLE)) {
      eligibilityCell.textContent = "Already a Support Coach";
      eligibilityCell.style.color = "blue";
    } else if (isEligible) {
      eligibilityCell.textContent = "Eligible";
      eligibilityCell.style.color = "green";
    } else {
      const missingRoles = REQUIRED_ROLES.filter(role => !roles.includes(role));
      const missingRolesText = missingRoles.join("<br/>");
      eligibilityCell.innerHTML = `Not eligible | Required course(s)<div style="color:purple;">${missingRolesText}</div>`;
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
