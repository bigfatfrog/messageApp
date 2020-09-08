<?php


namespace App\Services;


use Predis\Client;

class PredisService
{

    private static $redisClient;

    public static function client(){
        if(!isset(self::$redisClient)){
            self::$redisClient = new Client();
        }
        return self::$redisClient;
    }

    public function set($key, $value)
    {
        self::client()->set($key, $value);
    }

    public function get($key)
    {
        $value = self::client()->get($key);
        return $value;
    }
}
