<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="p-b-10 card-body">
                <a href="<?= site_url('tambah-data-puskesmas') ?>">
                    <button class="btn btn-info"><i class="fa fa-plus-square"></i> TAMBAH PUSKESMAS</button>
                </a>
                <div>
                    <table id="table" class="table table-bordered table-striped display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama Puskesmas</th>
                                <th class="text-center">Jenis</th>
                                <th class="text-center">Kepala Puskesmas</th>
                                <th class="text-center">Nutrisionis Puskesmas</th>
                                <th class="text-center">Alamat</th>
                                <th class="text-center">Kabupaten</th>
                                <th class="text-center">Propinsi</th>
                                <th class="text-center">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        //datatables
        table = $('#table').DataTable({ 
            'searching'   : true,
            'paging'      : true,
            'lengthChange': true,
            'ordering'    : true,
            'info'        : true,
            'scrollX'     : true,
            // 'scrollCollapse': true,
            // 'fixedColumns': true,
            "scrollX": true,
            'language'    :{
                            'url'         : '<?=base_url("assets/plugins/datatables/dataTables-language-id.json")?>',
                            'sEmptyTable' : 'Tidak ada data untuk ditampilkan'
                           },
            "processing"  : true, 
            "serverSide"  : true, 
            "order"       : [], 
            
            "ajax"        : {
                             "url": "<?php echo site_url('puskesmas/list_datatables')?>",
                             "type": "POST"
                            },

            "columnDefs" : [
                                {
                                    "targets": [ 0 ], 
                                    "orderable": false, 
                                },
                            ],

        });

    });
</script>