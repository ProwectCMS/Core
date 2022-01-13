<?php

namespace ProwectCMS\Core\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use ProwectCMS\Core\Aggregates\Account\AccountAggregate;
use ProwectCMS\Core\Models\Account;
use Ramsey\Uuid\Uuid;

class AccountController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:prowectcms_api')->except([
        //     'store'
        // ]);
    }

    public function index()
    {
        // TODO:
    }

    public function store(Request $request)
    {
        $this->authorize('store', Account::class);

        $this->validate($request, [
            'type' => [
                Rule::in(Account::getAvailableTypes())
            ],

            'meta' => [
                'array'
            ]
        ]);

        $type = $request->input('type', Account::TYPE_GUEST);
        $meta = $request->input('meta', []);

        $attributes = [
            'type' => $type,
            'meta' => $meta
        ];

        $account = Account::createWithAttributes($attributes);

        return response()->json([
            'status' => 'ok',
            'key' => 'account.create.success',
            'message' => 'Account has successfully been created',

            'account' => $account
        ]);
    }

    public function show()
    {
        // TODO:
    }

    public function update()
    {
        // TODO:
    }

    public function destroy(Account $account)
    {        
        $this->authorize('delete', $account);

        AccountAggregate::retrieve($account->id)
            ->delete()
            ->persist();

        return response()->json([
            'status' => 'ok',
            'key' => 'account.delete.success',
            'message' => 'Account has successfully been deleted'
        ]);
    }
}