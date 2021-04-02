<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(strpos($_SERVER['HTTP_HOST'], 'admin') !== false || strpos($_SERVER['HTTP_HOST'], 'seller') !== false)
{
	$override_controller = "Admin_controller/Error404";
	$route['default_controller'] = "Admin_controller/dashboard";
}
else
{
	$override_controller = "User_controller/Error404";
	$route['default_controller'] = "User_controller";
}

$route['404_override'] = $override_controller;

$admin_controller = 'Admin_controller/';
$user_controller = 'User_controller/';
$v1_api_controller = 'V1_api_controller/';
$excel_controller = 'Excel_controller/';
$merchant_controller = 'Merchant_controller/';
$common_controller = 'Common_controller/';

//send mail
$route['sendMail'] = $common_controller.'sendMail';

//web url
$route['app'] = "Welcome";

//mail test function
$route['api/v1/sendMailTesting'] = $v1_api_controller.'sendMailTesting';

//VERSION:V1 API CONTROLLER ROUTES FOR CONSUMER APP
$route['api/v1/users/merchants/login'] = $v1_api_controller.'merchantLogin';
$route['api/v1/users/merchants/uploadProfilePic'] = $v1_api_controller.'uploadProfilePic';
$route['api/v1/users/merchants/signup'] = $v1_api_controller.'merchantSignup';
$route['api/v1/users/merchants/update'] = $v1_api_controller.'updateMerchant';
$route['api/v1/users/merchants/uploadBusinessProof'] = $v1_api_controller.'uploadBusinessProof';
$route['api/v1/users/merchants/uploadShopLogo'] = $v1_api_controller.'uploadShopLogo';
$route['api/v1/users/merchants/uploadShopImages'] = $v1_api_controller.'uploadShopImage';
$route['api/v1/users/merchants/deleteShopImage'] = $v1_api_controller.'deleteShopImage';
$route['api/v1/users/merchants/deleteLogo'] = $v1_api_controller.'deleteLogo';
$route['api/v1/users/merchants/address/delete'] = $v1_api_controller.'deleteAddress1';
$route['api/v1/users/merchants/changePassword'] = $v1_api_controller.'changeMerchantPassword';
$route['api/v1/users/merchants/resetPassword'] = $v1_api_controller.'resetMerchantPassword';
$route['api/v1/listings/(:num)/delete'] = $v1_api_controller.'deleteListingAPI/$1';
$route['api/v1/products/requested'] = $v1_api_controller.'getRequestedProduct';
$route['api/v1/products/requested/delete'] = $v1_api_controller.'deleteRequestedProduct';
$route['api/v1/categories/(:num)/specifications'] = $v1_api_controller.'getCategoryAttribtes/$1';
$route['api/v1/users/merchants/updateDefaultValues'] = $v1_api_controller.'updateMerchantDefaultValues';
$route['api/v1/users/merchants/address/addUpdate'] = $v1_api_controller.'addAddress';
$route['api/v1/merchants/listing/addUpdate'] = $v1_api_controller.'addListing';
//$route['api/v1/products/requested/add'] = $v1_api_controller.'addRequestedProduct';


