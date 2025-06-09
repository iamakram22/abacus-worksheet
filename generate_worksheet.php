<?php
// Include mPDF library
require_once __DIR__ . '/vendor/autoload.php';

use Mpdf\Mpdf;
use PhpOffice\PhpSpreadsheet\IOFactory;

// Retrieve form data
$worksheet_type = $_POST['worksheet_type'];
$class = $_POST['class'];
$topic = $_POST['topic'];
$sheet = $_POST['sheet'];
$number_questions = $_POST['number_questions'];
$include_subtraction = isset($_POST['include_subtraction']) ?? false;
$generate_pdf = isset($_POST['generate_pdf']) ?? false;

$title = explode('.', $sheet)[0];

// Set worksheet type
$worksheet_title = $worksheet_type === 'ab' ? 'Abacus' : 'Easy Maths';

function getQuestionsFromXlsx($filePath)
{
    $spreadsheet = IOFactory::load($filePath);
    $worksheet = $spreadsheet->getActiveSheet();

    $questions = [];

    foreach ($worksheet->getRowIterator() as $row) {
        $cell = $worksheet->getCell('A' . $row->getRowIndex());
        $value = trim($cell->getValue());

        if (!empty($value)) {
            $questions[] = $value;
        }
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

$title = "{$class}: {$topic} - " . explode('.', $sheet)[0];

// Generate worksheet data
$content .= '<div class="worksheet_type">' . $title . '</div>';
$content .= '<div id="worksheet_table">';
$filePath = "./{$worksheet_type}/{$class}/{$topic}/{$sheet}";

$questions = getQuestionsFromXlsx($filePath);
$randomQuestions = getRandomQuestions($questions, $number_questions);

foreach ($randomQuestions as $key => $question) {
    $content .= '<div class="table_row">';
    $content .= '<table><tr><td>';
    $content .= '<div class="question_number cell cell-bg">Q. ' . ($key + 1) . '</div>';

    $formattedQuestion = str_replace(["\\n", "\r\n", "\r", "\n"], "<br>", $question);
    $content .= '<div class="cell">' . str_replace('=', '', $formattedQuestion) . '</div>';
    // $content .= '<div class="cell">' . nl2br(htmlspecialchars($question)) . '</div>'; 

    $content .= '<div class="cell answer_cell cell-bg"><span class="operator">=</span><code>___________</code></div>';
    $content .= '</td></tr></table>';
    $content .= '</div>';
}
$content .= '</div>';

if ($generate_pdf) {
    $mpdf = new Mpdf();

    $mpdf->SetAuthor('Hashtagweb.in');
    $mpdf->SetCreator('Hashtagweb.in');
    $mpdf->SetTitle($worksheet_title . ' Worksheet');
    $mpdf->SetSubject($worksheet_title . ' Worksheet');
    $header = $worksheet_title . ' Worksheet | | <a href="https://iiva.in">AVAS IIVA</a>';
    $footer = 'Developed by <a href="https://hashtagweb.in">Hashtagweb.in</a> Pwered by Kaps Learning System | | {PAGENO}';

    $mpdf->SetHeader($header);
    $mpdf->SetFooter($footer);
    $mpdf->AddPage();
    $mpdf->WriteHTML(file_get_contents('assets/pdf.css'), 1);
    $mpdf->WriteHTML($content);

    $mpdf->Output('Worksheet_' . str_replace(' ', '_', $title) . '_' . time() . '.pdf', 'I');

    exit;
} else {
    include 'header.php';
    echo $content;
    include 'footer.php';
}
