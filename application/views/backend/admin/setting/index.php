
<div class='container'>
  <div class="card">
    <div class="card-body">      
      <div class="col-md-12">
        <div class="form-group">
          <label class='pull-left'>Email Login</label>                            
          <input type="text" class="form-control border-input" id="email" value="<?=$email?>">
        </div>

      </div>

      <div class="col-md-12">
        <div class="form-group">
          <a href="javascript:void(0)" class="pull-right" onclick='showPassword()'>Ganti Password ?</a>
        </div>

      </div>

    </div>

  </div>
  <div class="card-footer">
    <a href='<?=ADMIN_WEBAPP_URL?>' class='btn btn-warning'><i class='fa fa-chevron-left'></i>&nbsp; Kembali ke Dashboard</a>
    <button type="submit" class="pull-right btn btn-flat btn-success" onclick="PostConfirmation()"><i class="fa fa-save"></i>&nbsp; Simpan</button>
  </div>

</div>
</div>
<div class="modal fade"  aria-labelledby="myModalLabel" id="PostConfirmationModal" role="dialog" data-backdrop='false'>
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Konfirmasi</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body">
        <p>Apakah data yang dimasukkan sudah benar ? </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick='update()'>Ya</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
      </div>
    </div>

  </div>
</div>

<div class="modal fade"  aria-labelledby="myModalLabel" id="PasswordModal" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Ganti Password</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Masukkan Password Lama</label>
              <input type="password" class="form-control border-input" id="old_pass">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Masukkan Password Baru</label>
              <input type="password" class="form-control border-input" id="new_pass" >
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="ChangePass()">Ya</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
        </div>
      </div>

    </div>
  </div>
</div>

