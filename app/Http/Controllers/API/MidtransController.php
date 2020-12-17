<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;
use App\Models\Transaction;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        //Configure midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$clientKey = config('services.midtrans.clientKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized  = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        //create notification instances
        $notification = new Notification();

        //asign variable
        $status = $notification->transacton_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $notification->order_id;

        //find transaction by id
        $transaction = Transaction::findOrFail($order_id);

        //handle notification status
        if($status == 'capture')
        {
            if($type)
            {
                if($fraud == 'challange')
                {
                    $transaction->status = 'PENDING';
                }
                else
                {
                    $transaction->status = 'SUCCESS';
                }
            }
        }
        else if($status == 'settlement')
        {
            $transaction->status = 'SUCCESS';
        }
        else if($status == 'pending')
        {
            $transaction->status = 'PENDING';
        }
        else if($status == 'deny')
        {
            $transaction->status = 'CANCELED';
        }
        else if($status == 'expire')
        {
            $transaction->status = 'CANCELED';
        }
        else if($status == 'cancle')
        {
            $transaction->status = 'CANCELED';
        }

        //save transaction
        $transaction->save();

    }

    public function success()
    {
        return view('midtrans.success');
    }
    public function unfinish()
    {
        return view('midtrans.unfinish');
    }
    public function eror()
    {
        return view('midtrans.error');
    }
}
