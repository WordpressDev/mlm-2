$(document).ready(function () {
    $('#phone').mask('+79---------'); //@todo убрать!!!!!

    $('[name=register]').submit(function(e) {
        e.preventDefault();

        var data = {
            phone : $('#phone').val(),
            name : $('#name').val(),
            email : $('#email').val(),
            sponsor : $('#sponsor').val(),
            captcha : $('#captcha').val(),
            password : $('#password').val(),
            agreement : $('#agreement').val()
        }

        $.ajax({
            type: 'POST',
            url: '',
            data: {
                type : 'ajax',
                module : 'RegisterUser',
                data : data
            },
            dataType: 'json',
            beforeSend: function() {
                return checkFields();
            },
            complete: function() {
            },
            success: function(res) {
                if (res.result === 'error')
                {
                    checkFields(res.data);
                } else if (res.result === 'success') {
                    showDialog();
                }
            },
            error: function(data) {
                console.log('error');
            }
        });
    });

    $('#agreement').change(function() {
        var $submit = $('#submit');

        if ($(this).is(':checked'))
            $submit.attr('disabled', false);
        else
            $submit.attr('disabled', true);
    });

    $confirmCodeInput = $('#confirm-code');
    $confirmCodeInput.mask('-----');
    $confirmCodeInput.keyup(function() {
        var value = parseInt( $(this).val()),
            confirmButton = $('#confirm-submit');

        if (value > 10000)
            confirmButton.attr({disabled : false});
        else
            confirmButton.attr({disabled : true});
    });

    $('#confirm-phone').submit(function(e) {
        e.preventDefault();

        var data = {
            phone : $('#phone').val(),
            code : $('#confirm-code').val()
        };

        $.ajax({
            type: 'POST',
            url: '',
            data: {
                type : 'ajax',
                module : 'ActivateUser',
                data : data
            },
            dataType: 'json',
            beforeSend: function() {
            },
            complete: function() {
            },
            success: function(res) {
                if (res.result === 'error')
                {
                    $('#confirm-phone .error').text(res.message);
                } else if (res.result === 'success') {
                    window.location.href = '/';
                }
            },
            error: function(data) {
                console.log('error');
            }
        });
    });

    $('#resend-code').click(function () {
        var data = {
            phone : $('#phone').val()
        }
        $.ajax({
            type: 'POST',
            url: '',
            data: {
                type : 'ajax',
                module : 'ActivateUser',
                action : 'resendCode',
                data : data
            },
            dataType: 'json',
            beforeSend: function() {
            },
            complete: function() {
            },
            success: function(data) {
            },
            error: function(data) {
                console.log('error');
            }
        });
    });

    /*---------------------------FUNCTIONS---------------------------*/

    function checkFields(errors)
    {
        var data = {
            phone : $('#phone'),
            name : $('#name'),
            email : $('#email'),
            captcha : $('#captcha'),
            password : $('#password'),
            agreement : $('#agreement')
            },
            valid = true;

        for (item in data)
        {
            if (errors)
            {
                valid = false;
                for (var i=0; i<errors.length; i++)
                {
                    if (errors[i].type === item)
                        data[item].closest('div').find('.error').text(errors[i].message);
                    else
                        data[item].closest('div').find('.error').text('');
                }
            } else {
                if (data[item].val() === '')
                {
                    valid = false;
                    data[item].closest('div').find('.error').text('Заполните поле!');
                } else
                    data[item].closest('div').find('.error').text('');
            }
        }

        return valid;
    }

    function showDialog()
    {
        $('.blind').show();

        setTimeout(function() {
            $('#resend-code').attr({disabled : false});
        }, 60000);

        $confirmCodeInput.val('').focus();
    }
});