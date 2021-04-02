<style type="text/css">
.btn-grey{
    background-color:#D8D8D8;
	color:#FFF;
}
.rating-block{
	background-color:#FAFAFA;
	border:1px solid #EFEFEF;
	padding:15px 15px 20px 15px;
	border-radius:3px;
}
.bold{
	font-weight:700;
}
.padding-bottom-7{
	padding-bottom:7px;
}

.review-block{
	background-color:#FAFAFA;
	border:1px solid #EFEFEF;
	padding:15px;
	border-radius:3px;
	margin-bottom:15px;
}
.review-block-name{
	font-size:12px;
	margin:10px 0;
}
.review-block-date{
	font-size:12px;
}
.review-block-rate{
	font-size:13px;
	margin-bottom:15px;
}
.review-block-title{
	font-size:15px;
	font-weight:700;
	margin-bottom:10px;
}
.review-block-description{
	font-size:13px;
}

.right-side{
	padding: 20px;
}
</style>

<aside class="right-side">
	<!-- bread crumb -->
    <section class="content-header">
        <h1>Merchant Review</h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Reviews</li>
        </ol>
    </section>

	<?php if ($merchant_review) {  ?>
		<div class="row">
			<div class="col-sm-3">
				<div class="rating-block">
					<h4>Average rating</h4>
					<h2 class="bold padding-bottom-7"><?= round($rating_info['avg_rating']) ?> <small>/ 5</small></h2>
					<?php printRatingStars($rating_info['avg_rating']); ?>
				</div>
			</div>	

			<div class="col-sm-4">
				<h4>Rating breakdown</h4>
				<div class="pull-left">
					<div class="pull-left" style="width:35px; line-height:1;">
						<div style="height:9px; margin:5px 0;">5 <span class="glyphicon glyphicon-star"></span></div>
					</div>
					<div class="pull-left" style="width:180px;">
						<div class="progress" style="height:9px; margin:8px 0;">
						  	<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" style="width: 1000%"></div>
						</div>
					</div>
					<div class="pull-right" style="margin-left:10px;"><?= $rating_info['rating_count_5_star'] ?></div>
				</div>
				<div class="pull-left">
					<div class="pull-left" style="width:35px; line-height:1;">
						<div style="height:9px; margin:5px 0;">4 <span class="glyphicon glyphicon-star"></span></div>
					</div>
					<div class="pull-left" style="width:180px;">
						<div class="progress" style="height:9px; margin:8px 0;">
						  	<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="4" aria-valuemin="0" aria-valuemax="5" style="width: 80%"></div>
						</div>
					</div>
					<div class="pull-right" style="margin-left:10px;"><?= $rating_info['rating_count_4_star'] ?></div>
				</div>
				<div class="pull-left">
					<div class="pull-left" style="width:35px; line-height:1;">
						<div style="height:9px; margin:5px 0;">3 <span class="glyphicon glyphicon-star"></span></div>
					</div>
					<div class="pull-left" style="width:180px;">
						<div class="progress" style="height:9px; margin:8px 0;">
						  	<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="3" aria-valuemin="0" aria-valuemax="5" style="width: 60%"></div>
						</div>
					</div>
					<div class="pull-right" style="margin-left:10px;"><?= $rating_info['rating_count_3_star'] ?></div>
				</div>
				<div class="pull-left">
					<div class="pull-left" style="width:35px; line-height:1;">
						<div style="height:9px; margin:5px 0;">2 <span class="glyphicon glyphicon-star"></span></div>
					</div>
					<div class="pull-left" style="width:180px;">
						<div class="progress" style="height:9px; margin:8px 0;">
						  	<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="5" style="width: 40%"></div>
						</div>
					</div>
					<div class="pull-right" style="margin-left:10px;"><?= $rating_info['rating_count_2_star'] ?></div>
				</div>
				<div class="pull-left">
					<div class="pull-left" style="width:35px; line-height:1;">
						<div style="height:9px; margin:5px 0;">1 <span class="glyphicon glyphicon-star"></span></div>
					</div>
					<div class="pull-left" style="width:180px;">
						<div class="progress" style="height:9px; margin:8px 0;">
						  	<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="5" style="width: 20%"></div>
						</div>
					</div>
					<div class="pull-right" style="margin-left:10px;"><?= $rating_info['rating_count_1_star'] ?></div>
				</div>
			</div>			
		</div>			
		
		<?php foreach ($merchant_review as $review) {  ?>
			<div class="row">
				<div class="col-sm-12">
					<hr/>
					<div class="review-block">
						<div class="row">
							<div class="col-sm-2">
								<?php 
								$consumer_pic = $this->config->item('site_url').PROFILE_PIC_PATH.$review['consumer_user_id'].'.png';
								$file_headers = get_headers($consumer_pic);
								if ($file_headers[0] == 'HTTP/1.0 404 Not Found') 
									$consumer_pic = "http://dummyimage.com/60x60/666/ffffff&text=No+Image";
								?>
								<img src="<?= $consumer_pic ?>" class="img-rounded" width="60px">
								<div class="review-block-name"><a href="#"><?= $review['consumer_name'] ?></a></div>
								<div class="review-block-date">
									<?= date('F d, Y', strtotime($review['review_date'])) ?>
								</div>
							</div>
							<div class="col-sm-10">
								<div class="review-block-rate">
									<?php printRatingStars($review['rating']); ?>
								</div>
								<div class="review-block-title"><?= $review['review_title'] ?></div>
								<div class="review-block-description"><?= $review['review'] ?></div>
							</div>
						</div>
						<hr/>
					</div>
				</div>
			</div>
	<?php } 
		} 
		else 
			echo "Review not available";
	?>
</aside>