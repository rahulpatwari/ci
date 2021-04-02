<?php
$seller_page = $brand_page = $products_page = $place_management = $seller_management = $product_seller_linking = $countryManagement = $stateManagement = $cityManagement = $areaManagement = $userManagement = $offerManagement = $requestProduct = $merchantReview = $productReview = $review = $data_import_export = $productExcel = $merchantExcel = $listingExcel = $addressExcel = $siteSettings = $claimed_request = $countryExcel = $stateExcel = $cityExcel = $areaExcel = $maintenance = '';

$parse_url = parse_url($_SERVER['REQUEST_URI']);
$url = explode('/', $_SERVER['REQUEST_URI']);

$dashboard_page = in_array("dashboard", $url) ? "active" : '';
$seller_default_values = in_array("default_values", $url) ? "active" : '';
$category_page = (in_array("category", $url) || in_array("addCategory", $url) || in_array("editCategory", $url)) ? "active" : "";
$attributes_page = (in_array("attributes", $url) || in_array("addAttribute", $url) || in_array("editAttribute", $url)) ? "active" : "";
$address_management = ((isset($_GET['user_id']) || isset($_GET['address_id'])) && $_COOKIE['site_code'] == 'seller') ? "active" : "";

if (in_array("sellersTable", $url) || in_array("sellersList", $url) || in_array("addSeller", $url) || in_array("seller", $url) || in_array("getAllProducts", $url) || in_array("getProductDetail", $url) || isset($_GET['user_id']) || isset($_GET['address_id']) || in_array("claimedRequest", $url))
{
    $seller_page = "active";

    if (in_array("sellersList", $url) || in_array("getAllProducts", $url) || in_array("getProductDetail", $url))
        $product_seller_linking = 'active';
    else if (in_array("sellersTable", $url) || in_array("addSeller", $url) || in_array("seller", $url) || isset($_GET['user_id']) || isset($_GET['address_id']))
        $seller_management = 'active';
    else if (in_array("claimedRequest", $url))
        $claimed_request = 'active';
}
else if (in_array("brand", $url) || in_array("addBrand", $url) || in_array("editBrand", $url))
    $brand_page = "active";
else if (in_array("products", $url) || in_array("addProduct", $url) || in_array("editProduct", $url) || isset($_GET['cat']))
    $products_page = "active";
else if (in_array("countryManagement", $url) || in_array("stateManagement", $url) || in_array("editCountry", $url) || in_array("addCountry", $url) || (isset($_GET['getStateList']) && $parse_url['path'] != '/stateExcel') || isset($_GET['addNewState']) || in_array('cityManagement', $url) || (isset($_GET['getCityList']) && $parse_url['path'] != '/cityExcel') || isset($_GET['addNewCity']) || in_array("areaManagement", $url) || ((isset($_GET['getAreaList'])) && $parse_url['path'] != '/areaExcel') || isset($_GET['addNewArea'])) 
{
    $place_management = "active";

    if (in_array("countryManagement", $url) || in_array("addCountry", $url) || in_array("editCountry", $url))
        $countryManagement = "active";
    else if (in_array("stateManagement", $url) || isset($_GET['getStateList']) || isset($_GET['addNewState']))
        $stateManagement = "active";
    else if (in_array("cityManagement", $url) || isset($_GET['getCityList']) || isset($_GET['addNewCity']))
        $cityManagement = "active";
    else if (in_array("areaManagement", $url) || isset($_GET['getAreaList']) || isset($_GET['addNewArea'])) 
        $areaManagement = "active";
}
else if (in_array("userManagement", $url) || in_array("addUser", $url) || isset($_GET['user_type']) || in_array("editUser", $url))
    $userManagement = "active";
else if ( in_array("offerManagement", $url) || in_array("addOffer", $url) || isset($_GET['ofr_id']) || in_array("editOffer", $url) || in_array("offers", $url) )
    $offerManagement = "active";
