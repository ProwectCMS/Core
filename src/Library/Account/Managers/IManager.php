<?php

namespace ProwectCMS\Core\Library\Account\Managers;

use Illuminate\Http\Request;
use ProwectCMS\Core\Library\Account\Credentials\ICredential;
use ProwectCMS\Core\Models\Account;

interface IManager
{
    public function getCreateValidationRules(): array;

    public function getUpdateValidationRules(): array;

    public function handleCreateRequest(Account $account, Request $request): ICredential;

    public function handleUpdateRequest(Request $request);

    public function handleDeleteRequest(Request $request);
}