<?php

require_once __DIR__ . '/Client.php';
require_once __DIR__ . '/Http.php';

class Api
{
    const URL = "https://open.jisuapp.cn";
    protected $businessGoodsListUrl = self::URL . "/business/Shop/goodsList";
    protected $pcGoodsListUrl = self::URL . "/pc/Shop/goodsList";
    protected $apiGoodsListUrl = self::URL . "/api/Goods/GetGoodsList";

    public $client;
    public $header = array(
        'Content-Type: application/x-www-form-urlencoded',
    );

    public function setAccesstoken($access_token)
    {
        if (empty($this->client)) {
            $this->client = new StdClass();
            $this->client->access_token = $access_token;
        }
    }

    /*
     *  $client_id 开放平台client_id
     *  $client_secret 开放平台client_secret
     *  $type 对应三种不用的业务  Client.php 里面有申明
     *  $session_key 小程序登录的唯一标识
     *  $code 开放平台用来换取access_token的标识
     */
    public function __construct($client_id = '', $client_secret = '', $type = '', $session_key = '', $code = '')
    {
        if (!empty($client_id) && !empty($client_secret)) {
            $this->client = new Client($client_id, $client_secret, $type, $session_key, $code);

            if (!empty($this->client->data_error)) {
                echo json_encode($this->client->data_error);
                exit;
            }
        }
    }

    /*
     *  商家应用的商品列表
     *    $parameter 参数
     *    详情参数请参考官方文档  http://doc.jisuapp.cn
     */
    public function businessGoodsList($parameter = array())
    {
        $postdata = array(
            'access_token' => $this->client->access_token,
        );
        if (!empty($parameter)) {
            $postdata = array_merge($postdata, $parameter);
        }

        $queryparas = array();
        $header = $this->header;
        $timeout = 5;

        $result = Http::curlPost($this->businessGoodsListUrl, $queryparas, $postdata, $header, $timeout);

        if (isset($result['status_code']) && $result['status_code'] == 200 && !empty($result['body'])) {
            return $result['body'];
        } else {
            return $result;
        }
    }

    /*
     *  插件小程序的商品列表
     *
     *     $parameter 参数
     *    详情参数请参考官方文档  http://doc.jisuapp.cn
     */
    public function apiGoodsList($parameter = array())
    {
        $postdata = array(
            'access_token' => $this->client->access_token,
        );
        if (!empty($parameter)) {
            $postdata = array_merge($postdata, $parameter);
        }

        $queryparas = array();
        $header = $this->header;
        $timeout = 5;

        $result = Http::curlPost($this->apiGoodsListUrl, $queryparas, $postdata, $header, $timeout);

        if (isset($result['status_code']) && $result['status_code'] == 200 && !empty($result['body'])) {
            return $result['body'];
        } else {
            return $result;
        }
    }

    /*
    *  插件后台的商品列表
     *    $parameter 参数
     *    详情参数请参考官方文档  http://doc.jisuapp.cn
    */
    public function pcGoodsList($parameter = array())
    {
        $postdata = array(
            'access_token' => $this->client->access_token,
        );
        if (!empty($parameter)) {
            $postdata = array_merge($postdata, $parameter);
        }

        $queryparas = array();
        $header = $this->header;
        $timeout = 5;

        $result = Http::curlPost($this->pcGoodsListUrl, $queryparas, $postdata, $header, $timeout);

        if (isset($result['status_code']) && $result['status_code'] == 200 && !empty($result['body'])) {
            return $result['body'];
        } else {
            return $result;
        }
    }


}