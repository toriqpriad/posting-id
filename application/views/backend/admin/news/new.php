<script src="<?=BACKEND_STATIC_FILES?>assets/ckeditor/ckeditor.js"></script>
<div class='container'>
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md-8">
          <div class="form-group">
            <label>Judul</label>
            <input type="text" class="form-control"   id="title">
          </div>
        </div>
        <div class="col-md-4" >
            <div class="form-group">
              <label>Kategori</label><br>                          
              <?php
              $js = 'id="category" class="form-control" style="width:100%"';
              echo form_dropdown('category', $category_news_options, FALSE, $js);
              ?>
            </div>
          </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>Deskripsi</label><br>
            <textarea id="desc" ></textarea>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
         <div class="form-group">           
          <label><a href='javascript:void(0)' onclick="filemanagerModalShow('image')"><i class="fa fa-plus"></i> Tambah Gambar</a></label>
          <br><br>
          
          <div class='row'  id="image_contents">
            <br><br>

          </div>
        </div>
      </div>

    </div>
  </div>
  <div class="card-footer">
    <a href='<?=ADMIN_WEBAPP_URL?>' class='btn btn-warning'><i class='fa fa-chevron-left'></i>&nbsp; Kembali ke Dashboard</a>
    <button type="submit" class="pull-right btn btn-flat btn-success" onclick="PostConfirmation()"><i class="fa fa-save"></i>&nbsp; Simpan</button>
  </div>
</div>
</section>


<div class="modal fade"  aria-labelledby="myModalLabel" id="PostConfirmationModal" role="dialog" data-backdrop='false'>
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi</h4>
      </div>
      <div class="modal-body">
        <p>Apakah data yang dimasukkan sudah benar ? </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick='post()'>Ya</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
      </div>
    </div>

  </div>
</div>

<div class="modal fade"  aria-labelledby="myModalLabel" id="filemanagerModal" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Pilih Gambar</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" id="filemanager_url" value="<?=$filebrowser_url?>">
        <input type="hidden" id="active_action" value="">
        <iframe src="" style="width:100%;height:100%" frameborder="0" id="filemanager_frame"></iframe>
      </div>
    </div>

  </div>
</div>

<script>
 function ckeditor(){
  CKEDITOR.replace( 'desc' );
}
ckeditor();
</script>
<br>
