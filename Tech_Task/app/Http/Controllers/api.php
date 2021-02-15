<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function App\Http\Controllers\request;

class api extends Controller
{
    public function apiRequest(request $re){
        $re->validate([//will through an error if fields are left blank
            'amount' => 'required',
            'reference' => 'required|min:3'
        ]);

    $amount = $re->amount;//grabs information form form
    $ref = $re->reference;

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
        <form action="http://127.0.0.1:8000/requests/" class="paymentWidgets" data-brands="VISA MASTER AMEX"></form>
        <?php


    }

    public function requests($path){

        function request() {
            $url = "https://test.oppwa.com/v1/checkouts/{id}/payment";
            $url .= "?entityId=8a8294174b7ecb28014b9699220015ca";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if(curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);
            return $responseData;
        }
        $responseData = request();

    }

}
