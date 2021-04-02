<div class="span9">
    <ul class="breadcrumb">
		<li><a href="<?= base_url() ?>">Home</a> <span class="divider">/</span></li>
		<li class="active">User Login or Signup</li>
    </ul>
	<hr class="soft"/>
	
	<div class="row">
		<div class="span4">
			<div class="well">
				<h5>SIGN UP</h5><br/>
				<form method="post" action="<?= base_url('insertUser') ?>">
					<div class="control-group">
						<label class="control-label">Full name <sup>*</sup></label>
						<div class="controls">
							<input class="span3" type="text" name="full_name" placeholder="Full name" required />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Email <sup>*</sup></label>
						<div class="controls">
							<input class="span3" type="text" name="email" placeholder="Email" required />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Password <sup>*</sup></label>
						<div class="controls">
							<input class="span3" type="password" name="password" id="password" placeholder="Password" required />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Confirm Password <sup>*</sup></label>
						<div class="controls">
							<input class="span3" type="password" name="confirm_password" placeholder="Confirm Password" required />
						</div>
					</div>
					<div class="controls">
						<button type="submit" class="btn block">Sign up</button>
					</div>
				</form>
			</div>
		</div>
		<div class="span1"> &nbsp;</div>
		<div class="span4">
			<div class="well">
				<h5>ALREADY REGISTERED ?</h5>
				<form method="post" action="<?= base_url('userLogin') ?>">
					<div class="control-group">
						<label class="control-label">Email <sup>*</sup></label>
						<div class="controls">
							<input class="span3"  type="text" name="email" placeholder="Email" required />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Password <sup>*</sup></label>
						<div class="controls">
							<input type="password" class="span3" name="password" placeholder="Password" required />
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<button type="submit" class="btn">Login</button> <a href="forgetpass.html">Forgot password?</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>	
</div>
</div>
</div>
</div>
<!-- MainBody End ============================= -->
