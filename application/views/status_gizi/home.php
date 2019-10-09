<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="p-b-10 card-body">
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
                                <!-- <th class="text-center">BB</th>
                                <th class="text-center">TB</th>
                                <th class="text-center">PB</th>
                                <th class="text-center">LILA</th> -->
                                <?php
                                    if($this->uri->segment(1) == 'balita-gizi-buruk'){
                                        echo '<th class="text-center" style="background-color:#ef5350; color:#FFFFFF">BB / U</th>';
                                    }else if($this->uri->segment(1) == 'balita-stunting'){
                                        echo '<th class="text-center" style="background-color:#ef5350; color:#FFFFFF">TB / U Atau PB / U</th>';
                                    }else if($this->uri->segment(1) == 'balita-bb-tb-atau-bb-pb'){
                                        echo '<th class="text-center" style="background-color:#ef5350; color:#FFFFFF">BB / TB Atau BB / PB</th>';
                                    }else if($this->uri->segment(1) == 'balita-imt-u'){
                                        echo '<th class="text-center" style="background-color:#ef5350; color:#FFFFFF">IMT / U</th>';
                                    }
                                ?>
                                <th class="text-center">Detail</th>
                                <th class="text-center">Lihat Lokasi</th>
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
                             "url": "<?php echo site_url('status_gizi/list_datatables/'.$this->uri->segment(1))?>",
                             "type": "POST"
                            },

            "columnDefs" : [
                                {
                                    "targets": [ 0 ], 
                                    "orderable": false, 
                                },
                            ],
            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    $('td:eq(3)', nRow).css({'text-align':'center'});
                    $('td:eq(5)', nRow).css({'text-align':'center'});
                    $('td:eq(6)', nRow).css({'background-color':'#ef5350','color':'#FFFFFF','text-align':'center'});

                    if ( aData[8] == "0" ){
                        $('td', nRow).css({'font-weight':'900'});
                    }
            }

        });

    });
</script>