const totalSchoolYears = 12;
const totalSchoolSubjects = 20;
let HistoricalHours = Array.from({ length: totalSchoolSubjects }, () => Array(totalSchoolYears).fill(0));
let HITV = document.querySelectorAll("#historicalTable .numVal");
let indx = 0;
for (let i = 0; i < totalSchoolSubjects; i++) {
    for (let j = 0; j < totalSchoolYears; j++) {
        HistoricalHours[i][j] = parseInt(HITV[indx++].innerText);
    }
}

let AnomaliesEachYear = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]; 
let DesiredTotInstrucTimeEachYear = [730, 730, 787, 876, 876, 876, 875, 875, 875, 875, 875, 875]; 
let HypotheticalWeeklyPeriods = HistoricalHours.map(row => [...row]);
let HypotheticalHours = HypotheticalWeeklyPeriods;
let totals = [730, 730, 787, 876, 876, 876, 875, 875, 875];
let totals_c = 10125;
let diff = Array.from({ length: totalSchoolSubjects }, () => Array(totalSchoolYears).fill(0));

// Function to get the active cell in the table
function getActiveCell() {
    console.log("getActiveCell");
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

function updateHypothetical() {
    console.log("updateHypothetical");
    let index = 0;
    let total = 0;
    totals_c = 0;
    let num_val = document.querySelectorAll("#HypotheticalTable td.numVal");
    let num_val_t = document.querySelectorAll("#HypotheticalTable td.numValt");
    let num_val_p = document.querySelectorAll("#HypotheticalTable td.numValp");

    for (let i = 0; i < totalSchoolSubjects; i++) {
        total = 0;
        for (let j = 0; j < totalSchoolYears; j++) {
            total += Math.floor(HypotheticalWeeklyPeriods[i][j]);
            num_val[index++].innerText = Math.floor(HypotheticalWeeklyPeriods[i][j]);
        }
        totals[i] = total;
        totals_c += total;
    }

    for (let i = 0; i < totalSchoolSubjects; i++) {
        num_val_t[i].innerText = totals[i];
        num_val_p[i].innerText = Math.floor(totals[i] / totals_c * 100) + "%";
    }
}

function updateAnomaliesEachYear(){
    let num_val = document.querySelectorAll("#totalAnomaly td.numVal");
    let num_val_t = document.querySelector("#totalAnomaly td.numValt");
    let atot = 0;

    for (let i = 0; i < totalSchoolYears; i++) {
        atot += AnomaliesEachYear[i];
        num_val[i].innerText = AnomaliesEachYear[i];
    }
    num_val_t.innerText = atot;
}

function updateChanges() {
    console.log("updateChanges");
    let index = 0;
    diff =  subtractMatrices(HypotheticalWeeklyPeriods, HistoricalHours);
    let num_val = document.querySelectorAll("#ChangesTable td.numVal");
    for (let i = 0; i < totalSchoolSubjects; i++) {
        for (let j = 0; j < totalSchoolYears; j++) {
            num_val[index++].innerText = Math.floor(diff[i][j]);
        }

    }
}

function ButtonToNeutraliseAnomalies_Click() {
    console.log("ButtonToNeutraliseAnomalies_Click");
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
        console.log("onit");
        
        let SumOfColumn = DesiredTotInstrucTimeEachYear[thiscolumn] + AnomaliesEachYear[thiscolumn];

        for (let thisrow = 0; thisrow < NrRows; thisrow++) {
            let XCell = HypotheticalHours[thisrow][thiscolumn];
            let ItsShareOfAnomaly = AnomaliesEachYear[thiscolumn] * (XCell / SumOfColumn);
            Tempo[thisrow] = XCell - ItsShareOfAnomaly;
        }
        
        for (let thisrow = 0; thisrow < NrRows; thisrow++) {
            if (thisrow === thisSubjectNr && thiscolumn === thisSchoolYear) continue;
            HypotheticalHours[thisrow][thiscolumn] = Tempo[thisrow];
        }
        AnomaliesEachYear[thiscolumn] = 0;
    }
    updateHypothetical();
    updateAnomaliesEachYear();
    updateChanges();
}

function checkLimits(selCell, anIncrement){
    if (!SelCellIsInHypothRange(selCell)) {
        $.notify("Please select a cell inside the under planning table", { className: "error", position: "top center" });
        return false;
    }
    const oldValueOfCell = selCell.value;
    const newValueOfCell = oldValueOfCell + anIncrement;
    let thisSchoolYear = selCell.column - 1;
    let thisSubjectNr = selCell.row;

    if (newValueOfCell < HistoricalHoursMin[thisSubjectNr][thisSchoolYear]) {
        $.notify("This is the minimum hours for this subject", { className: "error", position: "top center" });
        return false;
    }

    if (newValueOfCell > HistoricalHoursMax[thisSubjectNr][thisSchoolYear]) {
        $.notify("This is the maximum hours for this subject", { className: "error", position: "top center" });
        return false;
    }
    return true;
}

