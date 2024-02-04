<?php
include('header.php');

// Retrieve form data
$num_digits = $_POST['num_digits'];
$num_rows = $_POST['num_rows'];
$num_questions = $_POST['num_questions'];
$operator = $_POST['operator'];

// Generate table
echo '<div id="worksheet_table">';
for ($i=0; $i < $num_questions; $i++) { 
    echo '<div class="table_row">';
    echo '<span class="question_number">Q. '. $i + 1 .'</span>';

    for ($j=0; $j < $num_rows; $j++) { 
        $num = rand(1, 10 ** $num_digits);
        echo '<div class="cell">' . $num . '</div>';
    }

    echo '<div class="cell answer_cell"><span class="operator">' . $operator . '</span><code>______</code></div>';

    echo '</div>';
}
echo '</div>';


include('footer.php');