<?php
session_start();
require_once('TCPDF/tcpdf.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the subject names and matrices from the form
    $subjects = $_SESSION['subjects'];
    $mainMatrix = explode("\n", trim($_POST['mainMatrix']));
    $planningMatrix = explode("\n", trim($_POST['planningMatrix']));
    $start = (int) $_POST['start'];
    $end = (int) $_POST['end'];

    // Clean matrix rows
    $mainMatrix = array_map(function($row) {
        return explode(',', trim($row));
    }, $mainMatrix);

    $planningMatrix = array_map(function($row) {
        return explode(',', trim($row));
    }, $planningMatrix);

    // Create a new PDF document
    $pdf = new TCPDF();

    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('GARESC');
    $pdf->SetTitle('Ratio Weights');
    $pdf->SetSubject('Ratio Weights PDF');
    $pdf->SetKeywords('TCPDF, PDF, example, subjects, Ratio Weights');

    // Set default header data
    $pdf->SetHeaderData('', '', 'Ratio Weights Report', 'Generated by Your GARESC');

    // Add a page for "Main"
    $pdf->AddPage();
    $pdf->SetFont('helvetica', 'B', 9);

    // Title for Main Section
    $pdf->writeHTML('<h1>Main</h1><br />', true, false, true, false, '');

    $html = '<table border="1" cellpadding="4">
            <tr>
                <th style="width: 100px;">Grade</th>';

    for ($i = $start; $i <= $end; $i++) {
        $html .= '<th>' . $i . '</th>';
    }

    $html .= '<th style="width: 50px;">Total</th>
        </tr>';
    $counter = 0;
    foreach ($subjects as $index => $subject) {
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars(trim($subject)) . '</td>';
        foreach ($mainMatrix[$counter] as $value) {
            $html .= '<td>' . htmlspecialchars(trim($value)) . '</td>';
        }
        $html .= '</tr>';
        if ($counter >= count($subjects)) {
            $counter = 0;
        } else {
            $counter = $counter + 1;
        }
    }
    $html .= '</table>';

    // Print the HTML for Main Matrix
    $pdf->writeHTML($html, true, false, true, false, '');

    // Add a new page for "Under Planning"
    $pdf->AddPage();

    // Title for Under Planning Section
    $pdf->writeHTML('<h1>Under Planning</h1><br />', true, false, true, false, '');

    // Build the table for Planning Matrix
    $html = '<table border="1" cellpadding="4">
    <tr>
        <th style="width: 100px;">Grade</th>';

    for ($i = $start; $i <= $end; $i++) {
    $html .= '<th>' . $i . '</th>';
    }

    $html .= '<th style="width: 50px;">Total</th>
    </tr>';
    
    $counter2 = 0;
    foreach ($subjects as $index => $subject) {
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars(trim($subject)) . '</td>';
        foreach ($planningMatrix[$counter2] as $value) {
            $html .= '<td>' . htmlspecialchars(trim($value)) . '</td>';
        }
        $html .= '</tr>';
        if ($counter2 >= count($subjects)) {
            $counter2 = 0;
        } else {
            $counter2 = $counter2 + 1;
        }
    }
    $html .= '</table>';

    // Print the HTML for Planning Matrix
    $pdf->writeHTML($html, true, false, true, false, '');

    $randomNumber = rand(1000, 9999);
    $pdfFilename = 'subject_report_' . $randomNumber . '.pdf';
    // Output the PDF for download
    $pdf->Output($pdfFilename, 'D');  // 'D' forces the download dialog
}