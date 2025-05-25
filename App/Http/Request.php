<?php

class Request
{
    protected array $server_info;

    protected array $payload;

    /**
     * Capture the raw initial request
     */
    public function capture()
    {
        $this->server_info = $_SERVER;
        $this->payload = self::getPayload();
    }

    /**
     * Choose correct payload according to the request
     */
    private function getPayload(): array
    {
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            return $_GET;
        }elseif($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SERVER['HTTP_CONTENT_TYPE']) && $_SERVER['HTTP_CONTENT_TYPE'] == 'application/json'){
            return static::getBody();
        }elseif($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SERVER['HTTP_CONTENT_TYPE']) && $_SERVER['HTTP_CONTENT_TYPE'] == 'application/x-www-form-urlencoded'){
            return $_POST;
        }else{
            return [];
        }
    }

    /**
     * Get all data from captured request
     */
    public function all(): array
    {
        return [
            'server_info' => $this->server_info,
            'payload' => $this->payload
        ];
    }

    /**
     * get raw body from php to parse into array when http request is from application json
     */
    public static function getBody(): array
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        return $data;
    }
}