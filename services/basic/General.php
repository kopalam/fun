<?php
/**
 * Created by PhpStorm.
 * User: kopa
 * Date: 2018/11/6
 * Time: 3:20 PM
 * Content:通用API接口管理
 */
namespace app\services\basic;
use app\models\SiteSet;
use app\models\WechatSet;
use Yii;
use yii\db\Exception;

Class   General{

    function __construct()
    {
        $this->model = trim('app\models\ ');
    }

    /*
     * @table 'Auth...'
     * 状态处理，status = 0/1
     * */
    public function disableStatus($table,$id){
        $model  =   $this->model.$table;
        $result     =   $model::findOne($id);
        $check  =   is_object($result) ? 0 : 1;
        $result->status     =   $result->status == 0 ? 1: 0;
        if($result->save() == false)
            throw new \Exception('更新状态失败',30001);

        return true;
    }
    /*
     *删除用户
     * */
    function deleteGeneral($table,$id)
    {
        $model  =   $this->model.$table;
        $reslut     =   $model::find()->where(['id'=>$id])->one();
        $reslut->delete();

        return true;
    }

    /*
     * 网站基本设置
     * 通过findOne查找出网站设置信息，如果无则创建，有则修改
     * */
    public function site($data){
        $result   =   SiteSet::findOne(['id'=>0]);
        if($result==null)
        {
            $res    =   new SiteSet();
            $res->site_title    =   $data['site_title'];
            $res->site_logo     =   $data['site_logo'];
            $res->site_description  =   $data['site_description'];
            $res->site_icp  =   $data['site_icp'];
            $res->site_keyword  =   $data['site_keyword'];
            $res->telephone     =   $data['telephone'];
            if($res->insert()==false)
                throw new Exception('网站设置失败',30003);
        }else{
            $result->site_title    =   $data['site_title'];
            $result->site_logo     =   $data['site_logo'];
            $result->site_description  =   $data['site_description'];
            $result->site_icp  =   $data['site_icp'];
            $result->site_keyword  =   $data['site_keyword'];
            $result->telephone     =   $data['telephone'];
            $result->copyright_all  =   $data['copyright_all'];
            $result->save($data);
        }
        return $res;
    }

    /*
     * 微信公众号基本设置
     * */
    public function wechatSet($data,$uid){
        $result     =   WechatSet::findOne(['wechat_id'=>$data['wechat_id']]);
        if(!$result){
            //如果不存在，则新建
            $wechat     =   new WechatSet();
            $wechat->wechat_account     =    $data['wechat_account'];
            $wechat->wechat_id     =   $data['wechat_id'];
            $wechat->wechat_rank    =   $data['wechat_rank'];
            $wechat->wechat_appid   =   $data['wechat_appid'];
            $wechat->wechat_secret  =   $data['wedchat_secret'];
            $wechat->wechat_token   =   $data['wechat_token'];
            $wechat->wechat_encoding    =   $data['wechat_encoding'];
            $wechat->wechat_qrcode  =   $data['wechat_qrcode'];
            $wechat->uid    =   $uid;
            if($wechat->insert()==false)
                throw new Exception('微信设置失败',30004);
        }else{
            $result->wechat_account     =    $data['wechat_account'];
            $result->wechat_id     =   $data['wechat_id'];
            $result->wechat_rank    =   $data['wechat_rank'];
            $result->wechat_appid   =   $data['wechat_appid'];
            $result->wechat_secret  =   $data['wedchat_secret'];
            $result->wechat_token   =   $data['wechat_token'];
            $result->wechat_encoding    =   $data['wechat_encoding'];
            $result->wechat_qrcode  =   $data['wechat_qrcode'];
            $result->uid    =   $uid;
            $result->save();
        }
        return true;
    }

    /*
     * 获取网站设置相关内容
     * */
    function getSiteData(){
        $result   =   SiteSet::find()->where(['id'=>0])->asArray()->one();
        if(!$result)
            return false; //不存在就什么都不做

        unset($result['visit_code']);
        unset($result['baidu_push']);
        return $result;
    }

    /*
     * 获取微信设置相关内容
     * */
    function getWechatData($uid){
        $result   =   WechatSet::find()->where(['uid'=>$uid])->asArray()->one();
        if(!$result)
            return false; //不存在就什么都不做

        return $result;
    }

}