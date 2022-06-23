<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\Email;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function send()
    {
        //ini cara pake aja.............

        $objDemo = new \stdClass();
        $objDemo->demo_one = 'Demo One Value';
        $objDemo->demo_two = 'Demo Two Value';
        $objDemo->sender = 'noreply.sd1@indomaret.co.id';
        $objDemo->receiver = 'ReceiverUserName';

        $send = array();
        $send[0] = 'leonardo.randy@ti.ukdw.ac.id';
//        $send[1] = 'randysetiawan99@gmail.com';

        Mail::to($send)->send(new Email($objDemo));
    }
}
