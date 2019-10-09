<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="p-b-10 card-body">
                <a href="<?= site_url('tambah-data-balita') ?>">
                    <button class="btn btn-info"><i class="fa fa-plus-square"></i> TAMBAH BALITA</button>
                </a>
                <div>
                    <table id="table" class="table table-bordered table-striped display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Foto</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Tanggal Lahir</th>
                                <th class="text-center">Jenis Kelamin</th>
                                <th class="text-center">Nama Orang Tua</th>
                                <th class="text-center">NIK Orang Tua</th>
                                <th class="text-center">Keluarga Miskin</th>
                                <th class="text-center">Posyandu</th>
                                <th class="text-center">Desa</th>
                                <th class="text-center">Kematan</th>
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
            'scrollCollapse': true,
            // 'fixedColumns': true,
            'fixedColumns' : {
                         'rightColumns': 1
                                },
            'language'    :{
                            'url'         : '<?=base_url("assets/plugins/datatables/dataTables-language-id.json")?>',
                            'sEmptyTable' : 'Tidak ada data untuk ditampilkan'
                           },
            "processing"  : true, 
            "serverSide"  : true, 
            "order"       : [], 
            
            "ajax"        : {
                             "url": "<?php echo site_url('balita/list_datatables')?>",
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