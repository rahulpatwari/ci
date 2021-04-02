<div class="span9">
    <ul class="breadcrumb">
		<li><a href="<?= base_url() ?>">Home</a> <span class="divider">/</span></li>
		<li class="active">Profile</li>
    </ul>
	
	<div class="well">
		<?php if (isset($_GET['profile']) && $_GET['profile'] == 'view') {  ?>
			<form class="form-horizontal">
				<h4>
					Your personal information
					<a href="<?= base_url('userProfile?profile=edit') ?>" class="btn btn-primary pull-right">Edit profile</a>
				</h4>
				<div class="control-group">
					<img src="<?= $profile_image ?>" width="150px">
				</div>
				<div class="control-group">
					<label class="control-label" >Name:</label>
					<div class="controls">
						<?= $full_name ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" >Email:</label>
					<div class="controls">
				  		<?= $email ?>
					</div>
			  	</div>	
			  	<div class="control-group">
					<label class="control-label" >Date of birth:</label>
					<div class="controls">
				  		<?= $birthday ?>
					</div>
			  	</div>	
			  	<div class="control-group">
					<label class="control-label" >Phone:</label>
					<div class="controls">
						<?= $phone ?>
					</div>
				</div>
			  	<div class="control-group">
					<label class="control-label">Gender:</label>
					<div class="controls">
						<?= $gender ?>
					</div>
				</div>
			</form>
		<?php } elseif (isset($_GET['profile']) && $_GET['profile'] == 'edit') {  ?>
			<form class="form-horizontal" method="post" action="<?= base_url('insertUser') ?>" enctype="multipart/form-data">
				<input type="hidden" name="user_id" value="<?= $_SESSION['user_detail']['userId'] ?>" required />
				<h4>Your personal information</h4>
				<div class="control-group">
					<img src="<?= $profile_image ?>" width="150px">
				</div>
				<div class="control-group">
					<label class="control-label">Name <sup>*</sup></label>
					<div class="controls">
						<input type="text" name="full_name" placeholder="Name" value="<?= $full_name ?>" required />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Email</label>
					<div class="controls">
				  		<input type="email" value="<?= $email ?>" readonly />
					</div>
			  	</div>	
			  	<div class="control-group">
					<label class="control-label">Profile picture</label>
					<div class="controls">
						<input type="file" name="file" onchange="readURL(this);" />
						<img id="blah" src="http://placehold.it/180" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" >Date of birth</label>
					<div class="controls">
				  		<input type="text" name="dob" value="<?= $birthday ?>" placeholder="dd-mm-yyyy" />
				  		(Please use dd-mm-yyyy format)
					</div>
			  	</div>	
			  	<div class="control-group">
					<label class="control-label" >Phone</label>
					<div class="controls">
						<input type="text" name="phone" placeholder="Contact no" value="<?= $phone ?>" />
					</div>
				</div>
			  	<div class="control-group">
					<label class="control-label">Gender</label>
					<div class="controls">
						<select class="span1" name="gender">
							<?php
							$male_selected = '';
							$female_selected = '';
							$other_selected = '';

							if ($gender == "MALE")
								$male_selected = 'selected="selected"';
							else if ($gender == "FEMALE")
								$female_selected = 'selected="selected"';
							else if ($gender == "OTHER")
								$other_selected = 'selected="selected"';

							echo '<option value="MALE" '.$male_selected.'>Male</option>
								<option value="FEMALE" '.$female_selected.'>Female</option>
								<option value="OTHER" '.$other_selected.'>Other</option>';
							?>
						</select>
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
						<input class="btn btn-large btn-success" type="submit" value="Update" />
					</div>
				</div>		
			</form>
		<?php } ?>
	</div>
</div>
</div>
</div>
</div>
<!-- MainBody End ============================= -->

<style type="text/css">
#blah{
	max-width:180px;
}
</style>
<script type="text/javascript">
function readURL(input) {
	if (input.files && input.files[0]) 
	{
		var reader = new FileReader();

		reader.onload = function (e) {
			$('#blah').attr('src', e.target.result);
		};

		reader.readAsDataURL(input.files[0]);
	}
}
</script>