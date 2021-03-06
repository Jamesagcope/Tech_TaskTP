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
            'reference' => 'required|min:3',
            'billingAddress' => 'required',
            'customerInfo' => 'required'
        ]);

        $amount = $re->amount;//grabs information form form
        $ref = $re->reference;
        $bAddress = $re->billingAddress;
        $cInfo = $re->customerInfo;

        //create session for amount and reference
        $re->session()->put('tranRef', $ref);
        $re->session()->put('amount', $amount);
        $re->session()->put('address', $bAddress);
        $re->session()->put('info', $cInfo);

        //API
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
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        //API

        $response = json_decode($responseData);//decoding jason to get the array output

        $idResponse = $response->id;




        //php breake to display the api payment system.

        //calls request page that calls requests function

        return view('/maKePayment', compact('idResponse'));

    }
    //request function that gets the api response.
    public function requests(request $path){

        $rp = $_GET['resourcePath'];//get url path

        //getting info out of the session to put in the database
        $amount = session()->get('amount');
        $ref = session()->get('tranRef');
        $userid = session()->get('id');
        $bAddress = session()->get('address');
        $cInfo = session()->get('info');


        $url = "https://test.oppwa.com".$rp;//adds path to this url to get a response as it has the id need to generate a success or error
        $url .= "?entityId=8ac7a4ca759cd78501759dd759ad02df";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGFjN2E0Y2E3NTljZDc4NTAxNzU5ZGQ3NThhYjAyZGR8NTNybThiSmpxWQ=='));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);

        $Aresponse = json_decode($responseData);

        //adding the data into the payments database.
        $trans = new App\payment;

        $trans->amount = $amount;
        $trans->Reference = $ref;
        $trans->billingAddress = $bAddress;
        $trans->customerInfo = $cInfo;
        $trans->paymentStatus = $Aresponse->result->description;
        $trans->userID = $userid;
        $trans->created_at = $Aresponse->timestamp;
        $trans->updated_at = $Aresponse->timestamp;
        $trans->save();//saving the data

        $code = $Aresponse->result->code;
        $des = $Aresponse->result->description;

        //return to show if the payment was successful or not.
        return view('/madePayment', compact('code', 'des'));
    }

}
