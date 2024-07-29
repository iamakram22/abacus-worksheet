<?php
// Include mPDF library
require_once __DIR__ . '/vendor/autoload.php';

use Mpdf\Mpdf;
use PhpOffice\PhpSpreadsheet\IOFactory;

$vmDir = './vm';

// Retrieve form data
$worksheet_type = $_POST['worksheet_type'];
$number_digits = $_POST['number_digits'];
$number_rows = $_POST['number_rows'];
$number_questions = $_POST['number_questions'];
$operator = $_POST['operator'];
$include_subtraction = isset($_POST['include_subtraction']) ?? false;
$generate_pdf = isset($_POST['generate_pdf']) ?? false;

// Set worksheet type
$worksheet_title = $worksheet_type === 'ab' ? 'Abacus' : 'Vedic Maths';

// Assign operator Text
$operatorTitles = [
    '+' => 'Addition',
    '-' => 'Subtraction',
    'x' => 'Multiplication',
    '/' => 'Division',
];
$title = isset($operatorTitles[$operator]) && $worksheet_type === 'ab' ? $operatorTitles[$operator] : $_POST['vm_topic'];

/**
 * Generate random number
 * @param int $digits
 * @return int
 */
function generateRandomNumber($digits) {
    return rand(1, 10 ** $digits);
}

function getQuestionsFromXlsx($filePath)
{
    $spreadsheet = IOFactory::load($filePath);
    $worksheet = $spreadsheet->getActiveSheet();

    $questions = [];
    foreach ($worksheet->getRowIterator() as $row) {
        $cell = $row->getCellIterator()->current();
        $questions[] = $cell->getValue();
    }

    return $questions;
}

function getRandomQuestions($questions, $numberOfQuestions)
{
    if ($numberOfQuestions > count($questions)) {
        $numberOfQuestions = count($questions);
    }

    $randomKeys = array_rand($questions, $numberOfQuestions);
    $randomQuestions = [];
    foreach ($randomKeys as $key) {
        $randomQuestions[] = $questions[$key];
    }

    return $randomQuestions;
}

// Intialize content
$content = '';

// Generate worksheet data
$content .= '<div class="worksheet_type">'. $title .'</div>';
$content .= '<div id="worksheet_table">';
if($worksheet_type === 'ab')
{
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
            $content .=  $num;
            // $content .=  $j === ($number_rows - 1) ? $operator . ' ' . $num : $num;
            $content .= '</div>';
        }

        $content .= '<div class="cell answer_cell cell-bg"><span class="operator">=</span><code>___________</code></div>';
        $content .= '</td></tr></table>';
        $content .= '</div>';
    }
} else
{
    $fileName = $_POST['vm_topic'];
    $filePath = "$vmDir/$fileName.xlsx";

    $questions = getQuestionsFromXlsx($filePath);
    $randomQuestions = getRandomQuestions($questions, $number_questions);

    foreach($randomQuestions as $key => $question) {
        $content .= '<div class="table_row">';
        $content .= '<table><tr><td>';
        $content .= '<div class="question_number cell cell-bg">Q. ' . ($key + 1) . '</div>';

        $content .= '<div class="cell">' . $question . '</div>';

        $content .= '<div class="cell answer_cell cell-bg"><span class="operator">=</span><code>___________</code></div>';
        $content .= '</td></tr></table>';
        $content .= '</div>';
    }
}
$content .= '</div>';

if($generate_pdf) {
    $mpdf = new Mpdf();

    $mpdf->SetAuthor('Hashtagweb.in');
    $mpdf->SetCreator('Hashtagweb.in');
    $mpdf->SetTitle( $worksheet_title . ' Worksheet');
    $mpdf->SetSubject($worksheet_title .' Worksheet');
    $header = $worksheet_title . ' Worksheet | | <a href="https://iiva.in">AVAS IIVA</a>';
    $footer = 'Developed by <a href="https://hashtagweb.in">Hashtagweb.in</a> | | {PAGENO}';

    $mpdf->SetHeader($header);
    $mpdf->SetFooter($footer);
    $mpdf->AddPage();
    $mpdf->WriteHTML(file_get_contents('assets/pdf.css'), 1);
    $mpdf->WriteHTML($content);

    $mpdf->Output('Worksheet_'. str_replace(' ', '_', $title) . '_' . time() .'.pdf', 'I');

    exit;
} else {
    include 'header.php';
    echo $content;
    include 'footer.php';
}