<?php
/**
 * Created by PhpStorm.
 * User: kopa
 * Date: 2018/11/6
 * Time: 9:57 AM
 */
namespace app\services\basic;
class Utils
{

    static public function apiDisplay( $data ){
        echo json_encode($data,true);
        exit();
    }

    static public function jsonError( $code , $message ,$data = [] ){
        echo json_encode(
            ['status'  => $code,
                'message' => $message,
                'data'    => $data]
        );
        exit();
    }

    static public function jsonSuccess( $message ,$data = []){
        echo json_encode([
            'status'  => 0,
            'message' => $message,
            'data'    => $data
        ],true);
        exit();
    }


    static public function wxParseXml( $xml ){
        $xml_object = simplexml_load_string( $xml ,'SimpleXMLElement', LIBXML_NOCDATA);
        return json_decode(json_encode( $xml_object ),true);
    }


    static public function makeSign( $data ,$app_key){
        ksort($data);
        foreach($data as $key => $value){
            if(is_null($value)){
                unset($data[$key]);
                continue;
            }
            $fields_string.= $key."=".$value."&";
        }
        $stringSignTemp   = $fields_string."key=".$app_key;
        $sign = strtoupper(md5($stringSignTemp));
        return $sign;
    }
}