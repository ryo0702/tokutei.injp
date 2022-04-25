import $ from "jquery";
import inView from "in-view";

// Document Completed
window.addEventListener('DOMContentCompleted', () => {
    inView('#contact-form').once('enter', (el) => {
        import(/* webpackChunkName: "jquery-validation" */'jquery-validation').then(({validate}) => {
            $.extend($.validator.messages, {
                required   : "このアイテムはrequiredです。",
                remote     : "Please fix this field.",
                email      : "有効なメールアドレスを入力してください。",
                url        : "Please enter a valid URL.",
                date       : "Please enter a valid date.",
                dateISO    : "Please enter a valid date ( ISO ).",
                number     : "Please enter a valid number.",
                digits     : "Please enter only digits.",
                creditcard : "Please enter a valid credit card number.",
                equalTo    : "Please enter the same value again.",
                maxlength  : $.validator.format("Please enter no more than {0} characters."),
                minlength  : $.validator.format("Please enter at least {0} characters."),
                rangelength: $.validator.format("Please enter a value between {0} and {1} characters long."),
                range      : $.validator.format("Please enter a value between {0} and {1}."),
                max        : $.validator.format("Please enter a value less than or equal to {0}."),
                min        : $.validator.format("Please enter a value greater than or equal to {0}.")
            });

            $(el).find('#agree-check').on('click', function () {
                const submit = $(el).find('[type="submit"]');
                if ($(this).is(':checked')) {
                    submit.removeAttr('disabled');
                } else {
                    submit.attr('disabled', 'disabled');
                }
            });

            $(el).validate({
                submitHandler: function (form) {
                    // Serialize the form data.
                    const formMessages = $(form).find('.form-message');
                    const submit       = $(form).find('[type="submit"]');
                    const resetForm    = () => {
                        form.reset();
                        if ($(form).find('#agree-check').length) {
                            submit.attr('disabled', 'disabled');
                        }
                        $(form).removeClass('loading');
                    }

                    $(form).addClass('loading');

                    // Submit the form using AJAX.
                    $.ajax({
                        url : form.action,
                        type: form.method,
                        data: $(form).serialize(),
                    }).done(function (response) {
                        // Make sure that the formMessages div has the 'success' class.
                        if (!response.success) {
                            formMessages.removeClass('success');
                            formMessages.addClass('error');
                        } else {
                            formMessages.removeClass('error');
                            formMessages.addClass('success');
                        }

                        // Set the message text.
                        formMessages.text(response.data.message);

                        // Set the message text.
                        if (response.data.redirect && response.data.redirect !== '') {
                            window.location.href = response.data.redirect;
                        }

                        // Clear the form.
                        resetForm();

                    }).fail(function (data) {
                        // Make sure that the formMessages div has the 'error' class.
                        formMessages.removeClass('success');
                        formMessages.addClass('error');

                        // Set the message text.
                        if (data.responseText !== '') {
                            formMessages.text(data.responseText);
                        } else {
                            formMessages.text('Oops! An error occurred and your message could not be sent.');
                        }
                        // Clear the form.
                        resetForm();
                    });
                }
            });
        });
    });
});