//VERSION:V1 API CONTROLLER ROUTES FOR CONSUMER APP
$route['api/v1/apps/consumer/version'] = $v1_api_controller.'version';
$route['api/v1/brands/(:num)'] = $v1_api_controller.'brands/$1';
$route['api/v1/brands/(:num)/(:any)'] = $v1_api_controller.'brands/$1/$2';
$route['api/v1/brands'] = $v1_api_controller.'brands';
$route['api/v1/categories'] = $v1_api_controller.'categories';
$route['api/v1/categories/(:any)'] = $v1_api_controller.'categories/$1';
$route['api/v1/categories/(:any)/(:any)'] = $v1_api_controller.'categories/$1/$2';
$route['api/v1/listings'] = $v1_api_controller.'listings';
$route['api/v1/listings/(:num)'] = $v1_api_controller.'listings/$1';
$route['api/v1/listings/(:num)/(:any)'] = $v1_api_controller.'listings/$1/$2';
$route['api/v1/merchants'] = $v1_api_controller.'merchants';
$route['api/v1/merchants/(:num)/reviews/(:num)'] = $v1_api_controller.'addMerchantReview/$1/$2';
$route['api/v1/merchants/(:num)/(:any)'] = $v1_api_controller.'merchants/$1/$2';
$route['api/v1/merchants/(:any)'] = $v1_api_controller.'merchants/$1';
$route['api/v1/offers'] = $v1_api_controller.'offers';
$route['api/v1/offers/(:num)'] = $v1_api_controller.'offers/$1';
$route['api/v1/products'] = $v1_api_controller.'products';
$route['api/v1/products/(:num)/reviews/(:num)'] = $v1_api_controller.'addProductReview/$1/$2';
$route['api/v1/products/(:any)'] = $v1_api_controller.'products/$1';
$route['api/v1/products/(:num)/(:any)'] = $v1_api_controller.'products/$1/$2';
$route['api/v1/users/consumers/signup'] = $v1_api_controller.'addUser';
$route['api/v1/users/consumers/updateProfile'] = $v1_api_controller.'addUser';
$route['api/v1/users/consumers/login'] = $v1_api_controller.'login';
$route['api/v1/users/consumers/changePassword'] = $v1_api_controller.'changePassword';
$route['api/v1/users/consumers/resetPassword'] = $v1_api_controller.'resetPassword';
$route['api/v1/users/consumers/uploadProfilePic'] = $v1_api_controller.'uploadProfilePic';
$route['api/v1/search'] = $v1_api_controller.'search';
$route['api/v1/countries'] = $v1_api_controller.'country';
$route['api/v1/states'] = $v1_api_controller.'state';
$route['api/v1/cities'] = $v1_api_controller.'city';
$route['api/v1/areas'] = $v1_api_controller.'area';

//AJAX REQUEST
$route['states/(:num)'] = $admin_controller.'statesAJAX/$1';
$route['cities/(:num)'] = $admin_controller.'citiesAJAX/$1';

