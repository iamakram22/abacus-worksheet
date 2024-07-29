<?php
include('header.php');
/**
 * Generate topic dropdown for Vedic Maths
 * @return void
 */
function generateDropdown()
{
    $files = glob('./vm/*.xlsx');
    $fileNames = array_map(function ($file) {
        return pathinfo($file, PATHINFO_FILENAME);
    }, $files);

    foreach ($fileNames as $fileName) {
        // $fileValue = str_replace(' ', '_', strtolower($fileName));
        echo '<option value="' . htmlspecialchars($fileName) . '">' . htmlspecialchars($fileName) . '</option>';
    }
}

?>
<section class="main container">
    <div class="container">

        <h1 class="mb-4 mt-2">Generate Worksheet</h1>
        
        <form action="./generate_worksheet.php" method="post" id="worksheet_generator_form">

            <div class="input-group mb-3">
                <span class="input-group-text col-7">Worksheet Type:</span>
                <select class="form-select" name="worksheet_type" id="worksheet_type" title="Select Worksheet Type">
                    <option value="ab">Abacus</option>
                    <option value="vm">Vedic Maths</option>
                </select>
            </div>

            <div class="input-group mb-3 ab_field">
                <span class="input-group-text col-7">Number of Digits:</span>
                <input type="number" id="number_digits" name="number_digits" class="form-control" value="1" min="1" max="10" title="Number of Digits">
            </div>
            
            <div class="input-group mb-3 ab_field">
                <span class="input-group-text col-7">Number of Rows:</span>
                <input type="number" id="number_rows" name="number_rows" class="form-control" value="5" min="2" max="10" title="Number of Rows">
            </div>
            
            <div class="input-group mb-3">
                <span class="input-group-text col-7">Number of Questions:</span>
                <input type="number" id="number_questions" name="number_questions" class="form-control" value="50" min="10" max="200" step="10" title="Number of Questions">
            </div>
            
            <div class="input-group mb-3 ab_field">
                <span class="input-group-text col-7">Operator:</span>
                <select class="form-select" name="operator" id="operator" title="Select Operator">
                    <option value="+" class="ab-option">Addition (+)</option>
                    <option value="-" class="ab-option">Subtraction (-)</option>
                    <option value="x" class="ab-option">Multiplication (x)</option>
                    <option value="/" class="ab-option">Division (/)</option>
                </select>
            </div>

            <div class="input-group mb-3 vm_field">
                <span class="input-group-text col-7">Topic</span>
                <select name="vm_topic" id="vm_topic" class="form-select" title="Select Vedic Maths Topic">
                    <?php generateDropdown(); ?>
                </select>
            </div>

            <div class="input-group mb-3 ab_field" id="subtraction_field">
                <span class="input-group-text col-7">Include Subtractions</span>
                <div class="form-control">
                    <input type="checkbox" name="include_subtraction" id="include_subtraction" class="form-check-input" title="Include Subtractions">
                </div>
            </div>

            <div class="input-group mb-3" id="pdf_field">
                <span class="input-group-text col-7">Generate PDF</span>
                <div class="form-control">
                    <input type="checkbox" name="generate_pdf" id="generate_pdf" class="form-check-input" checked title="Generate PDF">
                </div>
            </div>

            <input type="submit" class="btn btn-primary" value="Generate Worksheet" title="Generate Worksheet">

        </form>

    </div>
    <div id="credit" class="bg-secondary-subtle text-center p-2 position-absolute bottom-0 start-0 z-n1">
        Tool developed by <a href="https://hashtagweb.in" target="_blank">Hashtagweb.in</a>.
    </div>
</section>


<?php
include('footer.php');