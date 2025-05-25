<?php

require_once './App/Services/AccountService.php';

/**
 * This controller is used to handle requests from method /balance of API
 */
class HandleBalanceController
{

    public AccountService $accountService;

    public function __construct()
    {
        $this->accountService = new AccountService();
    }
    
    public function handleBalance(Request $request)
    {

        /**
         * Trying to get account balance, if does not exist we return 0
         */

        $data = $request->all();
        try {
            if(!isset($data['payload']['account_id'])){
                throw new Exception("Error Processing Request", 1);            
            }

            $accountBalance = $this->accountService->balance($data['payload']['account_id']);
            if(empty($accountBalance)){
                throw new Exception("Error Processing Request", 1);
            }

            return response(200, 'Content-Type: application/json', $accountBalance["balance"]);
        } catch (\Throwable $th) {
            return response(404, 'Content-Type: application/json', 0);
        }
    }

}