if(strpos($_SERVER['HTTP_HOST'], 'admin') !== false || strpos($_SERVER['HTTP_HOST'], 'seller') !== false)
{
	//ADMIN AND SELLER CONTROLLER ROUTES
	$route['admin'] = $admin_controller.'dashboard';
	$route['signout'] = $admin_controller.'logout';
	$route['login'] = $admin_controller.'login';
	$route['page/(:any)'] = $admin_controller.'pageLoad/$1';
	$route['dashboard'] = $admin_controller.'dashboard';
	$route['doLogin'] = $admin_controller.'doLogin';
	$route['addCategory'] = $admin_controller.'addCategory';
	$route['home'] = $admin_controller.'home';
	$route['insertProduct'] = $admin_controller.'insertProduct';
	$route['category'] = $admin_controller.'category';
	$route['changeParentCategory'] = $admin_controller.'changeParentCategory';
	$route['editProduct/(:num)/(:any)'] = $admin_controller.'editProduct/$1/$2';
	$route['editCategory/(:num)/(:any)'] = $admin_controller.'editCategory/$1/$2';
	$route['deleteCategory/(:num)'] = $admin_controller.'deleteCategory/$1';
	$route['brand'] = $admin_controller.'getBrands';
	$route['addBrand'] = $admin_controller.'addBrand';
	$route['addProduct'] = $admin_controller.'addProduct';
	$route['products'] = $admin_controller.'products';
	$route['editBrand/(:num)/(:any)'] = $admin_controller.'editBrand/$1/$2';
	$route['deleteBrand/(:num)'] = $admin_controller.'deleteBrand/$1';
	$route['addAttribute'] = $admin_controller.'addAttribute';
	$route['editAttribute/(:num)'] = $admin_controller.'editAttribute/$1';
	$route['deleteAttribute/(:num)'] = $admin_controller.'deleteAttribute/$1';
	$route['categoryAttributes/(:num)/(:num)'] = $admin_controller.'CategoryAttribtesAJAX/$1/$2';
	$route['productAttributesValue/(:num)'] = $admin_controller.'productAttributesValueAJAX/$1';
	$route['addProductVarient'] = $admin_controller.'addProductVarient';
	$route['sellers/(:any)'] = $admin_controller.'sellers/$1';
	$route['deleteProductVarientValue/(:num)/(:num)'] = $admin_controller.'deleteProductVarientValue/$1/$2';
	$route['addSeller'] = $admin_controller.'addSeller';
	$route['seller/(:num)/(:any)'] = $admin_controller.'seller/$1/$2';
	$route['changeSellerStatus/(:num)/(:num)/(:any)'] = $admin_controller.'changeSellerStatus/$1/$2/$3';
	$route['deleteAttactchment/(:any)/(:any)/(:num)'] = $admin_controller.'deleteAttactchment/$1/$2/$3';
	$route['deleteProduct/(:num)'] = $admin_controller.'deleteProduct/$1';
	$route['getAllProducts/(:num)'] = $admin_controller.'getProductsForLinking/$1';
	$route['getProductDetail/(:num)/(:num)/(:num)'] = $admin_controller.'getProductDetail/$1/$2/$3';
	$route['insertListingInfo'] = $admin_controller.'addListing';
	$route['deleteListing/(:num)/(:num)'] = $admin_controller.'deleteListing/$1/$2';
	$route['addCountry'] = $admin_controller.'addCountry';
	$route['editCountry/(:num)'] = $admin_controller.'editCountry/$1';
	$route['changeCountryStatus/(:num)/(:num)'] = $admin_controller.'changeCountryStatus/$1/$2';
	$route['changeStateStatus/(:num)/(:num)/(:num)'] = $admin_controller.'changeStateStatus/$1/$2/$3';
	$route['addState'] = $admin_controller.'addState';
	$route['addCity'] = $admin_controller.'addCity';
	$route['changeCityStatus/(:num)/(:num)/(:num)/(:num)'] = $admin_controller.'changeCityStatus/$1/$2/$3/$4';
	$route['addArea'] = $admin_controller.'addArea';
	$route['changeAreaStatus/(:num)/(:num)/(:num)/(:num)/(:num)'] = $admin_controller.'changeAreaStatus/$1/$2/$3/$4/$5';
	$route['addUser'] = $admin_controller.'addUser';
	$route['changeUserStatus/(:num)/(:num)'] = $admin_controller.'changeUserStatus/$1/$2';
	$route['deleteUser/(:num)'] = $admin_controller.'deleteUser/$1';
	$route['editUser/(:num)'] = $admin_controller.'editUser/$1';
	$route['select_merchant'] = $admin_controller.'select_merchant';
	$route['remove_merchant'] = $admin_controller.'remove_merchant';
	$route['addOffer'] = $admin_controller.'addOffer';
	$route['deleteOffer/(:num)'] = $admin_controller.'deleteOffer/$1';
	$route['editOffer/(:num)/(:any)'] = $admin_controller.'editOffer/$1/$2';
	$route['seller'] = $admin_controller.'dashboard';
	$route['signup'] = $admin_controller.'merchantSignUp';
	$route['addRequestedProduct'] = $admin_controller.'addRequestedProduct';
	$route['fillListingDetailOfRequestedProduct/(:num)'] = $admin_controller.'fillListingDetailOfRequestedProduct/$1';
	$route['addAddress'] = $admin_controller.'addAddress';
	$route['deleteAddress/(:num)/(:num)/(:num)'] = $admin_controller.'deleteAddress/$1/$2/$3';
	$route['deleteMerchant/(:num)'] = $admin_controller.'deleteMerchant/$1';
	$route['review/(:any)'] = $admin_controller.'review/$1';
	$route['deleteReview/(:num)/(:any)'] = $admin_controller.'deleteReview/$1/$2';
	$route['editReview/(:num)/(:any)'] = $admin_controller.'editReview/$1/$2';
	$route['addReview'] = $admin_controller.'addReview';
	$route['editRequestedProduct/(:num)'] = $admin_controller.'editRequestedProduct/$1';
	$route['deleteRequestProduct/(:num)'] = $admin_controller.'deleteRequestProduct/$1';
	$route['deleteFeature/(:num)/(:num)'] = $admin_controller.'deleteProductKeyFeature/$1/$2';
	$route['deleteSellerOffering/(:num)/(:num)'] = $admin_controller.'deleteSellerOffering/$1/$2';
	$route['addKeyFeature'] = $admin_controller.'addProductKeyFeature';
	$route['deleteLink/(:num)/(:num)/(:any)'] = $admin_controller.'deleteHTMLLink/$1/$2/$3';
	$route['viewReview/(:num)/(:any)'] = $admin_controller.'viewReview/$1/$2';
	$route['changeReviewStatus/(:num)/(:num)/(:any)'] = $admin_controller.'changeReviewStatus/$1/$2/$3';
	$route['deleteReview/(:num)/(:any)'] = $admin_controller.'deleteReview/$1/$2';
	$route['insertSellerDefaultValues'] = $admin_controller.'insertSellerDefaultValues';
	$route['addSellerOffering'] = $admin_controller.'addSellerOffering';
	$route['updateSiteSetting'] = $admin_controller.'updateSiteSetting';
	$route['viewRequest/(:num)'] = $admin_controller.'viewRequest/$1';
	$route['acceptRequest'] = $admin_controller.'acceptRequest';
	$route['deleteClaimedRequest/(:num)'] = $admin_controller.'deleteClaimedRequest/$1';

	//excel actions(routing)
	$route['addressExcel'] = $excel_controller.'loadAddressExcelPage';
	$route['merchantExcel'] = $excel_controller.'loadMerchantExcelPage';
	$route['productExcel'] = $excel_controller.'loadProductExcelPage';
	$route['listingExcel'] = $excel_controller.'loadListingExcelPage';
	$route['countryExcel'] = $excel_controller.'loadCountryExcelPage';
	$route['stateExcel'] = $excel_controller.'loadStateExcelPage';
	$route['cityExcel'] = $excel_controller.'loadCityExcelPage';
	$route['areaExcel'] = $excel_controller.'loadAreaExcelPage';

	$route['importAddressXls'] = $excel_controller.'importAddressXls';
	$route['importListingXls'] = $excel_controller.'importListingXls';
	$route['importCountryXls'] = $excel_controller.'importCountryXls';
	$route['importCityXls'] = $excel_controller.'importCityXls';

	$route['exportTemplateForAddress'] = $excel_controller.'exportTemplateForAddress';
	$route['exportTemplateForMerchant'] = $excel_controller.'exportTemplateForMerchant';
	$route['exportTemplateForProduct'] = $excel_controller.'exportTemplateForProduct';
	$route['exportTemplateForListing'] = $excel_controller.'exportTemplateForListing';
	$route['exportTemplateForCountry/(:num)'] = $excel_controller.'exportTemplateForCountry/$1';
	$route['exportTemplateForState/(:num)'] = $excel_controller.'exportTemplateForState/$1';
	$route['exportTemplateForCity/(:num)'] = $excel_controller.'exportTemplateForCity/$1';
	$route['generateSimpleXlsReport'] = $excel_controller.'generateSimpleXlsReport';

	//merchant actions(routing)
	$route['merchantLoginSignup'] = $merchant_controller.'loginSignupPage';
	$route['merchantSignupStep2/(:num)/(:num)'] = $merchant_controller.'merchantSignupStep2/$1/$2';
	$route['updateMerchant'] = $merchant_controller.'updateMerchant';
	$route['insertSeller'] = $merchant_controller.'insertSeller';
	$route['merchantLogin'] = $merchant_controller.'login';
	$route['verifyListing/(:num)/(:num)/(:num)'] = $merchant_controller.'verifyListing/$1/$2/$3';
}
else
{
	//USER CONTROLLER ROUTES
	$route['products'] = $user_controller.'product';
	$route['products/(:any)'] = $user_controller.'product_detail/$1';
	$route['categories/(:any)'] = $user_controller.'product/$1';
	$route['merchants'] = $user_controller.'merchants';
	$route['merchants/(:any)'] = $user_controller.'merchants';
	$route['listings/(:any)'] = $user_controller.'listing_detail';
	$route['location_setting'] = $user_controller.'location_setting';
	$route['listing_detail'] = $user_controller.'listing_detail';
	$route['insertUser'] = $user_controller.'insertUser';
	$route['login'] = $user_controller.'login_page';
	$route['userLogin'] = $user_controller.'userLogin';
	$route['userLogout'] = $user_controller.'userLogout';
	$route['userProfile'] = $user_controller.'userProfile';
	$route['brands'] = $user_controller.'brands';
	$route['brands/(:any)'] = $user_controller.'brands/$1';
	$route['addReview'] = $user_controller.'insertReview';
	$route['help_support'] = $user_controller.'help_support';
	$route['offer/(:any)'] = $user_controller.'offer';
	$route['search'] = $user_controller.'search';
	$route['privacypolicy'] = $user_controller.'privacypolicy';
	$route['claimBusiness'] = $user_controller.'claimBusiness';
}