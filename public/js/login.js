$(document).ready(function() {
    // Login function
    $(document).on('click', '.login', function() {
        let formData;
        formData = $('#login-form').serialize();
        $('#email-error').html('');
        $('#password-error').html('');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: baseUrl + 'checklogin',
            method: 'POST',
            data: formData,
            dataType: 'json',
            error: function(jqXhr) {
                let data;
                if (jqXhr.status === 422) {
                    data = jqXhr.responseJSON;
                    $.each(data.errors, function(key, val) {
                        $("#" + key + "-error").text(val[0]);
                    });
                }
                if (jqXhr.status === 401) {
                    data = jqXhr.responseJSON;
                    $("#password-error").text(data.error);
                }
            },
            success: function(user) {

                window.location.href = baseUrl + 'dashboard';
            }
        });
    });
    // Backend login by keypress
    $('#login-form').keydown(function(e) {
        var key = e.which;
        if (key == 13) {
            $('.login').trigger('click');
        }
    });
});