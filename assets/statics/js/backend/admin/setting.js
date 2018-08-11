function update() {     
    var email = $('#email').val();
    empty_validate(email, 'Email');     
    var input = new FormData();    
    input.append('email', email);       
    var post_url = 'setting/update';
    ServerPost(post_url, input, true);
}

function showPassword(link) {
    $('#PasswordModal').modal({
        backdrop: false
    });
}

function ChangePass() {
    var input = new FormData();
    var old_pass = $('#old_pass').val();
    empty_validate(old_pass, 'Password lama');
    var new_pass = $('#new_pass').val();
    empty_validate(new_pass, 'Password Baru');
    var input = new FormData();
    input.append('old_pass', old_pass);
    input.append('new_pass', new_pass);
    var post_url = 'setting/update_password';
    ServerPost(post_url, input);
}

function PostConfirmation() {
    $('#PostConfirmationModal').modal({
        backdrop: false
    });
}

