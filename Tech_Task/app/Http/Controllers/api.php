<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function App\Http\Controllers\request;
use App;

class api extends Controller
{
    public function apiRequest(request $re){
        $re->validate([//will through an error if fields are left blank
            'amount' => 'required',
            'reference' => 'required|min:3'
        ]);

        $amount = $re->amount;//grabs information form form
        $ref = $re->reference;

        $re->session()->put('tranRef', $ref);
        $re->session()->put('amount', $amount);

        $url = "https://test.oppwa.com/v1/checkouts";
        $data = "entityId=8ac7a4ca759cd78501759dd759ad02df" .
            "&amount=".number_format($amount,2).
            "&currency=GBP" .
            "&paymentType=DB";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGFjN2E0Y2E3NTljZDc4NTAxNzU5ZGQ3NThhYjAyZGR8NTNybThiSmpxWQ=='));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);


        //$responseData = request($amount, $ref);

        $Aresponse = json_decode($responseData);

         ?>
        <style>body {background-color:#f6f6f5;}</style>
        <script src="https://test.oppwa.com/v1/paymentWidgets.js?checkoutId=<?=$Aresponse->id?>"></script>
        <form action="/requests/" class="paymentWidgets" data-brands="VISA MASTER AMEX"></form>
        <?php
    }

    public function requests(request $path){

        $path = $_GET['id'];
        $rp = $_GET['resourcePath'];

        $amount = session()->get('amount');
        $ref = session()->get('tranRef');
        $userid = session()->get('id');


        $url = "https://test.oppwa.com".$rp;
        $url .= "?entityId=8ac7a4ca759cd78501759dd759ad02df";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGFjN2E0Y2E3NTljZDc4NTAxNzU5ZGQ3NThhYjAyZGR8NTNybThiSmpxWQ=='));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);

        $Aresponse = json_decode($responseData);

        $trans = new App\payment;

        $trans->amount = $amount;
        $trans->Reference = $ref;
        $trans->userID = $userid;
        $trans->created_at = $Aresponse->timestamp;
        $trans->updated_at = $Aresponse->timestamp;
        $trans->save();

        $code = $Aresponse->result->code;
        $des = $Aresponse->result->description;

        return view('/madePayment', compact('code', 'des'));

    }

}
