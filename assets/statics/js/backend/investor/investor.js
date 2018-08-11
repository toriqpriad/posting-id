var site = localStorage.getItem('investor_url');

function ShowLogoutModal() {
  $('#logoutModal').modal('show');
}

function goLogout() {
  var post_url = 'submit_logout';
  localStorage.removeItem('investor_url');  
  $('#logoutModal').modal('hide');    
  ServerPost(post_url,'',true);

}

