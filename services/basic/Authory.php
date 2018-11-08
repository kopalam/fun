<?php

	namespace app\services\basic;
	use app\services\basic\Utils;
    use Yii;
	
	Class Authory{
	protected $token;

		public function __construct( $token=null ){
        $this->token = $token;
        }

        public function loggingVerify(){

            if( !$this->token )
                Utils::apiDisplay(["status" => 2,"message" => "用户未登录"]);

            $user  = Yii::$app->cache->get($this->token);

            if( !$this->token )
                Utils::apiDisplay(["status" => 2,"message" => "用户未登录"]);
        }

        public function checkToken($uid){
//		    exit(json_encode($this->token));
            if( !$this->token )
                Utils::apiDisplay(["status" => 2,"message" => "用户未登录3"]);

//            $redis = new UseRedis();
            $user  = Yii::$app->redis->get($this->token);

            if( !$user )
                Utils::apiDisplay(["status" => 2,"message" => "用户未登录"]);

            $user = json_decode($user,TRUE);
            if ($user['userId'] !== $uid)
                Utils::apiDisplay(["status" => 2,"message" => "非法登录"]);
        }

        public function getUid(){

            $user  =Yii::$app->cache->get($this->token);
            $user = json_decode($user,TRUE);
            return $user['userId'];
        }
		
	}