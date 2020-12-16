<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class WalletController extends Controller
{
    public function getWallet()
    {
        return response()->json([
            'error' => false,
            'msg' => 'wallet retrieved',
            'data' => Auth::user()->wallet
        ]);
    }

    public function getUserData()
    {
        $user = User::with('wallet')->with('id_card')->with('ref_code')->find(Auth::id());
        return response()->json([
            'error' => false,
            'data' => $user,
        ]);
    }

    public function transfer(Request $request)
    {
        $wallet = Auth::user()->wallet;
        if ($request->amount < $wallet->max_transfer && $request->amount < $wallet->current_balance) {
            $wallet->current_balance = $wallet->current_balance - $request->amount;
            $wallet->save();

            return response()->json([
                'error' => false,
                'msg' => 'transfer successful'
            ]);
        }

    }
}
