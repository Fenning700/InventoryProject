<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\confirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ConfirmationController extends Controller
{
    public function send(Request $request)
    {
        $address = $_SESSION['user']['email'];
        Mail::to($request->$address)->send(new confirmation());
    }
}