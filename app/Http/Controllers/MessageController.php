<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class MessageController extends Controller
{
    public function indexMessage(){
        return Inertia::render('Messenger/index');
    }
}
