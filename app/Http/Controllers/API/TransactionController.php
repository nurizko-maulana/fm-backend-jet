<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class TransactionController extends Controller
{
    public function all(Request $request) 
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $food_id = $request->input('food_id');
        $status = $request->input('status');
        

        if($id){
            $transaction = Transaction::where(['food','user'])->find($id);

            if($transaction){
                return ResponseFormatter::success($transaction, 'Data fetch succesfully');
            } else{
                return ResponseFormatter::error(
                    null,
                    'Data not existing'
                );
            }
        }

        $transaction = Transaction::with(['food','user'])->where('user_id', Auth::user()->id);

        if($food_id){
            $transaction->where('name',   $food_id );
        }
        if($status){
            $transaction->where('status',  $status );
        }

        return ResponseFormatter::success($transaction->paginate($limit), 'Data fecth successfully' );

    }

    public function checkout(Request $request)
    {
        //validate request data
        $request->validate([
            'food_id' => 'required|exist:food.id',
            'user_id' => 'required|exist:user.id',
            'quantity' => 'required',
            'total' => 'required',
            'status' => 'required',
        ]);
        //create transaction record
        $transaction = Transaction::create([
            'food_id' => $request->food_id,
            'user_id' => $request->user_id,
            'quantity' => $request->quantity,
            'total' => $request->quantity,
            'status' => $request->quantity,
            'payment_url' => '',
        ]);

        //Midtrans configuration
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$clientKey = config('services.midtrans.clientKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized  = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        $transaction = Transaction::with(['food','user'])->find($transaction->id);

        //create json request body
        $midtrans = [
            'transaction_detail' => [
                'order_id' => $transaction->id,
                'gross_amount' => (int) $transaction->total,
            ],
            'customer_detail' => [
                'first_name' => $transaction->user->name,
                'email' => $transaction->user->email,
            ], 
            'enabled_payments' => [
                'gopay','bank_transfer'
            ], 
            'vtweb' => []
        ];

        //Call Midtrans
        try {
            //get midtrasn paymemnt page
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

            $transaction->paymentUrl = $paymentUrl;
            $transaction->save();

            //mengembalikan data ke API
            return ResponseFormatter::success($transaction, 'Transaction Success');

        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage() , 'Transaction Failed');
        }
    }
}


