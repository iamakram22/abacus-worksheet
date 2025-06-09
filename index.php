<?php
include('header.php');
?>
<section class="main container">
    <div class="container">

        <h1 class="mb-4 mt-2">Generate Worksheet</h1>

        <form action="./generate_worksheet.php" method="post" id="worksheet_generator_form">

            <div class="input-group mb-3">
                <span class="input-group-text col-7">Subject:</span>
                <select class="form-select" name="worksheet_type" id="worksheet_type" title="Select Worksheet Type" required>
                    <option value="" disabled selected hidden>Select Subject</option>
                    <option value="ab">Abacus (AB)</option>
                    <option value="vm">Easy Maths (EM)</option>
                </select>
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text col-7">Select Class:</span>
                <select class="form-select" name="class" id="class" required disabled>
                    <option value="">Select Class</option>
                </select>
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text col-7">Select Topic:</span>
                <select class="form-select" name="topic" id="topic" required disabled>
                    <option value="">Select Topic</option>
                </select>
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text col-7">Select Sheet:</span>
                <select class="form-select" name="sheet" id="sheet" required disabled>
                    <option value="">Select Sheet</option>
                </select>
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text col-7">Number of Questions:</span>
                <input type="number" id="number_questions" name="number_questions" class="form-control" required value="50"
                    min="10" max="100" step="10" title="Number of Questions">
            </div>

            <div class="input-group mb-3" id="pdf_field">
                <span class="input-group-text col-7">Generate PDF</span>
                <div class="form-control">
                    <input type="checkbox" name="generate_pdf" id="generate_pdf" class="form-check-input" checked
                        title="Generate PDF">
                </div>
            </div>

            <input type="submit" class="btn btn-primary" id="generate_worksheet" value="Generate Worksheet" title="Generate Worksheet" disabled>

        </form>

    </div>
    <div id="credit" class="bg-secondary-subtle text-center p-2 position-absolute bottom-0 start-0 z-n1">
        Tool developed by <a href="https://hashtagweb.in" target="_blank">Hashtagweb.in</a> | Powered by Kaps Learning System.
    </div>
</section>


<?php
include('footer.php');
