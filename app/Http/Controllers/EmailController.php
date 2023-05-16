<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
 
class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
   
            $to = $request->input('to');
            $subject = $request->input('subject');
            $body = $request->input('body');
            $from = 'ssotufab@gmail.com';
            $Message_from= $request->input('from');
            Mail::to( $to )->send(new ContactFormMail($subject, $body, $from, $Message_from ));
            return response()->json(array('message' => 'Email sent successfully TO '.$to.' '), 200);
        }

}
