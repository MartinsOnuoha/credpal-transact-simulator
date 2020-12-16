<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Http\Requests\UserStoreRequest;
use \App\Http\Requests\UserLoginRequest;
use \App\Models\User;
use \App\Models\RefCode;
use \App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Hash;

class AuthController extends Controller
{
    public $bonus = 1000;
    /**
     * register a new user
     *
     * @param UserStoreRequest $request
     * @return void
     */
    public function register(UserStoreRequest $request)
    {
        $data = $request->validated(); // get the validated request
        $data = (object) $data;
        $data->password = Hash::make($data->password);
        $data = (array) $data;

        $user = User::create($data); // create user
        $this->assignRefCode($user); // generate referral code
        $this->assignWallet($user); // generate wallet for user

        $token = $user->createToken(env('SANCTUM_TOKEN_NAME'));

        if ($request->ref_code) {
            $refCode = RefCode::where('code', strtoupper($request->ref_code))->first();
            if ($refCode) {
                // award registering user 1,000
                $this->awardUserBonus($user);
            }
        }
        return response()->json([
            'error' => false,
            'token' => $token->plainTextToken,
            'user' => $user,
        ], 201);
    }
    /**
     * login existing user
     *
     * @param UserLoginRequest $request
     * @return void
     */
    public function login(UserLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $request->session()->regenerate();

            $user->tokens()->delete(); // delete existing tokens

            $token = $user->createToken(env('SANCTUM_TOKEN_NAME')); // generate new token
            return response()->json([
                'error' => false,
                'token' => $token->plainTextToken,
                'user' => $user
            ], 200);
        }
        return response()->json([
            'error' => true,
            'msg' => 'Authentication failed, invalid email or password'
        ]);
    }
    /**
     * award bonus for referral code registration
     *
     * @param User $user
     * @return void
     */
    public function awardUserBonus(User $user)
    {
        $wallet = Wallet::where('user_id', $user->id)->first();
        $wallet->current_balance = $wallet->current_balance  + $this->bonus;
        $wallet->save();
    }
    /**
     * assign wallet to user
     *
     * @param User $user
     * @return void
     */
    public function assignWallet(User $user)
    {
        Wallet::create([ 'user_id' => $user->id ]);
    }
    /**
     * assign referral code to user
     *
     * @param User $user
     * @return void
     */
    public function assignRefCode(User $user)
    {
        RefCode::create([
            'user_id' => $user->id,
            'code' => strtoupper(substr(md5($user->email . date('Y-m-d h:i:sa')), 0, 7))
        ]);
    }
}
