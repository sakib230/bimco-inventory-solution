function mobileNoValidation(mobileNumber, fieldId) {
    if (mobileNumber.length === 11) {
        var string = mobileNumber;
        var re = new RegExp("^01[3-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]");
        if (re.test(string)) {
        } else {
            sweetAlert("Invalid mobile number");
            document.getElementById(fieldId).value = '';
            document.getElementById(fieldId).select();
        }
    } else {
        sweetAlert("Invalid mobile number");
        document.getElementById(fieldId).value = '';
        document.getElementById(fieldId).select();
    }

}

function emailValidation(email, fieldId) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!regex.test(email)) {
        $('#' + fieldId).val('');
        sweetAlert("Invalid email");
    }
}

function showLoader() {
    $('#overlay1').show();
}
function hideLoader() {
    $('#overlay1').hide();
}

$('.dateTxt').datetimepicker({
    format: 'YYYY-MM-DD'
});


$(document).ready(function () {
    $(document).on('click', '.btn-number', function (e) {
        e.preventDefault();
        fieldName = $(this).attr('data-field');
        type = $(this).attr('data-type');
        var input = $("input[name='" + fieldName + "']");
        var currentVal = parseInt(input.val());
        if (!isNaN(currentVal)) {
            if (type === 'minus') {

                if (currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                }
                if (parseInt(input.val()) === input.attr('min')) {
                    $(this).attr('disabled', true);
                }

            } else if (type === 'plus') {

                if (currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();
                }
                if (parseInt(input.val()) === input.attr('max')) {
                    $(this).attr('disabled', true);
                }
            }
        } else {
            input.val(0);
        }
    });
    $(document).on('focusin', '.input-number', function () {
        $(this).data('oldValue', $(this).val());
    });
    
    
    $(document).on('change', '.input-number', function () {
        minValue = parseInt($(this).attr('min'));
        maxValue = parseInt($(this).attr('max'));
        valueCurrent = parseInt($(this).val());
        name = $(this).attr('name');
        if (valueCurrent >= minValue) {
            $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled');
        } else {
            //alert('Sorry, the minimum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        if (valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled');
        } else {
            //alert('Sorry, the maximum value was reached');
            $(this).val($(this).data('oldValue'));
        }


    });
    $(document).on('keydown', '.input-number', function (e) {
// Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                // Allow: Ctrl+A
                        (e.keyCode === 65 && e.ctrlKey === true) ||
                        // Allow: home, end, left, right
                                (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
});


function getInputData(fieldsArr) {
    var jsonVariable = {};
    var inputArr = new Array();
    var requiredFlag = 1;
    for (var i = 0; i < fieldsArr.length; i++) {
        var inputTextValue = "";
        inputArr = fieldsArr[i].split('|');

        inputTextValue = $.trim($('#' + inputArr[0]).val());  // inputArr[0] text filed id
        if (inputArr.length === 2) {  // 2 means this filed is required
            if (inputTextValue === "") {
                requiredFlag = 0;
                $("#" + inputArr[1]).attr('class', 'text-danger');  // inputArr[1] is required field's error div id
            } else {
                $("#" + inputArr[1]).attr('class', 'hidden text-danger');
            }
        }
        jsonVariable[inputArr[0]] = inputTextValue;
    }
    if (requiredFlag === 0) {
        return false;  // required field validation return false
    }
    return jsonVariable;
}