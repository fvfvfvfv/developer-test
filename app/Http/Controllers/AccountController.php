<?php

namespace App\Http\Controllers;

use App\Http\Requests\Account\StoreAccountRequest;
use App\Http\Requests\Account\UpdateAccountRequest;
use App\Models\Account;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class AccountController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Accounts/Index', [
            'accounts' => Account::all()
        ]);
    }

    public function show(Account $account): Response
    {
        return Inertia::render('Accounts/Show', [
            'account' => $account,
            'owner' => $account->owner,
            'contacts' => $account->contacts
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Accounts/Create', ['users' => User::all()]);
    }

    public function store(StoreAccountRequest $request): RedirectResponse
    {
        $account = Account::create($request->validated());
        return redirect()->route('accounts.show', $account);
    }

    public function edit(Account $account): Response
    {
        return Inertia::render('Accounts/Edit',
            [
                'account' => $account,
                'users' => User::all()
            ]
        );
    }

    public function update(Account $account, UpdateAccountRequest $request): RedirectResponse
    {
        $account->fill(array_filter($request->validated()))->save();
        return redirect()->route('accounts.show', $account);
    }

    public function destroy(Account $account): RedirectResponse
    {
        $account->delete();
        return redirect()->route('accounts.index');
    }
}
