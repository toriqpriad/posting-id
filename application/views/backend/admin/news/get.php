<script src="<?=BACKEND_STATIC_FILES?>assets/ckeditor/ckeditor.js"></script>
<div class='container'>
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md-8">
          <div class="form-group">
            <label>Judul</label>
            <input type="text" class="form-control"   id="title" value='<?=$record->title?>'>
            <input type="hidden"  id="title_old" value='<?=$record->title?>'>
          </div>
        </div>
        <div class="col-md-4" >
          <div class="form-group">
            <label>Kategori</label><br>                          
            <?php
            $js = 'id="category" class="form-control" style="width:100%"';
            echo form_dropdown('category', $category_news_options, $record->category_id, $js);
            ?>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>Deskripsi</label><br>
            <textarea id="desc" ><?=$record->description?></textarea>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
         <div class="form-group">           
          <label><a href='javascript:void(0)' onclick="filemanagerModalShow('image')"><i class="fa fa-plus"></i> Tambah Gambar</a></label>
          <br><br>
          
          <div class="row" id="image_contents">
            <br><br>
            <?php
            if (isset($images_news)) {
              if (!empty($images_news)) {
                foreach ($images_news as $img) {
                  if ($img['type'] == 'I') {
                    ?>
                    <div class="col-md-4 image_container">
                      <div class="panel panel-default">
                        <div class="panel-heading">
                          <div class="radio-inline">
                            <?php
                            $checked = '';
                            if ($img['thumbnail'] == 'yes') {
                              $checked = 'checked="checked"';
                            }
                            ?>
                            <input type='radio' <?=$checked?> id='set_active' name='thumbnail' onclick='setToThumbnail("<?=$img['name']?>")'>
                            Jadikan sebagai gambar depan
                          </div>
                        </div>
                        <br>
                        <div class="panel-body">

                          <img src="<?=$img['url']?>" class="old_image_data img-responsive center-block" value="<?=$img['name']?>" thumbnail='' style="height:250px; width:325px;margin-right:15px;margin-bottom:15px;">                           
                          <button class="btn btn-block btn-default" image-id='<?=$img['id']?>' onclick="deleteThisImageInEdit(this)" style="margin-bottom:10px;">Hapus</button>

                        </div>
                      </div>
                    </div>
                    <?php
                  }
                }
              }
            }
            ?>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label>Post Generator</label>
          <a href='javascript:void(0)' class="pull-right btn btn-danger btn-sm" onclick='ShowDatasetModal()' ><i class="fa fa-list"></i>&nbsp;Pilih Dataset Kota</a>
        </div>
      </div>
      <div class="col-md-12 table-responsive">
        <table  class='table'>
          <thead>
            <th>Dataset</th>
            <th>Kota</th>              
          </thead>
          <tbody id='datasetrecord'>
            <?php               
            if(isset($city_news)){
              foreach($city_news as $city)  {
                ?>
                <tr class='tr_city' data-name="<?=$city?>">            

                  <td> <small><?=$city?>.txt</small>  <br><br> <button class='text-center btn btn-danger btn-center btn-flat btn-xs' onclick='deleteCity(this,"live_delete")' data-name='<?=$city?>'><i class='fa fa-trash'></i>&nbsp;Hapus</button></td>
                  <td><div class='city_div' data-name='<?=$city?>' ><div class="city_data"></div></div></td>

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
        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick='update()'>Ya</button>
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

<div class="modal fade"  aria-labelledby="myModalLabel" id="datasetModal" role="dialog" data-backdrop='false'>
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Dataset</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>

      </div>
      <div class="modal-body">
        <p>Pilih dataset kota : </p>
        <div id="datasetDiv"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal" onclick='setSelectedCity()'>Gunakan</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
      </div>
    </div>

  </div>
</div>

<div class="modal fade"  aria-labelledby="myModalLabel" id="DeleteDatasetModal" role="dialog" data-backdrop='false'>
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Konfirmasi</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>

      </div>
      <div class="modal-body">
        <p>Apakah yakin menghapus dataset ini ? </p>
        <input type="hidden" id='pgp_name_to_delete' value="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"  id='DeleteDatasetLive' >Ya</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
      </div>
    </div>

  </div>
</div>

<script>
 function ckeditor(){
  CKEDITOR.replace( 'desc' );
}
ckeditor();
var deleted_image = [];
var thumbnail = "";
LoadCity();
var selected_city = <?=$selected_city?>;
</script>
<br>
