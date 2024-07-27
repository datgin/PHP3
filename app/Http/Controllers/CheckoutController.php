<?php

namespace App\Http\Controllers;

use App\Events\OrderShipped;
use App\Notifications\SendNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;
use App\Mail\OrderEmailSentSuccessfully;
use App\Models\Cities;
use App\Models\Shipping;
use App\Models\User;
use Exception;
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

        $cities = Cities::all();

        session()->forget('url.intended');

        return view('client.pages.checkout', compact('cities'));
    }

    public function pocessCheckout(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:100',
            'email' => 'required|email',
            'phone_number' => 'required|numeric',
            'address' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $validated['total_price'] = $request->total;
            $validated['amount_shipping'] = $request->amount_shipping;

            $address = Cities::find($request->address)->select('name')->first();
            $validated['address'] = $address->name;

            $carts = Cart::content();

            $order = User::find(Auth::user()->id)->orders()->create($validated);

            $orderItems = Cart::content()->map(function ($item) {
                return [
                    'product_id' => $item->id,
                    'name' => $item->name,
                    'price' => $item->subtotal,
                    'quantity' => $item->qty,
                ];
            })->toArray();

            $order->items()->createMany($orderItems);
            Cart::destroy();

            // OrderShipped::dispatch($order);
            event(new OrderShipped($order, $carts));

            $user = User::find(Auth::user()->id);
            $user->notify(new SendNotification($order));

            DB::commit();
        } catch (Exception $th) {
            DB::rollBack();
            session()->flash('error', 'Đặt hàng thất bại');
        }


        session()->flash('success', 'Đặt hàng thành công');
        return redirect()->route('thank-you');
    }

    public function thankYou()
    {
        if (session()->has('success')) {
            return view('client.pages.thank-you');
        }
        return redirect()->route('home');
    }

    public function getAmount($id)
    {
        $amount = Shipping::query()->select('amount')->where('city_id', $id)->first()->toArray();

        if ($amount == null) abort(404);


        return response()->json($amount['amount']);
    }
}
