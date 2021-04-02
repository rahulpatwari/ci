<div class="span9">
    <ul class="breadcrumb">
		<li><a href="<?= base_url() ?>">Home</a> <span class="divider">/</span></li>
		<li class="active">Location Setting</li>
    </ul>
	<hr class="soft"/>
	
	<div class="row">
		<div class="span2"> &nbsp;</div>
		<div class="span4">
			<div class="well" align="center">
				<form method="post" action="<?= base_url('insertUser') ?>">
					<div class="control-group">
						<div class="controls">
							<input type="button" class="btn btn-default" name="" value="Select current location" />
						</div>
					</div>
					
					<hr /><center>OR</center><hr />

					<div class="control-group">
						<div class="controls">
							<select>
								<option>--select city--</option>
							</select>
						</div>
					</div>
					<div class="control-group">
						<select>
							<option>--select area--</option>
						</select>
					</div>
					<div class="controls">
						<button type="submit" class="btn block">Select</button>
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