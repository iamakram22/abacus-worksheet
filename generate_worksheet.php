<?php
// Include mPDF library
require_once __DIR__ . '/vendor/autoload.php';

include('header.php');

// Retrieve form data
$number_digits = $_POST['number_digits'];
$number_rows = $_POST['number_rows'];
$number_questions = $_POST['number_questions'];
$operator = $_POST['operator'];
$include_subtraction = isset($_POST['include_subtraction']) ? $_POST['include_subtraction'] : false;

ob_start();
// Generate table
echo '<div id="worksheet_table">';
    for ($i=0; $i < $number_questions; $i++) { 
        echo '<div class="table_row">';
        echo '<span class="question_number">Q. '. $i + 1 .'</span>';

        for ($j=0; $j < $number_rows; $j++) { 
            $num = rand(1, 10 ** $number_digits);
            if (!empty($include_subtraction)) {
                $num = rand(-$number_digits, $number_digits) < 0.5 ? -$num : $num;
            }
            echo '<div class="cell">' . $num . '</div>';
        }

        echo '<div class="cell answer_cell"><span class="operator">' . $operator . '</span><code>______</code></div>';

        echo '</div>';
    }
echo '</div>';

$content = ob_get_clean();

// include('generate_worksheet_pdf.php');
include('footer.php');

// Create a new mPDF object
$mpdf = new \Mpdf\Mpdf();

$stylesheet = file_get_contents('style.css');

$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);

// Write content to PDF
$mpdf->WriteHTML($content);

// Output the PDF as a download
$mpdf->Output('worksheet.pdf', 'D');