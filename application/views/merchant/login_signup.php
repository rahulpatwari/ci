<div class="span12">
    <div class="row">
		<div class="span2"> &nbsp;</div>
		<div class="span4">
			<div class="well">
				<h5>SELLER SIGN UP</h5><br/>
				<form method="post" action="<?= base_url('insertSeller') ?>">
					<div class="control-group">
						<label class="control-label">First name <sup>*</sup></label>
						<div class="controls">
							<input class="span3" type="text" name="first_name" placeholder="First name" required />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Last name </label>
						<div class="controls">
							<input class="span3" type="text" name="last_name" placeholder="Last name" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Email <sup>*</sup></label>
						<div class="controls">
							<input class="span3" type="email" name="email" placeholder="Email" required />
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
					<div class="control-group">
						<label class="control-label">Contact number <sup>*</sup></label>
						<div class="controls">
							<input class="span3" type="text" name="contact_number" placeholder="Contact number" required />
						</div>
					</div>
					<div class="controls">
						<button type="submit" class="btn block">Sign up</button>
					</div>
				</form>
			</div>
		</div>
		<div class="span4">
			<div class="well">
				<h5>ALREADY REGISTERED ?</h5>
				<form method="post" action="<?= base_url('merchantLogin') ?>">
					<div class="control-group">
						<label class="control-label">Email <sup>*</sup></label>
						<div class="controls">
							<input class="span3"  type="email" name="username" placeholder="Email" required />
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
		<div class="span2"> &nbsp;</div>
	</div>	
</div>
</div>
</div>
</div>
<!-- MainBody End ============================= -->
