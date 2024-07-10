$(document).ready(function(){
    $('#worksheet_generator_form').validate();

    // Hide VM options first
    const vmOptions = $('.vm-option');
    vmOptions.hide();

    const numberRows = $('#number_rows');
    const subtractionField = $('#subtraction_field');
    const includeSubtraction = $('#include_subtraction');
    const operator = $('#operator');
    const vmOperators = ['sr', 'cr'];

    /**
     * Change Include Subtraction field attributes
     * @param {boolean} checked
     * @param {boolean} disabled
     */
    function changeSubtractionField(checked = false, disabled = false) {
        includeSubtraction.prop({'checked': checked, 'disabled': disabled})
    }

    /**
     * Change subtraction field visibility
     * @param {boolean} hide 
     * @param {number} animation 
     */
    function visibilitySubtractionField(hide = true, animation = 100) {
        hide ? subtractionField.hide(animation) : subtractionField.show(animation);
    }

    /**
     * Chnage number of rows field visibility & value
     * @param {boolean} hide 
     * @param {number} value 
     */
    function visibilityNumberRows(hide = false, value = 5) {
        hide ? numberRows.val(value).parent().hide() : numberRows.val(value).parent().show();
    }

    /**
     * Change worksheet form fields
     * @param {string} type 
     */
    function changeForm(type = 'ab') {
        if(type === 'ab') {
            vmOptions.hide();
            subtractionField.show(100);
            numberRows.val(5).parent().show(100);
            changeSubtractionField();
        } else {
            vmOptions.show();
            // subtractionField.hide(100);
            changeSubtractionField();
        }
    }

    // Remove options on operator change
    operator.on('change', function(){
        let value = $(this).val();
        if(value === '+') {
            visibilitySubtractionField(false)
            changeSubtractionField();
            visibilityNumberRows(false, 5);
        } else if( value === '/') {
            changeSubtractionField(true,true);
            visibilityNumberRows(false, 2);
        } else if(value === 'sr' || value === 'cr') {
            visibilityNumberRows(true, 1);
            visibilitySubtractionField();
            changeSubtractionField(false,true);
        } else {
            visibilitySubtractionField();
            changeSubtractionField(false,true);
            visibilityNumberRows(false, 5);
        }
    });

    // Show hide VM options on type change
    const worksheetType = $('#worksheet_type');
    worksheetType.on('change', function() {
        operator.val('+');
        $(this).val() === 'vm' ? changeForm('vm') : changeForm();
    });
});