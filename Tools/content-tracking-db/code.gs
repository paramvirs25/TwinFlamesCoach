//Content tracking DB
//URL https://docs.google.com/spreadsheets/d/1a1ScqiOWw7Te5tr3Ir71DBnMa7dlRHKFpU8BSGhOkyE/edit?gid=1874005644#gid=1874005644

function onEdit(e) {

  const vmSheet = "Video Master";
  const taskSheet = "Tasks";

  const r = e.range;
  const sheet = r.getSheet();

  if (sheet.getName() !== vmSheet) return;

  const readyColumn = 7; // Ready checkbox column
  if (r.getColumn() !== readyColumn || r.getRow() < 2) return;

  const ss = SpreadsheetApp.getActiveSpreadsheet();
  const vm = ss.getSheetByName(vmSheet);
  const tasks = ss.getSheetByName(taskSheet);

  const row = r.getRow();
  const ready = r.getValue();

  const videoID = vm.getRange(row, 1).getValue();
  const title = vm.getRange(row, 2).getValue();
  const source = vm.getRange(row, 3).getValue();
  const datePosted = vm.getRange(row, 4).getValue();

  if (!videoID || !source || !datePosted) return;

  // ---- remove old tasks if unchecked
  if (ready === false) {
    const data = tasks.getDataRange().getValues();
    for (let i = data.length - 1; i > 0; i--) {
      if (data[i][1] == videoID) {
        tasks.deleteRow(i + 1);
      }
    }
    return;
  }

  // ---- prevent duplicates
  const existing = tasks.getDataRange().getValues();
  for (let i = 1; i < existing.length; i++) {
    if (existing[i][1] == videoID) return;
  }

  // ---- task creation rules
  let platforms = [];
  const rulesSheet = ss.getSheetByName("Platform Rules");
  const rulesData = rulesSheet.getDataRange().getValues();

  for (let i = 1; i < rulesData.length; i++) {
    const ruleSource = rulesData[i][0];
    const rulePlatform = rulesData[i][1];
    const ruleDelay = rulesData[i][2];

    if (ruleSource === source) {
      platforms.push([rulePlatform, ruleDelay]);
    }
  }


  // ---- create rows
  platforms.forEach(p => {
    const scheduled = new Date(datePosted);
    scheduled.setDate(scheduled.getDate() + p[1]);

    const taskID = videoID + "-" + p[0];

    const idColumn = tasks.getRange("A:A").getValues();
    let newRow = 2;

    for (let i = idColumn.length - 1; i >= 1; i--) {
      if (idColumn[i][0] !== "") {
        newRow = i + 2;
        break;
      }
    }

    tasks.getRange(newRow, 1, 1, 6).setValues([[
      taskID,
      videoID,
      title,
      source,
      p[0],
      scheduled
    ]]);

    // Apply real checkboxes
    tasks.getRange(newRow, 7).insertCheckboxes();
    tasks.getRange(newRow, 8).insertCheckboxes();

    // Default unchecked
    tasks.getRange(newRow, 7, 1, 2).setValue(false);

  });

  const lastRow = tasks.getLastRow();
if(lastRow > 2){
  tasks.getRange(2,1,lastRow-1,8).sort({column:6, ascending:true});
}

}