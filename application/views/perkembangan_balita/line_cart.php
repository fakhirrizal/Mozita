<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="p-b-10 card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4"><label>Nomor RM</label></div>
                            <div class="col-md-8">: <?= $balita->norm ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><label>Nama Balita</label></div>
                            <div class="col-md-8">: <?= $balita->nama ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><label>Tanggal Lahir</label></div>
                            <div class="col-md-8">: <?= $balita->tgllahir ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><label>Jenis kelamin</label></div>
                            <div class="col-md-8">: <?= $balita->jenkel ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><label>Nama Orang Tua</label></div>
                            <div class="col-md-8">: <?= $balita->nmortu ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><label>NIK Orang Tua</label></div>
                            <div class="col-md-8">: <?= $balita->nikortu ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><label>Keluarga Miskin</label></div>
                            <div class="col-md-8">: <?= $balita->gakin ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><label>Memiliki KMS</label></div>
                            <div class="col-md-8">: <?= $balita->kms ?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <img src="<?= $balita->fotobayi ?>" width="200" height="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex flex-wrap">
                            <div>
                                <h4 class="card-title">Perkembangan Balita</h4>
                            </div>
                            <div class="ml-auto">
                                <ul class="list-inline">
                                    <li><h6 class="text-muted text-success"><i class="fa fa-circle font-10 m-r-10 "></i>BB</h6> </li>
                                    <li><h6 class="text-muted text-info"><i class="fa fa-circle font-10 m-r-10"></i>TB</h6> </li>
                                    <li><h6 class="text-muted text-warning"><i class="fa fa-circle font-10 m-r-10"></i>PB</h6> </li>
                                    <li><h6 class="text-muted text-primary"><i class="fa fa-circle font-10 m-r-10"></i>LILA</h6> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div id="earning" style="height: 355px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        "use strict";
        // ============================================================== 
        // Sales overview
        // ============================================================== 
        Morris.Area({
            element: 'earning',
            data: <?= $data_grafik ?>,
            parseTime:false,
            xkey: 'period',
            ykeys: ['BB', 'TB', 'PB','LILA'],
            labels: ['BB', 'TB', 'PB','LILA'],
            pointSize: 3,
            fillOpacity: 0,
            pointStrokeColors: ['#1976d2', '#26c6da', '#ffb22b', '#99abb4'],
            behaveLikeLine: true,
            gridLineColor: '#e0e0e0',
            lineWidth: 3,
            hideHover: 'auto',
            lineColors: ['#1976d2', '#26c6da', '#ffb22b', '#99abb4'],
            resize: true

        });

    });
</script>