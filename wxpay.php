<?php
/**
 * User: Sober
 * Date: 2019/4/1
 * Time: 11:39
 */
namespace wepay;
class WePay {

    private $mchId = '1497120092';//商户号
    private $key = 'd78cd2c1294eaeef3a30d8c243513caf';//商户秘钥

    /**
     * @param $args
     * @return bool|mixed|null
     * 统一下单
     * 'body' => '商品描述',
     * 'out_trade_no' => '用户订单号',
     * 'total_fee' => '总价',
     * 'notify_url' => '回调地址',
     * 'trade_type' => 'JSAPI',
     * 'openid' => '用户id',
     *
     */
    public function unifiedOrder($args)
    {
        $args['appid'] = 'wxd3ef73e2d8eeb9fc';
        $args['mch_id'] = $this->mchId;
        $args['nonce_str'] = md5(uniqid());
        $args['sign_type'] = 'MD5';
        $args['spbill_create_ip'] = '127.0.0.1';
        $args['sign'] = $this->makeSign($args);
        $xml = $this->arrayToXml($args);
        $api = "https://api.mch.weixin.qq.com/pay/unifiedorder";
        $result=$this->Curl($api, $xml);
        if (!$result)
            return false;
        return $this->xmlToArray($result);
    }

    /**
     * @param $order_no
     * @return bool
     * 查询订单
     *
     * 'order_no'=>订单号
     *
     */
    public function orderQuery($order_no)
    {
        $data = [
            'appid' => $this->WeChat->appId,
            'mch_id' => $this->WeChat->MchId,
            'out_trade_no' => $order_no,
            'nonce_str' => md5(uniqid()),
        ];
        $data['sign'] = $this->makeSign($data);
        $xml = $this->arrayToXml($data);
        $api = "https://api.mch.weixin.qq.com/pay/orderquery";
        $result=$this->WeChat->Curl($api, $xml);
        if (!$result)
            return false;
        return $this->xmlToArray($result);
    }

    /**
     * @param $args
     * @return bool|mixed|null
     *
     * 退款申请
     *
     * 'out_trade_no' => '商户订单号，最大长度32',
     *
     * 'out_refund_no' => '商户退款单号，最大长度32',
     *
     * 'total_fee' => '订单总金额，单位为分',
     *
     * 'refund_fee' => '退款总金额，单位为分',
     */
    public function refund($args)
    {
        $args['appid'] = $this->WeChat->appId;
        $args['mch_id'] = $this->WeChat->MchId;
        $args['nonce_str'] = md5(uniqid());
        $args['op_user_id'] = $this->WeChat->MchId;
        $args['sign'] = $this->makeSign($args);
        $xml = $this->arrayToXml($args);
        $api = 'https://api.mch.weixin.qq.com/secapi/pay/refund';
        $result=$this->WeChat->Curl($api, $xml,true);
        if (!$result)
            return false;
        return $this->xmlToArray($result);
    }
    /**
     *
     * @param $args
     * @return bool
     * 企业付款
     *
     */
    public function transfers($args)
    {
        $args['mch_appid'] = $this->WeChat->appId;
        $args['mchid'] = $this->WeChat->MchId;
        $args['nonce_str'] = md5(uniqid());
        $args['check_name'] = 'NO_CHECK';
        $args['spbill_create_ip'] = '127.0.0.1';
        $args['sign'] = $this->makeSign($args);
        $xml = $this->arrayToXml($args);
        $api = "https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers";
        $result=$this->WeChat->Curl($api, $xml,true);
        if (!$result)
            return false;
        return $this->xmlToArray($result);
    }
    /**
     * @param $args
     * @return string
     * MD5签名
     */
    public function makeSign($args)
    {

        if (isset($args['sign']))
            unset($args['sign']);

        ksort($args);
        foreach ($args as $i => $arg) {
            if ($args === null || $arg === '')
                unset($args[$i]);
        }
        $string = $this->arrayToUrlParam($args, false);
        $string = $string . "&key=".$this->key;
        $string = md5($string);
        $result = strtoupper($string);
        return $result;
    }

    /***
     * @param $url
     * @param string $data
     * @param bool $Cert
     * @param int $expires
     * @return mixed|string
     * 请求
     */
    public function Curl($url , $data='', $Cert = false, $expires = 30)
    {


        $ch = curl_init();

        curl_setopt($ch, CURLOPT_TIMEOUT, $expires);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);//严格校验
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        if ($Cert == true) {
            //设置证书
            //使用证书：cert 与 key 分别属于两个.pem文件
            curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
            curl_setopt($ch, CURLOPT_SSLCERT, $this->cert_pem_file);
            curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
            curl_setopt($ch, CURLOPT_SSLKEY, $this->key_pem_file);
        }
        //post提交方式
        if($data){
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        //运行curl
        $data = curl_exec($ch);

        curl_close($ch);
        //返回结果
        if ($data) {

            return $data;
        }

    }



    public static function arrayToXml($array)
    {
        if (!is_array($array) || count($array) <= 0)
            return null;
        $xml = "<xml>\r\n";
        $xml .= self::arrayToXmlSub($array);
        $xml .= "</xml>";
        return $xml;
    }

    private static function arrayToXmlSub($array)
    {
        if (!is_array($array) || count($array) <= 0)
            return null;
        $xml = "";
        foreach ($array as $key => $val) {
            if (is_array($val)) {
                if (is_numeric($key))
                    $xml .= self::arrayToXmlSub($val);
                else
                    $xml .= "<" . $key . ">" . self::arrayToXmlSub($val) . "</" . $key . ">\r\n";
            } elseif (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">\r\n";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">\r\n";
            }
        }
        return $xml;
    }

    public static function xmlToArray($xml)
    {
        try {
            if (!$xml) {
                return null;
            }
            //将XML转为array
            //禁止引用外部xml实体
            libxml_disable_entity_loader(true);
            @ $res = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
            return $res;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function arrayToUrlParam($array, $url_encode = true)
    {
        $url_param = "";
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $list_url_param = "";
                foreach ($value as $list_key => $list_value) {
                    if (!is_array($list_value))
                        $url_param .= $key . "[" . $list_key . "]=" . ($url_encode ? urlencode($list_value) : $list_value) . "&";
                }
                $url_param .= trim($list_url_param, "&") . "&";
            } else {
                $url_param .= $key . "=" . ($url_encode ? urlencode($value) : $value) . "&";
            }
        }
        return trim($url_param, "&");
    }
}
