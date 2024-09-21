/******************************************
 * My Login
 *
 * Bootstrap 4 Login Page
 *
 * @author          Muhamad Nauval Azhar
 * @uri 			https://nauval.in
 * @copyright       Copyright (c) 2018 Muhamad Nauval Azhar
 * @license         My Login is licensed under the MIT license.
 * @github          https://github.com/nauvalazhar/my-login
 * @version         1.2.0
 *
 * Help me to keep this project alive
 * https://www.buymeacoffee.com/mhdnauvalazhar
 *
 ******************************************/

'use strict';

$(function() {


    $("input[type='password'][data-eye]").each(function(i) {
        var $this = $(this),
            id = 'eye-password-' + i,
            el = $('#' + id);

        $this.wrap($("<div/>", {
            style: 'position:relative',
            id: id
        }));

        $this.css({
            paddingRight: 60
        });
        $this.after($("<div/>", {
            html: '<i class="fa-solid fa-eye"></i>',
            class: 'btn btn-primary btn-sm',
            id: 'passeye-toggle-'+i,
        }).css({
            position: 'absolute',
            right: 10,
            top: ($this.outerHeight() / 2) - 12,
            padding: '2px 7px',
            fontSize: 12,
            cursor: 'pointer',
        }));

        $this.after($("<input/>", {
            type: 'hidden',
            id: 'passeye-' + i
        }));

        var invalid_feedback = $this.parent().parent().find('.invalid-feedback');

        if(invalid_feedback.length) {
            $this.after(invalid_feedback.clone());
        }

        $this.on("keyup paste", function() {
            $("#passeye-"+i).val($(this).val());
        });
        $("#passeye-toggle-" + i).on("click", function () {
            if ($this.attr('type') === 'text') {
                $this.attr('type', 'password');

                // Change the icon to fa-eye when hiding the password
                $(this).html('<i class="fa-solid fa-eye"></i>');
            } else {
                $this.attr('type', 'text');

                // Change the icon to fa-eye-slash when showing the password
                $(this).html('<i class="fa-solid fa-eye-slash"></i>');
            }
        });


    });

    $(".my-login-validation").submit(function() {
        var form = $(this);
        if (form[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.addClass('was-validated');
    });
});
