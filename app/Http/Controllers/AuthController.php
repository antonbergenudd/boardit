<?php

namespace boardit\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Carbon\Carbon;
use boardit\User;

class AuthController extends BaseController
{
    public function delivering(User $user, Request $request) {
        $user->delivering = $request->delivering;

        if($request->delivering) {
            $user->delivering_since = Carbon::now()->format('Y-m-d H:i:s');
        } else {
            $user->delivering_since = NULL;
        }

        $user->save();

        return back();
    }
}
