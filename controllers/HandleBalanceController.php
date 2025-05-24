<?php

/**
 * This controller is used to handle requests from method /balance of API
 */
class HandleBalanceController
{
    
    public function handleBalance(array $request)
    {

        /**
         * Trying to get account balance, if does not exist we return 0
         */

        try {
            if(!isset($request['payload']['account']) || !isset($_SESSION['account'][$request['payload']['account']])){
                throw new Exception("Error Processing Request", 1);                
            }

            return response(200, 'Content-Type: application/json', $account['balance']);
        } catch (\Throwable $th) {
            return response(404, 'Content-Type: application/json', 0);
        }
    }

}