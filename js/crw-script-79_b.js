const totalSchoolYears = 3;
const totalSchoolSubjects = 20;
let HistoricalHours = Array.from({ length: totalSchoolSubjects }, () => Array(totalSchoolYears).fill(0));
let HITV = document.querySelectorAll("#historicalTable .numVal");
let indx = 0;
for (let i = 0; i < totalSchoolSubjects; i++) {
    for (let j = 0; j < totalSchoolYears; j++) {
        HistoricalHours[i][j] = parseInt(HITV[indx++].innerText);
    }
}

function updateBarChart() {
    return 0;
}

function updatePieChart(a) {
    return a;
}

let AnomaliesEachYear = [0, 0, 0, 0, 0, 0]; 
let DesiredTotInstrucTimeEachYear = [875, 875, 875]; 
let HypotheticalWeeklyPeriods = HistoricalHours.map(row => [...row]);
let HypotheticalHours = HypotheticalWeeklyPeriods;
let totals = [875, 875, 875];
let totals_c = 2625;
let diff = Array.from({ length: totalSchoolSubjects }, () => Array(totalSchoolYears).fill(0));

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
    const oldValueOfCell = selCell.value;
    const newValueOfCell = oldValueOfCell + anIncrement;
    const newValueOfCellC = oldValueOfCell +  (2 * anIncrement);
    let thisSchoolYear = selCell.column - 1;
    let thisSubjectNr = selCell.row;

    if (newValueOfCell < HistoricalHoursMin[thisSubjectNr][thisSchoolYear]) {
        $.notify("This is the minimum hours for this subject", { className: "error", position: "top center" });
        selCell.self.classList.add("lowLim");
        selCell.self.classList.remove("clowLim");
        return false;
    } else if (newValueOfCellC < HistoricalHoursMin[thisSubjectNr][thisSchoolYear]) {
        selCell.self.classList.add("clowLim");
        selCell.self.classList.remove("lowLim");
    } else {
        selCell.self.classList.remove("lowLim");
        selCell.self.classList.remove("clowLim");
    }

    if (newValueOfCell > HistoricalHoursMax[thisSubjectNr][thisSchoolYear]) {
        $.notify("This is the maximum hours for this subject", { className: "error", position: "top center" });
        selCell.self.classList.add("HigLim");
        selCell.self.classList.remove("cHigLim");
        return false;
    } else if (newValueOfCellC > HistoricalHoursMax[thisSubjectNr][thisSchoolYear]) {
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
    // if (!checkLimits(selCell, anIncrement)) return;

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

// Handling click events on table cells
document.addEventListener('DOMContentLoaded', function () {
    const numCells = document.querySelectorAll('.numVal');
    numCells.forEach(cell => {
        cell.addEventListener('click', function () {
            numCells.forEach(c => c.classList.remove('active'));
            subsnCells.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
        });
    });

    const subsnCells = document.querySelectorAll('.subname');
    subsnCells.forEach(cell => {
        cell.addEventListener('click', function () {
            numCells.forEach(c => c.classList.remove('active'));
            subsnCells.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
        });
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            numCells.forEach(c => c.classList.remove('active'));
            subsnCells.forEach(c => c.classList.remove('active'));
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
    HypotheticalWeeklyPeriods = HistoricalHours.map(row => [...row]);;
    HypotheticalHours = HistoricalHours.map(row => [...row]);;
    updateHypothetical();
    updateAnomaliesEachYear();
    updateChanges();
}