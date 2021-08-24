<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function createMessage(Request $request) {
        return response()->json([''], 200);
    }
}
