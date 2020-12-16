<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddIdRequest;
use App\Models\ID;
use App\Models\Wallet;
use Auth;

class AccountController extends Controller
{
    /**
     * Add ID Card for an account
     *
     * @param AddIdRequest $request
     * @return void
     */
    public function addIdCard(AddIdRequest $request)
    {
        ID::create([
            'user_id' => Auth::id(),
            'id_name' => $request->id_name,
            'id_number' => $request->id_number,
            'id_image' => 'https://visme.co/blog/wp-content/uploads/2017/08/40-Creative-Logo-Designs-to-Inspire-You-SlingShot.gif',
        ]);
        Auth::user()->hasValidId = 1;
        Auth::user()->save();

        $wallet = Wallet::where('user_id', Auth::id())->first();
        $wallet->max_transfer = 200000.00;
        $wallet.save();
        return response()->json([
            'error' => false,
            'msg' => 'id card added'
        ]);
    }
}
