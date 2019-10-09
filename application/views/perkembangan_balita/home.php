<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="p-b-10 card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label>Masukkan Nama Balita / Nomor RM</label>                            
                    </div>
                    <div class="col-md-5">
                        <select id="nama_balita" class="form-control">
                            <option value="0">Pilih</option>
                            <?= ((isset($data->nama))?"<option value='".$data->norm."' selected>".$data->norm." - ".$data->nama."</option>":"") ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button id="btn_tampilkan" class="btn btn-info ">
                            <div id="loading" class="spinner" style="display:none">
                                <div class="rect1"></div>
                                <div class="rect2"></div>
                                <div class="rect3"></div>
                                <div class="rect4"></div>
                                <div class="rect5"></div>
                            </div>
                            <a id="text_btn">TAMPILKAN</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="tampil_data"></div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();
    });

    $(function(){
        $('#nama_balita').select2({
            placeholder: 'Masukkan nama balita',
            ajax: {
                // type: 'POST',
                url: '<?= site_url("perkembangan_balita/getNamaBalita") ?>',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                return {
                        results: data
                    };
                },
                cache: true
            },
            minLength: 3,
        });

        $(document).on('click','#btn_tampilkan', function(){
            $('#tampil_data').load("<?php echo site_url('perkembangan_balita/getData/') ?>"+$("#nama_balita").val(),function(){
            });
        });
    });
</script>