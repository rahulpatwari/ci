<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- bread crumb -->
    <section class="content-header">
        <h1>Category<small>Management</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Categories</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <?= form_open('changeParentCategory'); ?>
                        <!-- select sub category -->
                        <div class="col-sm-12" style="margin-bottom: 10px;">
                            <div class="col-sm-3">
                                <label>Move selected to parent category: </label>
                            </div>
                            <div class="col-sm-4">
                                <select class="form-control" name="parent_cat_id" >
                                    <?php
                                    if ($success) 
                                    {
                                        echo "<option value='0'>Please choose parent category!</option>";

                                        foreach ($categories as $cat_value) 
                                            echo "<option value='".$cat_value['category_id']."'>".$cat_value['category_name']."</option>";
                                    }
                                    else
                                        echo "<option value='0'>No parent category available!</option>";
                                    ?>
                                </select>
                            </div>
                            
                            <div class="col-sm-2">
                                <button type="submit" class="btn btn-default">Go</button>
                            </div>

                            <div class="col-sm-3 pull-right">
                                <a href="<?= base_url('page/addCategory');?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add New Category</a> 
                            </div>
                        </div>

                        <div class="box-body table-responsive" style="margin-top: 20px;">
                            <table id="example1" class="table table-bordered table-striped" style="margin-top: 40px;">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Category ID</th>
                                        <th>Category</th>
                                        <th>Parent Category</th>
                                        <th>Action</th>
                                        <th>Move selected</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($success) 
                                    {
                                        $count = 1;
                                        foreach ($categories as $cat_key => $cat_value) 
                                        {
                                            $cat_id = $cat_value['category_id'];
                                            echo "<tr>
                                                    <td>".$count++."</td>
                                                    <td>".$cat_value['category_id']."</td>
                                                    <td><a href='".base_url("editCategory/$cat_id/view")."'>".$cat_value['category_name']."</a></td>
                                                    <td>".$cat_value['parent_cat']."</td>
                                                    <td>
                                                        <a href='".base_url("editCategory/$cat_id/edit")."' class='btn btn-primary'>Edit</a>
                                                        <a href='".base_url("deleteCategory/$cat_id")."' class='btn btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                                    </td>
                                                    <td>
                                                        <input type='checkbox' value='".$cat_id."' name='selected_sub_category_ids[]'>
                                                    </td>
                                                </tr>";
                                        }
                                    }
                                    else
                                        echo "<tr><td colspan='5' align='center'>No Record found.</td></tr>";
                                    ?>
                                </tbody>
                            </table>
                        </div><!-- /.box-body -->
                    <?= form_close(); ?>
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- ./wrapper -->
