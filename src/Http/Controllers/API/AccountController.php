<?php

namespace ProwectCMS\Core\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use ProwectCMS\Core\Aggregates\Account\AccountAggregate;
use ProwectCMS\Core\Models\Account;
use Ramsey\Uuid\Uuid;

class AccountController extends Controller
{
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

        // $uuid = Uuid::uuid4();
        // $accountAggregate = AccountAggregate::retrieve($uuid);
        // $accountAggregate->create($attributes)->persist();
        // $account = Account::find($uuid);

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

    public function destroy()
    {
        // TODO:
    }
}