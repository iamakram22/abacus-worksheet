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
            subtractionField.hide(100);
            numberRows.val(1).parent().hide(100);
            changeSubtractionField();
        }
    }

    // Remove options on operator change
    operator.on('change', function(){
        let value = $(this).val();
        if(value === '+') {
            visibilitySubtractionField(false)
            changeSubtractionField();
        } else if( value === '/') {
            numberRows.val(2);
            changeSubtractionField(true,true);
        } else {
            visibilitySubtractionField();
            changeSubtractionField(false,true);
        }
    });

    // Show hide VM options on type change
    const worksheetType = $('#worksheet_type');
    worksheetType.on('change', function() {
        $(this).val() === 'vm' ? changeForm('vm') : changeForm();
    });
});