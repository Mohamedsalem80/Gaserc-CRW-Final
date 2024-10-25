function updateBarChart() {
    return 0;
}

function updatePieChart(a) {
    return a;
}

// Function to get the active cell in the table
function getActiveCell() {
    const activeCell = document.querySelector('.numVal.active');
    if (activeCell) {
        const rowIndex = activeCell.parentElement.rowIndex;
        const cellIndex = Array.from(activeCell.parentElement.children).indexOf(activeCell);
        return {
            self: activeCell,
            value: parseFloat(activeCell.textContent),
            row: rowIndex,
            column: cellIndex,
            parentTableId: activeCell.closest('table').id
        };
    }
    return null;
}

function getActiveSN() {
    const activeCell = document.querySelector('.subname.active');
    if (activeCell) {
        const rowIndex = activeCell.parentElement.rowIndex;
        const cellIndex = Array.from(activeCell.parentElement.children).indexOf(activeCell);
        return {
            self: activeCell,
            name: activeCell.textContent,
            row: rowIndex,
            column: cellIndex,
            parentTableId: activeCell.closest('table').id
        };
    }
    return null;
}


function subtractMatrices(matrixA, matrixB) {
    if (matrixA.length === 0 || matrixA.length !== matrixB.length || matrixA[0].length !== matrixB[0].length) {
        throw new Error("Matrices must have the same dimensions");
    }

    const resultMatrix = [];

    for (let i = 0; i < matrixA.length; i++) {
        resultMatrix[i] = [];
        for (let j = 0; j < matrixA[i].length; j++) {
            resultMatrix[i][j] = matrixA[i][j] - matrixB[i][j];
        }
    }

    return resultMatrix;
}

function removeRow(matrix, rowIndex) {
    if (rowIndex >= 0 && rowIndex < matrix.length) {
        matrix.splice(rowIndex, 1);
    } else {
        console.log("Invalid row index");
    }
    return matrix;
}

function transposeMatrix(matrix) {
    return matrix[0].map((_, colIndex) => matrix.map(row => row[colIndex]));
}

function updateHypothetical() {
    let index = 0;
    let total = 0;
    totals_c = 0;
    let num_val = document.querySelectorAll("#HypotheticalTable td.numVal");
    let num_val_t = document.querySelectorAll("#HypotheticalTable td.numValt");
    let num_val_p = document.querySelectorAll("#HypotheticalTable td.numValp");

    for (let i = 0; i < totalSchoolSubjects; i++) {
        total = 0;
        for (let j = 0; j < totalSchoolYears; j++) {
            total += Math.round(HypotheticalWeeklyPeriods[i][j]);
            num_val[index++].innerText = Math.round(HypotheticalWeeklyPeriods[i][j]);
        }
        totals[i] = total;
        totals_c += total;
    }

    for (let i = 0; i < totalSchoolSubjects; i++) {
        num_val_t[i].innerText = totals[i];
        num_val_p[i].innerText = Math.round(totals[i] / totals_c * 100) + "%";
    }
}

function updateAnomaliesEachYear(){
    let num_val = document.querySelectorAll("#totalAnomaly td.numVal");
    let num_val_t = document.querySelector("#totalAnomaly td.numValt");
    let atots = Array.from({ length: totalSchoolSubjects }).fill(0);
    let atot = 0;
    let temp = 0;
    for (let i = 0; i < totalSchoolYears; i++) {
        for (let j = 0; j < totalSchoolSubjects; j++) {
            atots[i] += HypotheticalWeeklyPeriods[j][i];
        }
        temp = atots[i] - DesiredTotInstrucTimeEachYear[i];
        num_val[i].innerText = Math.round(temp);
        AnomaliesEachYear[i] = Math.round(temp);
    }
    for (let i = 0; i < totalSchoolYears; i++) {
        atot += AnomaliesEachYear[i];
    }
    num_val_t.innerText = atot;
    atot = 0;
    updatePieChart(0);
    updateBarChart();
}

function updateChanges() {
    let ctot = 0;
    let index = 0;
    diff =  subtractMatrices(HypotheticalWeeklyPeriods, HistoricalHours);
    let num_val = document.querySelectorAll("#ChangesTable td.numVal");
    let num_valt = document.querySelectorAll("#ChangesTable td.numValt");
    for (let i = 0; i < totalSchoolSubjects; i++) {
        ctot = 0;
        for (let j = 0; j < totalSchoolYears; j++) {
            ctot += Math.round(diff[i][j]);
            num_val[index++].innerText = Math.round(diff[i][j]);
        }
        num_valt[i].innerText = ctot;
    }
}

