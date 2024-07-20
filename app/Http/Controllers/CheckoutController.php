<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;
use App\Mail\OrderEmailSentSuccessfully;
use Gloudemans\Shoppingcart\Facades\Cart;

class CheckoutController extends Controller
{
    public function index()
    {
        if (Cart::count() == 0) {
            return redirect()->route('cartShow');
        }
        if (!Auth::check()) {
            if (!session()->has('url.intended')) {
                session(['url.intended' => url()->current()]);
            }
            return redirect()->route('login');
        }

        session()->forget('url.intended');
        return view('client.pages.checkout');
    }

    public function pocessCheckout(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:100',
            'email' => 'required|email',
            'phone_number' => 'required|numeric',
            'address' => 'required|min:3|max:255',
        ]);

        $validated['total_price'] = Cart::total();

        DB::beginTransaction();

        try {
            $order = Auth::user()->orders()->create($validated);

            $orderItems = Cart::content()->map(function ($item) {
                return [
                    'product_id' => $item->id,
                    'name' => $item->name,
                    'price' => $item->price,
                    'quantity' => $item->qty,
                ];
            })->toArray();

            $order->items()->createMany($orderItems);
            Cart::destroy();

            DB::commit();

            // Mail::to($order->email)->send(new OrderEmailSentSuccessfully());
            sleep(2);
            session()->flash('success', 'Đặt hàng thành công');
            return redirect()->route('thank-you');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Đặt hàng thất bại');
        }
    }

    public function thankYou()
    {
        if (session()->has('success')) {
            return view('client.pages.thank-you');
        }
        return redirect()->route('home');
    }
}
