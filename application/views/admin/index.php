<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Dashboard </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <?php if ( $_COOKIE['site_code'] == "admin" ) { ?>
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-gray">
                        <div class="inner">
                            <h4><?= convert_to_user_date($counts['last_db_backup_time'], 'j-n-Y g:i:s A', $serverTimeZone = 'UTC'); ?></h4>
                            <p>Databse last backup time</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="<?= base_url('Admin_controller/createDbBackup') ?>" class="small-box-footer">
                            Backup now <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div><!-- ./col -->

                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3><?= $counts['product_count'] ?></h3>
                            <p>Products</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="<?= base_url('products') ?>" class="small-box-footer">
                            More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div><!-- ./col -->

                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3><?= $counts['consumer_count'] ?></h3>
                            <p>Registered Consumers</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="<?= base_url('page/userManagement?user_type=BUYER') ?>" class="small-box-footer">
                            More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div><!-- ./col -->

                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3><?= $counts['varified_seller_count'] + $counts['not_varified_seller_count'] ?></h3>
                            <p>Registered Merchants  (<?= $counts['varified_seller_count'] ?> Verified)</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="<?= base_url('sellers/sellersTable') ?>" class="small-box-footer">
                            More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div><!-- ./col -->

                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3><?= $counts['brand_count'] ?></h3>
                            <p>Brands</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="<?= base_url('brand') ?>" class="small-box-footer">
                            More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div><!-- ./col -->

                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-maroon">
                        <div class="inner">
                            <h3><?= $counts['pending_requested_product_count'] ?></h3>
                            <p>Pending Requested Produts</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="<?= base_url('page/requestedProducts') ?>" class="small-box-footer">
                            More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div><!-- ./col -->
            <?php } ?>

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-black">
                    <div class="inner">
                        <h3><?= $counts['listed_products_count'] ?></h3>
                        <p>Listed Products</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <?php if ( $_COOKIE['site_code'] == "admin" ) { ?>
                        <a href="<?= base_url('sellers/sellersList') ?>" class="small-box-footer">
                            More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    <?php } else if ( $_COOKIE['site_code'] == "seller" ) { 
                        $url = 'getAllProducts/'.$_COOKIE['merchant_id'];
                    ?>
                        <a href="<?= base_url($url) ?>" class="small-box-footer">
                            More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    <?php } ?>
                </div>
            </div><!-- ./col -->

            <?php if ($_COOKIE['site_code'] == "seller") { ?>
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-orange">
                        <div class="inner">
                            <h3><?= $counts['active_offers_count'] ?></h3>
                            <p>Active Offers</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="<?= base_url('page/offerManagement') ?>" class="small-box-footer">
                            More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div><!-- ./col -->

                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3><?= $counts['merchant_review_average'].'('.$counts['merchant_review_count'].')' ?></h3>
                            <p>Average rating(Number of reviews)</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="<?= base_url('page/merchantReview') ?>" class="small-box-footer">
                            More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div><!-- ./col -->
            <?php } ?>

        </div><!-- /.row -->
    </section><!-- /.content -->
</aside><!-- /.right-side -->