function ButtonToNeutraliseAnomalies_Click() {
    updateHypothetical();
    let Nrcols = totalSchoolYears;
    let NrRows = totalSchoolSubjects;
    let Tempo = new Array(NrRows).fill(0);
    let selCell = getActiveCell();
    let thisSchoolYear = selCell.column - 1;
    let thisSubjectNr = selCell.row; 

    for (let thiscolumn = 0; thiscolumn < Nrcols; thiscolumn++) {
        if (AnomaliesEachYear[thiscolumn] == 0) {
            continue;
        }
        
        let SumOfColumn = DesiredTotInstrucTimeEachYear[thiscolumn] + AnomaliesEachYear[thiscolumn];

        for (let thisrow = 0; thisrow < NrRows; thisrow++) {
            let XCell = HypotheticalHours[thisrow][thiscolumn];
            let ItsShareOfAnomaly = AnomaliesEachYear[thiscolumn] * (XCell / SumOfColumn);
            Tempo[thisrow] = XCell - ItsShareOfAnomaly;
        }
        
        for (let thisrow = 0; thisrow < NrRows; thisrow++) {
            if (thisrow === thisSubjectNr && thiscolumn === thisSchoolYear) continue;
            HypotheticalHours[thisrow][thiscolumn] = Math.round(Tempo[thisrow]);
        }
    }
    
    updateAnomaliesEachYear();
    updateHypothetical();
    updateChanges();
}

function checkLimits(selCell, anIncrement){
    if (!SelCellIsInHypothRange(selCell)) {
        $.notify("Please select a cell inside the under planning table", { className: "error", position: "top center" });
        return false;
    }
    let oldValueOfCell = selCell.value;
    let thisSchoolYear = selCell.column - 1;
    let thisSubjectNr = selCell.row;
    let newValueOfCell = oldValueOfCell + anIncrement;
    newValueOfCell = Math.round(newValueOfCell / DesiredTotInstrucTimeEachYear[thisSchoolYear]*100);
    let newValueOfCellC = oldValueOfCell +  (2 * anIncrement);
    newValueOfCellC = Math.round(newValueOfCellC / DesiredTotInstrucTimeEachYear[thisSchoolYear]*100);

    if (newValueOfCell < HistoricalHoursMin[thisSubjectNr]) {
        $.notify("This is the minimum hours for this subject", { className: "error", position: "top center" });
        selCell.self.classList.add("lowLim");
        selCell.self.classList.remove("clowLim");
        return false;
    } else if (newValueOfCellC < HistoricalHoursMin[thisSubjectNr]) {
        selCell.self.classList.add("clowLim");
        selCell.self.classList.remove("lowLim");
    } else {
        selCell.self.classList.remove("lowLim");
        selCell.self.classList.remove("clowLim");
    }

    if (newValueOfCell > HistoricalHoursMax[thisSubjectNr]) {
        $.notify("This is the maximum hours for this subject", { className: "error", position: "top center" });
        selCell.self.classList.add("HigLim");
        selCell.self.classList.remove("cHigLim");
        return false;
    } else if (newValueOfCellC > HistoricalHoursMax[thisSubjectNr]) {
        selCell.self.classList.add("cHigLim");
        selCell.self.classList.remove("HigLim");
    } else {
        selCell.self.classList.remove("HigLim");
        selCell.self.classList.remove("cHigLim");
    }
    return true;
}

// Function to increment or decrement cell values
function autoAdjustCell(selCell, anIncrement, mode, outOfRangeMessage) {
    checkLimits(selCell, anIncrement);

    let thisSchoolYear = selCell.column - 1;
    let thisSubjectNr = selCell.row;

    const wantTotal = DesiredTotInstrucTimeEachYear[thisSchoolYear];
    const oldValueOfCell = selCell.value;

    let specialIncrement = 0;
    if ((wantTotal - oldValueOfCell - anIncrement) !== 0) {
        specialIncrement = anIncrement * (wantTotal / (wantTotal - oldValueOfCell - anIncrement));
    } else {
        return;
    }

    let temp;
    if (mode === "With Compensation") {
        // temp = oldValueOfCell + specialIncrement;
        temp = oldValueOfCell + anIncrement;
        if (temp > 0 && temp < wantTotal) {
            selCell.value = temp;
            selCell.self.innerText = temp;
            HypotheticalWeeklyPeriods[selCell.row][selCell.column - 1] = Math.round(temp);
        }
    } else {
        temp = oldValueOfCell + anIncrement;
        if (temp > 0 && temp < wantTotal) {
            selCell.value = temp;
            selCell.self.innerText = temp;
            HypotheticalWeeklyPeriods[selCell.row][selCell.column - 1] = Math.round(temp);
        }
    }

    // const normFactor = wantTotal / (wantTotal + specialIncrement);
    const normFactor = wantTotal / (wantTotal + anIncrement);
    if (mode === "With Compensation") {
        for (let anySubject = 0; anySubject < totalSchoolSubjects; anySubject++) {
            temp = normFactor * HypotheticalWeeklyPeriods[anySubject][thisSchoolYear];
            if (temp > 0 && temp < wantTotal) {
                if(anySubject === thisSubjectNr) continue;
                HypotheticalWeeklyPeriods[anySubject][thisSchoolYear] = Math.round(temp);
            }
        }
    }

    updatePieChart(0);
    updateBarChart();
}

