<div class="span9">
    <ul class="breadcrumb">
    	<li><a href="<?= base_url() ?>">Home</a> <span class="divider">/</span></li>
    	<li class="active">Search</li>
    </ul>	
	
	Your search term: <i><?= $search_term ?></i><br /><br />
	<div class="span4">
		<div class="panel panel-white post panel-shadow">
			<a href="">
			    <div class="post-heading">
			        <div class="pull-left image">
			            Product
			            <p><?= $products ?> Products found</p>
			        </div>
			    </div> 
			</a>
		</div>
	</div>

	<div class="span4">
		<div class="panel panel-white post panel-shadow">
			<a href="">
			    <div class="post-heading">
			        <div class="pull-left image">
			            Category
			            <p><?= $categories ?> Products for this category</p>
			        </div>
			    </div> 
			</a>
		</div>
	</div>

	<div class="span4">
		<div class="panel panel-white post panel-shadow">
			<a href="">
			    <div class="post-heading">
			        <div class="pull-left image">
			            Merchant
			            <p><?= $merchants ?> Merchant found</p>
			        </div>
			    </div> 
			</a>
		</div>
	</div>

	<div class="span4">
		<div class="panel panel-white post panel-shadow">
			<a href="">
			    <div class="post-heading">
			        <div class="pull-left image">
			            Brand
			            <p><?= $brands ?> Product found</p>
			        </div>
			    </div> 
			</a>
		</div>
	</div>
</div>
</div>
</div>
</div> 
</div>
</div>
<!-- MainBody End ============================= -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
div.stars {
  width: 270px;
  display: inline-block;
}

input.star { display: none; }

label.star {
  float: right;
  padding: 10px;
  font-size: 36px;
  color: #444;
  transition: all .2s;
}

input.star:checked ~ label.star:before {
  content: '\2605';
  color: orange;
  transition: all .25s;
}

input.star-5:checked ~ label.star:before {
  color: #FE7;
  text-shadow: 0 0 20px #952;
}

input.star-1:checked ~ label.star:before { color: #F62; }

label.star:hover { transform: rotate(-15deg) scale(1.3); }

label.star:before {
  content: '\2605';
}

.heading {
	font-size: 25px;
	margin-right: 25px;
}

.fa {
	font-size: 25px;
}

.checked {
	color: orange;
}

/* Three column layout */
.side {
	float: left;
	width: 15%;
	margin-top:10px;
}

.middle {
	margin-top:10px;
	float: left;
	width: 70%;
}

/* Place text to the right */
.right {
	text-align: right;
}

/* Clear floats after the columns */
.row:after {
	content: "";
	display: table;
	clear: both;
}

/* The bar container */
.bar-container {
	width: 100%;
	background-color: #f1f1f1;
	text-align: center;
	color: white;
}

/* Individual bars */
.bar-5 {
	width: <?= $five_star_width ?>; 
	height: 18px; 
	background-color: #4CAF50;
}
.bar-4 {
	width: <?= $four_star_width ?>;
	height: 18px; 
	background-color: #2196F3;
}
.bar-3 {
	width: <?= $three_star_width ?>;
	height: 18px; 
	background-color: #00bcd4;
}
.bar-2 {
	width: <?= $two_star_width ?>;
	height: 18px; 
	background-color: #ff9800;
}
.bar-1 {
	width: <?= $one_star_width ?>;
	height: 18px; 
	background-color: #f44336;
}

/* Responsive layout - make the columns stack on top of each other instead of next to each other */
@media (max-width: 400px) {
	.side, .middle {
		width: 100%;
	}
	.right {
		display: none;
	}
}


.panel-shadow {
    box-shadow: rgba(0, 0, 0, 0.3) 7px 7px 7px;
}
.panel-white {
  border: 1px solid #dddddd;
  margin: 20px;
}
.panel-white  .panel-heading {
  color: #333;
  background-color: #fff;
  border-color: #ddd;
}
.panel-white  .panel-footer {
  background-color: #fff;
  border-color: #ddd;
}

.post .post-heading {
  height: 40px;
  padding: 20px 15px;
}
.post .post-heading .avatar {
  width: 60px;
  height: 60px;
  display: block;
  margin-right: 15px;
}
.post .post-heading .meta .title {
  margin-bottom: 0;
}
.post .post-heading .meta .title a {
  color: black;
}
.post .post-heading .meta .title a:hover {
  color: #aaaaaa;
}
.post .post-heading .meta .time {
  margin-top: 8px;
  color: #999;
}
.post .post-image .image {
  width: 100%;
  height: auto;
}
.post .post-description {
  padding: 15px;
}
.post .post-description p {
  font-size: 14px;
}
.post .post-description .stats {
  margin-top: 20px;
}
.post .post-description .stats .stat-item {
  display: inline-block;
  margin-right: 15px;
}
.post .post-description .stats .stat-item .icon {
  margin-right: 8px;
}
.post .post-footer {
  border-top: 1px solid #ddd;
  padding: 15px;
}
.post .post-footer .input-group-addon a {
  color: #454545;
}
.post .post-footer .comments-list {
  padding: 0;
  margin-top: 20px;
  list-style-type: none;
}
.post .post-footer .comments-list .comment {
  display: block;
  width: 100%;
  margin: 20px 0;
}
.post .post-footer .comments-list .comment .avatar {
  width: 35px;
  height: 35px;
}
.post .post-footer .comments-list .comment .comment-heading {
  display: block;
  width: 100%;
}
.post .post-footer .comments-list .comment .comment-heading .user {
  font-size: 14px;
  font-weight: bold;
  display: inline;
  margin-top: 0;
  margin-right: 10px;
}
.post .post-footer .comments-list .comment .comment-heading .time {
  font-size: 12px;
  color: #aaa;
  margin-top: 0;
  display: inline;
}
.post .post-footer .comments-list .comment .comment-body {
  margin-left: 50px;
}
.post .post-footer .comments-list .comment > .comments-list {
  margin-left: 50px;
}
</style>