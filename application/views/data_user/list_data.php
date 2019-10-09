
<table id="table" class="table display table-bordered table-striped" style="width:100%">
    <thead>
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Foto</th>
            <th class="text-center">Nama Lengkap</th>
            <th class="text-center">NIP</th>
            <th class="text-center">Nomor Seluler</th>
            <th class="text-center">Email</th>
            <th class="text-center">Level</th>
            <th class="text-center">Aktif</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        
    </tbody>
</table>

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
            'language'    :{
                            'url'         : '<?=base_url("assets/plugins/datatables/dataTables-language-id.json")?>',
                            'sEmptyTable' : 'Tidak ada data untuk ditampilkan'
                           },
            "processing"  : true, 
            "serverSide"  : true, 
            "order"       : [], 
            
            "ajax"        : {
                             "url": "<?php echo site_url('data_user/list_datatables')?>",
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
