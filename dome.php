<?php
/**
 * Created by PhpStorm.
 * User: EDZ
 * Date: 2018/12/15
 * Time: 10:11
 */

/*
 * 以下为domo里面 client_id和client_secret是自己创建的商家应用的秘钥信息
 *  利用client_id和client_secret可以进行测试
 *
 *  如果想接着开发可以继承api.php实现不同的接口
 *   也可以基于client.php的授权认证重写api.php
 */

require_once __DIR__ . '/libs/Api.php';

//1.商家应用  获取商品列表

//商家应用 client_id  client_secret
$client_id = '9U3G9ScluO';
$client_secret = 'u99VY9D9Dv9zHupHWz49FUhqb4F4QBhP';
$type = Client::BUINESS;
$api = new Api($client_id, $client_secret, $type);
$result = $api->businessGoodsList();
echo json_encode($result);
exit;

//2.插件小程序端  获取商品列表

//插件 client_id  client_secret
$client_id = 'GvR76Rp0R0';
$client_secret = 'W6k6v6WPSfsfmV3mnmB1Fmb1M6FCsNnb';
//小程序登录的标识  在管理后台打包小程序解压用微信开发者工具打开
//查看任意需要登录的接口 获取请求参数登录标识 session_key
$session_key = "wx_webapp_session_key_LLHC12oOo9";
$type = Client::PLUGIN_APPLETS;
$api = new Api($client_id, $client_secret, $type, $session_key);
$result = $api->apiGoodsList();
echo json_encode($result);
//exit;


//3.插件后台  获取商品列表

//插件 client_id  client_secret
$client_id = 'GvR76Rp0R0';
$client_secret = 'W6k6v6WPSfsfmV3mnmB1Fmb1M6FCsNnb';
$type = Client::PLUGIN_BACK;
//管理后台在点击我的插件里面->进入管理后台  跳转会在你填写的插件后台地址跟上?code=$code
$code = '';
$api = new Api($client_id, $client_secret, $type, $session_key, $code);
$result = $api->pcGoodsList();
echo json_encode($result);