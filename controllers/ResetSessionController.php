<?php

/**
 * This controller is used only for reset the data from session when the testing come from of API
 */
class ResetSessionController
{

    /**
     * Reseting data
     */
    public function reset()
    {
        session_destroy();
        return response(200, "Content-Type: text/plain", "OK");
    }

}