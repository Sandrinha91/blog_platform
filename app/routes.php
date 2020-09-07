<?php


//defined routes

//user routes
$router->get('', 'PageController@home');
$router->get('homepage/{lang}', 'PageController@home');
$router->get('page/not/found', 'PageController@notFound');

$router->get('blog/{lang}/{page}', 'BlogController@blog');
$router->get('category/{lang}/{category_id}/{page}', 'BlogController@fromCategory');
$router->get('text/{lang}/{id}', 'BlogController@readText');

// Search routes 
//for user
//for all posts
$router->post('search/view/user/check/{lang}/{page}', 'SearchController@checkData');
$router->get('search/view/user/check/{lang}/{keyword}/{page}', 'SearchController@showPosts');

//for category search
$router->post('user/search/post/category/{lang}/{id}/{page}', 'SearchController@checkData');
$router->get('public/search/post/categories/{lang}/{id}/{keyword}/{page}', 'SearchController@showPosts');

// newsletter routes

$router->post('newsletter/{lang}', 'NewsletterController@checkData');
$router->get('confirmation/newsletter/{$selector}/{$token}/{$lang}', 'VerificationController@checkData');
$router->post('guest/send/email/{lang}', 'UserContactController@checkMsgData');
$router->get('unsuscribe/me/{$id}/{$selector}/{$token}/{$lang}', 'VerificationController@unsuscribeMe');
$router->get('resend/verify/token/{$id}/{$lang}/{$token}/{$selector}', 'VerificationController@ResendVerificationLink');

//forgor pass routes
$router->get('forgot/password', 'ForgotPasswordController@formView');
$router->get('password/forgot', 'ForgotPasswordController@formView');
$router->post('submit/email/recover', 'ForgotPasswordController@checkData');
$router->get('cant/rememberpwd/{$selector}/{$token}', 'ForgotPasswordController@enterNewPass');
$router->post('change/pwd/new', 'ForgotPasswordController@checkPass');


//admin panel routes

$router->get('homepage/login/admin', 'PageController@admin');
$router->get('logout/admin/blog/{value}', 'LogOutController@logout');

$router->post('admin/view/authorized', 'AdminValidationController@checkData');
$router->get('add/new/post/{bingo}', 'AuthController@returnView');
$router->get('new/post/added/{bingo}', 'AuthController@returnView');
$router->get('en/all/post/{username}/{page}', 'AuthController@returnView');
$router->get('read/all/newsletter/{username}/{page}', 'AuthController@returnView');
$router->get('email/delete/{username}/{id}', 'AuthController@returnView');

$router->get('erase/text/{bid}/{user}/{lang}', 'AdminPostController@deletePost');
$router->get('edit/post/{username}/{post_id}/{lang}', 'AuthController@returnView');
$router->get('finished/edit/post/{username}/{post_id}/{lang}', 'AuthController@returnView');

// Search routes 
//for admin
$router->post('categories/filter/{admin}/{page}', 'AdminPostController@postFilter');
$router->get('from/filter/{admin}/{lang}/{page}/{id}', 'AdminPostController@getPostFilter');
$router->post('check/text/{username}/{page}', 'SearchController@checkData');
$router->get('check/text/{username}/{language}/{search}/{page}', 'SearchController@showPosts');

// routes for for eddit and delete text
$router->post('plus/one/new/post/{username}', 'AddTextController@addNewText');
$router->post('update/article/{id}/{username}', 'AddTextController@editText');




