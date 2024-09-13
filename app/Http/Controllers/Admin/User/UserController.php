<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $isEdit = false;
        return view('admin.user.modal', compact(['isEdit']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $data = [
            'name' => $request->name ?? '',
            'email' => $request->email ?? '',
            'number' => $request->number ?? '',
            'password' => Hash::make($request->password) ?? '',
            'user_type' => $request->user_type ?? '',
            'status' => $request->status ?? '',
            'address' => $request->address ?? ''
        ];
        $create = User::create($data);
        if($create){
            return redirect()->route('users.index')->with(['success' => true]);
        }
        return redirect()->back()->with(['success' => false]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $isEdit = true;
        return view('admin.user.modal', compact(['user', 'isEdit']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $data = [
            'name' => $request->name ?? '',
            'email' => $request->email ?? '',
            'number' => $request->number ?? '',
            'user_type' => $request->user_type ?? '',
            'status' => $request->status ?? '',
            'address' => $request->address ?? ''
        ];
        if($request->password != null){
            $data['password'] = Hash::make($request->password) ?? '';
        }
        $update = User::whereId($user->id)->update($data);
        if($update){
            return redirect()->route('users.index')->with(['success' => true, 'edit' => true]);
        }
        return redirect()->back()->with(['success' => false]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user)
    {
        if ($request->ajax()) {
            if ($user->exists()) {
                $user->delete();
                return response()->json(['status' => true, 'message' => getConstant('USER_DELETE')]);
            } else {
                return response()->json(['status' => false, 'message' => getConstant('ERROR_MESSAGE')]);
            }
        }

        abort(403, 'Unauthorized Action');
    }

    public function checkDuplicate(Request $request)
    {
        if($request->email){
            $userEmail = $request->email;
            $userInfo["cnt"] = User::where(["email" => $userEmail])->where('id', '!=', $request->id)->get()->count();
        } else {
            $usernumber = $request->number;
            $userInfo["cnt"] = User::where(["number" => $usernumber])->where('id', '!=', $request->id)->get()->count();
        }
        if ($userInfo["cnt"] > 0) {
            $resp = 1;
        } else {
            $resp = 0;
        }
        echo ($resp == 1) ? "false" : "true";
        exit;
    }
}
