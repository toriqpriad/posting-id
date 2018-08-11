
  <section class="content">
    <div class="panel panel-default">                  
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label>Nama</label>
              <input type="text" class="form-control" placeholder="..." id="name" value='<?=$record->name?>'>
              <input type="hidden"  value='<?=$record->id?>'>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label>Tipe</label>
              <select id='type' class='form-control' onchange='setType(this)' value=''>
                <?php 
                $txt = ["label" => "Input Text", "value" => "TXT"];
                $rdb = ["label" => "Radio Button", "value" => "RDB"];
                $cbx = ["label" => "Checkbox", "value" => "CBX"];
                $txa = ["label" => "Textarea", "value" => "TXA"];
                $arr = array($txt,$rdb,$cbx,$txa);
                foreach($arr as $ar){
                  $selected = "";
                  if($record->type == $ar['value']){
                    $selected = "selected";
                  } 
                  echo "<option value='".$ar['value']."' ".$selected.">".$ar['label']."</option>";
                } 
                ?>                
              </select>              
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label>Satuan</label>
              <input type="text" class="form-control" placeholder="..." id="count_as" value='<?=$record->count_as?>'>              
            </div>
          </div>
        </div>

        <?php 
        if(empty($record->options)){
          $none = 'none';                
        } else {
          $none = '';
        }
        ?>

        <div class="row"  id="type_value" style='display: <?=$none?>'>
          <div class="col-md-12">
            <div class="form-group">
              <label>Pilihan</label>              
              <span onclick="addOptions()" class="btn label label-primary pull-right" id='add_value_btn' style='display: <?=$none?>;'>
                <i class="fa fa-plus"></i>&nbsp; Tambah
              </span>
            </div>

            <div class="row">
              <?php 
              if(!empty($record->options)){                
                foreach($record->options as $opt){
                  ?>
                  <div class="col-md-6" style="margin-bottom:4px;"> 
                    <div class="input-group ">
                      <input type="text" class="form-control input-sm option" placeholder="" value="<?=$opt->label?>" data-id="<?=$opt->id?>">
                      <span class="input-group-btn">
                        <button class="btn btn-danger btn-md" type="button" style="padding:7px;" onclick="delThisOptionsOnEdit(this,'<?=$opt->id?>')"><i class="fa fa-close"></i></button>
                      </span>
                    </div>
                  </div>
                  <?php
                }
              }
              ?>
            </div>

          </div>
        </div>
      </div>  
      <div class="box-footer">
        <a href="<?=$active_url.$record->category_property_id?>" class="btn btn-flat btn-warning pull-left"><i class="fa fa-arrow-left"></i>
        &nbsp; Kembali</a>
        <button type="submit"  class="pull-right btn btn-flat btn-success" onclick="UpdateAttributeConfirmation()"><i class="fa fa-save"></i>
        &nbsp; Simpan</button>        
        <button class="btn btn-danger btn-flat pull-right" onclick="DeleteConfirmation()" style='margin-right:2px;'><i class="fa fa-trash"></i>&nbsp; Hapus</button>
      </div>
    </div>
  </section>
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
        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick='updateAttribute()'>Ya</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade"  aria-labelledby="myModalLabel" id="DeleteConfirmationModal" role="dialog" data-backdrop='false'>
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi</h4>
      </div>
      <div class="modal-body">
        <p>Apakah yakin menghapus data ini ? </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick='deleteAttribute()'>Ya</button>
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
  var options_to_delete = [];
</script>