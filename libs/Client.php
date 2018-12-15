<?php
/**
 * Created by PhpStorm.
 * User: EDZ
 * Date: 2018/12/14
 * Time: 17:32
 */

require_once __DIR__ . '/Http.php';

class Client
{
    //代表商家应用
    const BUINESS = 3;
    //代表插件后台
    const PLUGIN_BACK = 2;
    //代表插件小程序端
    const PLUGIN_APPLETS = 1;

    //开放平台client_id
    public $client_id = '';
    //开放平台client_secret
    public $client_secret = '';
    //小程序登录的唯一标识
    public $session_key = '';
    //开放平台用来换取access_token的标识
    public $code = '';
    //业务标识
    public $type = '';

    public $refresh_token = '';
    public $access_token = '';
    //获取access_token成功后的数组信息
    public $data = array();
    //获取access_token失败后的报错信息
    public $data_error = array();

    protected $businessAuthorize = "https://open.jisuapp.cn/OAuth2/BusinessAuthorize/";
    protected $toAccesstoken = "https://open.jisuapp.cn/OAuth2/token/";
    protected $pluginAppletsAuthorize = "https://open.jisuapp.cn/OAuth2/authorize/";

    public function __construct($client_id, $client_secret, $type = '', $session_key = '', $code = '')
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->session_key = $session_key;
        $this->type = $type;
        $this->code = $code;

        $this->codeToAccesstoken();
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function setSession_key($session_key)
    {
        $this->session_key = $session_key;
    }

    public function setRefresh_token($refresh_token)
    {
        $this->refresh_token = $refresh_token;
    }

    public function getData()
    {
        if (empty($this->data)) {
            $this->codeToAccesstoken();
        }
        return $this->data;
    }

    public function getDataError()
    {
        return $this->data_error;
    }

    /*
     * 商家应用获取code
     */
    public function buinessGetCode()
    {
        $postdata = array(
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
        );
        $queryparas = array();
        $header = array();
        $timeout = 5;

        $result = Http::curlPost($this->businessAuthorize, $queryparas, $postdata, $header, $timeout);

        if (isset($result['status_code']) && $result['status_code'] == 200 && !empty($result['body'])) {
            if (isset($result['body']['code'])) {
                $this->code = $result['body']['code'];
            } else {
                $this->data_error[] = $result['body'];
            }
        } else {
            $this->data_error[] = $result;
        }
    }

    /*
     * 插件小程序端获取code
     */
    public function pluginAppletsGetCode($session_key = '')
    {
        if (empty($session_key)) {
            $session_key = $this->session_key;
        }

        $postdata = array(
            'client_id' => $this->client_id,
            'session_key' => $session_key,
        );

        $queryparas = array();
        $header = array();
        $timeout = 5;

        $result = Http::curlPost($this->pluginAppletsAuthorize, $queryparas, $postdata, $header, $timeout);

        if (isset($result['status_code']) && $result['status_code'] == 200 && !empty($result['body'])) {
            if (isset($result['body']['code'])) {
                $this->code = $result['body']['code'];
            } else {
                $this->data_error[] = $result['body'];
            }
        } else {
            $this->data_error[] = $result;
        }
    }

    public function getCode()
    {
        switch ($this->type) {
            case self::BUINESS:
                $this->buinessGetCode();
                break;
            case self::PLUGIN_APPLETS:
                $this->pluginAppletsGetCode();
                break;
            default:
                $this->buinessGetCode();
                break;
        }
    }

    /*
     * code换取Accesstoken
     */
    public function codeToAccesstoken($code = '')
    {
        if (empty($code)) {
            if (empty($this->code)) {
                $this->getCode();
            }
            $code = $this->code;
        }

        $postdata = array(
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'code' => $code,
            'grant_type' => 'authorization_code',
            'scope' => 'basic',
        );
        $queryparas = array();
        $header = array();
        $timeout = 5;

        $result = Http::curlPost($this->toAccesstoken, $queryparas, $postdata, $header, $timeout);

        if (isset($result['status_code']) && $result['status_code'] == 200 && !empty($result['body'])) {
            if (isset($result['body']['access_token'])) {
                $this->access_token = $result['body']['access_token'];
                $this->refresh_token = isset($result['body']['refresh_token']) ? $result['body']['refresh_token'] : $this->refresh_token;
                $this->data = $result['body'];
            } else {
                $this->data_error[] = $result['body'];
            }
        } else {
            $this->data_error[] = $result;
        }

        return $this->access_token;
    }

    /*
     * refreshtoken刷新Accesstoken
     */
    public function refreshtokenToAccesstoken($refresh_token = '')
    {
        if (empty($refresh_token)) {
            $refresh_token = $this->refresh_token;
        }

        $postdata = array(
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'refresh_token' => $refresh_token,
            'grant_type' => 'refresh_token',
            'scope' => 'basic',
        );
        $queryparas = array();
        $header = array();
        $timeout = 5;

        $result = Http::curlPost($this->toAccesstoken, $queryparas, $postdata, $header, $timeout);

        if (isset($result['status_code']) && $result['status_code'] == 200 && !empty($result['body'])) {
            if (isset($result['body']['access_token'])) {
                $this->access_token = $result['body']['access_token'];
                $this->refresh_token = isset($result['body']['refresh_token']) ? $result['body']['refresh_token'] : $this->refresh_token;
                $this->data = $result['body'];
            } else {
                $this->data_error[] = $result['body'];
            }
        } else {
            $this->data_error[] = $result;
        }

        return $this->access_token;
    }
}


