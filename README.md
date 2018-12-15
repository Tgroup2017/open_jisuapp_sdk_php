#1.获取accesstoken

##商家应用
```php

require_once __DIR__ . '/libs/Api.php';

$type = Client::BUINESS;
$client_id = '9U3G9ScluO';
$client_secret = 'u99VY9D9Dv9zHupHWz49FUhqb4F4QBhP';
$client = new Client($client_id, $client_secret, $type);
var_dump($client->codeToAccesstoken());

```

##插件小程序
```php

require_once __DIR__ . '/libs/Api.php';

$client_id = 'GvR76Rp0R0';
$client_secret = 'W6k6v6WPSfsfmV3mnmB1Fmb1M6FCsNnb';
$session_key = "wx_webapp_session_key_1v4Y4z448g";
$type = Client::PLUGIN_APPLETS;
$client = new Client($client_id, $client_secret, $type, $session_key);

var_dump($client->codeToAccesstoken());

```

##插件后台
```php
require_once __DIR__ . '/libs/Api.php';

$client_id = 'GvR76Rp0R0';
$client_secret = 'W6k6v6WPSfsfmV3mnmB1Fmb1M6FCsNnb';
$code = '';
$type = Client::PLUGIN_BACK;
$client = new Client($client_id, $client_secret, $type, '', $code);
var_dump($client->codeToAccesstoken());


//或者
$client_id = 'GvR76Rp0R0';
$client_secret = 'W6k6v6WPSfsfmV3mnmB1Fmb1M6FCsNnb';
$code = '';
$type = Client::PLUGIN_BACK;
$client = new Client($client_id, $client_secret, $type);
$client->setCode($code);
var_dump($client->codeToAccesstoken());

```

#2.接口调用示例

```php

require_once __DIR__ . '/libs/Api.php';

//商家应用获取 Accesstoken
$type = Client::BUINESS;
$client_id = '9U3G9ScluO';
$client_secret = 'u99VY9D9Dv9zHupHWz49FUhqb4F4QBhP';
$client = new Client($client_id, $client_secret, $type);
$Accesstoken = $client->codeToAccesstoken();

//商家应用
$api = new Api();
$api->setAccesstoken($Accesstoken);
$result = $api->businessGoodsList();
echo json_encode($result);

//插件后台
$api = new Api();
$api->setAccesstoken($Accesstoken);
$result = $api->pcGoodsList();
echo json_encode($result);

//插件小程序
$api = new Api();
$api->setAccesstoken($Accesstoken);
$result = $api->apiGoodsList();
echo json_encode($result);

```