function autoAdjustCell(selCell, anIncrement, mode, outOfRangeMessage) {
    console.log("autoAdjustCell");
    checkLimits(selCell, anIncrement);

    let thisSchoolYear = selCell.column - 1;
    let thisSubjectNr = selCell.row;

    const wantTotal = DesiredTotInstrucTimeEachYear[thisSchoolYear];
    const oldValueOfCell = selCell.value;

    let specialIncrement = 0;
    if ((wantTotal - oldValueOfCell - anIncrement) !== 0) {
        specialIncrement = anIncrement * (wantTotal / (wantTotal - oldValueOfCell - anIncrement));
        console.log(`specialIncrement ${specialIncrement}`);
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
            HypotheticalWeeklyPeriods[selCell.row][selCell.column - 1] = temp;
        }
    } else {
        temp = oldValueOfCell + anIncrement;
        if (temp > 0 && temp < wantTotal) {
            selCell.value = temp;
            selCell.self.innerText = temp;
            HypotheticalWeeklyPeriods[selCell.row][selCell.column - 1] = temp;
        }
    }

    // const normFactor = wantTotal / (wantTotal + specialIncrement);
    const normFactor = wantTotal / (wantTotal + anIncrement);
    if (mode === "With Compensation") {
        for (let anySubject = 0; anySubject < totalSchoolSubjects; anySubject++) {
            temp = normFactor * HypotheticalWeeklyPeriods[anySubject][thisSchoolYear];
            if (temp > 0 && temp < wantTotal) {
                if(anySubject === thisSubjectNr) continue;
                HypotheticalWeeklyPeriods[anySubject][thisSchoolYear] = temp;
            }
        }
    }
}

// Handling click events on table cells
document.addEventListener('DOMContentLoaded', function () {
    const numCells = document.querySelectorAll('.numVal');
    numCells.forEach(cell => {
        cell.addEventListener('click', function () {
            numCells.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
        });
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            const activeCellInfo = getActiveCell();
            console.log(activeCellInfo);
        }
        if (event.key === 'Escape') {
            numCells.forEach(c => c.classList.remove('active'));
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
    console.log("spinButton2SpinUp");
    let selCell = getActiveCell();
    let IncrementPeriodsPerClick = getIncrementPeriodsPerClick();
    const nowIncrement = IncrementPeriodsPerClick;
    AnomaliesEachYear[selCell.column - 1] += nowIncrement;
    autoAdjustCell(selCell, nowIncrement, "This Cell Only", "");
    updateHypothetical();
    updateAnomaliesEachYear();
    updateChanges();
}

function spinButton2SpinDown() {
    console.log("spinButton2SpinDown");
    const selCell = getActiveCell();
    let IncrementPeriodsPerClick = getIncrementPeriodsPerClick();
    const nowIncrement = -1 * IncrementPeriodsPerClick;
    AnomaliesEachYear[selCell.column - 1] += nowIncrement;
    autoAdjustCell(selCell, nowIncrement, "This Cell Only", "");
    updateHypothetical();
    updateAnomaliesEachYear();
    updateChanges();
}

function spinButton1SpinUp() {
    console.log("spinButton1SpinUp");
    const selCell = getActiveCell();
    let IncrementPeriodsPerClick = getIncrementPeriodsPerClick();
    const nowIncrement = IncrementPeriodsPerClick;
    autoAdjustCell(selCell, nowIncrement, "With Compensation", "");
    updateHypothetical();
    updateChanges();
}

function spinButton1SpinDown() {
    console.log("spinButton1SpinDown");
    const selCell = getActiveCell();
    let IncrementPeriodsPerClick = getIncrementPeriodsPerClick();
    const nowIncrement = -1 * IncrementPeriodsPerClick;
    autoAdjustCell(selCell, nowIncrement, "With Compensation", "");
    updateHypothetical();
    updateChanges();
}

// Get Increment value from UI
function getIncrementPeriodsPerClick() {
    console.log("getIncrementPeriodsPerClick");
    return parseInt(document.getElementById("incrementPeriodsPerClick").textContent);
}

function SelCellIsInHypothRange(selCell) {
    return selCell.parentTableId === "HypotheticalTable";
}

function reset(){
    console.log("reset");
    HypotheticalWeeklyPeriods = HistoricalHours.map(row => [...row]);;
    HypotheticalHours = HistoricalHours.map(row => [...row]);;
    updateHypothetical();
    updateAnomaliesEachYear();
    updateChanges();
}