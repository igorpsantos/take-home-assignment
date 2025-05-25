<?php

require_once './App/Repositories/AccountRepository.php';


/**
 * This Service implement some business logic that can be used on Handle Balance and Event Controllers
 */
class AccountService
{

    private AccountRepository $accountRepository;

    public function __construct()
    {
        $this->accountRepository = new AccountRepository();
    }

    public function balance(string $id): array
    {
        $account = $this->accountRepository->search($id);
        return $account;
    }

    public function deposit(string $id, int $amount): array
    {
        $account = $this->accountRepository->search($id);
        if(empty($account)){
            $account["id"] = $id;
            $account["balance"] = 0;
        }

        $account["balance"] += $amount;

        $this->accountRepository->save($id, $account);

        return $account;
    }

    public function withdraw(string $id, int $amount): array
    {
        $account = $this->accountRepository->search($id);
        if(empty($account)){
            return [];
        }

        $account["balance"] -= $amount;
        $this->accountRepository->save($id, $account);

        return $account;
    }

    public function transfer(string $origin_id, string $destination_id, int $amount): array
    {
        $accountOrigin = $this->accountRepository->search($origin_id);
        if(empty($accountOrigin)){
            return [];
        }

        $accountDestination = $this->accountRepository->search($destination_id);
        if(empty($accountDestination)){
            $accountDestination["id"] = $destination_id;
            $accountDestination["balance"] = 0;
        }

        $accountDestination["balance"] += $amount;
        $accountOrigin["balance"] -= $amount;

        # TODO
        # Is necessary implement a dynamic save stating of account
        $this->accountRepository->save($origin_id, $accountOrigin);
        $this->accountRepository->save($destination_id, $accountDestination);

        return ['origin' => $accountOrigin, 'destination' => $accountDestination];
    }

    public function reset()
    {
        $this->accountRepository->reset();
    }

}