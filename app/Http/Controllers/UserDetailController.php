<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserDetailStoreRequest;
use App\Http\Requests\UserDetailUpdateRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserDetailController extends Controller
{

    public function userDetailEdit(Request $request){
        $userDetails = $request->user()->user_details;
        return Inertia::render('User/UserDetailEdit', compact('userDetails'));
    }

    public function userDetailStore(UserDetailStoreRequest $request){
        $validatedData = $request->validated();
        $request->user()->user_details()->create($validatedData);
        return redirect()->route('user.profile.show', $request->user()->user_name);
    }

    public function userDetailUpdate(UserDetailUpdateRequest $request){
        $validatedData = $request->validated();
        $request->user()->user_details()->update($validatedData);
        return redirect()->route('user.profile.show', $request->user()->user_name);
    }
}
