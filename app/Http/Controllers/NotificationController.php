<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Member;
use App\Setting;
use App\Orders as Order;
use App\Midtrans_Payment;
use Illuminate\Http\Request;
use App\Notifications\MailNotification;

class NotificationController extends Controller
{
    public function index()
    {
        return "notification index";
    }

    public function midtrans(Request $request)
    {
        if(isset($request)){
            $data = json_decode($request->getContent(), true);
            // $data_json = json_decode(str_replace('}"','}',str_replace('"{','{',str_replace('\"','"',$request->getContent()))), true);
            $midtrans_payment = new Midtrans_Payment();
            $midtrans_payment->content = $request->getContent();
            // $midtrans_payment->bank = $data_json['bank'];
            // $midtrans_payment->eci = $data_json['eci'];
            // $midtrans_payment->transaction_time = $data_json['transaction_time'];
            // $midtrans_payment->gross_amount = $data_json['gross_amount'];
            // $midtrans_payment->order_id = $data_json['order_id'];
            // $midtrans_payment->payment_type = $data_json['payment_type'];
            // $midtrans_payment->signature_key = $data_json['signature_key'];
            // $midtrans_payment->status_code = $data_json['status_code'];
            // $midtrans_payment->transaction_id = $data_json['transaction_id'];
            // $midtrans_payment->transaction_status = $data_json['transaction_status'];
            // $midtrans_payment->fraud_status = $data_json['fraud_status'];
            // $midtrans_payment->status_message = $data_json['status_message'];
            $midtrans_payment->save();
            $order = Order::where('order_id', str_replace("ORDER-", "", $data['order_id']))->first();
            if($order){
                $data['order'] = $order['cart'][0]['products'];
                $data['payment'] = (object) $order['payment'][0];
                $data['member'] = (object) $order['member'][0];
                $data['courier'] = (object) $order['courier'][0]['costs'][0]['cost'][0];
                $data['company'] = Setting::first();
                $member = Member::find($order->member[0]['_id']);
                $status = $data['transaction_status'];
                $midtrans_payment->order_id = "success";
                $midtrans_payment->save();
                switch ($status) {
                    case 'pending':
                        $member->notify(new MailNotification($data, 'Payment pending'));
                        $midtrans_payment->mailer = 'success send pending';
                        $midtrans_payment->save();
                        break;
                    case 'settlement':
                        $order->status = 'settlement';
                        $order->save();
                        $member->notify(new MailNotification($data, 'Payment complete'));
                        $midtrans_payment->mailer = 'success send settlement';
                        $midtrans_payment->save();
                        break;                
                    default:
                        \Log::info('Payment denied');
                        break;
                }
            }else{
                sleep(1000);
                $midtrans_payment->order_id = "failed";
                $midtrans_payment->save();
            }

        }
    }
}
