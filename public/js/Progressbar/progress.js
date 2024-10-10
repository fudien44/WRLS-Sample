$(document).ready(function() {
    var current_fs, next_fs, previous_fs; // fieldsets
    var opacity;
    var current = 1;
    var steps = $("fieldset").length;

    setProgressBar(current);

    $(".next").click(function() {
        // e.preventDefault(); // Prevent default action to stop form transition

        current_fs = $(this).parent();
        next_fs = $(this).parent().next();

        var valid = true;

        // Validate required fields
        $(current_fs).find('input[required], select[required]').each(function() {
            $(this).removeClass('invalid-field'); 
            if ($(this).val() === "" || $(this).val() === "0") {
                valid = false;
                $(this).addClass('invalid-field').focus(); 
                toastr.error("Please fill out all required fields.", "Validation Error", {
                    closeButton: true,
                    progressBar: true,
                    timeOut: 3000
                });

                    
                return false; // Stop checking other fields
            }
        //     const telephoneInput = $('#telephone_number').val();
        //  if (telephoneInput.trim() === "") {
        //      valid = false; // If telephone number is empty, set valid to false
        //      $('#telephone_number').addClass('invalid-field').focus(); // Highlight the field
        //      toastr.error("Please fill out the telephone number.", "Validation Error", {
        //          closeButton: true,
        //          progressBar: true,
        //          timeOut: 3000
        //      });
        //      return false; // Halt further processing
        //  }
        });



        // Validate telephone number format
        if (!validateTelephoneNumber()) {
            valid = false; // If validation fails, set valid to false
        }

        // Validate file attachments (must be PDF)
        $(current_fs).find('input[type="file"]').each(function() {
            var fileInput = $(this)[0];
            $(this).removeClass('invalid-file'); 
            if (fileInput.files.length > 0) {
                var file = fileInput.files[0];
                var fileType = file.type;

                if (fileType !== "application/pdf") {
                    valid = false;
                    $(this).addClass('invalid-file').focus(); 
                    toastr.error("Only PDF files are allowed.", "File Upload Error", {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 3000
                    });
                    return false;
                }
            }
        });

        if (!valid) {
            return false; // Halt the form transition if validation fails
        }

        // Proceed if the form is valid
        // Add Class Active
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

        // Show the next fieldset
        next_fs.show(); 
        // Hide the current fieldset with animation
        current_fs.animate({opacity: 0}, {
            step: function(now) {
                opacity = 1 - now;
                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                next_fs.css({'opacity': opacity});
            }, 
            duration: 500
        });
        setProgressBar(++current);
    });

    $(".previous").click(function() {
        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();

        // Remove class active
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

        // Show the previous fieldset
        previous_fs.show();

        // Hide the current fieldset with animation
        current_fs.animate({opacity: 0}, {
            step: function(now) {
                opacity = 1 - now;
                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previous_fs.css({'opacity': opacity});
            }, 
            duration: 500
        });
        setProgressBar(--current);
    });

    function validateTelephoneNumber() {
        const telephoneInput = $('#telephone_number').val();
        const telephoneField = $('#telephone_number');

        // Check if input is empty
        if (telephoneInput.trim() === "") {
            telephoneField.removeClass('invalid-field'); // Remove invalid class if empty
            return true; // Return true if no input
        }

        const telephoneRegex = /^09\d{9}$/;  // Matches 09XXXXXXXXX

        if (!telephoneRegex.test(telephoneInput)) {
            // Show error notification
            toastr.error('Invalid telephone number format. Expected 11-digits format: 09XXXXXXXXX', 'Validation Error');

            // Add invalid class and focus on the input field
            telephoneField.addClass('invalid-field');
            telephoneField.focus();  // Focus on the telephone input field

            return false;
        } else {
            // Remove invalid class if the input is valid
            telephoneField.removeClass('invalid-field');
            return true;
        }
    }

    function setProgressBar(curStep) {
        var percent = parseFloat(100 / steps) * curStep;
        percent = percent.toFixed();
        $(".progress-bar").css("width", percent + "%");
    }

    $(".submit").click(function() {
        return false;
    });
});