<script src="<?= BACKEND_STATIC_FILES ?>bower_components/bootstrap/js/bootstrap-notify.js"></script>
<script src="<?= BACKEND_STATIC_FILES ?>bower_components/jquery-md5/jquerymd5.js"></script>


<div class="main-container">
  <div class="container">
    <br><br><br><br>
    <div class="row">

      <div class="col-md-4 col-md-offset-4">      
        <div class="panel panel-default">

          <div class="panel-body">
            <div class="form-group">
              <label for="form-field-22">
                Username
              </label>
              <input type='text' id='username' class='form-control'>
            </div>
            <div class="form-group">
              <label for="form-field-22">
                Password
              </label>
              <input type='password' id='password' class='form-control'>
            </div>
            <div>
             <input type='hidden' id='url' value='<?=$url?>'>
             <button type='submit' class='btn btn-success btn-flat pull-right' onclick='login()'>Masuk </button>
             
           </div>
         </div>
       </div>
     </div>
   </div>
 </div>

</div>