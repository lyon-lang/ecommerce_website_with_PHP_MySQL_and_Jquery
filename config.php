<?php
define('BASEURL', $_SERVER['DOCUMENT_ROOT'].'/online-mall/');
define('CART_COOKIE', 'SBwi72Uklwiqzz2');
define('CART_COOKIE_EXPIRE', time() + (86400 *30));
define('TAXRATE',0.00);//sales tax rate. set to 0 if you aren't charging tax


#below is payment configration process but tutorial used stripe which does not work in Ghana
#define('CURRENCY', 'usd');
#define('CHECKOUTMODE', 'TEST')//Dont forget to change the TEST to LIVE when you are ready to go LIVE

#if(CHECKOUTMODE == 'TEST'){
#    define('STRIPE_PRIVATE', '');
#    define('STRIPE_PUBLIC', '');
#}

#if(CHECKOUTMODE == 'LIVE'){
#    define('STRIPE_PRIVATE', '');
#    define('STRIPE_PUBLIC', '');
#}