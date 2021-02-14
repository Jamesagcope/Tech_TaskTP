<?php


namespace App\Http\Controllers;
use App;

class PaymentHistoryController
{
    public function receiveData(){

        print session()->get('id');

        $payments = App\payment::where('userID', session()->get('id'))->get();

        return view('/paymentHistory', compact('payments'));

    }
}