else if (in_array("review", $url) || in_array("merchantReview", $url) || in_array("editReview", $url) || in_array("viewReview", $url))
{
    $review = "active";
    if (in_array("merchant", $url) || in_array("merchantReview", $url))
        $merchantReview = 'active';
    else if (in_array("product", $url))
        $productReview = 'active';
}
else if (in_array("requestProduct", $url) || in_array("fillListingDetailOfRequestedProduct", $url) || in_array("requestedProducts", $url) || in_array("merchantRequestedProducts", $url) || in_array("editRequestedProduct", $url) || isset($_GET['req_prd_id']))
    $requestProduct = "active";
else if (isset($_SERVER['REDIRECT_URL']) && (strpos("/productExcel", $_SERVER['REDIRECT_URL']) !== false || strpos("/merchantExcel", $_SERVER['REDIRECT_URL']) !== false || strpos("/addressExcel", $_SERVER['REDIRECT_URL']) !== false || strpos("/listingExcel", $_SERVER['REDIRECT_URL']) !== false || strpos("/countryExcel", $_SERVER['REDIRECT_URL']) !== false || strpos("/stateExcel", $_SERVER['REDIRECT_URL']) !== false || strpos("/cityExcel", $_SERVER['REDIRECT_URL']) !== false || strpos("/areaExcel", $_SERVER['REDIRECT_URL']) !== false || strpos("/importAddressXls", $_SERVER['REDIRECT_URL']) !== false))
{
    $data_import_export = "active";
    if (strpos("/productExcel", $_SERVER['REDIRECT_URL']) !== false)
        $productExcel = 'active';
    else if (strpos("/merchantExcel", $_SERVER['REDIRECT_URL']) !== false)
        $merchantExcel = 'active';
    else if (strpos("/addressExcel", $_SERVER['REDIRECT_URL']) !== false || strpos("/importAddressXls", $_SERVER['REDIRECT_URL']) !== false)
        $addressExcel = 'active';
    else if (strpos("/listingExcel", $_SERVER['REDIRECT_URL']) !== false)
        $listingExcel = 'active';
    else if (strpos("/countryExcel", $_SERVER['REDIRECT_URL']) !== false)
        $countryExcel = 'active';
    else if (strpos("/stateExcel", $_SERVER['REDIRECT_URL']) !== false)
        $stateExcel = 'active';
    else if (strpos("/cityExcel", $_SERVER['REDIRECT_URL']) !== false)
        $cityExcel = 'active';
    else if (strpos("/areaExcel", $_SERVER['REDIRECT_URL']) !== false)
        $areaExcel = 'active';
}
else if (in_array("siteSettings", $url))
    $siteSettings = 'active';
else if (in_array("claimedRequests", $url))
    $claim_requests = 'active';
else if (in_array("maintenance", $url))
    $maintenance = 'active';
else
    $dashboard_page = "active";

if (isset($_COOKIE['image']))
    $usr_profile_pic = $_COOKIE['image'];
else
    $usr_profile_pic = $this->config->item('site_url').'assets/admin/img/avatar3.png';
?>

<style type="text/css">
.sidebar{
    max-height: calc(100vh - 10rem);
    overflow-y: auto;
}
</style>

