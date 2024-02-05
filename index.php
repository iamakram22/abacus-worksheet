<?php
include('header.php');
?>
<section class="main container">
    <div class="container">

        <h1>Abacus Worksheet Generator</h1>
        
        <form action="generate_worksheet.php" method="post" id="worksheet_generator_form">

            <div class="input-group mb-3">
                <span class="input-group-text col-7">Number of Digits:</span>
                <input type="number" id="number_digits" name="number_digits" class="form-control" value="2" min="2" max="10">
            </div>
            
            <div class="input-group mb-3">
                <span class="input-group-text col-7">Number of Rows:</span>
                <input type="number" id="number_rows" name="number_rows" class="form-control" value="5" min="2" max="10">
            </div>
            
            <div class="input-group mb-3">
                <span class="input-group-text col-7">Number of Questions:</span>
                <input type="number" id="number_questions" name="number_questions" class="form-control" value="50" min="10" max="200" step="10">
            </div>
            
            <div class="input-group mb-3">
                <span class="input-group-text col-7">Operator:</span>
                <select class="form-select" name="operator" id="operator">
                    <option value="+">Addition (+)</option>
                    <option value="-">Subtraction (-)</option>
                    <option value="x">Multiplication (*)</option>
                    <option value="/">Division (/)</option>
                </select>
            </div>

            <div class="input-group mb-3" id="subtraction_field">
                <span class="input-group-text col-7">Include Subtractions</span>
                <div class="form-control">
                    <input type="checkbox" name="include_subtraction" id="include_subtraction" class="form-check-input">
                </div>
            </div>

            <input type="submit" class="btn btn-primary" value="Generate Worksheet">

        </form>

    </div>
</section>


<?php
include('footer.php');