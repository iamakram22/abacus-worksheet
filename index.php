<?php
include('header.php');
?>
<section class="main">
    <div class="container">

        <h1>Abacus Worksheet Generator</h1>
        
        <form action="generate_worksheet.php" method="post">
            <label for="num_digits">Number of Digits:</label>
            <input type="number" name="num_digits" id="num_digits" value="2" min="1" max="10">
            <br>
            <label for="num_rows">Number of Rows:</label>
            <input type="number" name="num_rows" id="num_rows" value="5" min="1" max="10">
            <br>
            <label for="num_questions">Number of Question:</label>
            <input type="number" name="num_questions" id="num_questions" value="50" min="10" max="200" step="10">
            <br>
            <label for="operator">Operator:</label>
            <select name="operator" id="operator">
                <option value="+">Addition (+)</option>
                <option value="-">Subtraction (-)</option>
                <option value="x">Multiplication (*)</option>
                <option value="/">Division (/)</option>
            </select>
            <br>
            <input type="submit" value="Generate Worksheet">
        </form>

    </div>
</section>


<?php
include('footer.php');