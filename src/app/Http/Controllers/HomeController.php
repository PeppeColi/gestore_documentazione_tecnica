<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Client;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();

        /** @var bool $isAdmin */
        $isAdmin = $currentUser->is_admin;

        // @todo use pagination for users and clients

        /** @var array $users */
        $users = $isAdmin
            ? User::query()->where('id', '!=', $currentUser->id)->get()->toArray()
            : [];

        /** @var array $clients */
        $clients = $isAdmin
            ? Client::all()->toArray()
            : [];

        /** @var array $data */
        $data = [
            'user_is_admin' => $isAdmin, // @todo as alternative, pass the entire User model
            'api_token' => $currentUser->api_token, // @see config/auth.php
            'users' => $users,
            'clients' => $clients,
        ];

        return view('home', $data);
    }
}
