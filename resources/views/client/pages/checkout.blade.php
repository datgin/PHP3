@extends('client.layouts.master')

@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="#">Shop</a></li>
                    <li class="breadcrumb-item">Checkout</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-9 pt-4">
        <div class="container">
            <form action="{{ route('pocess-checkout') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="sub-title">
                            <h2>Shipping Address</h2>
                        </div>
                        <div class="card shadow-lg border-0">
                            <div class="card-body checkout-form">
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="name" value="{{ auth()->user()->name }}"
                                                id="first_name" class="form-control" placeholder="First Name">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" value="{{ auth()->user()->email }}" name="email"
                                                id="email" class="form-control" placeholder="Email">
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>



                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <select name="address" id="address" class="form-control">
                                                <option value="" disabled selected>Địa chỉ</option>
                                                @if ($cities->isNotEmpty())
                                                    @foreach ($cities as $city)
                                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('address')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text"
                                                value="{{ old('phone_number', auth()->user()->phone_number) }}"
                                                name="phone_number" id="mobile" class="form-control"
                                                placeholder="Mobile No.">
                                            @error('phone_number')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <textarea name="order_notes" name="node" id="order_notes" cols="30" rows="2"
                                                placeholder="Order Notes (optional)" class="form-control"></textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="sub-title">
                            <h2>Order Summery</h3>
                        </div>
                        <div class="card cart-summery">
                            <div class="card-body">
                                @php($subtotal = 0)
                                @foreach (Cart::content() as $item)
                                    @php($subtotal += $item->subtotal + $item->tax)
                                    <div class="d-flex justify-content-between pb-2">
                                        <div class="h6 dots w-75"><small>x{{ $item->qty }} |
                                            </small>{{ $item->name }}
                                        </div>
                                        <div class="h6">{{ number_format($item->price, 0, ',', '.') }} ₫</div>
                                    </div>
                                @endforeach

                                <div class="d-flex justify-content-between summery-end">
                                    <div class="h6"><strong>Subtotal</strong></div>
                                    <div class="h6"><strong>{{ Cart::total(0, ',', '.') }} ₫</strong></div>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <div class="h6"><strong>Shipping</strong></div>
                                    <div class="h6" id="amount-shipping"><strong>0 ₫</strong></div>
                                    <input type="hidden" name="amount_shipping" id="amount-shipping-input" value="0">
                                </div>
                                <div class="d-flex justify-content-between mt-2 summery-end">
                                    <div class="h5"><strong>Total</strong></div>
                                    <div class="h5"><strong id="total">{{ number_format($subtotal, 0, ',', '.') }}
                                            ₫</strong>
                                        <input type="hidden" name="total" value="0" id="total-input">
                                    </div>
                                </div>
                                <div class="pt-4">
                                    <button type="submit" class="btn-dark btn btn-block w-100">Pay Now</button>
                                </div>
                            </div>
                        </div>



                        <!-- CREDIT CARD FORM ENDS HERE -->

                    </div>
                </div>
            </form>

        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $("#address").change(function() {
            let city_id = $(this).val()
            $.ajax({
                type: "GET",
                url: "{{ route('get-amount', ':id') }}".replace(':id', city_id),
                data: {
                    city_id
                },
                success: function(response) {
                    $("#amount-shipping").html(response.toLocaleString('vi-VN') + " ₫")

                    $("#amount-shipping-input").val(response)

                    let total = "{{ Cart::total(0, ',', '.') }}";

                    total = parseInt(total.replace(/\./g, '').replace(' ₫', ''), 10)

                    $("#total").html((total + response).toLocaleString('vi-VN') + " ₫")

                    $("#total-input").val((total + response))

                }
            })
        });
    </script>
@endsection
