<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //


    public function test(){
        $stripe = new \Stripe\StripeClient(
            'sk_test_51IgN1gKSJimKrMZgUG5KfA8AFGAIWy2eHdPsmfMlr8gE2Jgd0y1sgv7NDxM9gPLl3ASsPo8ceygzqKObnnp3bF6p00z1ppmyft'
        );
//       $account =  $stripe->accounts->create([
//            'type' => 'express',
//            'country' => 'US',
//            'email' => 'jenny@yopmail.com',
//            'capabilities' => [
//                'card_payments' => ['requested' => true],
//                'transfers' => ['requested' => true],
//            ],
//        ]);
//       dd($account);


//        $account = $stripe->accountLinks->create([
//            'account' => $account->id,
//            'refresh_url' => 'https://example.com/reauth',
//            'return_url' => route('stripe.board'),
//            'type' => 'account_onboarding',
//        ]);
//
//       $account1 =  $stripe->accounts->createLoginLink(
//            'acct_1JnHWK4Dy7vIorEo',
//        );

//        $account1 = $stripe->accounts->retrieve(
//            'acct_1JnHVn4Ci3R4Nhu4',
//        );
//        $account2 = $stripe->accounts->retrieve(
//            'acct_1JnHWK4Dy7vIorEo',
//        );
        $account_details = $stripe->accounts->retrieve(
            'acct_1Jn02A4KeuXKFWyF',
        );
        if($account_details->details_submitted === false){
            $link=  $stripe->accountLinks->create([
                'account' => $account_details->id,
                'refresh_url' => 'https://example.com/reauth',
                'return_url' => route('stripe.board'),
                'type' => 'account_onboarding',
            ]);
            return response()->json(['status'=>1,'message'=>'kindly verify your stripe details',$link->url]);
        }elseif(!$account_details->payouts_enabled || !$account_details->charges_enabled){
            $link =  $stripe->accounts->createLoginLink(
                $account_details->id,
            );
            return response()->json(['status'=>1,'message'=>'kindly verify your stripe details',$link->url]);
        }else{
            return  response()->json(['status'=>1,'message'=>'success','data'=>$account_details]);
        }
    }
}
