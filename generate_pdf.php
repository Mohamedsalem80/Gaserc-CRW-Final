<?php
session_start();
require_once('TCPDF/tcpdf.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the language setting
    $countriesArabic = [
        'الامارات',
        'البحرين',
        'السعودية',
        'عمان',
        'قطر',
        'الكويت',
        'اليمن'
    ];
    
    // Country names in English
    $countriesEnglish = [
        'United Arab Emirates',
        'Bahrain',
        'Saudi Arabia',
        'Oman',
        'Qatar',
        'Kuwait',
        'Yemen'
    ];

    $lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';
    $isArabic = $lang === 'ar';
    $country = isset($_SESSION['country']) ? $_SESSION['country'] : '';
    $country_formatted = str_replace(' ', '_', $country);
    $index = array_search($country, $countriesEnglish);
    $displayCountry = ($index !== false) && $isArabic? $countriesArabic[$index] : $country;

    // Translate headers based on language
    $mainLogo = $isArabic ? 'logo' : 'logo_en';
    $mainTitle = $isArabic ? 'الرئيسي' : 'Main';
    $planningTitle = $isArabic ? 'تحت التخطيط' : 'Under Planning';
    $subTitle = $isArabic ? 'تقرير الاوزان النسبية' : 'Ratio-Weights Report';

    // Set text alignment for tables based on language
    $textAlign = $isArabic ? 'right' : 'left';

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

    // Set the Arabic-compatible font and direction
    $pdf->SetFont('dejavusans', '', 9);
    $pdf->setRTL($isArabic);  // Set text direction based on language

    $pdf->AddPage();
    $pdf->writeHTML('<h1 style="text-align: center; font-weight: bolder; font-size: 48px;">' . $displayCountry . '</h1><br /><h2 style="text-align: center;"> ' . $subTitle . ' </h2>', true, false, true, false, '');
    $pdf->Ln(30); // Add some space between images
    $pdf->Image('images/' . $mainLogo . '.jpg', '', '', 150, 22, 'JPG', '', 'C', true, 300, 'C', false, false, 1, false, false, false);
    $pdf->Ln(60); // Add some space between images
    if (!empty($country_formatted)) {
        $pdf->Image('images/Flag_of_' . $country_formatted . '.jpg', '', '', 60, 40, 'JPG', '', 'C', true, 300, 'C', false, false, 1, false, false, false);
    }

    // Add a page for "Main"
    $pdf->AddPage();
    $pdf->SetFont('dejavusans', 'B', 9);

    // Title for Main Section
    $pdf->writeHTML('<h1 style="text-align: ' . $textAlign . ';">' . $mainTitle . '</h1><br />', true, false, true, false, '');

    // Build the table for Main Matrix
    $html = '<table border="1" cellpadding="4">
            <tr>
                <th style="width: 100px; text-align: ' . $textAlign . ';">' . ($isArabic ? 'الصف' : 'Grade') . '</th>';

    for ($i = $start; $i <= $end; $i++) {
        $html .= '<th style="text-align: ' . $textAlign . ';">' . $i . '</th>';
    }

    $html .= '<th style="width: 50px; text-align: ' . $textAlign . ';">' . ($isArabic ? 'المجموع' : 'Total') . '</th>
        </tr>';
    
    $counter = 0;
    foreach ($subjects as $subject) {
        $html .= '<tr>';
        $html .= '<td style="text-align: ' . $textAlign . ';">' . htmlspecialchars(trim($subject)) . '</td>';
        foreach ($mainMatrix[$counter] as $value) {
            $html .= '<td style="text-align: ' . $textAlign . ';">' . htmlspecialchars(trim($value)) . '</td>';
        }
        $html .= '</tr>';
        $counter = ($counter + 1) % count($mainMatrix);  // Ensure counter loops correctly within matrix bounds
    }
    $html .= '</table>';

    // Print the HTML for Main Matrix
    $pdf->writeHTML($html, true, false, true, false, '');

    // Add a new page for "Under Planning"
    $pdf->AddPage();
    $pdf->writeHTML('<h1 style="text-align: ' . $textAlign . ';">' . $planningTitle . '</h1><br />', true, false, true, false, '');

    // Build the table for Planning Matrix
    $html = '<table border="1" cellpadding="4">
    <tr>
        <th style="width: 100px; text-align: ' . $textAlign . ';">' . ($isArabic ? 'الصف' : 'Grade') . '</th>';

    for ($i = $start; $i <= $end; $i++) {
        $html .= '<th style="text-align: ' . $textAlign . ';">' . $i . '</th>';
    }

    $html .= '<th style="width: 50px; text-align: ' . $textAlign . ';">' . ($isArabic ? 'المجموع' : 'Total') . '</th>
    </tr>';
    
    $counter2 = 0;
    foreach ($subjects as $subject) {
        $html .= '<tr>';
        $html .= '<td style="text-align: ' . $textAlign . ';">' . htmlspecialchars(trim($subject)) . '</td>';
        foreach ($planningMatrix[$counter2] as $value) {
            $html .= '<td style="text-align: ' . $textAlign . ';">' . htmlspecialchars(trim($value)) . '</td>';
        }
        $html .= '</tr>';
        $counter2 = ($counter2 + 1) % count($planningMatrix);  // Ensure counter2 loops correctly within matrix bounds
    }
    $html .= '</table>';

    // Print the HTML for Planning Matrix
    $pdf->writeHTML($html, true, false, true, false, '');

    $randomNumber = rand(1000, 9999);
    $pdfFilename = 'CRW_report_' . $randomNumber . '.pdf';
    // Output the PDF for download
    $pdf->Output($pdfFilename, 'D');  // 'D' forces the download dialog
}