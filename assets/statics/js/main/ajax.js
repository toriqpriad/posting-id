  function ServerPost(next_url,input,reload_action) {

    create_toastr("info","Memproses");     
    if(input === undefined || input === ""){
      var input = new FormData();
    }
    csrfCookie(input);

    $.ajax({
      url: site + next_url,
      method: 'POST',
      data: input,
      dataType: 'json',
      contentType: 'application/json',
      cache: false,
      contentType: false,
      processData: false,
      success: function (response) {

        toastr.remove()
        
        if (response.response == 'OK') {          
          create_toastr("success",response.message);
        } else {
         create_toastr("error",response.message);
         $.each(response.error, function(index, item) {
          create_toastr("error",item);
        })
       }
       if(reload_action){
        setTimeout(function ()
        {
          window.location.href = response.data.link;
        }, 1000);
      } else {
        $("#success_param").val('yes');
      }

    }
  });

  }

  function create_toastr(color,msg){
    toastr.options = {   
     "positionClass": "toast-bottom-right",
     "preventDuplicates": true,   
   }
   toastr[color](msg);
 }


 function csrfCookie(input){  
  var csrf_token = $.cookie("csrf_cookie_pid");  
  input.append('csrf_pid',csrf_token);
}
