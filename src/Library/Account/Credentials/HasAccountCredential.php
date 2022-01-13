<?php

namespace ProwectCMS\Core\Library\Account\Credentials;

use ProwectCMS\Core\Models\AccountCredential;

trait HasAccountCredential
{
    protected ?AccountCredential $accountCredential;

    public function __construct(?AccountCredential $accountCredential = null)
    {
        $this->accountCredential = $accountCredential;
    }

    public function __call($name, $arguments)
    {
        return $this->accountCredential->$name(...$arguments);
    }

    public function __get($name)
    {
        return $this->accountCredential->{$name};
    }

    public function __set($name, $value)
    {
        $this->accountCredential->{$name} = $value;
    }
}