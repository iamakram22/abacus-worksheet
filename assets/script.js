$(document).ready(function(){
    $('#worksheet_generator_form').validate();

    const abFields = $('.ab_field');
    const vmFields = $('.vm_field');
    
    const numberRows = $('#number_rows');
    const subtractionField = $('#subtraction_field');
    const includeSubtraction = $('#include_subtraction');
    const operator = $('#operator');
    const vmOperators = ['sr', 'cr'];
    
    // Hide VM options Init
    toggleFields();

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
     * Toggle AB & VM Fields based on type
     * @param {boolean} ab 
     */
    function toggleFields(ab = true) {
        if(ab) {
            numberRows.val(5);
            abFields.show();
            vmFields.hide();
        } else {
            numberRows.val(1);
            abFields.hide();
            vmFields.show();
        }
    }

    /**
     * Remove options on operator change
     */
    operator.on('change', function(){
        let value = $(this).val();
        if(value === '+') {
            visibilitySubtractionField(false)
            changeSubtractionField();
            visibilityNumberRows(false, 5);
        } else if( value === '/') {
            changeSubtractionField(true,true);
            visibilityNumberRows(false, 2);
        } else {
            visibilitySubtractionField();
            changeSubtractionField(false,true);
            visibilityNumberRows(false, 5);
        }
    });

    /**
     * Toggle VM options on type change
     */
    const worksheetType = $('#worksheet_type');
    worksheetType.on('change', function() {
        operator.val('+');
        $(this).val() === 'ab' ? toggleFields() : toggleFields(false);
    });
});