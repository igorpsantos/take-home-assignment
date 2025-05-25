<?php

class HandleEventController
{
    /**
     * Handle type of events from API
     * */ 
    public function handleEvent(Request $request)
    {
        $data = $request->all();

        # Create account with initial balance and Deposit into existing accounts
        if(isset($data['payload']['type']) && $data['payload']['type'] == 'deposit'){
            $account = isset($_SESSION['account'][$data['payload']['destination']]) ? $_SESSION['account'][$data['payload']['destination']] : [];
            if(empty($account)){
                $account["id"] = $data['payload']['destination'];
                $account["balance"] = 0;
            }
            $account["balance"] += $data['payload']['amount'];

            # share account in the life cycle of app
            $_SESSION['account'][$data['payload']['destination']] = $account;

            return response(201, 'Content-type: application/json', [
                "destination" => $account
            ]);
        }

        # withdraw from existing and non-existing accounts
        if(isset($data['payload']['type']) && $data['payload']['type'] == 'withdraw'){
            $account = isset($_SESSION['account'][$data['payload']['origin']]) ? $_SESSION['account'][$data['payload']['origin']] : [];
            # Withdraw from non-existing account
            if(empty($account)){
                return response(404, 'Content-type: application/json', 0);
            }

            if($data['payload']['amount'] > $account['balance']){
                return response(403, 'Content-type: application/json', ["error" => "Insufficient balance"]);
            }

            # Withdraw from existing account
            $account["balance"] -= $data['payload']['amount'];

            # share account in the life cycle of app
            $_SESSION['account'][$data['payload']['origin']] = $account;

            return response(201, 'Content-type: application/json', [
                "origin" => $account
            ]);
        }

        # Transfer from existing and non-existing accounts
        if(isset($data['payload']['type']) && $data['payload']['type'] == 'transfer'){
            $accountOrigin = isset($_SESSION['account'][$data['payload']['origin']]) ? $_SESSION['account'][$data['payload']['origin']] : [];
            # transfer from non-existing origin account
            if(empty($accountOrigin)){
                return response(404, 'Content-type: application/json', 0);
            }

            $accountDestination = isset($_SESSION['account'][$data['payload']['destination']]) ? $_SESSION['account'][$data['payload']['destination']] : [];
            if(empty($accountDestination)){
                $accountDestination["id"] = $data['payload']['destination'];
                $accountDestination["balance"] = 0;
            }

            # transfer amount to destination account
            $accountDestination["balance"] += $data['payload']['amount'];

            # update balance on origin account
            $accountOrigin["balance"] -= $data['payload']['amount'];

            # share account in the life cycle of app
            $_SESSION['account'][$data['payload']['origin']] = $accountOrigin;
            $_SESSION['account'][$data['payload']['destination']] = $accountDestination;

            return response(201, 'Content-type: application/json', [
                "origin" => $accountOrigin,
                "destination" => $accountDestination
            ]);
        }
    }

}