$(document).ready(function() {

// Function to delete application
$(document).on('click', '.delete-app', function() {
    let id = $(this).data('id');
    Swal.fire({
        title: 'Are you sure',
        text: 'All related data will also be deleted!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, keep it'
    }).then((result) => {
        if (result.value) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: baseUrl + 'applications/delete/' + id,
            method: 'POST',
            success: function(response) {
                Swal.fire({
                    title: 'Success',
                    text: 'Deleted succesfully',
                    icon: 'success',
                    confirmButtonText: 'Ok',
                }).then((result) => {
                    window.location.href = baseUrl + 'dashboard';
                });

            }
        });
    }
    });
});

// Function to update application
$(document).on('click', '.update-application', function() {
    let formData = $('#' + $(this).data('form')).serialize();
    let form = $(this).data('form');
    $("#application-view-form :input").each(
        function() {
            var input = $(this).attr('name');
            var id = input + "-error";
            $('#' + id).html('');
        }
    );
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: baseUrl + 'applications/update',
        method: 'PUT',
        data: formData,
        error: function(jqXhr) {
            if (jqXhr.status === 422) {
                let data = jqXhr.responseJSON;
                $.each(data.errors, function(key, val) {
                    $("#" + form + ' ' + "#" + key + "-error").text(val[0]);
                });
            }
        },
        success: function(response) {
            Swal.fire({
                title: 'Success',
                text: 'Updated succesfully',
                icon: 'success',
                confirmButtonText: 'Ok',
            }).then((result) => {
                window.location.reload();
            });
        }
    });
});
});
