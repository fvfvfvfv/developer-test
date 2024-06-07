<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\StoreContactRequest;
use App\Http\Requests\Contact\UpdateContactRequest;
use App\Models\Account;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Contacts/Index', ['contacts' => Contact::with('account')->get()]);
    }

    public function show(Contact $contact): Response
    {
        return Inertia::render('Contacts/Show', ['contact' => $contact, 'account' => $contact->account]);
    }

    public function create(Request $request): Response
    {
        return Inertia::render('Contacts/Create', [
            'accounts' => Account::all(),
            'account_id' => (int) $request->query('account_id')]);
    }

    public function store(StoreContactRequest $request): RedirectResponse
    {
        $contact = Contact::create($request->validated());
        return redirect()->route('contacts.show', ['contact' => $contact]);
    }

    public function edit(Contact $contact): Response
    {
        return Inertia::render('Contacts/Edit', ['contact' => $contact, 'accounts' => Account::all()]);
    }

    public function update(Contact $contact, UpdateContactRequest $request): RedirectResponse
    {
        $contact->fill(array_filter($request->validated()))->save();
        return redirect()->route('contacts.show', ['contact' => $contact]);
    }

    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();
        return redirect()->route('contacts.index');
    }
}
