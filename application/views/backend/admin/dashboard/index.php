
<div class="container">
  <div class="row">
    <div class="col-md-3">

     <div class="row">
       <div class="col-md-12">
         <div class="list-group">
          <a href="javascript:void(0)" class="list-group-item list-group-item-action active" onclick='NewCategoryModal()'>
            <i class="fa fa-plus"></i> Buat Kategori 
          </a>
          <div id="category_list_div">

          </div>

        </div>
      </div>
    </div>
  </div>
  <div class="col-md-9">    
    <div class="row">      
     <div class="col-md-12">
      <div class="card"  >
        <div class="card-body">
          <h5 class="card-title">Buat Berita</h5>
          <p class="card-text">Klik di sini untuk menambah berita. <a href="<?=ADMIN_WEBAPP_URL?>news/add" class="pull-right btn btn-primary" style='margin-top:-10px;'><i class="fa fa-pencil-square-o"></i>&nbsp; Buat Berita</a> </p>  
          <p><input type="text" class='form-control' placeholder="Pencarian" onchange='searchNews()' id='keyword'></p>      
        </div>
      </div>
      <br>
    </div>
  </div>

  <div class="row" id="news_div">

     

  </div>

</div>
</div>

<br>
<input type="hidden"  id="success_param" value=''>

<div class="modal fade" id="NewCategoryShowModal"   data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Buat Kategori</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="exampleInputEmail1">Nama</label>
          <input type="text" class="form-control" id="category_name"  placeholder="Nama Kategori">              
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick='post()' data-dismiss="modal">Simpan</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="EditCategoryShowModal"   data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Kategori</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="exampleInputEmail1">Nama</label>
          <input type="text" class="form-control" id="category_edit_name" value=''  placeholder="Nama Kategori">              
          <input type="hidden"  id="category_edit_id" value=''>              
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick='update()' data-dismiss="modal">Simpan</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="DelCategoryShowModal"   data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     <div class="modal-header">
      <h5 class="modal-title">Konfirmasi</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <div class="form-group">
        Menghapus kategori ini berarti juga menghapus <b>berita</b> dengan kategori ini. Yakin hapus ?
        <input type="hidden"  id="category_del_id" value=''>              
      </div>

    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" onclick='del()' data-dismiss="modal">Hapus</button>
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="DelNewsModal"   data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     <div class="modal-header">
      <h5 class="modal-title">Konfirmasi</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <div class="form-group">
        Yakin hapus ?
        <input type="hidden"  id="news_del_id" value=''>              
      </div>

    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" onclick='delNewsNow()' data-dismiss="modal">Hapus</button>
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
    </div>
  </div>
</div>
</div>

<script>
  category_list_refresh();
  news_refresh();
</script>