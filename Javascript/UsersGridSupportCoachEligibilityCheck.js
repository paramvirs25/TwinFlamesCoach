function addEligibilityColumn() {
    // Check if the current URL is correct
    if (window.location.href !== "https://members.twinflamescoach.com/wp-admin/users.php?role=apprentice_basic_iw") {
      return;
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
      
      // Check if the row is eligible for support coach
      const isEligible = roles.includes("Basic IW 1") &&
                         roles.includes("TfcIw") &&
                         roles.includes("Advanced Twin Flame Healings 1") &&
                         roles.includes("Certified Coach") &&
                         roles.includes("Apprentice Basic IW");
      
      // Create the new cell with the eligibility status
      const eligibilityCell = document.createElement("td");
      if (roles.includes("Support")) {
        eligibilityCell.textContent = "Already a Support Coach";
        eligibilityCell.style.color = "black";
      } else if (isEligible) {
        eligibilityCell.textContent = "Eligible";
        eligibilityCell.style.color = "green";
      } else {
        eligibilityCell.textContent = "Not eligible";
        eligibilityCell.style.color = "red";
      }
      row.appendChild(eligibilityCell);
    });
  }
  
  window.addEventListener('load', () => {
      addEligibilityColumn();
  });