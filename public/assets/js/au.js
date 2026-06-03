$(document).ready(function () {
    $('#login-form').on('submit', function (e) {
        e.preventDefault();

        let form = $(this);
        let btn = $('#btn-login');
        let errorContainer = $('#error-container');

        btn.prop('disabled', true).text('Loading...');
        errorContainer.empty();

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    btn.prop('disabled', false).text('Login');
                    window.location.replace(response.redirect_url);
                }
            },
            error: function (xhr) {
                btn.prop('disabled', false).text('Login');

                let errorMsg = '';

                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    if (errors.username && errors.password) {
                        errorMsg = 'Tolong isi semua bidang!';
                    } else {
                        let firstErrorKey = Object.keys(errors)[0];
                        errorMsg = errors[firstErrorKey][0];
                    }
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                } else {
                    errorMsg = 'Terjadi kesalahan pada server.';
                }

                errorContainer.html(`
                        <div class="alert alert-danger" role="alert">
                            <span class="font-medium text-white">${errorMsg}</span>
                        </div>
                    `);
            }
        });
    });
});