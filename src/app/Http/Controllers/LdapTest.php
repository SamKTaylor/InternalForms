<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Ldap\User;

class LdapTest extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::get();

        return view('ldap.users.index', ['users' => $users]);
    }
}
