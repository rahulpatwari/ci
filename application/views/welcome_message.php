<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>ROPO Shop - Research Online Purchase Offline</title>
        <meta name="description" content="Love ROPO Shop." />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--Bootstrap 4-->
        <link rel="stylesheet" href="<?= $this->config->item('site_url').'assets/admin/css/bootstrap1.min.css' ?>" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css" />
        <!--icons-->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    </head>
    <body>
        <!--header-->
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-primary sticky-navigation">
            <a class="navbar-brand" href="<?= base_url() ?>"><strong>ROPO Shop</strong></a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item mr-3">
                        <a class="nav-link page-scroll" href="#features">Features <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item mr-3">
                        <a class="nav-link page-scroll" href="#pricing">Pricing</a>
                    </li>
                    <li class="nav-item mr-3">
                        <a class="nav-link page-scroll" href="#download">Download</a>
                    </li>
                    <li class="nav-item mr-3">
                        <a class="nav-link page-scroll" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item mr-3">
                        <a class="nav-link" href="<?= base_url() ?>">Web</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!--main section-->
        <section class="bg-texture hero pt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-white wow fadeIn">
                        <div class="mt-5 pt-5 d-none d-md-block"></div>
                        <h1>ROPO Shop</h1>
                        <h2>A Platform to <span class="text-orange">Research Online and Purchase Offline</span> </h2>
                        <p class="mt-4 lead">
                            Presently in India, consumer's ability to discover prse off-lineoducts on-line but purcha is limited.
ROPO Shop is a suit of software (Consumer application + Sellers Web Portal) for consumers and sellers that
provides a platform to share information about products with the ultimate goal to enhance
deal making.
                      </p>
                        <p class="mt-5">
                            Available soon for Android Phones
                            <a href="#" class="mr-2"><img src="<?= $this->config->item('site_url').'assets/admin/img/google-play.png' ?>" class="store-img"/></a>
                        </p>
                    </div>
                    <div class="col-md-6 pt-5 d-none d-md-block wow fadeInRight">
                        <img class="img-fluid mx-auto d-block" src="<?= $this->config->item('site_url').'assets/admin/img/shot-3.png' ?>"/>
                    </div>
                </div>
            </div>
        </section>

        <!--main features-->
        <section class="bg-white" id="features">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-8 mx-auto text-center wow fadeIn">
                        <h2 class="text-primary">Why ROPO Shop?</h2>
                        <p class="lead">
                            ROPO Shop offers a user same convenience of shopping at home as Online Shopping, once user have decided on what
he/she want to buy and from which seller then only he/she need to visit the shop and make purchase.
                        </p>
                    </div>
                </div>
                <div class="row d-md-flex mt-4 text-center">
                    <div class="col-sm-6 col-md-3 mt-2">
                        <div class="card border-none wow fadeIn">
                            <div class="card-body">
                                <div class="icon-box">
                                    <i class="material-icons dp36">bug_report e868</i>
                                </div>
                                <h5 class="card-title text-primary pt-5">Risk</h5>
                                <p class="card-text">In online shopping you do not touch or feel the product in a physical
sense . There is risk involve whether it will
reach on time? Product size and
colour may differ. Even the product may be damaged.</p>
<p class="card-text">With ROPO Shop You buy product from shop after physical checks so there is no Risk.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 mt-2">
                        <div class="card border-none wow fadeIn">
                            <div class="card-body">
                                <div class="icon-box">
                                    <i class="material-icons dp36">update e923</i>
                                </div>
                                <h5 class="card-title text-primary pt-5">Delivery time</h5>
                                <p class="card-text">Online shopping takes a minimum of six to seven days to
deliver the product while In Offline shopping You get the product immediately.                              </p>
                                <p class="card-text">With ROPO Shop you also get the possession of product immediately.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 mt-2">
                        <div class="card border-none wow fadeIn">
                            <div class="card-body">
                                <div class="icon-box">
                                    <i class="material-icons dp36">card_giftcard e8f6</i>
                                </div>
                                <h5 class="card-title text-primary pt-5">Variety</h5>
                                <p class="card-text">Variety that a customer gets online is hard to match with offline shopping. In online shopping You can virtually find any product no matter how hard to find it is in the offline store.</p>
<p class="card-text">ROPO Shop also offer same kind of Variety of prodcts as Online.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 mt-2">
                        <div class="card border-none wow fadeIn">
                            <div class="card-body">
                                <div class="icon-box">
                                    <i class="material-icons dp36">sentiment_very_satisfied e815</i>
                                </div>
                                <h5 class="card-title text-primary pt-5">Instant gratification</h5>
                                <p class="card-text">When buying offline You gets products as soon as You pay for it but in online shopping You
