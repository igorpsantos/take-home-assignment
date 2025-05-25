<?php

require_once './App/Services/AccountService.php';

class HandleEventController
{

    public AccountService $accountService;

    public function __construct()
    {
        $this->accountService = new AccountService();
    }

    /**
     * Handle type of events from API
     * */ 
    public function handleEvent(Request $request)
    {
        $data = $request->all();

        # Create account with initial balance and Deposit into existing accounts
        if(isset($data['payload']['type']) && $data['payload']['type'] == 'deposit'){
            $account = $this->accountService->deposit($data['payload']['destination'], $data['payload']['amount']);
            
            return response(201, 'Content-type: application/json', [
                "destination" => $account
            ]);
        }

        # withdraw from existing and non-existing accounts
        if(isset($data['payload']['type']) && $data['payload']['type'] == 'withdraw'){
            $account = $this->accountService->withdraw($data['payload']['origin'], $data['payload']['amount']);
            # Withdraw from non-existing account
            if(empty($account)){
                return response(404, 'Content-type: application/json', 0);
            }

            if($data['payload']['amount'] > $account['balance']){
                return response(403, 'Content-type: application/json', ["error" => "Insufficient balance"]);
            }

            return response(201, 'Content-type: application/json', [
                "origin" => $account
            ]);
        }

        # Transfer from existing and non-existing accounts
        if(isset($data['payload']['type']) && $data['payload']['type'] == 'transfer'){
            $data = $this->accountService->transfer($data['payload']['origin'], $data['payload']['destination'], $data['payload']['amount']);
            $accountOrigin = $data['origin'] ?? [];
            $accountDestination = $data['destination'] ?? [];
            # transfer from non-existing origin account
            if(empty($accountOrigin)){
                return response(404, 'Content-type: application/json', 0);
            }

            return response(201, 'Content-type: application/json', [
                "origin" => $accountOrigin,
                "destination" => $accountDestination
            ]);
        }

        # default return
        return response(404, 'Content-type: application/json', 0);
    }

}