document.addEventListener('DOMContentLoaded', function () {
    document.body.addEventListener('click', function (e) {
        if (e.target.classList.contains('numVal')) {
            document.querySelectorAll('.numVal').forEach(c => c.classList.remove('active'));
            document.querySelectorAll('.subname').forEach(c => c.classList.remove('active'));
            e.target.classList.add('active');
        }

        if (e.target.classList.contains('subname')) {
            document.querySelectorAll('.numVal').forEach(c => c.classList.remove('active'));
            document.querySelectorAll('.subname').forEach(c => c.classList.remove('active'));
            e.target.classList.add('active');
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            document.querySelectorAll('.numVal').forEach(c => c.classList.remove('active'));
            document.querySelectorAll('.subname').forEach(c => c.classList.remove('active'));
        }
    });

    const control_panel = document.querySelector(".control_panel");
    const panelBTN = document.querySelector(".panel_btn");
    panelBTN.addEventListener('click', function () {
        if(control_panel.classList.contains("panel_up")){
            control_panel.classList.remove("panel_up");
            control_panel.classList.add("panel_down");
            panelBTN.innerHTML = '<i class="fa fa-arrow-up"></i>';
        } else {
            control_panel.classList.remove("panel_down");
            control_panel.classList.add("panel_up");
            panelBTN.innerHTML = '<i class="fa fa-arrow-down"></i>';
        }
    });
});

function spinButton2SpinUp() {
    let selCell = getActiveCell();
    let IncrementPeriodsPerClick = getIncrementPeriodsPerClick();
    const nowIncrement = IncrementPeriodsPerClick;
    autoAdjustCell(selCell, nowIncrement, "This Cell Only", "");
    updateHypothetical();
    updateAnomaliesEachYear();
    updateChanges();
}

function spinButton2SpinDown() {
    const selCell = getActiveCell();
    let IncrementPeriodsPerClick = getIncrementPeriodsPerClick();
    const nowIncrement = -1 * IncrementPeriodsPerClick;
    autoAdjustCell(selCell, nowIncrement, "This Cell Only", "");
    updateHypothetical();
    updateAnomaliesEachYear();
    updateChanges();
}

function spinButton1SpinUp() {
    const selCell = getActiveCell();
    let IncrementPeriodsPerClick = getIncrementPeriodsPerClick();
    const nowIncrement = IncrementPeriodsPerClick;
    autoAdjustCell(selCell, nowIncrement, "With Compensation", "");
    updateHypothetical();
    updateAnomaliesEachYear();
    updateChanges();
}

function spinButton1SpinDown() {
    const selCell = getActiveCell();
    let IncrementPeriodsPerClick = getIncrementPeriodsPerClick();
    const nowIncrement = -1 * IncrementPeriodsPerClick;
    autoAdjustCell(selCell, nowIncrement, "With Compensation", "");
    updateHypothetical();
    updateAnomaliesEachYear();
    updateChanges();
}

// Get Increment value from UI
function getIncrementPeriodsPerClick() {
    let noWeeks = parseInt(document.getElementById("noWeeks").innerText);
    let clsmin = parseInt(document.getElementById("classMints").innerText)/60;
    document.getElementById("incrementPeriodsPerClick").innerText = Math.round(noWeeks * clsmin);
    return Math.round(noWeeks * clsmin);
}

function SelCellIsInHypothRange(selCell) {
    if (!selCell) return false;
    return selCell.parentTableId === "HypotheticalTable";
}

function reset(){
    const Velements = document.querySelectorAll(".numVal");
    const Telements = document.querySelectorAll(".subname ");
    Velements.forEach(function(ele){
        ele.classList.remove("active");
        ele.classList.remove("lowLim");
        ele.classList.remove("clowLim");
        ele.classList.remove("HigLim");
        ele.classList.remove("cHigLim");
    });
    Telements.forEach(function(ele){
        ele.classList.remove("active");
    });
    document.getElementById("HypotheticalTable").innerHTML = document.getElementById("historicalTable").innerHTML;
    HypotheticalWeeklyPeriods = HistoricalHours.map(row => [...row]);
    HypotheticalHours = HistoricalHours.map(row => [...row]);
    updateHypothetical();
    updateAnomaliesEachYear();
    updateChanges();
    window.location.reload();
}

