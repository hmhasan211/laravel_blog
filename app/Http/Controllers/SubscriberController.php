<?php

namespace App\Http\Controllers;

use App\Subscriber;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email'=>'required|email|unique:subscribers'
        ]);

        $subsciber = new Subscriber();
        $subsciber->email = $request->email;
        $subsciber->save();
        Toastr::success('You are added to subscriber list!!','success');
        return redirect()->back();
    }
}

