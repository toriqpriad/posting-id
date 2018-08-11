
<section class="content">
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="row">        
        <div class="col-md-12">
          <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control" placeholder="..." id="name">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>Deskripsi</label><br>
            <textarea id="desc" class='form-control' ></textarea>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <label for="">Atribut yang tersedia : </label>
          <button style="margin-bottom: 10px;" class="btn btn-xs btn-primary pull-right btn-flat" onclick="NewAttribute()"><i class="fa fa-plus"></i>&nbsp; Tambah</button>
          <table class='table table-bordered table-stripped' style="font-size: 13px;">
            <thead>
              <tr>
                <th>Label</th>
                <th>Tipe</th>
                <th>Pilihan</th>
                <th>Satuan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody id='attribute_table'></tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <button type="submit" class="pull-right btn btn-flat btn-success" onclick="PostConfirmation()"><i class="fa fa-save"></i>&nbsp; Simpan</button>
    </div>
  </div>  
</section>
</div>

<div class="modal fade"  aria-labelledby="myModalLabel" id="NewAttributeModal" role="dialog" data-backdrop='false'>
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tambah Atribut Baru</h4>
      </div>
      <div class="modal-body">

        <div class="form-group">
          <label>Label</label>
          <input type="text" class="form-control" placeholder="..." id="new_label" value=''>
        </div>

        <div class="form-group">
          <label>Tipe</label>
          <select id='new_type' class='form-control' onchange='setType(this)' value=''>
            <option value="TXT">Input Text</option>
            <option value="RDB">Radio Button</option>
            <option value="CBX">Checkbox</option>
            <option value="TXA">Textarea</option>
          </select>
        </div>

        <div class="form-group">
          <label>Satuan</label>
          <input type="text" class="form-control"  id="new_count_as" value=''>
        </div>  

        <div class="form-group">
          <label>Pilihan</label>      
          <span 
          onclick="addOptions()" 
          class="btn label label-primary pull-right" 
          id='add_value_btn' style='display: none;'>
          <i class="fa fa-plus"></i>&nbsp; Tambah
        </span>
        <div class='row' id="type_value"></div>
      </div>      

    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger"  onclick="pushToTable()">Ya</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
    </div>
  </div>

</div>
</div>


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

<style>
.attribute_option_fix{
  margin:10px;
}
</style>

<script>
  table_render();
  
</script>
