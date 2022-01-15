<?php

namespace ProwectCMS\Core\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use ProwectCMS\Core\Aggregates\Account\AccountAggregate;
use ProwectCMS\Core\Commands\Account\UpdateAccount;
use ProwectCMS\Core\Models\Account;
use Ramsey\Uuid\Uuid;
use Spatie\EventSourcing\Commands\CommandBus;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:prowectcms_api')->except([
            'store'
        ]);
    }

    public function index(Request $request)
    {
        $this->authorize('list', Account::class);

        $this->validate($request, [
           'limit' => 'integer|min:1|max:200'
        ]);

        $limit = $request->input('limit', 25);

        $query = Account::query();

        $accounts = $query->paginate($limit);

        return response()->json($accounts);
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

    public function show(Account $account)
    {
        $this->authorize('show', $account);

        return response()->json($account);
    }

    public function update(Account $account, Request $request, CommandBus $commandBus)
    {
        $this->authorize('update', $account);

        $this->validate($request, [
            'type' => [
                Rule::in(Account::getAvailableTypes()) // TODO: Account type cannot be changed?
            ],

            'meta' => [
                'array'
            ]
        ]);

        $updatableAttributes = ['type', 'meta'];

        $attributes = [];
        foreach ($updatableAttributes as $updatableAttribute) {
            if ($request->has($updatableAttribute)) {
                $attributes[$updatableAttribute] = $request->input($updatableAttribute);
            }
        }

        $commandBus->dispatch(new UpdateAccount($account->id, $attributes));

        return response()->json([
            'status' => 'ok',
            'key' => 'account.update.success',
            'message' => 'Account has successfully been updated'
        ]);
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