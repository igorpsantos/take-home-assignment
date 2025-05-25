<?php

/**
 * This a singleton class to avoid the test runner miss session when has a new request without session/cookie
 * When the PHP/PHPFPM process the request it will be stored in memory, but when the process finished the memory is freeable and we can't get this information
 * So, I've created a json file that can store a Account State
 */
class Account
{

    private static $instance;
    private static string $file = './storage/account-state.json';

    private function __construct()
    {

    }

    public static function getInstance()
    {
        if(!isset(self::$instance)){
            self::$instance = new self;
        }

        return self::$instance;
    }

    public static function get(string $account_id)
    {
        $accountState = json_decode(file_get_contents(self::$file), true);
        if(isset($accountState['id']) && $accountState['id'] == $account_id){
            return $accountState;
        }
        return [];
    }

    public static function set(string $account_id, array $account)
    {
        file_put_contents(self::$file, json_encode($account));
    }

    public static function reset()
    {
        file_put_contents(self::$file, json_encode([]));
    }

}