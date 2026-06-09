<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('make:admin {name?} {email?} {--password=}', function () {
    $name = $this->argument('name') ?: $this->ask('Admin name');
    $email = $this->argument('email') ?: $this->ask('Admin email');
    $password = $this->option('password');

    if (! is_string($password) || $password === '') {
        $password = $this->secret('Password (min 8 characters)');
        $confirmation = $this->secret('Confirm password');

        if ($password !== $confirmation) {
            $this->error('Passwords did not match.');

            return self::FAILURE;
        }
    }

    $data = [
        'name' => $name,
        'email' => $email,
        'password' => $password,
    ];

    $validator = Validator::make($data, [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'string', 'min:8'],
    ]);

    if ($validator->fails()) {
        foreach ($validator->errors()->all() as $error) {
            $this->error($error);
        }

        return self::FAILURE;
    }

    $user = User::create($validator->validated());

    $this->info("Admin user created for {$user->email}.");

    return self::SUCCESS;
})->purpose('Create an admin user for the application');
