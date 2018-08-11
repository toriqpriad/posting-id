<script src="<?=BACKEND_STATIC_FILES?>assets/jquery.cookie.js" type="text/javascript"></script>
<script src="<?=BACKEND_STATIC_FILES?>assets/auth.js" type="text/javascript"></script>

<div class="page" style='margin-top:100px;'>
  <div class="page-single">
    <div class="container">      
      <div class="row">
        <div class="col-md-4 col-md-offset-4 col-login mx-auto">
          <div class="text-center mb-6">
            <img src="<?= FRONTEND3_STATIC_FILES ?>images/logo-2.png" class="img img-responsive" alt="" style='width:300px;margin-bottom: 30px;'>
          </div>
          <?php
           if ($this->session->flashdata('confirmed')) {
            $confirmed = $this->session->flashdata('confirmed');
            if ($confirmed->status == OK_STATUS) {
              ?>
              <div class="alert alert-success alert-dismissible">              
                <h4><i class="icon fa fa-check"></i> Sukses!</h4>
                <?php 
                if(isset($confirmed->message)){
                  echo $confirmed->message;
                }
                ?>
              </div>
              <?php
            } else {
              ?>
              <div class="alert alert-danger alert-dismissible">              
                <h4><i class="icon fa fa-warning"></i> Mohon maaf !</h4>
                <?php 
                if(isset($confirmed->message)){
                  echo $confirmed->message;
                }
                ?>
              </div>
              <?php
            }
          }
          ?>
          <form class="card" method='POST' action='<?=$url?>' id='login' >

          <div class="card-body p-6">              
            <div class="form-group">
              <label class="form-label">Masukkan Email Login</label>
              <input type="email" id='email' name='email' class="form-control"  placeholder= "">
              <input type='hidden' id='token' class='form-control' name='' val=''>
            </div>
                       
            <div class="form-footer">
              <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </div>
          </div>
        </form>        
      </div>
    </div>
  </div>
</div>
</div>
<script>
  set_csrf();
  login();
</script>