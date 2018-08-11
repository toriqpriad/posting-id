function ServerPost(next_url, input, reload_action) {
    create_toastr("info", "Memproses");
    var csrf_token = $.cookie("csrf_cookie_grosirparfum");
    input.append('csrf_grosirparfum', csrf_token);
    $.ajax({
        url: next_url,
        method: 'POST',
        data: input,
        dataType: 'json',
        contentType: 'application/json',
        cache: false,
        contentType: false,
        processData: false,
        success: function(response) {
            toastr.clear();
            if (response.response == 'OK') {
                create_toastr("success", response.message);
                if (response.data.role == 'A') {
                    localStorage.setItem('admin_url', response.data.backend_url);
                } else if (response.data.role == 'U') {
                    localStorage.setItem('user_url', response.data.backend_url);
                } else if (response.data.role == 'I') {
                    localStorage.setItem('investor_url', response.data.backend_url);
                }
                if (reload_action) {
                    setTimeout(function() {
                        window.location.href = response.data.backend_url;
                    }, 1000);
                }
            } else {
                create_toastr("error", response.message);
                $.each(response.error, function(index, item) {
                    create_toastr("error", item);
                })
            }
        }
    });
}

function login() {
    $("#login").submit(function(event) {        
        var error = false;        
        var email = $("#email").val();
        if (email == '') {
            create_toastr('error', 'Email tidak boleh kosong')
            error = true;
        };
        var password = $("#password").val();
        if (password == '') {
            create_toastr('error', 'Password tidak boleh kosong')
            error = true;
        };
        if (error == true) {
            event.preventDefault();
        }
    });
}

function register() {
    $("#register").submit(function(event) {
        var name = $("#name").val();
        var error = false;
        if (name == '') {
            create_toastr('error', 'Nama tidak boleh kosong')
            error = true;
        };
        var email = $("#email").val();
        if (email == '') {
            create_toastr('error', 'Email tidak boleh kosong')
            error = true;
        };
        var password = $("#password").val();
        if (password == '') {
            create_toastr('error', 'Password tidak boleh kosong')
            error = true;
        };
        if (error == true) {
            event.preventDefault();
        }
    });
}

function create_toastr(color, msg) {
    toastr.options = {
        "positionClass": "toast-bottom-right",
        "preventDuplicates": true,
    }
    toastr[color](msg);
}

function set_csrf() {
    var csrf_token = $.cookie("csrf_cookie_pid");
    $("#token").attr('name', 'csrf_pid');
    $("#token").val(csrf_token);
}