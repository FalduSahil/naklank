<?php

namespace App\Http\Controllers\Home\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Home\Inquiry\InquiryRequest;
use App\Mail\InquiryMail;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CommonController extends Controller
{
    public function contactUs()
    {
        return view('web.contact-us.contact');
    }

    public function inquiry(InquiryRequest $request)
    {
        $id = Inquiry::insertGetId(
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'message' => $request->message,
            ]
        );
        if($id){
            $inquiry = Inquiry::find($id);
            
            $sendOrderAdminEmails = getConstant('EMAILS');
            
            foreach ($sendOrderAdminEmails as $adminEmail) {
                Mail::to($adminEmail)->send(new InquiryMail($inquiry));
            }
            
            return back()->with(['success' => 'Inquiry Noted Successfully. We Will Contact You Soon.']);
        }
        return back()->withInput()->withErrors(['error' => 'Something Went Wrong! Please Try Again.']);
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        if($request->method() == 'POST'){
            $products = Product::where('status', 'active')
                        ->where('quantity', '>', 0)
                        ->where(function($query) use ($search) {
                            $query->where('name', 'LIKE', "%$search%")
                                  ->orWhere('description', 'LIKE', "%$search%")
                                  ->orWhereHas('getCategory', function ($q) use ($search) {
                                        $q->where('name', 'LIKE', "%$search%")
                                          ->orWhere('description', 'LIKE', "%$search%");
                                  });
                        })
                        ->paginate(9);

        } else {
            $products = Product::where('status', 'active')->where('quantity', '>', '0')->paginate(9);
        }

        return view('home.shop.shop', compact(['products', 'search']));
    }

    public function checkLogOutAll(Request $request)
    {
        if(Auth::check() && Auth::user()->logout_all === 'yes'){
            User::whereId(Auth::user()->id)->update(['logout_all' => 'no']);
            Auth::guard('web')->logout();
            session()->flash('forceLogout');
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);
    }

    public function checkLoginTime(Request $request)
    {
        $user = Auth::user();
        if(Auth::check() && $user->login_type === 'limited'){
            $now = Carbon::now();
            $login_access_until = Carbon::parse($user->login_access_until);
            if ($now->greaterThanOrEqualTo($login_access_until)) {
                Auth::guard('web')->logout();
                session()->flash('loginExpired');
                return response()->json(['status' => true]);
            }
            return response()->json(['status' => false]);
        }
        return response()->json(['status' => false]);
    }
}
