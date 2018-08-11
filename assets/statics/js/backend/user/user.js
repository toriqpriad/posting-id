var site = localStorage.getItem('user_url');

function ShowLogoutModal() {
  $('#logoutModal').modal('show');
}

function goLogout() {
  var post_url = 'submit_logout';
  localStorage.removeItem('user_url');  
  $('#logoutModal').modal('hide');    
  ServerPost(post_url,'',true);

}