have to wait to get the product. When You want to get the product instantly than offline shopping
become necessary.</p>
<p class="card-text">ROPO Shop alows You to get products as soon as You purchase it.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--extra features-->
        <section class="bg-dark text-white" id="extra-features">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-xs-12 text-center wow fadeIn">
                        <h2 class="text-orange">Features & Details</h2>
                        <p class="lead">
                            Built for consumers who wants to compare prodcuts online for price and other features but want to
purchase it from offline market
                        </p>
                    </div>
                </div>
                <div class="row d-md-flex mt-5">
                    <div class="col-sm-4 wow fadeIn">
                        <h5 class="text-orange">Tangibility of the product</h5>
                        <p>Consumer get a chance to touch and feel the product before making final purchase.</p>
                        <h5 class="text-orange pt-5">Shorter Delivery time</h5>
                        <p>Consumer get the possession of product immediately.</p>
                        <h5 class="text-orange pt-5">Immediate Value</h5>
                        <p>Immediate value to users through the product search and compare product features.</p>
                    </div>
                    <div class="col-sm-4 wow fadeIn">
                        <img class="img-fluid mx-auto d-block pb-3" src="<?= $this->config->item('site_url').'assets/admin/img/shot-3.png' ?>" />
                    </div>
                    <div class="col-sm-4 wow fadeIn">
                        <h5 class="text-orange">Reviews</h5>
                        <p>Read reviews from other users for Sellers and Products</p>
                        <h5 class="text-orange pt-5">Best Deal</h5>
                        <p>Look for the sellers offering the product and compare price from different sellers.</p>
                        <h5 class="text-orange pt-5">Navigation</h5>
                        <p>Choose seller you want to purchase the product from and get the navigation details to reach to the shop.</p>
                    </div>
                </div>
            </div>
        </section>

        <!--pricing-->
        <section class="bg-alt" id="pricing">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-8 mx-auto text-center">
                        <h2 class="text-primary">Pricing</h2>
                        <p class="lead">
                            ROPO Shop services are absolutly free.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!--download-->
        <section class="bg-orange" id="download">
            <div class="container">
                <div class="row d-md-flex text-center wow fadeIn">
                    <div class="col-md-6 offset-md-3 col-sm-10 offset-sm-1 col-xs-12">
                        <h2 class="text-primary">Awailable to download soon</h2>
                        <p class="mt-4 lead">
                            ROPO Shop app for Android phones is under alpha testing and will be availabel soon for you. Stay tune for updates. 
                        </p>
                        <p class="mt-5">
                            <a href="#" class="mr-2"><img src="<?= $this->config->item('site_url').'assets/admin/img/google-play.png' ?>" class="store-img"/></a>
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!--contact-->
        <section class="bg-texture-collage p-0" id="contact">
            <div class="container">
                <div class="row d-md-flex text-white text-center wow fadeIn">
                    <div class="col-md-4 p-5">
                        <p><em class="material-icons dp36">phone</em></p>
                        <p class="lead">request by email</p>
                    </div>
                    <div class="col-md-4 p-5">
                        <p><em class="material-icons dp36">email</em></p>
                        <p class="lead">support@roposhop.com</p>
                    </div>
                    <div class="col-md-4 p-5">
                        <p><em class="material-icons dp36">location_on</em></p>
                        <p class="lead">Indore, India</p>
                    </div>
                </div>
            </div>
        </section>

        <!--footer-->
        <section class="bg-dark pt-5" id="connect">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-xs-12 text-center wow fadeIn">
                        <h2 class="hero-heading text-muted">ROPO Shop</h2>
                        <p class="mt-4">
                            <a href="https://twitter.com/" target="_blank"><em class="ion-social-twitter text-twitter-alt icon-sm mr-3"></em></a>
                            <a href="https://facebook.com/" target="_blank"><em class="ion-social-github text-facebook-alt icon-sm mr-3"></em></a>
                            <a href="https://www.linkedin.com/" target="_blank"><em class="ion-social-linkedin text-linkedin-alt icon-sm mr-3"></em></a>
                        </p>
                        <p class="pt-2 text-muted">
                            &copy; 2018 Ropo Shop
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.js"></script>
        <script src="<?= $this->config->item('site_url').'assets/admin/js/scripts.js' ?>"></script>
    </body>
</html>

<script>
function loadLogin(site_code) 
{
    if (site_code) 
    {
        if (site_code == 'admin')
        {
            //document.cookie = "site_code=admin; expires=null; path=/";
            window.location = "<?= 'admin.'.base_url() ?>";
        }
        else if (site_code == 'merchant')
        {
            //document.cookie = "site_code=seller; expires=null; path=/";
            window.location = "<?= 'seller.'.base_url('seller') ?>";
        }
    }
    else
    {
        alert("Error:Site code is not defined!");
        window.location = "<?= base_url('home') ?>";
    }
}
</script>
