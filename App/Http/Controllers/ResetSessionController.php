<?php

require_once './App/Services/AccountService.php';

/**
 * This controller is used only for reset the data from session when the testing come from of API
 */
class ResetSessionController
{

    public AccountService $accountService;

    public function __construct()
    {
        $this->accountService = new AccountService();
    }

    /**
     * Reseting data
     */
    public function reset()
    {
        $this->accountService->reset();
        return response(200, "Content-Type: text/plain", "OK");
    }

}