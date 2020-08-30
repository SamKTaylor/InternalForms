<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $user_array = [];

    public function __construct()
    {
        foreach (User::all() as $user){
            $this->user_array[$user->id] = $user->name;
        }

        App::singleton('user_array', $this->user_array);

        View::share('user_array', $this->user_array);
    }
}
