
<!-- Content Header (Page header) -->
<section class="content">

    <div class="panel panel-default">        
        <div class="panel-body">
            <a href="<?=$new_link?>" class="btn btn-primary btn-flat btn-fill  pull-left"><i class="fa fa-plus"></i>&nbsp; Tambah </a>
            <table class="table table-bordered table-striped table-hover dataTable table1" style="font-size: 13px;">
                <thead>
                  <tr>
                    <th  width='10'>No</th>
                    <th>Judul</th>                                                                              
                    <th>Deskripsi</th>
                    <th>Update Terakhir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </tbody>
    </table>

</div>
</div>
</section>
<!-- /.content -->
<!-- /.content-wrapper -->
</div>

<div class="modal fade"  aria-labelledby="myModalLabel" id="DeleteConfirmationModal" role="dialog"  >
    <div class="modal-dialog modal-xs">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Konfirmasi</h4>
        </div>
        <div class="modal-body">
            <p>Menghapus data ini berarti menonaktifkan beberapa data terkait. Yakin menghapus ?</p>
            <input type="hidden" id="del_id" value="">        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal" id='yes'>Ya</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
        </div>
    </div>

</div>
</div>

<script>
    table_render();
   
</script>