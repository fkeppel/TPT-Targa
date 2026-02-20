<?php
class comController extends BaseController
{
private    function curl($url, $cookie = false, $post = false, $header = false, $follow_location = false, $referer=false,$proxy=false)
    {
        $proxy = 'http://10.254.0.1';
        $proxy_port = 8080;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
        curl_setopt($ch, CURLOPT_PROXYPORT, $proxy_port);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
        curl_setopt($ch,CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_REFERER, $referer);
        curl_setopt($ch, CURLOPT_HEADER, $header);
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $follow_location);
        if ($cookie) {
            curl_setopt ($ch, CURLOPT_COOKIE, $cookie);
        }
        if ($post) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        $response = curl_exec ($ch);
        if($response === false){
            echo 'Curl error: ' . curl_error($ch);
            exit;
        }
        return $response;
    }
    public function sendData(){
        $pps = tPPProduktpass::where('PPProduktpass_IAN', 'not like', '%rev%')->where('InternerStatus', 'FIX')->get();#
        foreach($pps as $pp){
            $order = $pp->PPProduktpass_IAN.'_'.substr($pp->PPProduktpass_Ausmusterungnummer,0,4);
            $partnerId = substr($pp->PPProduktpass_Ausmusterungnummer,0,4);
            $values[$order]['orders_orderno'] = $order;
            $values[$order]['orders_description'] = $pp->PPProduktpass_Artikelbezeichnung;
            $values[$order]['orders_remark'] = 'T';
            $values[$order]['orders_partners_Id'] = $partnerId;
            $values[$order]['orders_internalState'] = $pp->InternerStatus;
        }
        $auth = array('uname' => 'Frank', 'upasswd' => 'Keppel', 'type' => 'order', 'values' =>json_encode($values) );
        $response = $this->curl('http://xtarga.de/receiveData', false, $auth);
        echo(json_decode($response));
    }
}
