<?php 
if (isset($_GET['getStateList']))
    $query_string_cnt_id = $_GET['getStateList'];
else if (isset($_GET['addNewState']))
    $query_string_cnt_id = $_GET['addNewState'];
else
    $query_string_cnt_id = '';

$state_name = isset($state['name']) ? $state['name'] : '';
$state_id = isset($state['state_id']) ? $state['state_id'] : '';
$cnt_id = isset($state['country_id']) ? $state['country_id'] : '';
$status = isset($state['status']) ? $state['status'] : 1;
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
            <li class="active">State management</li>
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
                                    </div>
                                    <div class="col-sm-12" style="margin-top: 10px;" align="right">
                                        <button class="btn btn-primary" onclick="stateManagement('getStateList');">Get state list</button>

                                        <button class="btn btn-warning" onclick="stateManagement('addNewState');"><i class="fa fa-plus"></i> Add new state</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (!isset($_GET['addNewState'])) { ?>
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
                                        <th>Action</th>
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
                                                    <td>
                                                        <a href='".base_url("page/stateManagement?addNewState=$query_string_cnt_id&state_id=$state_id")."' class='btn btn-primary'>Edit</a>
                                                        <a href='".base_url("changeStateStatus/$state_id/$query_string_cnt_id/$newStatus")."' class='btn btn-warning'>Change status</a>
                                                    </td>
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
                <?php } else if (isset($_GET['addNewState'])) 
                { 
                    $cnt_id = $_GET['addNewState'];
                ?>
                    <div class="col-md-5 col-md-offset-3">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">Add state</h3>
                            </div>
                            <!-- form start -->
                            <?= form_open_multipart('addState'); ?>
                                <input type="hidden" name="cnt_id" value="<?= $cnt_id ?>" />
                                <input type="hidden" name="state_id" value="<?= $state_id ?>" />
                                <input type="hidden" name="status" value="<?= $status ?>" />

                                <div class="box-body">
                                    <div class="row form-group">
                                        <div class="col-sm-3">
                                            <label>State Name*:</label> 
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" name="state_name" class="form-control" placeholder="Enter State Name" value="<?= $state_name; ?>" required>      
                                        </div>
                                        <div class="col-sm-12" style="margin-top: 10px;" align="right">
                                            <a href='<?= base_url("page/stateManagement") ?>' class='btn btn-default'>Cancel</a>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            <?= form_close(); ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- ./wrapper -->

<script>
function stateManagement(type) 
{
    cnt = document.getElementById('cnt_id');
    cnt_id = cnt.value;

    if (cnt_id) 
    {
        url = "<?= base_url('page/stateManagement?') ?>"+type+"="+cnt_id;
        location.href = url;
    }
    else
        alert('Error: please select a country first!!');
}
</script>
