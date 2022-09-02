@extends('layouts.admin')
@push('script-page')


    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script type="text/javascript">
            @if($plan->price > 0.0 && $admin_payment_setting['is_stripe_enabled'] == 'on' && !empty($admin_payment_setting['stripe_key']) && !empty($admin_payment_setting['stripe_secret']))
        var stripe = Stripe('{{ $admin_payment_setting['stripe_key'] }}');
        var elements = stripe.elements();

        // Custom styling can be passed to options when creating an Element.
        var style = {
            base: {
                // Add your base input styles here. For example:
                fontSize: '14px',
                color: '#32325d',
            },
        };

        // Create an instance of the card Element.
        var card = elements.create('card', {style: style});

        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#card-element');

        // Create a token or display an error when the form is submitted.
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            stripe.createToken(card).then(function (result) {
                if (result.error) {
                    $("#card-errors").html(result.error.message);
                    toastrs('Error', result.error.message, 'error');
                } else {
                    // Send the token to your server.
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }

        @endif

        $(document).ready(function () {
            $(document).on('click', '.apply-coupon', function () {

                var ele = $(this);

                var coupon = ele.closest('.row').find('.coupon').val();

                $.ajax({
                    url: '{{route('apply.coupon')}}',
                    datType: 'json',
                    data: {
                        plan_id: '{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}',
                        coupon: coupon
                    },
                    success: function (data) {

                        if (data != '') {
                            $('.final-price').text(data.final_price);
                            $('#stripe_coupon, #paypal_coupon').val(coupon);

                            if (data.is_success) {
                                show_toastr('Success', data.message, 'success');
                            } else {
                                show_toastr('Error', data.message, 'error');
                            }
                        } else {
                            show_toastr('Error', "{{__('Coupon code required.')}}", 'error');
                        }
                    }
                })
            });
        });
        </script>
        @if(!empty($paymentSetting['is_paystack_enabled']) && isset($paymentSetting['is_paystack_enabled']) && $paymentSetting['is_paystack_enabled'] == 'on')
        <script>
        $(document).on("click", "#pay_with_paystack", function () {
            $('#paystack-payment-form').ajaxForm(function (res) {
                if (res.flag == 1) {
                    var paystack_callback = "{{ url('/plan/paystack') }}";
                    var order_id = '{{time()}}';
                    var coupon_id = res.coupon;
                    var handler = PaystackPop.setup({
                        key: '{{ $admin_payment_setting['paystack_public_key']  }}',
                        email: res.email,
                        amount: res.total_price * 100,
                        currency: res.currency,
                        ref: 'pay_ref_id' + Math.floor((Math.random() * 1000000000) +
                            1
                        ), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
                        metadata: {
                            custom_fields: [{
                                display_name: "Email",
                                variable_name: "email",
                                value: res.email,
                            }]
                        },

                        callback: function (response) {
                            console.log(response.reference, order_id);
                            window.location.href = paystack_callback + '/' + response.reference + '/' + '{{encrypt($plan->id)}}' + '?coupon_id=' + coupon_id
                        },
                        onClose: function () {
                            alert('window closed');
                        }
                    });
                    handler.openIframe();
                } else if (res.flag == 2) {

                } else {
                    show_toastr('Error', data.message, 'msg');
                }

            }).submit();
        });
        </script>
        @endif
        <script>

        //    Flaterwave Payment
    </script>
        @if(!empty($paymentSetting['is_flutterwave_enabled']) && isset($paymentSetting['is_flutterwave_enabled']) && $paymentSetting['is_flutterwave_enabled'] == 'on')
    <script>
        $(document).on("click", "#pay_with_flaterwave", function () {
            $('#flaterwave-payment-form').ajaxForm(function (res) {
                if (res.flag == 1) {
                    var coupon_id = res.coupon;
                    var API_publicKey = '{{ $admin_payment_setting['flutterwave_public_key']  }}';
                    var nowTim = "{{ date('d-m-Y-h-i-a') }}";
                    var flutter_callback = "{{ url('/plan/flaterwave') }}";
                    var x = getpaidSetup({
                        PBFPubKey: API_publicKey,
                        customer_email: '{{Auth::user()->email}}',
                        amount: res.total_price,
                        currency: '{{env('CURRENCY')}}',
                        txref: nowTim + '__' + Math.floor((Math.random() * 1000000000)) + 'fluttpay_online-' + {{ date('Y-m-d') }},
                        meta: [{
                            metaname: "payment_id",
                            metavalue: "id"
                        }],
                        onclose: function () {
                        },
                        callback: function (response) {
                            var txref = response.tx.txRef;
                            if (
                                response.tx.chargeResponseCode == "00" ||
                                response.tx.chargeResponseCode == "0"
                            ) {
                                window.location.href = flutter_callback + '/' + txref + '/' + '{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}?coupon_id=' + coupon_id;
                            } else {
                                // redirect to a failure page.
                            }
                            x.close(); // use this to close the modal immediately after payment.
                        }
                    });
                } else if (res.flag == 2) {

                } else {
                    show_toastr('Error', data.message, 'msg');
                }

            }).submit();
        });
    </script>
        @endif
    <script>
        // Razorpay Payment
    </script>
        @if(!empty($paymentSetting['is_razorpay_enabled']) && isset($paymentSetting['is_razorpay_enabled']) && $paymentSetting['is_razorpay_enabled'] == 'on')
    <script>
        $(document).on("click", "#pay_with_razorpay", function () {
            $('#razorpay-payment-form').ajaxForm(function (res) {
                if (res.flag == 1) {

                    var razorPay_callback = '{{url('/plan/razorpay')}}';
                    var totalAmount = res.total_price * 100;
                    var coupon_id = res.coupon;
                    var options = {
                        "key": "{{ $admin_payment_setting['razorpay_public_key']  }}", // your Razorpay Key Id
                        "amount": totalAmount,
                        "name": 'Plan',
                        "currency": '{{env('CURRENCY')}}',
                        "description": "",
                        "handler": function (response) {
                            window.location.href = razorPay_callback + '/' + response.razorpay_payment_id + '/' + '{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}?coupon_id=' + coupon_id;
                        },
                        "theme": {
                            "color": "#528FF0"
                        }
                    };
                    var rzp1 = new Razorpay(options);
                    rzp1.open();
                } else if (res.flag == 2) {

                } else {
                    show_toastr('Error', data.message, 'msg');
                }

            }).submit();
        });
        
        @endif

    </script>
@endpush
@php
    $dir= asset(Storage::url('uploads/plan'));
    $dir_payment= asset(Storage::url('uploads/payments'));

@endphp
@section('page-title')
    {{__('Manage Order Summary')}}
@endsection
@section('content')
    <div class="row plan-div">
        <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6">
            <div class="plan-3">
                <h6>{{$plan->name}}</h6>
                <p class="price">
                    <small class="final-price">
                        <sup>{{!empty(env('CURRENCY'))?env('CURRENCY'):'$'}}</sup>
                        {{$plan->price}}
                    </small>
                    <sub>{{__('Duration : ').ucfirst($plan->duration)}}</sub>
                </p>
                <p class="price-text"></p>
                <ul class="plan-detail">
                    <li>{{($plan->max_users==-1)?__('Unlimited'):$plan->max_users}} {{__('Users')}}</li>
                    <li>{{($plan->max_employees==-1)?__('Unlimited'):$plan->max_employees}} {{__('Employees')}}</li>
                </ul>
            </div>
        </div>

        <div class="col-md-8">
            <section class="nav-tabs">
                <div class="row our-system">
                    <ul class="nav nav-tabs">

                        @if($admin_payment_setting['is_stripe_enabled'] == 'on' && !empty($admin_payment_setting['stripe_key']) && !empty($admin_payment_setting['stripe_secret']))
                            <li>
                                <a data-toggle="tab" class="active" id="contact-tab1" href="#stripe_payment">{{__('Stripe')}}</a>
                            </li>
                        @endif

                        @if($admin_payment_setting['is_paypal_enabled'] == 'on' && !empty($admin_payment_setting['paypal_client_id']) && !empty($admin_payment_setting['paypal_secret_key']))
                            <li>
                                <a data-toggle="tab" id="contact-tab2" href="#paypal_payment">{{__('Paypal')}}</a>
                            </li>
                        @endif

                        @if($admin_payment_setting['is_paystack_enabled'] == 'on' && !empty($admin_payment_setting['paystack_public_key']) && !empty($admin_payment_setting['paystack_secret_key']))
                            <li>
                                <a data-toggle="tab" id="contact-tab3" href="#paystack_payment">{{__('Paystack')}}</a>
                            </li>
                        @endif
                        @if(isset($admin_payment_setting['is_flutterwave_enabled']) && $admin_payment_setting['is_flutterwave_enabled'] == 'on')
                            <li>
                                <a data-toggle="tab" id="contact-tab4" href="#flutterwave_payment">{{__('Flutterwave')}}</a>
                            </li>
                        @endif
                        @if(isset($admin_payment_setting['is_razorpay_enabled']) && $admin_payment_setting['is_razorpay_enabled'] == 'on')
                            <li>
                                <a data-toggle="tab" id="contact-tab5" href="#razorpay_payment">{{__('Razorpay')}}</a>
                            </li>
                        @endif
                        @if(isset($admin_payment_setting['is_mercado_enabled']) && $admin_payment_setting['is_mercado_enabled'] == 'on')
                            <li>
                                <a data-toggle="tab" id="contact-tab6" href="#mercado_payment">{{__('Mercado Pago')}}</a>
                            </li>
                        @endif
                        @if(isset($admin_payment_setting['is_paytm_enabled']) && $admin_payment_setting['is_paytm_enabled'] == 'on')
                            <li>
                                <a data-toggle="tab" id="contact-tab7" href="#paytm_payment">{{__('Paytm')}}</a>
                            </li>
                        @endif
                        @if(isset($admin_payment_setting['is_mollie_enabled']) && $admin_payment_setting['is_mollie_enabled'] == 'on')
                            <li>
                                <a data-toggle="tab" id="contact-tab8" href="#mollie_payment">{{__('Mollie')}}</a>
                            </li>
                        @endif
                        @if(isset($admin_payment_setting['is_skrill_enabled']) && $admin_payment_setting['is_skrill_enabled'] == 'on')
                            <li>
                                <a data-toggle="tab" id="contact-tab9" href="#skrill_payment">{{__('Skrill')}}</a>
                            </li>
                        @endif
                        @if(isset($admin_payment_setting['is_coingate_enabled']) && $admin_payment_setting['is_coingate_enabled'] == 'on')
                            <li>
                                <a data-toggle="tab" id="contact-tab10" href="#coingate_payment">{{__('Coingate')}}</a>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="tab-content">
                    @if($admin_payment_setting['is_stripe_enabled'] == 'on' && !empty($admin_payment_setting['stripe_key']) && !empty($admin_payment_setting['stripe_secret']))
                        <div class="tab-pane {{ (($admin_payment_setting['is_stripe_enabled'] == 'on' && !empty($admin_payment_setting['stripe_key']) && !empty($admin_payment_setting['stripe_secret'])) == 'on') ? "active" : "" }}" id="stripe_payment">
                            <div class="card">
                                <form role="form" action="{{ route('stripe.post') }}" method="post" class="require-validation" id="payment-form">
                                    @csrf
                                    <div class="border p-3 mb-3 rounded stripe-payment-div">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <div class="custom-radio">
                                                    <label class="font-16 font-weight-bold">{{__('Credit / Debit Card')}}</label>
                                                </div>
                                                <p class="mb-0 pt-1 text-sm">{{__('Safe money transfer using your bank account. We support Mastercard, Visa, Discover and American express.')}}</p>
                                            </div>
                                            <div class="col-sm-4 text-sm-right mt-3 mt-sm-0">
                                                <img src="{{asset('public/assets/img/payments/master.png')}}" height="24" alt="master-card-img">
                                                <img src="{{asset('public/assets/img/payments/discover.png')}}" height="24" alt="discover-card-img">
                                                <img src="{{asset('public/assets/img/payments/visa.png')}}" height="24" alt="visa-card-img">
                                                <img src="{{asset('public/assets/img/payments/american express.png')}}" height="24" alt="american-express-card-img">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="card-name-on" class="form-control-label text-dark">{{__('Name on card')}}</label>
                                                    <input type="text" name="name" id="card-name-on" class="form-control required" placeholder="{{\Auth::user()->name}}">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div id="card-element">
                                                    <!-- A Stripe Element will be inserted here. -->
                                                </div>
                                                <div id="card-errors" role="alert"></div>
                                            </div>
                                            <div class="col-md-10 mt-4">
                                                <div class="form-group">
                                                    <input type="text" id="stripe_coupon" name="coupon" class="form-control coupon" placeholder="{{ __('Enter Coupon Code') }}">
                                                </div>
                                            </div>
                                            <div class="col-auto my-auto">
                                                <a href="#" class="apply-btn apply-coupon" data-toggle="tooltip" data-title="{{__('Apply')}}"><i class="fas fa-save"></i></a>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="error" style="display: none;">
                                                    <div class='alert-danger alert'>{{__('Please correct the errors and try again.')}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end Credit/Debit Card box-->
                                    <div class="row mt-3">
                                        <div class="col-sm-12">
                                            <div class="text-sm-right">
                                                <input type="hidden" name="plan_id" value="{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}">
                                                <input type="submit" value="{{__('Pay Now')}}" class="btn-create badge-blue">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif

                    @if($admin_payment_setting['is_paypal_enabled'] == 'on' && !empty($admin_payment_setting['paypal_client_id']) && !empty($admin_payment_setting['paypal_secret_key']))
                        <div class="tab-pane {{ (($admin_payment_setting['is_stripe_enabled'] != 'on' && $admin_payment_setting['is_paypal_enabled'] == 'on' && !empty($admin_payment_setting['paypal_client_id']) && !empty($admin_payment_setting['paypal_secret_key'])) == 'on') ? "active" : "" }}" id="paypal_payment">
                            <div class="card">
                                <form class="w3-container w3-display-middle w3-card-4" method="POST" id="payment-form" action="{{ route('plan.pay.with.paypal') }}">
                                    @csrf
                                    <input type="hidden" name="plan_id" value="{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}">

                                    <div class="border p-3 mb-3 rounded">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label for="paypal_coupon" class="form-control-label">{{__('Coupon')}}</label>
                                                    <input type="text" id="paypal_coupon" name="coupon" class="form-control coupon" placeholder="{{ __('Enter Coupon Code') }}">
                                                </div>
                                            </div>
                                            <div class="col-auto my-auto">
                                                <a href="#" class="apply-btn apply-coupon" data-toggle="tooltip" data-title="{{__('Apply')}}"><i class="fas fa-save"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <div class="text-sm-right">
                                            <input type="submit" value="{{__('Pay Now')}}" class="btn-create badge-blue">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif

                    @if($admin_payment_setting['is_paystack_enabled'] == 'on' && !empty($admin_payment_setting['paystack_public_key']) && !empty($admin_payment_setting['paystack_secret_key']))
                        <div class="tab-pane " id="paystack_payment">
                            <div class="card">
                                <form class="w3-container w3-display-middle w3-card-4" method="POST" id="paystack-payment-form" action="{{ route('plan.pay.with.paystack') }}">
                                    @csrf
                                    <input type="hidden" name="plan_id" value="{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}">

                                    <div class="border p-3 mb-3 rounded">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label for="paypal_coupon" class="form-control-label">{{__('Coupon')}}</label>
                                                    <input type="text" id="paystack_coupon" name="coupon" class="form-control coupon" data-from="paystack" placeholder="{{ __('Enter Coupon Code') }}">
                                                </div>
                                            </div>
                                            <div class="col-auto my-auto">
                                                <a href="#" class="apply-btn apply-coupon" data-toggle="tooltip" data-title="{{__('Apply')}}"><i class="fas fa-save"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <div class="text-sm-right">
                                            <input type="button" id="pay_with_paystack" value="{{__('Pay Now')}}" class="btn-create badge-blue">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif

                    @if(isset($admin_payment_setting['is_flutterwave_enabled']) && $admin_payment_setting['is_flutterwave_enabled'] == 'on')
                        <div class="tab-pane " id="flutterwave_payment">
                            <div class="card">
                                <form role="form" action="{{ route('plan.pay.with.flaterwave') }}" method="post" class="require-validation" id="flaterwave-payment-form">
                                    @csrf
                                    <input type="hidden" name="plan_id" value="{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}">

                                    <div class="border p-3 mb-3 rounded">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label for="paypal_coupon" class="form-control-label">{{__('Coupon')}}</label>
                                                    <input type="text" id="flaterwave_coupon" name="coupon" class="form-control coupon" placeholder="{{ __('Enter Coupon Code') }}">
                                                </div>
                                            </div>
                                            <div class="col-auto my-auto">
                                                <a href="#" class="apply-btn apply-coupon" data-toggle="tooltip" data-title="{{__('Apply')}}"><i class="fas fa-save"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <div class="text-sm-right">
                                            <input type="button" id="pay_with_flaterwave" value="{{__('Pay Now')}}" class="btn-create badge-blue">
                                        </div>
                                    </div>
                                </form>
                            </div>


                        </div>
                    @endif

                    @if(isset($admin_payment_setting['is_razorpay_enabled']) && $admin_payment_setting['is_razorpay_enabled'] == 'on')
                        <div class="tab-pane " id="razorpay_payment">
                            <div class="card">
                                <form role="form" action="{{ route('plan.pay.with.razorpay') }}" method="post" class="require-validation" id="razorpay-payment-form">
                                    @csrf
                                    <input type="hidden" name="plan_id" value="{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}">

                                    <div class="border p-3 mb-3 rounded">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label for="paypal_coupon" class="form-control-label">{{__('Coupon')}}</label>
                                                    <input type="text" id="razorpay_coupon" name="coupon" class="form-control coupon" data-from="razorpay" placeholder="{{ __('Enter Coupon Code') }}">
                                                </div>
                                            </div>
                                            <div class="col-auto my-auto">
                                                <a href="#" class="apply-btn apply-coupon" data-toggle="tooltip" data-title="{{__('Apply')}}"><i class="fas fa-save"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <div class="text-sm-right">
                                            <input type="button" id="pay_with_razorpay" value="{{__('Pay Now')}}" class="btn-create badge-blue">
                                        </div>
                                    </div>
                                </form>
                            </div>


                        </div>
                    @endif

                    @if(isset($admin_payment_setting['is_mercado_enabled']) && $admin_payment_setting['is_mercado_enabled'] == 'on')
                        <div class="tab-pane " id="mercado_payment">
                            <div class="card">
                                <form role="form" action="{{ route('plan.pay.with.mercado') }}" method="post" class="require-validation" id="mercado-payment-form">
                                    @csrf
                                    <input type="hidden" name="plan_id" value="{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}">

                                    <div class="border p-3 mb-3 rounded">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label for="paypal_coupon" class="form-control-label">{{__('Coupon')}}</label>
                                                    <input type="text" id="mercado_coupon" name="coupon" class="form-control coupon" data-from="mercado" placeholder="{{ __('Enter Coupon Code') }}">
                                                </div>
                                            </div>
                                            <div class="col-auto my-auto">
                                                <a href="#" class="apply-btn apply-coupon" data-toggle="tooltip" data-title="{{__('Apply')}}"><i class="fas fa-save"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <div class="text-sm-right">
                                            <input type="submit" id="pay_with_mercado" value="{{__('Pay Now')}}" class="btn-create badge-blue">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif

                    @if(isset($admin_payment_setting['is_paytm_enabled']) && $admin_payment_setting['is_paytm_enabled'] == 'on')
                        <div class="tab-pane " id="paytm_payment">
                            <div class="card">
                                <form role="form" action="{{ route('plan.pay.with.paytm') }}" method="post" class="require-validation" id="paytm-payment-form">
                                    @csrf
                                    <input type="hidden" name="plan_id" value="{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}">

                                    <div class="border p-3 mb-3 rounded">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label for="paypal_coupon" class="form-control-label">{{__('Coupon')}}</label>
                                                    <input type="text" id="paytm_coupon" name="coupon" class="form-control coupon" data-from="paytm" placeholder="{{ __('Enter Coupon Code') }}">
                                                </div>
                                            </div>
                                            <div class="col-auto my-auto">
                                                <a href="#" class="apply-btn apply-coupon" data-toggle="tooltip" data-title="{{__('Apply')}}"><i class="fas fa-save"></i></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="flaterwave_coupon" class="form-control-label text-dark">{{__('Mobile Number')}}</label>
                                                    <input type="text" id="mobile" name="mobile" class="form-control mobile" data-from="mobile" placeholder="{{ __('Enter Mobile Number') }}" required>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <div class="text-sm-right">
                                            <input type="submit" id="pay_with_paytm" value="{{__('Pay Now')}}" class="btn-create badge-blue">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif

                    @if(isset($admin_payment_setting['is_mollie_enabled']) && $admin_payment_setting['is_mollie_enabled'] == 'on')
                        <div class="tab-pane " id="mollie_payment">
                            <div class="card">
                                <form role="form" action="{{ route('plan.pay.with.mollie') }}" method="post" class="require-validation" id="mollie-payment-form">
                                    @csrf
                                    <input type="hidden" name="plan_id" value="{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}">

                                    <div class="border p-3 mb-3 rounded">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label for="paypal_coupon" class="form-control-label">{{__('Coupon')}}</label>
                                                    <input type="text" id="mollie_coupon" name="coupon" class="form-control coupon" data-from="mollie" placeholder="{{ __('Enter Coupon Code') }}">
                                                </div>
                                            </div>
                                            <div class="col-auto my-auto">
                                                <a href="#" class="apply-btn apply-coupon" data-toggle="tooltip" data-title="{{__('Apply')}}"><i class="fas fa-save"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <div class="text-sm-right">
                                            <input type="submit" id="pay_with_mollie" value="{{__('Pay Now')}}" class="btn-create badge-blue">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif

                    @if(isset($admin_payment_setting['is_skrill_enabled']) && $admin_payment_setting['is_skrill_enabled'] == 'on')
                        <div class="tab-pane " id="skrill_payment">
                            <div class="card">
                                <form role="form" action="{{ route('plan.pay.with.skrill') }}" method="post" class="require-validation" id="skrill-payment-form">
                                    @csrf
                                    <input type="hidden" name="plan_id" value="{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}">

                                    <div class="border p-3 mb-3 rounded">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label for="paypal_coupon" class="form-control-label">{{__('Coupon')}}</label>
                                                    <input type="text" id="skrill_coupon" name="coupon" class="form-control coupon" data-from="skrill" placeholder="{{ __('Enter Coupon Code') }}">
                                                </div>
                                            </div>
                                            <div class="col-auto my-auto">
                                                <a href="#" class="apply-btn apply-coupon" data-toggle="tooltip" data-title="{{__('Apply')}}"><i class="fas fa-save"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $skrill_data = [
                                            'transaction_id' => md5(date('Y-m-d') . strtotime('Y-m-d H:i:s') . 'user_id'),
                                            'user_id' => 'user_id',
                                            'amount' => 'amount',
                                            'currency' => 'currency',
                                        ];
                                        session()->put('skrill_data', $skrill_data);

                                    @endphp
                                    <div class="form-group mt-3">
                                        <div class="text-sm-right">
                                            <input type="submit" id="pay_with_skrill" value="{{__('Pay Now')}}" class="btn-create badge-blue">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif

                    @if(isset($admin_payment_setting['is_coingate_enabled']) && $admin_payment_setting['is_coingate_enabled'] == 'on')
                        <div class="tab-pane " id="coingate_payment">
                            <div class="card">
                                <form role="form" action="{{ route('plan.pay.with.coingate') }}" method="post" class="require-validation" id="coingate-payment-form">
                                    @csrf
                                    <input type="hidden" name="plan_id" value="{{\Illuminate\Support\Facades\Crypt::encrypt($plan->id)}}">

                                    <div class="border p-3 mb-3 rounded">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label for="paypal_coupon" class="form-control-label">{{__('Coupon')}}</label>
                                                    <input type="text" id="coingate_coupon" name="coupon" class="form-control coupon" data-from="coingate" placeholder="{{ __('Enter Coupon Code') }}">
                                                </div>
                                            </div>
                                            <div class="col-auto my-auto">
                                                <a href="#" class="apply-btn apply-coupon" data-toggle="tooltip" data-title="{{__('Apply')}}"><i class="fas fa-save"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <div class="text-sm-right">
                                            <input type="submit" id="pay_with_coingate" value="{{__('Pay Now')}}" class="btn-create badge-blue">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
@endsection

