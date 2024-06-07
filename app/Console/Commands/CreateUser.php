<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-user {name?} {email?} {password?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a user in the CRM';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');

        if (!$name) {
            $name = $this->ask('Name: ');
        }

        if (!$email) {
            $email = $this->ask('Email: ');
        }

        if (!$password) {
            $password = $this->ask('Password: ');
        }

        if (strlen($name) > 255 || strlen($email) > 255) {
            $this->error('Name and email have to be shorter than 255 characters.');
            return;
        }

        // TODO: Validate that the given email is actually an email

        if (User::where('email', $email)->exists()) {
            $this->error('User with this email already exists.');
            return;
        }

        // TODO: Validate password against default rules
        // Something like this should work, don't have time atm
        //
        // $passwordRule = Password::defaults();
        //
        //if (!$passwordRule->passes('password', $password)) {
        //    $this->error($passwordRule->message()[0]);
        //    return;
        //}

        User::create(['email' => $email, 'name' => $name, 'password' => Hash::make($password), 'active' => 1]);

        $this->info('User created successfully!');
    }
}