function publish() {
    document.getElementById("historicalTable").innerHTML = document.getElementById("HypotheticalTable").innerHTML;
    HistoricalHours = HypotheticalWeeklyPeriods.map(row => [...row]);

    let theform = document.getElementById("rform2");
    document.getElementById("rforminp2").value = JSON.stringify(HypotheticalHours);;
    theform.submit();
}

function removeSub() {
    const selCell = getActiveSN();
    
    // Check if the selected cell is valid
    if (!SelCellIsInHypothRange(selCell)) {
        $.notify("Please select a subject inside the under planning table", { className: "error", position: "top center" });
        return;
    }
    
    let sid = selCell.self.innerText.trim(); // Use innerText and trim whitespace
    let theform = document.getElementById("rform");
    document.getElementById("rforminp").value = sid;
    theform.submit();
    return;
    // Get the subject name from the selected cell

    // Confirm with the user before deletion
    if (confirm("Are you sure you want to delete this subject?")) {
        // AJAX request to delete the subject
        $.ajax({
            url: 'delete_subject.php',
            type: 'POST',
            data: fdata,
            dataType: 'json',
            success: function(response) {
                console.log("Response:", response); // Log the response
                if (response.success) {
                    alert(response.message);
                    location.reload(); // Reload the page if deletion is successful
                } else {
                    alert(response.message); // Show error message from the server
                }
            },
            error: function(xhr, status, error) {
                console.error("XHR Response:", xhr.responseText); // Log the raw response text for debugging
                alert("An error occurred: " + error); // Show alert with error message
            }
        });
    }
}

function addSub() {
    let FormData = document.getElementById("addSubForm");
    if (FormData[0] == "" || FormData.length == 0) return;
    let DataLen = FormData.length;
    let values = Array.from({ length: DataLen }).fill(0);
    let valuesH = Array.from({ length: totalSchoolYears }).fill(0);
    let total = 0;
    for (let i = 0; i < DataLen; i++) {
        values[i] = FormData[i].value;
    }
    const tableBody = document.getElementById("HypotheticalTable").querySelector("tbody");
    const newRow = document.createElement("tr");
    newRow.innerHTML = `<td class="subname">${values[0]}</td>`;
    for (let j = 2; j < totalSchoolYears+2; j++) {
        total += parseInt(values[j]);
        valuesH[j-2] = parseInt(values[j]);
        newRow.innerHTML += `<td class="numVal">${values[j]}</td>`;
    }
    newRow.innerHTML += `<td class="numValt" style="width: 75px;">${total}</td>`;
    newRow.innerHTML += `<td class="numValp" style="width: 75px;">${Math.round(total/totals_c*100)}%</td>`;
    tableBody.appendChild(newRow);
    totalSchoolSubjects += 1;
    HypotheticalHours.push(valuesH);
    console.log("FormData[DataLen-2].value"+FormData[DataLen-2].value);
    console.log("FormData[DataLen-3].value"+FormData[DataLen-3].value);
    HistoricalHoursMax.push(parseInt(FormData[DataLen-2].value));
    HistoricalHoursMin.push(parseInt(FormData[DataLen-3].value));
    FormData.reset();
}

updateHypothetical();
updateAnomaliesEachYear();
updateChanges();
getIncrementPeriodsPerClick();

function downloadPDF2() {
    let mainTable = document.querySelectorAll("#historicalTable tbody tr");
    let mainMatrix = [];
    let subjects = [];
    
    mainTable.forEach(function(row) {
        let rowData = [];
        // Extract subject name
        let subject = row.querySelector(".subname").innerText.trim();
        subjects.push(subject);

        // Extract all values (td elements with class 'numVal' and 'numValt')
        row.querySelectorAll("td.numVal, td.numValt").forEach(function(cell) {
            rowData.push(cell.innerText.trim());
        });

        mainMatrix.push(rowData.join(','));  // Join values in a comma-separated row
    });

    // Collect data from the "Under Planning" table
    let planningTable = document.querySelectorAll("#HypotheticalTable tbody tr");
    let planningMatrix = [];
    
    planningTable.forEach(function(row) {
        let rowData = [];

        // Extract all values (td elements with class 'numVal' and 'numValt')
        row.querySelectorAll("td.numVal, td.numValt").forEach(function(cell) {
            rowData.push(cell.innerText.trim());
        });

        planningMatrix.push(rowData.join(','));  // Join values in a comma-separated row
    });

    // Inject data into the hidden form fields
    document.getElementById("subjectsField").value = subjects.join(',');
    document.getElementById("mainMatrixField").value = mainMatrix.join('\n');  // Line breaks between rows
    document.getElementById("planningMatrixField").value = planningMatrix.join('\n');

    // Submit the form
    document.getElementById("pdfForm").submit();
}