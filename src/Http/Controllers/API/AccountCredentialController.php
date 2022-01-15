<?php

namespace ProwectCMS\Core\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use ProwectCMS\Core\Aggregates\Account\AccountCredentialAggregate;
use ProwectCMS\Core\Library\Account\AccountCredentialFactory;
use ProwectCMS\Core\Models\Account;
use ProwectCMS\Core\Models\AccountCredential;

class AccountCredentialController extends Controller
{
    public function index()
    {
        // TODO:
    }

    public function store(Account $account, $type, Request $request)
    {
        $this->validateType($type);

        $this->authorize('store', AccountCredential::class);
        $this->authorize('storeCredential', $account);

        $accountCredentialManager = $this->getAccountCredential($type)->getManager();


        $this->validate($request, $accountCredentialManager->getCreateValidationRules());

        $accountCredential = $accountCredentialManager->handleCreateRequest($account, $request);

        return response()->json([
            'status' => 'ok',
            'key' => 'account.credential.create.success',
            'message' => 'Account credentials have successfully been created.',

            'account_credentials' => $accountCredential->toArray()
        ]);
    }

    public function update(Account $account, $type, AccountCredential $credential, Request $request)
    {
        $this->validateType($type);
        
        $this->authorize('update', $credential);
        // TODO: Validate Account Credential -> Account

        $accountCredential = $this->getAccountCredential($type, $credential);
        $accountCredentialManager = $accountCredential->getManager();

        $this->validate($request, $accountCredentialManager->getUpdateValidationRules());

        $accountCredentialManager->handleUpdateRequest($request);

        return response()->json([
            'status' => 'ok',
            'key' => 'account.credential.update.success',
            'message' => 'Account credentials have successfully been updated.',

            'account_credentials' => $credential->toArray()
        ]);
    }

    public function show(Account $account)
    {
        // TODO:
    }

    public function destroy(Account $account, $type, AccountCredential $credential, Request $request)
    {
        $this->validateType($type);

        $this->authorize('delete', $credential);
        
        // TODO: Validate AccountCredential -> Account
        
        $accountCredentialManager = $this->getAccountCredential($type, $credential)->getManager();
        $accountCredentialManager->handleDeleteRequest($request);

        return response()->json([
            'status' => 'ok',
            'key' => 'account.credential.delete.success',
            'message' => 'Account credentials have successfully been deleted.'
        ]);
    }

    protected function validateType(string $type)
    {
        $accountCredentialFactory = App::make(AccountCredentialFactory::class);

        $validator = Validator::make([
            'type' => strtoupper($type)
        ], [
            'type' => ['required', 'filled', Rule::in($accountCredentialFactory->getAvailableNames())]
        ]);

        return $validator->validate();
    }

    protected function getAccountCredential($type, AccountCredential $credential = null)
    {
        return App::make(AccountCredentialFactory::class)->create(strtoupper($type), $credential);
    }
}