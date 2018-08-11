
<section class="content">
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control" placeholder="..." id="name" value='<?=$record->name?>'>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>Deskripsi</label><br>
            <textarea id="desc" class='form-control' ><?=$record->description?></textarea>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <label for="">Spesifikasi utama : </label>              
          <a style="margin-bottom: 10px;" href="<?=$active_url.'attribute/new'?>" class="btn btn-xs btn-primary pull-right btn-flat"><i class="fa fa-plus"></i>&nbsp; Tambah</a>
          <!-- <button style="margin-bottom: 10px;" class="btn btn-xs btn-primary pull-right btn-flat" ><i class="fa fa-plus"></i>&nbsp; Tambah</button> -->
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
            <tbody id='attribute_table'>
              <?php 
              if($record->attributes != ""){

                foreach($record->attributes as $each)
                {
                  ?>
                  <tr>
                   <td id='each_old_name'><?=$each->name?></td>
                   <td id='each_old_type'>
                    <?php 
                    if($each->type == "TXT"){ echo 'Input Text'; } else 
                    if($each->type == "TXA"){ echo 'Textarea'; } else 
                    if($each->type == "RDB"){ echo 'Radiobutton'; } else 
                    if($each->type == "CBX"){ echo 'Checkbox'; }
                    ?>

                  </td>
                  <td id='each_old_options'>
                    <?php 
                    if(!empty($each->options)){
                      foreach($each->options as $opt){
                        echo $opt->label.'<br>';
                      }  
                    } else {
                      echo '<strong>-</strong>';
                    }
                    ?>                        
                  </td>

                  <td id='each_old_count_as'><?=$each->count_as?></td>
                  <td>                        
                    <a href="<?=$active_url.'attribute/'.$each->id?>" class="btn btn-sm btn-warning btn-flat" title='Edit'><i class="fa fa-pencil"></i></a>
                    <button class='btn btn-sm btn-danger btn-flat' onclick='DeleteAttributeModal(this,"<?=$each->id?>")' title='Hapus' >
                      <i class='fa fa-close'></i></button>
                    </td>
                  </tr>
                  <?php
                }

              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <label for="">Sub kategori dari kategori ini : </label>
          <a style="margin-bottom: 10px;" href="<?=ADMIN_WEBAPP_URL.'subcategory/new'?>" class="btn btn-xs btn-primary pull-right btn-flat"><i class="fa fa-plus"></i>&nbsp; Tambah</a>
          <table class='table table-bordered table-stripped' style="font-size: 13px;">
            <thead>
              <tr>
                <th>Nama</th>
                <th>Deskripsi</th>                
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              if(!empty($sub_category_property)){
                foreach($sub_category_property as $sub){
                  ?>
                  <tr>
                    <td><?=$sub->name?></td>
                    <td><?=$sub->description?></td>
                    <td>                        
                      <a href="<?=ADMIN_WEBAPP_URL.'subcategory/'.$sub->id?>" class="btn btn-sm btn-warning btn-flat" title='Edit'><i class="fa fa-pencil"></i></a>
                      <button class='btn btn-sm btn-danger btn-flat' onclick="DeleteSubCategoryModal(this,'<?=$sub->id?>')" title='Hapus' >
                        <i class='fa fa-close'></i></button>
                      </td>
                    </tr>
                    <?php
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="pull-right btn btn-flat btn-success" onclick="UpdateConfirmation()"><i class="fa fa-save"></i>&nbsp; Simpan</button>
      </div>
    </div>    
  </section>
</div>

<!-- MODAL -->



<div class="modal fade"  aria-labelledby="myModalLabel" id="DeleteConfirmationModal" role="dialog" data-backdrop='false'>
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi</h4>
      </div>
      <div class="modal-body">
        <p>Menghapus data attribut ini berarti menghapus data lain yang terkait. Yakin ? </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" id='yesDelete' data-dismiss='modal'>Ya</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade"  aria-labelledby="myModalLabel" id="DeleteSubCategoryConfirmationModal" role="dialog" data-backdrop='false'>
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi</h4>
      </div>
      <div class="modal-body">
        <p>Menghapus data ini berarti menghapus data lain yang terkait. Yakin ? </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" id='yesDeleteSubCategory' data-dismiss='modal'>Ya</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade"  aria-labelledby="myModalLabel" id="UpdateConfirmationModal" role="dialog" data-backdrop='false'>
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
        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick='update()'>Ya</button>
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


  var old_attribute_data = <?=$record->attributes_json?>;
  var attribute_selected_backup = '';
  var attribute_selected = '';
  var options_to_delete = '';
</script>