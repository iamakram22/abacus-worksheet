$(document).ready(function(){
    $('#worksheet_generator_form').validate();

    const subtraction_field = $('#subtraction_field');
    const include_subtraction = $('#include_subtraction');
    const operator = $('#operator');

    operator.on('change', function(){
        if($(this).val() !== '+') {
            subtraction_field.hide();
            include_subtraction.prop({'checked': false, 'disabled': true})
        } else {
            subtraction_field.show();
            include_subtraction.prop({'checked': false, 'disabled': false})
        }
    });
});