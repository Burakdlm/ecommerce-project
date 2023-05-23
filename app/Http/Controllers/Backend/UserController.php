<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use http\Client\Curl\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use function GuzzleHttp\Promise\all;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = \App\Models\User::all();
        return view("backend.users.index", ["users" => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("backend.users.insert_form");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $name = $request->get("name");
        $email = $request->get("email");
        $password = $request->get("password");
        $is_admin = $request->get("is_admin",0);
        $is_active = $request->get("is_active",0);

        $user = new \App\Models\User();
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->is_admin = $is_admin;
        $user->is_active = $is_active;

        $user->save();

        return Redirect::to("/users");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return "show => $id";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = \App\Models\User::find($id);
        return view("backend.users.update_form",["user"=>$user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        $name = $request->get("name");
        $email = $request->get("email");
        $is_admin = $request->get("is_admin",0);
        $is_active = $request->get("is_active",0);
        $user = \App\Models\User::find($id);
        $user ->name = $name;
        $user ->email = $email;
        $user ->is_admin = $is_admin;
        $user ->is_active = $is_active;
        $user ->save();
        return Redirect::to("/users");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = \App\Models\User::find($id);
        $user ->delete();
//        return Redirect::to("/users");
        return response()->json(["message"=>"Done","id"=>$id]);
    }
}
