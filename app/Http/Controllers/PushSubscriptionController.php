<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PushSubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'endpoint' => 'required|url',
            'keys.auth' => 'required|string',
            'keys.p256dh' => 'required|string',
        ]);

        $request->user()->update([
            'push_subscription' => json_encode($request->all())
        ]);

        return response()->json(['message' => 'Push subscription stored successfully']);
    }

    public function destroy(Request $request)
    {
        $request->user()->update([
            'push_subscription' => null
        ]);

        return response()->json(['message' => 'Push subscription removed successfully']);
    }
}
