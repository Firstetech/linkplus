<?php

namespace App\Http\Controllers\Payment;

use App\User;
use Redirect;
use App\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function preparePaymentGateway(Request $request, $planId)
    {
        $config = DB::table('config')->get();
        $payment_mode = Gateway::where('payment_gateway_id', $request->payment_gateway_id)->first();

        if ($payment_mode == null) {
            alert()->error(trans('Please choose valid payment method!'));
            return redirect()->route('user.plans');
        } else {
            $validator = Validator::make($request->all(), [
                'billing_name' => 'required',
                'billing_email' => 'required',
                'billing_phone' => 'required',
                'billing_address' => 'required',
                'billing_city' => 'required',
                'billing_state' => 'required',
                'billing_zipcode' => 'required',
                'billing_country' => 'required',
                'type' => 'required'
            ]);

            if ($validator->fails()) {
                return back()->with('errors', $validator->messages()->all()[0])->withInput();
            }

            User::where('user_id', Auth::user()->user_id)->update([
                'billing_name' => $request->billing_name,
                'billing_email' => $request->billing_email,
                'billing_phone' => $request->billing_phone,
                'billing_address' => $request->billing_address,
                'billing_city' => $request->billing_city,
                'billing_state' => $request->billing_state,
                'billing_zipcode' => $request->billing_zipcode,
                'billing_country' => $request->billing_country,
                'type' => $request->type,
                'vat_number' => $request->vat_number
            ]);

            if ($payment_mode->payment_gateway_id == "60964401751ab") {
                // Check key and secret
                if ($config[4]->config_value != "YOUR_PAYPAL_CLIENT_ID" || $config[5]->config_value != "YOUR_PAYPAL_SECRET") {
                    return redirect()->route('paywithpaypal', $planId);
                } else {
                    return redirect()->route('user.plans')->with('failed', trans('Something went wrong!'));
                }
            } else if ($payment_mode->payment_gateway_id == "60964410731d9") {
                // Check key and secret
                if ($config[6]->config_value != "YOUR_RAZORPAY_KEY" || $config[7]->config_value != "YOUR_RAZORPAY_SECRET") {
                    return redirect()->route('paywithrazorpay', $planId);
                } else {
                    return redirect()->route('user.plans')->with('failed', trans('Something went wrong!'));
                }
            } else if ($payment_mode->payment_gateway_id == "60964410732t9") {
                // Check key and secret
                if ($config[9]->config_value != "YOUR_STRIPE_PUB_KEY" || $config[10]->config_value != "YOUR_STRIPE_SECRET") {
                    return redirect()->route('paywithstripe', $planId);
                } else {
                    return redirect()->route('user.plans')->with('failed', trans('Something went wrong!'));
                }
            } else if ($payment_mode->payment_gateway_id == "60964410736592") {
                // Check key and secret
                if ($config[33]->config_value != "PAYSTACK_PUBLIC_KEY" || $config[34]->config_value != "PAYSTACK_SECRET_KEY") {
                    return redirect()->route('paywithpaystack', $planId);
                } else {
                    return redirect()->route('user.plans')->with('failed', trans('Something went wrong!'));
                }
            } else if ($payment_mode->payment_gateway_id == "6096441071589632") {
                // Check key and secret
                if ($config[37]->config_value != "mollie_key") {
                    return redirect()->route('paywithmollie', $planId);
                } else {
                    return redirect()->route('user.plans')->with('failed', trans('Something went wrong!'));
                }
            } else if ($payment_mode->payment_gateway_id == "659644107y2g5") {
                // Check key and secret
                if ($config[31]->config_value != "") {
                    return redirect()->route('paywithoffline', $planId);
                } else {
                    return redirect()->route('user.plans')->with('failed', trans('Something went wrong!'));
                }
            } else {
                return redirect()->route('user.plans')->with('failed', trans('Something went wrong!'));
            }
        }
    }
}
