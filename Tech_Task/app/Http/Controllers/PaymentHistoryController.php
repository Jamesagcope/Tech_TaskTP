<?php


namespace App\Http\Controllers;
use App;

class PaymentHistoryController
{
    public function insert(request $re){


    }

    public function receiveData(){


        $payments = App\payment::where('userID', session()->get('id'))->get();

        return view('/paymentHistory', compact('payments'));

    }
}