<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?= $usr_profile_pic ?>" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p><?php print_r(strtoupper($_COOKIE['name'])); ?></p>
                    <?= strtoupper($_COOKIE['site_code']) ?>
                </div>
            </div>

            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <!-- dashboard -->
                <li class="<?= $dashboard_page ?>">
                    <a href="<?= base_url('dashboard') ?>">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>

                <?php if ($_COOKIE['site_code'] == "admin") { ?>
                    <!-- category -->
                    <li class="<?= $category_page ?>">
                        <a href="<?= base_url('category') ?>">
                            <i class="fa fa-list-alt"></i> <span>Category</span>
                        </a>
                    </li>

                    <!-- attributes -->
                    <li class="<?= $attributes_page ?>">
                        <a href="<?= base_url('page/attributes') ?>">
                            <i class="fa fa-list-alt"></i> <span>Attributes</span>
                        </a>
                    </li>

                    <!-- brand -->
                    <li class="<?= $brand_page ?>">
                        <a href="<?= base_url('brand') ?>">
                            <i class="fa fa-xing-square"></i> <span>Brand</span>
                        </a>
                    </li>

                    <!-- products -->
                    <li class="<?= $products_page ?>">
                        <a href="<?= base_url('products') ?>">
                            <i class="fa fa-weibo"></i> <span>Product</span>
                        </a>
                    </li>

                    <style type="text/css">
                    .sidebar .sidebar-menu .active .treeview-menu {
                        display: block;
                    }
                    </style>

                    <!-- seller -->
                    <li class="treeview <?= $seller_page ?>" id="treeview1" onclick="openTreeView('#treeview1');">
                        <a href="#">
                            <i class="fa fa-bar-chart-o"></i>
                            <span>Seller</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?= $seller_management ?>">
                                <a href="<?= base_url('sellers/sellersTable') ?>">
                                    <i class="fa fa-angle-double-right"></i> 
                                    Seller Management
                                </a>
                            </li>
                            <li class="<?= $product_seller_linking ?>">
                                <a href="<?= base_url('sellers/sellersList') ?>">
                                    <i class="fa fa-angle-double-right"></i> 
                                    Product Listing
                                </a>
                            </li>
                            <li class="<?= $claimed_request ?>">
                                <a href="<?= base_url('page/claimedRequest') ?>">
                                    <i class="fa fa-angle-double-right"></i> 
                                    Claimed Request
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- place -->
                    <li class="treeview <?= $place_management ?>" id="treeview2" onclick="openTreeView('#treeview2');">
                        <a href="#">
                            <i class="fa fa-bar-chart-o"></i>
                            <span>Place Management</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?= $countryManagement ?>">
                                <a href="<?= base_url('page/countryManagement') ?>">
                                    <i class="fa fa-angle-double-right"></i> 
                                    Country Management
                                </a>
                            </li>

                            <li class="<?= $stateManagement ?>">
                                <a href="<?= base_url('page/stateManagement') ?>">
                                    <i class="fa fa-angle-double-right"></i> 
                                    State Management
                                </a>
                            </li>

                            <li class="<?= $cityManagement ?>">
                                <a href="<?= base_url('page/cityManagement') ?>">
                                    <i class="fa fa-angle-double-right"></i> 
                                    City Management
                                </a>
                            </li>

                            <li class="<?= $areaManagement ?>">
                                <a href="<?= base_url('page/areaManagement') ?>">
                                    <i class="fa fa-angle-double-right"></i> 
                                    Area Management
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- user management -->
                    <li class="<?= $userManagement ?>">
                        <a href="<?= base_url('page/userManagement') ?>">
                            <i class="fa fa-weibo"></i> <span>User Management</span>
                        </a>
                    </li>

                    <!-- offer management -->
                    <li class="<?= $offerManagement ?>">
                        <a href="<?= base_url('sellers/offers') ?>">
                            <i class="fa fa-weibo"></i> <span>Offer Management</span>
                        </a>
                    </li>

                    <!-- Requested product management -->
                    <li class="<?= $requestProduct ?>">
                        <a href="<?= base_url('page/requestedProducts') ?>">
                            <i class="fa fa-weibo"></i> <span>Requested Products</span>
                        </a>
                    </li>

                    <!-- review -->
                    <li class="treeview <?= $review ?>" id="treeview3" onclick="openTreeView('#treeview3');">
                        <a href="#">
                            <i class="fa fa-bar-chart-o"></i>
                            <span>Review</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?= $merchantReview ?>">
                                <a href="<?= base_url('review/merchant') ?>">
                                    <i class="fa fa-angle-double-right"></i> 
                                    Merchant
                                </a>
                            </li>
                            <li class="<?= $productReview ?>">
                                <a href="<?= base_url('review/product') ?>">
                                    <i class="fa fa-angle-double-right"></i> 
                                    Product
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- review -->
                    <li class="treeview <?= $data_import_export ?>" id="treeview4" onclick="openTreeView('#treeview4');">
                        <a href="#">
                            <i class="fa fa-bar-chart-o"></i>
                            <span>Import/Export</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?= $productExcel ?>">
                                <a href="<?= base_url('productExcel') ?>">
                                    <i class="fa fa-angle-double-right"></i> 
                                    Product
                                </a>
                            </li>
                            <li class="<?= $merchantExcel ?>">
                                <a href="<?= base_url('merchantExcel') ?>">
                                    <i class="fa fa-angle-double-right"></i> 
                                    Merchant
                                </a>
                            </li>
                            <li class="<?= $listingExcel ?>">
                                <a href="<?= base_url('listingExcel') ?>">
                                    <i class="fa fa-angle-double-right"></i> 
                                    Listing
                                </a>
                            </li>
                            <li class="<?= $addressExcel ?>">
                                <a href="<?= base_url('addressExcel') ?>">
                                    <i class="fa fa-angle-double-right"></i> 
                                    Address
                                </a>
                            </li>
                            <li class="<?= $countryExcel ?>">
                                <a href="<?= base_url('countryExcel') ?>">
                                    <i class="fa fa-angle-double-right"></i> 
                                    Country
                                </a>
                            </li>
                            <li class="<?= $stateExcel ?>">
                                <a href="<?= base_url('stateExcel') ?>">
                                    <i class="fa fa-angle-double-right"></i> 
                                    State
                                </a>
                            </li>
                            <li class="<?= $cityExcel ?>">
                                <a href="<?= base_url('cityExcel') ?>">
                                    <i class="fa fa-angle-double-right"></i> 
                                    City
                                </a>
                            </li>
                            <li class="<?= $areaExcel ?>">
                                <a href="<?= base_url('areaExcel') ?>">
                                    <i class="fa fa-angle-double-right"></i> 
                                    Area
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- site settings -->
                    <li class="<?= $siteSettings ?>">
                        <a href="<?= base_url('page/siteSettings') ?>">
                            <i class="fa fa-weibo"></i> <span>Settings</span>
                        </a>
                    </li>

                    <!-- site maintenance -->
                    <li class="<?= $maintenance ?>">
                        <a href="<?= base_url('page/maintenance') ?>">
                            <i class="fa fa-weibo"></i> <span>Maintenance</span>
                        </a>
                    </li>
                <?php } ?>

                <?php if ($_COOKIE['site_code'] == "seller") { ?>
                    <!-- offer management -->
                    <li class="<?= $offerManagement ?>">
                        <a href="<?= base_url('page/offerManagement') ?>">
                            <i class="fa fa-weibo"></i> <span>Offer Management</span>
                        </a>
                    </li>

                    <!-- request for product -->
                    <li class="<?= $requestProduct ?>">
                        <a href="<?= base_url('page/merchantRequestedProducts') ?>">
                            <i class="fa fa-weibo"></i> <span>Request product</span>
                        </a>
                    </li>

                    <!-- view review -->
                    <li class="<?= $merchantReview ?>">
                        <a href="<?= base_url('page/merchantReview') ?>">
                            <i class="fa fa-weibo"></i> <span>Review</span>
                        </a>
                    </li>

                    <!-- product linking -->
                    <li class="<?= $product_seller_linking ?>">
                        <a href="<?= base_url().'getAllProducts/'.$_COOKIE['merchant_id'] ?>">
                            <i class="fa fa-angle-double-right"></i> 
                            Product Listing
                        </a>
                    </li>

                    <!-- Address management -->
                    <li class="<?= $address_management ?>">
                        <a href="<?= base_url().'page/addressManagement?user_id='.$_COOKIE['user_id'].'&merchant_id='.$_COOKIE['merchant_id'] ?>">
                            <i class="fa fa-angle-double-right"></i> 
                            Address Management
                        </a>
                    </li>

                    <!-- Address management -->
                    <li class="<?= $seller_default_values ?>">
                        <a href="<?= base_url('page/default_values') ?>">
                            <i class="fa fa-angle-double-right"></i> 
                            Default values
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </section>
    </aside>

    <script>
    function openTreeView(id) {
        $(id).addClass('active');
    }
    </script>
