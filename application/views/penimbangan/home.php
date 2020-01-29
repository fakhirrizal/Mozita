<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="p-b-10 card-body">
                <a href="<?= site_url('tambah-penimbangan') ?>">
                    <button class="btn btn-info"><i class="fa fa-plus-square"></i> TAMBAH PENIMBANGAN</button>
                </a>
                <div>
                    <table id="table" class="table table-bordered table-striped display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Norm</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Tanggal Penimbangan</th>
                                <th class="text-center">Posyandu</th>
                                <th class="text-center">Umur Bayi (Bulan)</th>
                                <th class="text-center">BB</th>
                                <th class="text-center">TB</th>
                                <th class="text-center">PB</th>
                                <th class="text-center">LILA</th>
                                <th class="text-center">BB/ U</th>
                                <th class="text-center">TB/ U Atau PB/ U</th>
                                <th class="text-center">BB/ TB Atau BB/ PB</th>
                                <th class="text-center">IMT/ U</th>
                                <th class="text-center">LILA/ U</th>
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
                             "url": "<?php echo site_url('penimbangan/list_datatables')?>",
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