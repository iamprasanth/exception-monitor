
(function($) {
    "use strict"; // Start of use strict
  
    // Toggle the side navigation
    $("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
      $("body").toggleClass("sidebar-toggled");
      $(".sidebar").toggleClass("toggled");
      if ($(".sidebar").hasClass("toggled")) {
        $('.sidebar .collapse').collapse('hide');
      };
    });
  
    // Close any open menu accordions when window is resized below 768px
    $(window).resize(function() {
      if ($(window).width() < 768) {
        $('.sidebar .collapse').collapse('hide');
      };
      
      // Toggle the side navigation when window is resized below 480px
      if ($(window).width() < 480 && !$(".sidebar").hasClass("toggled")) {
        $("body").addClass("sidebar-toggled");
        $(".sidebar").addClass("toggled");
        $('.sidebar .collapse').collapse('hide');
      };
    });
  
    // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
    $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function(e) {
      if ($(window).width() > 768) {
        var e0 = e.originalEvent,
          delta = e0.wheelDelta || -e0.detail;
        this.scrollTop += (delta < 0 ? 1 : -1) * 30;
        e.preventDefault();
      }
    });
  
    // Scroll to top button appear
    $(document).on('scroll', function() {
      var scrollDistance = $(this).scrollTop();
      if (scrollDistance > 100) {
        $('.scroll-to-top').fadeIn();
      } else {
        $('.scroll-to-top').fadeOut();
      }
    });
  
    // Smooth scrolling using jQuery easing
    $(document).on('click', 'a.scroll-to-top', function(e) {
      var $anchor = $(this);
      $('html, body').stop().animate({
        scrollTop: ($($anchor.attr('href')).offset().top)
      }, 1000, 'easeInOutExpo');
      e.preventDefault();
    });
  
})(jQuery); // End of use strict

// General function for normal form submit
window.submitForm = function(element) {
    $('.help-block').html('');
    let formId = $(element).closest('form').attr('id');
    let actionUrl = $(element).closest('form').attr('action');
    let method = $(element).closest('form').attr('method');
    let formData = new FormData($('#' + formId)[0]);
    let redirect = $(element).data('redirect');
    let table = $(element).data('table');
    let alert = $(element).data('alert');
    let serverCall = $(element).data('servercall');
    let modalClose = $(element).data('modalclose');
    let modalId = $(element).closest('.modal').attr('id');
    if(serverCall) {
        $("#spinner-text").html('Server connection takes time. Please wait.');
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: actionUrl,
        type: method,
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
            $("#spinner-text").html('');
            if (data.success) {
                if (table) {
                    reloadDataTable('#' + table)
                    $('#' + modalId).modal('hide');
                } else if (typeof redirect != 'undefined') {
                    window.location.href = redirect;
                } else if(alert) {
                    if(modalId) {
                        $('#' + modalId).modal('hide');
                    }
                    Swal.fire({
                        title: 'Success',
                        text: 'Updated succesfully',
                        icon: 'success',
                        confirmButtonText: 'Ok',
                    });
                } else if(modalClose) {
                    $('#' + modalId).modal('hide');
                }
            }
        }, error: function(xhr) {
            $("#spinner-text").html('');
            if (xhr.status == 422) {
              var data = xhr.responseJSON;
              $.each(data.errors, function (key, val) {
                  $("." + key + "-error").text(val[0]);
              });
            }
        }
    });
}

// Function to reload a datatable
window.reloadDataTable = function(tableId) {
    $(tableId).DataTable().ajax.reload(null, false);
}

//dropdowns with searching
$(".app-select").select2({
    response: true,
    "allowClear": false,
    placeholder: 'Select an app',
    cache: true,
    theme: "classic"
});

//For roles right
$('#app-selector').on('change', function () {
    var id = $(this).val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: baseUrl + 'changeslug/' + id,
        type: 'GET',
        success: function (data) {
            window.location.reload();
        }
    });
});

// General function for delete
window.deletefunc = function(element) {
    let actionUrl = $(element).data('url');
    let id = $(element).data('id');
    let redirect = $(element).data('redirect');
    let message = $(element).data('message');
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
            url: actionUrl + '/' + id,
            method: 'POST',
            success: function(response) {
                Swal.fire({
                    title: 'Success',
                    text: message,
                    icon: 'success',
                    confirmButtonText: 'Ok',
                }).then((result) => {
                    window.location.href = redirect;
                });

            }
        });
    }
    });
}

// keypress
$('#login-form').keydown(function(e) {
    var key = e.which;
    if (key == 13) {
        $('.login').trigger('click');
    }
});

$("#ChangePasswordModel").on('show.bs.modal', function (e) {
    $("#myprofile").modal("hide");
});
$("#myprofile").on('show.bs.modal', function (e) {
    $("#ChangePasswordModel").modal("hide");
});

// Show loading spinner on page load and ajax calls
$(document).ready(function () {
    $(window).on('load', function(){
        if (!$.active) {// check for active ajax calls
            $('.loader-wrapper').fadeOut("fast");
        }
    });
    $(document).ajaxStart(function () {
        $('.loader-wrapper').show();
    });
    $(document).ajaxComplete(function () {
        $('.loader-wrapper').fadeOut("fast");
    });
});