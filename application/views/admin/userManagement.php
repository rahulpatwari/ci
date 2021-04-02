<?php 
$usr_type = isset($_GET['user_type']) ? $_GET['user_type'] : '';
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- bread crumb -->
    <section class="content-header">
        <h1>
            User
            <small>Management</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Users</li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="row" style="margin: 20px;">
                        <div class="col-sm-1">
                            <label>Filter user:</label>
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control" id="user_type">
                                <option value="ALL">ALL USERS</option>
                                <option value="ADMIN" <?php if($usr_type == "ADMIN"){ echo 'selected="selected"'; } ?> >ADMIN</option>
                                <option value="BUYER" <?php if($usr_type == "BUYER"){ echo 'selected="selected"'; } ?> >CONSUMER</option>
                                <option value="SELLER" <?php if($usr_type == "SELLER"){ echo 'selected="selected"'; } ?> >SELLER</option>
                                <option value="TEST USER" <?php if($usr_type == "TEST USER"){ echo 'selected="selected"'; } ?> >TEST USER</option>
                                <option value="1" <?php if($usr_type == "1"){ echo 'selected="selected"'; } ?> >ACTIVE USER</option>
                                <option value="0" <?php if($usr_type == "0"){ echo 'selected="selected"'; } ?> >DEACTIVE USER</option>
                            </select>
                        </div>
                        <div class="col-sm-9">
                            <button class="btn btn-default" onclick="getFilteredUsers() ">Search</button>
                            <a href="<?= base_url('page/addUser') ?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add New User</a> 
                        </div>
                    </div>

                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>User ID</th>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Current status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
                                if ($users) 
                            	{
                                    $count=0;
                                    foreach ($users as $user) 
                            		{
                                        $usr_id = $user['userId'];
                                        $name = $user['first_name']." ".$user['middle_name']." ".$user['last_name'];
                                        if ($user['status'])
                                        {
                                            $status = "<span class='label label-success'>Active</span>";
                                            $newStatus = 0;
                                        }
                                        else
                                        {
                                            $status = "<span class='label label-danger'>Not active</span>";
                                            $newStatus = 1;
                                        }
                                        
                                        $showAddressManagementButton = false;
                                        if ($user['roles']) 
                                        {
                                            $roles = "";
                                            $i = 0;

                                            foreach ($user['roles'] as $role) 
                                            {
                                                if ( $i > 0 )
                                                    $roles .= ",&nbsp;&nbsp;";

                                                $roles .= $role['type_name'];

                                                if ($role['type_name'] == "SELLER")
                                                    $showAddressManagementButton = true;

                                                $i++;
                                            }
                                        }
                                        else
                                            $roles = "-";

                                        if ($user['profile_image'])
                                            $profile_image = $user['profile_image'];
                                        else
                                            $profile_image = $this->config->item('site_url').'assets/admin/img/avatar3.png';

                                        echo "<tr>
                                                <td>".++$count."</td>
                                                <td>".$usr_id."</td>
                                                <td>
                                                    <img src=".$profile_image." width='60px' />
                                                    <a href='".base_url("editUser/$usr_id?view")."'>".$name."</a>
                                                </td>
                                                <td>".$user['email']."</td>
                                                <td>".$roles."</td>
                                                <td>".$status."</td>
                            					<td>
                                                    <div class='input-group input-group'>
                                                        <div class='input-group-btn'>
                                                            <button type='button' class='btn btn-danger dropdown-toggle' data-toggle='dropdown'>Action <span class='fa fa-caret-down'></span></button>
                                                            <ul class='dropdown-menu'>
                                                                <li><a href='".base_url("changeUserStatus/$usr_id/$newStatus")."' onclick='return confirm(\"Are you sure?\")'>Change status</a></li>
                                                                <li><a href='".base_url("editUser/$usr_id?edit")."'>Edit</a></li>";

                                                                if ($usr_id != $_COOKIE['user_id']) 
                                                                    echo "<li><a href='".base_url("deleteUser/$usr_id")."' onclick='return confirm(\"Are you sure?\")'>Delete</a></li>";
                                                
                                                        echo "</ul>
                                                        </div>
                                                    </div>
                                                </td>
                            				</tr>";
                            		}
                            	}
                            	else
                            		echo "<tr><td colspan='6' align='center'>No Record found.</td></tr>";
                            	?>
                            </tbody>
                        </table>
                        <?= form_close(); ?>
                    </div><!-- /.box-body -->
                </div>
            </div><!-- /.box -->
        </div>
    </section><!-- /.content -->
</div><!-- ./wrapper -->

<script>
function getFilteredUsers() 
{
    type = document.getElementById('user_type');
    user_type = type.value;

    if (user_type) 
    {
        url = "<?= base_url('page/userManagement?user_type=') ?>"+user_type;
        location.href = url;
    }
}
</script>
