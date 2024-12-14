$(document).ready(function() {
    $('#login-form').on('submit', function(event) {
        event.preventDefault();
        login();
    });

    $('#togglePassword').on('click', function() {
        const passwordField = $('#password');
        const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
        passwordField.attr('type', type);
        $(this).toggleClass('fa-eye fa-eye-slash');
    });
});

function login() {
    const email = $("#email").val();
    const password = $("#password").val();

    $.ajax({
        type: "POST",
        url: 'Services/User/LoginService.php',
        data: { email, password },
        success: function(response) {
            const data = JSON.parse(response);
            if (data.status === "success") {
                window.location.href = "homepage.php";
            } else {
                showAlert('danger', data.message);
            }
        },
        error: function() {
            showAlert('danger', 'An error occurred while processing your request.');
        }
    });
}

function showAlert(type, message) {
    const alertContainer = $('#alert-container');
    alertContainer.html(`<div class="alert alert-${type}">${message}</div>`);
}