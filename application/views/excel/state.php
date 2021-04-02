<?php 
if (isset($_GET['getStateList']))
    $query_string_cnt_id = $_GET['getStateList'];
else
    $query_string_cnt_id = 'ALL';

$cnt_id = isset($state['country_id']) ? $state['country_id'] : '';
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- bread crumb -->
    <section class="content-header">
        <h1>
            State
            <small>Management</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">State data import/export</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-md-5 col-md-offset-3">
                        <div class="box box-primary">
                            <div class="box-body">
                                <!-- select category -->
                                <div class="row form-group">
                                    <div class="col-sm-3">
                                        <label>Select country*:</label>    
                                    </div>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="cnt_id">
                                            <option value="">Select country</option>
                                            <?php
                                            foreach ($countries as $cnt_value) 
                                            {
                                                $cnt_id = $cnt_value['country_id'];

                                                $selected = '';
                                                if ($query_string_cnt_id == $cnt_id) 
                                                    $selected = "selected='selected'";

                                                echo "<option value='".$cnt_id."' ".$selected.">".$cnt_value['name']."</option>";
                                            }
                                            ?>          
                                        </select>

                                        <button class="btn btn-primary" onclick="stateManagement('getStateList');">Get state list</button>

                                        <?= form_open_multipart('importCountryXls') ?>
                                            <div class="file file_div btn btn-success">
                                                Import state
                                                <input type="file" name="result_file" class="input_type_file" required />
                                            </div>
                                            <a href="<?= base_url('exportTemplateForState/').$query_string_cnt_id ?>" class="btn btn-info">Export Existing Data</a>
                                            <a href="<?= base_url('exportTemplateForState/0') ?>" class="btn btn-warning">Export Empty Template</a>
                                        <?= form_close() ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header">
                        <h3>States <small>List</small></h3>
                    </div>

                    <div class="box-body table-responsive" style="margin-top: 20px;">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>State ID</th>
                                    <th>State</th>
                                    <th>Status</th>
                                    <th>Country ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($states) 
                                {
                                    $count = 1;
                                    foreach ($states as $state_value)
                                    {
                                        $state_id = $state_value['state_id'];
                                        $state_status = $state_value['status'];

                                        if ($state_status)
                                        {
                                            $status = "<span class='label label-success'>Active</span>";
                                            $newStatus = 0;
                                        }
                                        else
                                        {
                                            $status = "<span class='label label-warning'>Not active</span>";
                                            $newStatus = 1;
                                        }

                                        echo "<tr>
                                                <td>".$count++."</td>
                                                <td>".$state_id."</td>
                                                <td>".$state_value['name']."</td>
                                                <td>".$status."</td>
                                                <td>".$state_value['country_id']."</td>
                                            </tr>";
                                    }
                                }
                                else
                                    echo "<tr><td colspan='4' align='center'>No Record found.</td></tr>";
                                ?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- ./wrapper -->

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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>
$(document).ready(function(){
    $('input[type=file]').change(function() { 
        // select the form and submit
        $('form').submit(); 
    });
});

function stateManagement(type) 
{
    cnt = document.getElementById('cnt_id');
    cnt_id = cnt.value;

    if (cnt_id) 
    {
        url = "<?= base_url('stateExcel?') ?>"+type+"="+cnt_id;
        location.href = url;
    }
    else
    {
        url = "<?= base_url('stateExcel') ?>";
        location.href = url;
    }
}
</script>
