<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * PHP array_map() function example
     */
    public function array_map()
    {
        $array = [1, 2, 3, 4, 5];

        return array_map(function ($number) {
            return $number * 2;
        }, $array);
    }

    /**
     * Get all users with last_login_at
     */
    public function index1()
    {
        $users = User::query()
            // ->with('logins')
            ->select('id', 'name', 'email')
            ->addSelect([
                'last_login_at' => Login::select('created_at')
                    ->whereColumn('logins.user_id', 'users.id')
                    ->latest()
                    ->limit(1)
            ])
            ->withCasts(['last_login_at' => 'datetime'])
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'last_login_at' => $user->last_login_at->diffForHumans(),
                    // 'last_login_at' => $user->logins()->latest()->first()->created_at,
                    // 'last_login_at' => $user->logins->sortByDesc('created_at')->first()->created_at->diffForHumans()
                ];
            });

        return view('table', $this->data($users));
    }

    /**
     * Get lastLogin attribute of all users
     */
    public function index2()
    {
        $users = User::query()
            ->select('id', 'name', 'email')
            ->addSelect([
                'last_login_id' => Login::select('id')
                    ->whereColumn('logins.user_id', 'users.id')
                    ->latest()
                    ->limit(1),
            ])
            ->with('lastLogin')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'last_ip_address' => $user->lastLogin->ip_address,
                    'last_login_at' => $user->lastLogin->created_at->diffForHumans(),
                ];
            });

        return view('table', $this->data($users));
    }
}
