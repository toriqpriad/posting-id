// var site = localStorage.getItem('admin_url');
var site = $.cookie('admin_url');

function ShowLogoutModal() {
    $('#logoutModal').modal('show');
}

function goLogout() {
    var post_url = 'submit_logout';    
    $('#logoutModal').modal('hide');
    $.removeCookie('admin_url');
    ServerPost(post_url, '', true);
}