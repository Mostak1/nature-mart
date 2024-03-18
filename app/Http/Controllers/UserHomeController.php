<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use App\Models\OffOrder;
use App\Models\OffOrderDetails;
use App\Models\UserRole;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;

class UserHomeController extends Controller
{

  public function home()
  {
    return view('home');
  }
  public function shopGrid()
  {
    return view('user.pages.shop-grid');
  }
  public function shopCart()
  {
    return view('user.pages.shoping-cart');
  }
  public function shopDetails()
  {
    return view('user.pages.shop-details');
  }
  public function checkout()
  {
    return view('user.pages.checkout');
  }
  public function mail(Request $request)
  {
    // Validation
    $request->validate([
      'name' => 'required|string',
      'address' => 'required|string',
      'phone' => 'required|string',
      'email' => 'required|email',
      'productq' => 'required|integer|min:1',
    ]);
    $name = $request->name;
    $address = $request->address;
    $phone = $request->phone;
    $email = $request->email;
    $quantity = $request->productq;
    $total = 300 * $request->productq;

    $mail = Mail::to([$email, 'naturemartbd@gmail.com'])->send(new SendMail($name, $address, $phone, $email, $total, $quantity));
    if ($mail) {
      return back()->with('success', 'Your Order Place Successfully');
    } else {
      return back()->with('error', 'Your Order Place Fail');
    }
  }
}
