<?php

/**
 * This controller is used to handle requests from method /balance of API
 */
class HandleBalanceController
{
    
    public function handleBalance(Request $request)
    {

        /**
         * Trying to get account balance, if does not exist we return 0
         */

        $data = $request->all();
        try {
            if(!isset($data['payload']['account_id']) || !isset($_SESSION['account'][$data['payload']['account_id']])){
                throw new Exception("Error Processing Request", 1);                
            }

            return response(200, 'Content-Type: application/json', $_SESSION['account'][$data['payload']['account_id']]['balance']);
        } catch (\Throwable $th) {
            return response(404, 'Content-Type: application/json', 0);
        }
    }

}