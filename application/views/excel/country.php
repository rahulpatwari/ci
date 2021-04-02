<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- bread crumb -->
    <section class="content-header">
        <h1>Data import/export<small>Country</small></h1>
        
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Country data import/export</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="col-sm-12" style="margin: 10px 0 20px 0px;">
                        <div class="col-sm-11">
                            <?= form_open_multipart('importCountryXls') ?>
                                <div class="file file_div btn btn-success">
                                    Import country
                                    <input type="file" name="result_file" class="input_type_file" required />
                                </div>
                                <a href="<?= base_url('exportTemplateForCountry/1') ?>" class="btn btn-info">Export Existing Data</a>
                                <a href="<?= base_url('exportTemplateForCountry/0') ?>" class="btn btn-warning">Export Empty Template</a>
                            <?= form_close() ?>
                        </div>
                    </div>

                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Country ID</th>
                                    <th>Country</th>
                                    <th>Current status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($country) 
                                {
                                    $count = 1;
                                    foreach ($country['result'] as $value)
                                    {
                                        $cnt_id = $value['country_id'];
                                        $status = $value['status'];
                                        if ($status)
                                        {
                                            $status = "<span class='label label-success'>Active</span>";
                                            $new_status = 0;
                                        }
                                        else
                                        {
                                            $status = "<span class='label label-warning'>Not active</span>";
                                            $new_status = 1;
                                        }

                                        echo "<tr>
                                                <td>".$count++."</td>
                                                <td>".$cnt_id."</td>
                                                <td>".$value['name']."</td>
                                                <td>".$status."</td>
                                            </tr>";
                                    }
                                }
                                else
                                    echo "<tr><td colspan='5' align='center'>No Record found.</td></tr>";
                                ?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- ./wrapper -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<style type="text/css">
.file_div {
    position: relative;
    overflow: hidden;
}
.input_type_file {
    position: absolute;
    font-size: 50px;
    opacity: 0;
    right: 0;
    top: 0;
}
</style>

<script type="text/javascript">
$(document).ready(function(){
    $('input[type=file]').change(function() { 
        // select the form and submit
        $('form').submit(); 
    });
});
</script>