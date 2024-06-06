<?php
// Include mPDF library
require_once __DIR__ . '/vendor/autoload.php';

use Mpdf\Mpdf;

// Retrieve form data
$worksheet_type = $_POST['worksheet_type'];
$number_digits = $_POST['number_digits'];
$number_rows = $_POST['number_rows'];
$number_questions = $_POST['number_questions'];
$operator = $_POST['operator'];
$include_subtraction = isset($_POST['include_subtraction']) ? $_POST['include_subtraction'] : false;
$generate_pdf = isset($_POST['generate_pdf']) ? $_POST['generate_pdf'] : false;
$vmoperator;

// change HTML code to text
if($worksheet_type === 'vm') {
    switch ($operator) {
        case 'cr':
            $vmoperator = $operator;
            $operator = '&#8731;';
            break;
        
        default:
            $vmoperator = $operator;
            $operator = '&#8730;';
            break;
    }
} else {
    if ($operator === '/') $operator = '÷';
}

function generateRandomNumber($digits) {
    return rand(1, 10 ** $digits);
}

// Intialize content
$content = '';

// Generate worksheet data
$content .= '<div id="worksheet_table">';
for ($i = 0; $i < $number_questions; $i++) {
    $content .= '<div class="table_row">';
    $content .= '<table><tr><td>';
    $content .= '<div class="question_number cell cell-bg">Q. ' . ($i + 1) . '</div>';

    $sum = array();
    // Generate random number
    for ($j = 0; $j < $number_rows; $j++) {
        $num = rand(1, 10 ** $number_digits);
        $num = $num == 10 ? 9 : $num;
        $sum[$j] = $num;
        // Include negative numbers
        if (!empty($include_subtraction) && $j != 0 && $operator === '+') {
            $num = rand(-10, 10) < 0 ? $num * -1 : $num;
            $sum[$j] = $num;
            while(array_sum($sum) < 0) {
                $num = rand(-10, 10) < 0 ? $num * -1 : $num;
                $sum[$j] = $num;
            }
        }
        $content .= '<div class="cell">';
        $content .=  $j === ($number_rows - 1) ? $operator . ' ' . $num : $num;
        $content .= '</div>';
    }

    $content .= '<div class="cell answer_cell cell-bg"><span class="operator">=</span><code>___________</code></div>';
    $content .= '</td></tr></table>';
    $content .= '</div>';
}
$content .= '</div>';

if($generate_pdf) {
    $mpdf = new Mpdf();

    $mpdf->SetAuthor('Hashtagweb.in');
    $mpdf->SetCreator('Hashtagweb.in');
    $mpdf->SetTitle('Abacus Worksheet');
    $mpdf->SetSubject('Abacus Worksheet');

    $header = 'Abacus Worksheet | | <a href="https://iiva.in">AVAS IIVA</a>';
    $footer = 'Developed by <a href="https://hashtagweb.in">Hashtagweb.in</a> | | {PAGENO}';

    $mpdf->SetHeader($header);
    $mpdf->SetFooter($footer);
    $mpdf->AddPage();
    $mpdf->WriteHTML(file_get_contents('assets/pdf.css'), 1);
    $mpdf->WriteHTML($content);

    $mpdf->Output('Worksheet_'. time() .'_.pdf', 'I');

    exit;
} else {
    include 'header.php';
    echo $content;
    include 'footer.php';
}