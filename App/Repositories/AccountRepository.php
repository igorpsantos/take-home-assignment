<?php

require_once './App/Models/Account.php';

/**
 * This repository is used on Account State Static false flow, it's seem like a repository that can be used when this app has a database/persistence system
 */
class AccountRepository
{
    private $account;

    public function __construct()
    {
        $this->account = Account::getInstance();
    }

    public function search(string $id)
    {
        return $this->account->get($id);
    }

    public function save(string $account_id, array $account)
    {
        $this->account->set($account_id, $account);
    }

    public function reset()
    {
        $this->account->reset();
    }
}