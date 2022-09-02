@extends('layouts.admin')
@section('page-title')
    {{__('Settings')}}
@endsection

@section('action-button')
@endsection

@push('script-page')
<script>
    $(document).ready(function () {
            if ($('.gdpr_fulltime').is(':checked') ) {

                $('.fulltime').show();
            } else {

                $('.fulltime').hide();
            }

        $('#gdpr_cookie').on('change', function() {
            if ($('.gdpr_fulltime').is(':checked') ) {

                $('.fulltime').show();
            } else {

                $('.fulltime').hide();
            }
        });
    });

</script>
@endpush
@php
    $logo=asset(Storage::url('uploads/logo/'));
$lang=\App\Models\Utility::getValByName('default_language');
@endphp
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <section class="nav-tabs">
                <div class="col-lg-12 our-system">
                    <div class="row">
                        <ul class="nav nav-tabs my-4">
                            <li>
                                <a data-toggle="tab" href="#site-settings" class="active">{{__('Site Setting')}}</a>
                            </li>
                            <li class="annual-billing">
                                <a data-toggle="tab" href="#email-settings" class="">{{__('Email Setting')}} </a>
                            </li>
                            <li class="annual-billing">
                                <a data-toggle="tab" href="#payment-settings" class="">{{__('Payment Setting')}} </a>
                            </li>
                            <li class="annual-billing">
                                <a data-toggle="tab" href="#pusher-settings" class="">{{__('Pusher Setting')}} </a>
                            </li>
                            <li class="annual-billing">
                                <a data-toggle="tab" href="#recaptcha-settings" class="">{{__('ReCaptcha Setting')}} </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div id="site-settings" class="tab-pane in active">
                        {{Form::model($settings,array('url'=>'settings','method'=>'POST','enctype' => "multipart/form-data"))}}
                        <div class="row justify-content-between align-items-center">
                            <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                <h4 class="h4 font-weight-400 float-left pb-2">{{__('Site settings')}}</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-md-6">
                                <h4 class="small-title">{{__('Logo')}}</h4>
                                <div class="card setting-card setting-logo-box">
                                    <div class="logo-content">
                                        <img src="{{$logo.'/logo.png'}}" class="big-logo" alt=""/>
                                    </div>
                                    <div class="choose-file mt-5">
                                        <label for="logo">
                                            <div>{{__('Choose file here')}}</div>
                                            <input type="file" class="form-control" name="logo" id="logo" data-filename="edit-logo">
                                        </label>
                                        <p class="edit-logo"></p>
                                    </div>
                                    <p class="lh-160 mb-0 pt-2">{{__('These Logo will appear on Payslip.')}}</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-md-6">
                                <h4 class="small-title">{{__('Landing Page Logo')}}</h4>
                                <div class="card setting-card setting-logo-box">
                                    <div class="col-12">
                                        <div class="logo-content">
                                            <img src="{{$logo.'/landing_logo.png'}}" class="landing-logo" alt=""/>
                                        </div>
                                        <div class="choose-file mt-4">
                                            <label for="landing-logo">
                                                <div>{{__('Choose file here')}}</div>
                                                <input type="file" class="form-control" name="landing_logo" id="landing-logo" data-filename="edit-landing-logo">
                                            </label>
                                            <p class="edit-landing-logo"></p>
                                        </div>
                                    </div>
                                    <div class="form-group mt-2">
                                        {{Form::label('display_landing_page',__('Landing Page Display'),array('class'=>'form-control-label')) }}
                                        <div class="">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="display_landing_page" id="display_landing_page" {{ $settings['display_landing_page'] == 'on' ? 'checked="checked"' : '' }}>
                                                <label class="custom-control-label form-control-label" for="display_landing_page"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-md-6">
                                <h4 class="small-title">{{__('Favicon')}}</h4>
                                <div class="card setting-card setting-logo-box">
                                    <div class="logo-content">
                                        <img src="{{$logo.'/favicon.png'}}" class="small-logo" alt=""/>
                                    </div>
                                    <div class="choose-file mt-5">
                                        <label for="small-favicon">
                                            <div>{{__('Choose file here')}}</div>
                                            <input type="file" class="form-control" name="favicon" id="small-favicon" data-filename="edit-favicon">
                                        </label>
                                        <p class="edit-favicon"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-md-6">
                                <h4 class="small-title">{{__('Settings')}}</h4>
                                <div class="card setting-card">
                                    <div class="form-group">
                                        {{Form::label('title_text',__('Title Text'),array('class'=>'form-control-label')) }}
                                        {{Form::text('title_text',null,array('class'=>'form-control','placeholder'=>__('Title Text')))}}
                                        @error('title_text')
                                        <span class="invalid-title_text" role="alert">
                                             <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('footer_text',__('Footer Text'),array('class'=>'form-control-label')) }}
                                        {{Form::text('footer_text',null,array('class'=>'form-control','placeholder'=>__('Footer Text')))}}
                                        @error('footer_text')
                                        <span class="invalid-footer_text" role="alert">
                                                                     <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('default_language',__('Default Language'),array('class'=>'form-control-label')) }}
                                        <div class="changeLanguage">
                                            <select name="default_language" id="default_language" class="form-control select2">
                                                @foreach(\App\Models\Utility::languages() as $language)
                                                    <option @if($lang == $language) selected @endif value="{{$language }}">{{Str::upper($language)}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('SITE_RTL',__('RTL'),array('class'=>'form-control-label')) }}
                                        <div class="">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="SITE_RTL" id="SITE_RTL" {{ env('SITE_RTL') == 'on' ? 'checked="checked"' : '' }}>
                                                <label class="custom-control-label form-control-label" for="SITE_RTL"></label>
                                            </div>
                                        </div>
                                    </div>

                                        <div class="form-group">
                                            {{Form::label('disable_signup_button',__('Disable Signup Button'),array('class'=>'form-control-label')) }}
                                                <div class="">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" name="disable_signup_button" id="disable_signup_button" {{ $settings['disable_signup_button'] == 'on' ? 'checked="checked"' : '' }}>
                                                        <label class="custom-control-label form-control-label" for="disable_signup_button"></label>
                                                    </div>
                                                </div>
                                        </div>


                                    <div class="form-group">
                                        {{Form::label('gdpr_cookie',__('GDPR Cookie'),array('class'=>'form-control-label')) }}

                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input gdpr_fulltime gdpr_type" name="gdpr_cookie" id="gdpr_cookie" {{ isset($settings['gdpr_cookie']) && $settings['gdpr_cookie'] == 'on' ? 'checked="checked"' : '' }}>
                                            <label class="custom-control-label form-control-label" for="gdpr_cookie"></label>
                                        </div>
                                    </div>


                                    <div class="form-group">
                        
                                        <textarea id="btn" type="text" name="cookie_text" class="form-control fulltime"
                                        rows="4" style="height: auto"
                                        value="{{ isset($settings['cookie_text']) && $settings['cookie_text'] ? $settings['cookie_text'] : '' }}"
                                        placeholder="{{ isset($settings['cookie_text']) && $settings['cookie_text'] ? $settings['cookie_text'] : '' }}">{{ isset($settings['cookie_text']) && $settings['cookie_text'] ? $settings['cookie_text'] : '' }}</textarea>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-12 text-right">
                                <input type="submit" value="{{__('Save Changes')}}" class="btn-submit">
                            </div>
                        </div>
                        {{Form::close()}}
                    </div>

                    <div id="recaptcha-settings" class="tab-pane">
                        <div class="col-md-12">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                    <h4 class="h4 font-weight-400 float-left pb-2">{{ __('ReCaptcha settings') }}</h4>
                                </div>
                            </div>
                            <div class="card p-3">
                                <form method="POST" action="{{ route('recaptcha.settings.store') }}" accept-charset="UTF-8">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" name="recaptcha_module" id="recaptcha_module" value="yes" {{ env('RECAPTCHA_MODULE') == 'yes' ? 'checked="checked"' : '' }}>
                                                <label class="custom-control-label form-control-label" for="recaptcha_module">
                                                    {{ __('Google Recaptcha') }}
                                                    <a href="https://phppot.com/php/how-to-get-google-recaptcha-site-and-secret-key/" target="_blank" class="text-blue">
                                                        <small>({{__('How to Get Google reCaptcha Site and Secret key')}})</small>
                                                    </a>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                            <label for="google_recaptcha_key" class="form-control-label">{{ __('Google Recaptcha Key') }}</label>
                                            <input class="form-control" placeholder="{{ __('Enter Google Recaptcha Key') }}" name="google_recaptcha_key" type="text" value="{{env('NOCAPTCHA_SITEKEY')}}" id="google_recaptcha_key">
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                            <label for="google_recaptcha_secret" class="form-control-label">{{ __('Google Recaptcha Secret') }}</label>
                                            <input class="form-control " placeholder="{{ __('Enter Google Recaptcha Secret') }}" name="google_recaptcha_secret" type="text" value="{{env('NOCAPTCHA_SECRET')}}" id="google_recaptcha_secret">
                                        </div>
                                    </div>
                                    <div class="col-lg-12  text-right">
                                        <input type="submit" value="{{ __('Save Changes') }}" class="btn-submit text-white">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    

                    <div id="email-settings" class="tab-pane">
                        <div class="col-md-12">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                    <h4 class="h4 font-weight-400 float-left pb-2">{{__('Email settings')}}</h4>
                                </div>
                            </div>
                            <div class="card bg-none company-setting">
                                {{Form::open(array('route'=>'email.settings','method'=>'post'))}}
                                <div class="row">
                                    <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                        {{Form::label('mail_driver',__('Mail Driver'),array('class'=>'form-control-label')) }}
                                        {{Form::text('mail_driver',env('MAIL_DRIVER'),array('class'=>'form-control','placeholder'=>__('Enter Mail Driver')))}}
                                        @error('mail_driver')
                                        <span class="invalid-mail_driver" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                        {{Form::label('mail_host',__('Mail Host'),array('class'=>'form-control-label')) }}
                                        {{Form::text('mail_host',env('MAIL_HOST'),array('class'=>'form-control ','placeholder'=>__('Enter Mail Host')))}}
                                        @error('mail_host')
                                        <span class="invalid-mail_driver" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                        {{Form::label('mail_port',__('Mail Port'),array('class'=>'form-control-label')) }}
                                        {{Form::text('mail_port',env('MAIL_PORT'),array('class'=>'form-control','placeholder'=>__('Enter Mail Port')))}}
                                        @error('mail_port')
                                        <span class="invalid-mail_port" role="alert">
                                                    <strong class="text-danger">{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                        {{Form::label('mail_username',__('Mail Username'),array('class'=>'form-control-label')) }}
                                        {{Form::text('mail_username',env('MAIL_USERNAME'),array('class'=>'form-control','placeholder'=>__('Enter Mail Username')))}}
                                        @error('mail_username')
                                        <span class="invalid-mail_username" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                        {{Form::label('mail_password',__('Mail Password'),array('class'=>'form-control-label')) }}
                                        {{Form::text('mail_password',env('MAIL_PASSWORD'),array('class'=>'form-control','placeholder'=>__('Enter Mail Password')))}}
                                        @error('mail_password')
                                        <span class="invalid-mail_password" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                        {{Form::label('mail_encryption',__('Mail Encryption'),array('class'=>'form-control-label')) }}
                                        {{Form::text('mail_encryption',env('MAIL_ENCRYPTION'),array('class'=>'form-control','placeholder'=>__('Enter Mail Encryption')))}}
                                        @error('mail_encryption')
                                        <span class="invalid-mail_encryption" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                        {{Form::label('mail_from_address',__('Mail From Address'),array('class'=>'form-control-label')) }}
                                        {{Form::text('mail_from_address',env('MAIL_FROM_ADDRESS'),array('class'=>'form-control','placeholder'=>__('Enter Mail From Address')))}}
                                        @error('mail_from_address')
                                        <span class="invalid-mail_from_address" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 form-group">
                                        {{Form::label('mail_from_name',__('Mail From Name'),array('class'=>'form-control-label')) }}
                                        {{Form::text('mail_from_name',env('MAIL_FROM_NAME'),array('class'=>'form-control','placeholder'=>__('Enter Mail From Name')))}}
                                        @error('mail_from_name')
                                        <span class="invalid-mail_from_name" role="alert">
                                                 <strong class="text-danger">{{ $message }}</strong>
                                                 </span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-lg-12 ">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <a href="#" data-url="{{route('test.mail' )}}" data-ajax-popup="true" data-title="{{__('Send Test Mail')}}" class="text-white btn-custom">
                                                {{__('Send Test Mail')}}
                                            </a>
                                        </div>
                                        <div class="form-group col-md-6 text-right">
                                            <input type="submit" value="{{__('Save Changes')}}" class="btn-submit text-white">
                                        </div>
                                    </div>
                                </div>
                                {{Form::close()}}
                            </div>
                        </div>
                    </div>
                    <div id="payment-settings" class="tab-pane">
                        <div class="col-md-12">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                    <h4 class="h4 font-weight-400 float-left pb-2">{{__('Payment settings')}}</h4>
                                </div>
                            </div>
                            <div class="card bg-none company-setting">
                                {{Form::open(array('route'=>'payment.settings','method'=>'post'))}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{Form::label('currency_symbol',__('Currency Symbol *'),array('class'=>'form-control-label')) }}
                                            {{Form::text('currency_symbol',env('CURRENCY_SYMBOL'),array('class'=>'form-control','required','placeholder'=>__('Enter Currency Symbol')))}}
                                            @error('currency_symbol')
                                            <span class="invalid-currency_symbol" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{Form::label('currency',__('Currency *'),array('class'=>'form-control-label')) }}
                                            {{Form::text('currency',env('CURRENCY'),array('class'=>'form-control font-style','required','placeholder'=>__('Enter Currency')))}}
                                            <small> {{__('Note: Add currency code as per three-letter ISO code.')}}<br> <a href="https://stripe.com/docs/currencies" target="_blank">{{__('you can find out here..')}}</a></small> <br>
                                            @error('currency')
                                            <span class="invalid-currency" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div id="accordion-2" class="accordion accordion-spaced">
                                    <!-- Strip -->
                                    <div class="card">
                                        <div class="card-header py-4" id="heading-2-2" data-toggle="collapse" role="button" data-target="#collapse-2-2" aria-expanded="false" aria-controls="collapse-2-2">
                                            <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i>{{__('Stripe')}}</h6>
                                        </div>
                                        <div id="collapse-2-2" class="collapse" aria-labelledby="heading-2-2" data-parent="#accordion-2">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-6 py-2">

                                                        <small class=""> {{__('Note: This detail will use for make checkout of plan.')}}</small>
                                                    </div>
                                                    <div class="col-6 py-2 text-right">
                                                        <div class="custom-control custom-switch">
                                                            <input type="hidden" name="is_stripe_enabled" value="off">
                                                            <input type="checkbox" class="custom-control-input" name="is_stripe_enabled" id="is_stripe_enabled" {{ isset($admin_payment_setting['is_stripe_enabled']) && $admin_payment_setting['is_stripe_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                            <label class="custom-control-label form-control-label" for="is_stripe_enabled">{{__('Enable Stripe')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            {{Form::label('stripe_key',__('Stripe Key'),array('class'=>'form-control-label')) }}
                                                            {{Form::text('stripe_key',isset($admin_payment_setting['stripe_key'])?$admin_payment_setting['stripe_key']:'',['class'=>'form-control','placeholder'=>__('Enter Stripe Key')])}}
                                                            @if ($errors->has('stripe_key'))
                                                                <span class="invalid-feedback d-block">
                                                                    {{ $errors->first('stripe_key') }}
                                                                </span>
                                                            @endif

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            {{Form::label('stripe_secret',__('Stripe Secret'),array('class'=>'form-control-label')) }}
                                                            {{Form::text('stripe_secret',isset($admin_payment_setting['stripe_secret'])?$admin_payment_setting['stripe_secret']:'',['class'=>'form-control ','placeholder'=>__('Enter Stripe Secret')])}}
                                                            @if ($errors->has('stripe_secret'))
                                                                <span class="invalid-feedback d-block">
                                                                    {{ $errors->first('stripe_secret') }}
                                                                </span>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Paypal -->
                                    <div class="card">
                                        <div class="card-header py-4" id="heading-2-3" data-toggle="collapse" role="button" data-target="#collapse-2-3" aria-expanded="false" aria-controls="collapse-2-3">
                                            <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i>{{__('PayPal')}}</h6>
                                        </div>
                                        <div id="collapse-2-3" class="collapse" aria-labelledby="heading-2-3" data-parent="#accordion-2">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-6 py-2">

                                                        <small class=""> {{__('Note: This detail will use for make checkout of plan.')}}</small>
                                                    </div>
                                                    <div class="col-6 py-2 text-right">
                                                        <div class="custom-control custom-switch">
                                                            <input type="hidden" name="is_paypal_enabled" value="off">
                                                            <input type="checkbox" class="custom-control-input" name="is_paypal_enabled" id="is_paypal_enabled" {{ isset($admin_payment_setting['is_paypal_enabled']) && $admin_payment_setting['is_paypal_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                            <label class="custom-control-label form-control-label" for="is_paypal_enabled">{{__('Enable Paypal')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto pb-4">
                                                        <label class="paypal-label form-control-label" for="paypal_mode">{{__('Paypal Mode')}}</label> <br>
                                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                            <label class="btn btn-primary btn-sm {{isset($admin_payment_setting['paypal_mode']) && $admin_payment_setting['paypal_mode'] == 'sandbox' ? 'active' : ''}}">
                                                                <input type="radio" name="paypal_mode" value="sandbox" {{ isset($admin_payment_setting['paypal_mode']) && $admin_payment_setting['paypal_mode'] == '' || isset($admin_payment_setting['paypal_mode']) && $admin_payment_setting['paypal_mode'] == 'sandbox' ? 'checked="checked"' : '' }}>{{__('Sandbox')}}
                                                            </label>
                                                            <label class="btn btn-primary btn-sm {{isset($admin_payment_setting['paypal_mode']) && $admin_payment_setting['paypal_mode'] == 'live' ? 'active' : ''}}">
                                                                <input type="radio" name="paypal_mode" value="live" {{ isset($admin_payment_setting['paypal_mode']) && $admin_payment_setting['paypal_mode'] == 'live' ? 'checked="checked"' : '' }}>{{__('Live')}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="paypal_client_id" class="form-control-label">{{ __('Client ID') }}</label>
                                                            <input type="text" name="paypal_client_id" id="paypal_client_id" class="form-control" value="{{isset($admin_payment_setting['paypal_client_id'])?$admin_payment_setting['paypal_client_id']:''}}" placeholder="{{ __('Client ID') }}"/>
                                                            @if ($errors->has('paypal_client_id'))
                                                                <span class="invalid-feedback d-block">
                                                                    {{ $errors->first('paypal_client_id') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="paypal_secret_key" class="form-control-label">{{ __('Secret Key') }}</label>
                                                            <input type="text" name="paypal_secret_key" id="paypal_secret_key" class="form-control" value="{{isset($admin_payment_setting['paypal_secret_key'])?$admin_payment_setting['paypal_secret_key']:''}}" placeholder="{{ __('Secret Key') }}"/>
                                                            @if ($errors->has('paypal_secret_key'))
                                                                <span class="invalid-feedback d-block">
                                                                    {{ $errors->first('paypal_secret_key') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Paystack -->
                                    <div class="card">
                                        <div class="card-header py-4" id="heading-2-6" data-toggle="collapse" role="button" data-target="#collapse-2-6" aria-expanded="false" aria-controls="collapse-2-6">
                                            <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i>{{__('Paystack')}}</h6>
                                        </div>
                                        <div id="collapse-2-6" class="collapse" aria-labelledby="heading-2-6" data-parent="#accordion-2">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-6 py-2">

                                                        <small> {{__('Note: This detail will use for make checkout of plan.')}}</small>
                                                    </div>
                                                    <div class="col-6 py-2 text-right">
                                                        <div class="custom-control custom-switch">
                                                            <input type="hidden" name="is_paystack_enabled" value="off">
                                                            <input type="checkbox" class="custom-control-input" name="is_paystack_enabled" id="is_paystack_enabled" {{ isset($admin_payment_setting['is_paystack_enabled']) && $admin_payment_setting['is_paystack_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                            <label class="custom-control-label form-control-label" for="is_paystack_enabled">{{__('Enable Paystack')}}</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="paypal_client_id" class="form-control-label">{{ __('Public Key') }}</label>
                                                            <input type="text" name="paystack_public_key" id="paystack_public_key" class="form-control form-control-label" value="{{isset($admin_payment_setting['paystack_public_key']) ? $admin_payment_setting['paystack_public_key']:''}}" placeholder="{{ __('Public Key') }}"/>
                                                            @if ($errors->has('paystack_public_key'))
                                                                <span class="invalid-feedback d-block">
                                                                    {{ $errors->first('paystack_public_key') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="paystack_secret_key" class="form-control-label">{{ __('Secret Key') }}</label>
                                                            <input type="text" name="paystack_secret_key" id="paystack_secret_key" class="form-control form-control-label" value="{{isset($admin_payment_setting['paystack_secret_key']) ? $admin_payment_setting['paystack_secret_key']:''}}" placeholder="{{ __('Secret Key') }}"/>
                                                            @if ($errors->has('paystack_secret_key'))
                                                                <span class="invalid-feedback d-block">
                                                                    {{ $errors->first('paystack_secret_key') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- FLUTTERWAVE -->
                                    <div class="card">
                                        <div class="card-header py-4" id="heading-2-7" data-toggle="collapse" role="button" data-target="#collapse-2-7" aria-expanded="false" aria-controls="collapse-2-7">
                                            <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i>{{__('Flutterwave')}}</h6>
                                        </div>
                                        <div id="collapse-2-7" class="collapse" aria-labelledby="heading-2-7" data-parent="#accordion-2">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-6 py-2">

                                                        <small> {{__('Note: This detail will use for make checkout of plan.')}}</small>
                                                    </div>
                                                    <div class="col-6 py-2 text-right">
                                                        <div class="custom-control custom-switch">
                                                            <input type="hidden" name="is_flutterwave_enabled" value="off">
                                                            <input type="checkbox" class="custom-control-input" name="is_flutterwave_enabled" id="is_flutterwave_enabled" {{ isset($admin_payment_setting['is_flutterwave_enabled'])  && $admin_payment_setting['is_flutterwave_enabled']== 'on' ? 'checked="checked"' : '' }}>
                                                            <label class="custom-control-label form-control-label" for="is_flutterwave_enabled">{{__('Enable Flutterwave')}}</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="paypal_client_id" class="form-control-label">{{ __('Public Key') }}</label>
                                                            <input type="text" name="flutterwave_public_key" id="flutterwave_public_key" class="form-control" value="{{isset($admin_payment_setting['flutterwave_public_key'])?$admin_payment_setting['flutterwave_public_key']:''}}" placeholder="{{ __('Public Key') }}"/>
                                                            @if ($errors->has('flutterwave_public_key'))
                                                                <span class="invalid-feedback d-block">
                                                                    {{ $errors->first('flutterwave_public_key') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="paystack_secret_key" class="form-control-label">{{ __('Secret Key') }}</label>
                                                            <input type="text" name="flutterwave_secret_key" id="flutterwave_secret_key" class="form-control form-control-label" value="{{isset($admin_payment_setting['flutterwave_secret_key'])?$admin_payment_setting['flutterwave_secret_key']:''}}" placeholder="{{ __('Secret Key') }}"/>
                                                            @if ($errors->has('flutterwave_secret_key'))
                                                                <span class="invalid-feedback d-block">
                                                                    {{ $errors->first('flutterwave_secret_key') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Razorpay -->
                                    <div class="card">
                                        <div class="card-header py-4" id="heading-2-8" data-toggle="collapse" role="button" data-target="#collapse-2-8" aria-expanded="false" aria-controls="collapse-2-8">
                                            <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i>{{__('Razorpay')}}</h6>
                                        </div>
                                        <div id="collapse-2-8" class="collapse" aria-labelledby="heading-2-7" data-parent="#accordion-2">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-6 py-2">

                                                        <small> {{__('Note: This detail will use for make checkout of plan.')}}</small>
                                                    </div>
                                                    <div class="col-6 py-2 text-right">
                                                        <div class="custom-control custom-switch">
                                                            <input type="hidden" name="is_razorpay_enabled" value="off">
                                                            <input type="checkbox" class="custom-control-input " name="is_razorpay_enabled" id="is_razorpay_enabled" {{ isset($admin_payment_setting['is_razorpay_enabled']) && $admin_payment_setting['is_razorpay_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                            <label class="custom-control-label form-control-label" for="is_razorpay_enabled">{{__('Enable Razorpay')}}</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="paypal_client_id" class="form-control-label">{{ __('Public Key') }}</label>

                                                            <input type="text" name="razorpay_public_key" id="razorpay_public_key" class="form-control" value="{{ isset($admin_payment_setting['razorpay_public_key'])?$admin_payment_setting['razorpay_public_key']:''}}" placeholder="{{ __('Public Key') }}"/>
                                                            @if ($errors->has('razorpay_public_key'))
                                                                <span class="invalid-feedback d-block">
                                                                    {{ $errors->first('razorpay_public_key') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="paystack_secret_key" class="form-control-label">{{ __('Secret Key') }}</label>
                                                            <input type="text" name="razorpay_secret_key" id="razorpay_secret_key" class="form-control" value="{{ isset($admin_payment_setting['razorpay_secret_key'])?$admin_payment_setting['razorpay_secret_key']:''}}" placeholder="{{ __('Secret Key') }}"/>
                                                            @if ($errors->has('razorpay_secret_key'))
                                                                <span class="invalid-feedback d-block">
                                                                    {{ $errors->first('razorpay_secret_key') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Mercado Pago-->
                                    <div class="card">
                                        <div class="card-header py-4" id="heading-2-12" data-toggle="collapse" role="button" data-target="#collapse-2-12" aria-expanded="false" aria-controls="collapse-2-12">
                                            <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i>{{__('Mercado Pago')}}</h6>
                                        </div>
                                        <div id="collapse-2-12" class="collapse" aria-labelledby="heading-2-12" data-parent="#accordion-2">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-6 py-2">

                                                        <small> {{__('Note: This detail will use for make checkout of plan.')}}</small>
                                                    </div>
                                                    <div class="col-6 py-2 text-right">
                                                        <div class="custom-control custom-switch">
                                                            <input type="hidden" name="is_mercado_enabled" value="off">
                                                            <input type="checkbox" class="custom-control-input" name="is_mercado_enabled" id="is_mercado_enabled" {{isset($admin_payment_setting['is_mercado_enabled']) &&  $admin_payment_setting['is_mercado_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                            <label class="custom-control-label form-control-label" for="is_mercado_enabled">{{__('Enable Mercado Pago')}}</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="mercado_app_id" class="form-control-label">{{ __('App ID') }}</label>
                                                            <input type="text" name="mercado_app_id" id="mercado_app_id" class="form-control" value="{{isset($admin_payment_setting['mercado_app_id']) ?  $admin_payment_setting['mercado_app_id']:''}}" placeholder="{{ __('App ID') }}"/>
                                                            @if ($errors->has('mercado_app_id'))
                                                                <span class="invalid-feedback d-block">
                                                                    {{ $errors->first('mercado_app_id') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="mercado_secret_key" class="form-control-label">{{ __('App Secret KEY') }}</label>
                                                            <input type="text" name="mercado_secret_key" id="mercado_secret_key" class="form-control" value="{{isset($admin_payment_setting['mercado_secret_key']) ? $admin_payment_setting['mercado_secret_key']:''}}" placeholder="{{ __('App Secret Key') }}"/>                                                        @if ($errors->has('mercado_secret_key'))
                                                                <span class="invalid-feedback d-block">
                                                                    {{ $errors->first('mercado_secret_key') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Paytm -->
                                    <div class="card">
                                        <div class="card-header py-4" id="heading-2-8" data-toggle="collapse" role="button" data-target="#collapse-2-9" aria-expanded="false" aria-controls="collapse-2-9">
                                            <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i>{{__('Paytm')}}</h6>
                                        </div>
                                        <div id="collapse-2-9" class="collapse" aria-labelledby="heading-2-7" data-parent="#accordion-2">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-6 py-2">

                                                        <small> {{__('Note: This detail will use for make checkout of plan.')}}</small>
                                                    </div>
                                                    <div class="col-6 py-2 text-right">
                                                        <div class="custom-control custom-switch">
                                                            <input type="hidden" name="is_paytm_enabled" value="off">
                                                            <input type="checkbox" class="custom-control-input" name="is_paytm_enabled" id="is_paytm_enabled" {{ isset($admin_payment_setting['is_paytm_enabled']) && $admin_payment_setting['is_paytm_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                            <label class="custom-control-label form-control-label" for="is_paytm_enabled">{{__('Enable Paytm')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 pb-4">
                                                        <label class="paypal-label form-control-label" for="paypal_mode">{{__('Paytm Environment')}}</label> <br>
                                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                            <label class="btn btn-primary btn-sm {{isset($admin_payment_setting['paytm_mode']) && $admin_payment_setting['paytm_mode'] == 'local' ? 'active' : ''}}">
                                                                <input type="radio" name="paytm_mode" value="local" {{ isset($admin_payment_setting['paytm_mode']) && $admin_payment_setting['paytm_mode'] == '' || isset($admin_payment_setting['paytm_mode']) && $admin_payment_setting['paytm_mode'] == 'local' ? 'checked="checked"' : '' }}>{{__('Local')}}
                                                            </label>
                                                            <label class="btn btn-primary btn-sm {{isset($admin_payment_setting['paytm_mode']) && $admin_payment_setting['paytm_mode'] == 'live' ? 'active' : ''}}">
                                                                <input type="radio" name="paytm_mode" value="production" {{ isset($admin_payment_setting['paytm_mode']) && $admin_payment_setting['paytm_mode'] == 'production' ? 'checked="checked"' : '' }}>{{__('Production')}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="paytm_public_key" class="form-control-label">{{ __('Merchant ID') }}</label>
                                                            <input type="text" name="paytm_merchant_id" id="paytm_merchant_id" class="form-control" value="{{isset($admin_payment_setting['paytm_merchant_id'])? $admin_payment_setting['paytm_merchant_id']:''}}" placeholder="{{ __('Merchant ID') }}"/>
                                                            @if ($errors->has('paytm_merchant_id'))
                                                                <span class="invalid-feedback d-block">
                                                                {{ $errors->first('paytm_merchant_id') }}
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="paytm_secret_key" class="form-control-label">{{ __('Merchant Key') }}</label>
                                                            <input type="text" name="paytm_merchant_key" id="paytm_merchant_key" class="form-control" value="{{ isset($admin_payment_setting['paytm_merchant_key']) ? $admin_payment_setting['paytm_merchant_key']:''}}" placeholder="{{ __('Merchant Key') }}"/>
                                                            @if ($errors->has('paytm_merchant_key'))
                                                                <span class="invalid-feedback d-block">
                                                                {{ $errors->first('paytm_merchant_key') }}
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="paytm_industry_type" class="form-control-label"> {{ __('Industry Type') }}</label>
                                                            <input type="text" name="paytm_industry_type" id="paytm_industry_type" class="form-control" value="{{isset($admin_payment_setting['paytm_industry_type']) ?$admin_payment_setting['paytm_industry_type']:''}}" placeholder="{{ __('Industry Type') }}"/>
                                                            @if ($errors->has('paytm_industry_type'))
                                                                <span class="invalid-feedback d-block">
                                                                {{ $errors->first('paytm_industry_type') }}
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Mollie -->
                                    <div class="card">
                                        <div class="card-header py-4" id="heading-2-8" data-toggle="collapse" role="button" data-target="#collapse-2-10" aria-expanded="false" aria-controls="collapse-2-10">
                                            <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i>{{__('Mollie')}}</h6>
                                        </div>
                                        <div id="collapse-2-10" class="collapse" aria-labelledby="heading-2-7" data-parent="#accordion-2">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-6 py-2">

                                                        <small> {{__('Note: This detail will use for make checkout of plan.')}}</small>
                                                    </div>
                                                    <div class="col-6 py-2 text-right">
                                                        <div class="custom-control custom-switch">
                                                            <input type="hidden" name="is_mollie_enabled" value="off">
                                                            <input type="checkbox" class="custom-control-input" name="is_mollie_enabled" id="is_mollie_enabled" {{ isset($admin_payment_setting['is_mollie_enabled']) && $admin_payment_setting['is_mollie_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                            <label class="custom-control-label form-control-label" for="is_mollie_enabled">{{__('Enable Mollie')}}</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="mollie_api_key" class="form-control-label">{{ __('Mollie Api Key') }}</label>
                                                            <input type="text" name="mollie_api_key" id="mollie_api_key" class="form-control" value="{{ isset($admin_payment_setting['mollie_api_key'])?$admin_payment_setting['mollie_api_key']:''}}" placeholder="{{ __('Mollie Api Key') }}"/>
                                                            @if ($errors->has('mollie_api_key'))
                                                                <span class="invalid-feedback d-block">
                                                                    {{ $errors->first('mollie_api_key') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="mollie_profile_id" class="form-control-label">{{ __('Mollie Profile Id') }}</label>
                                                            <input type="text" name="mollie_profile_id" id="mollie_profile_id" class="form-control" value="{{ isset($admin_payment_setting['mollie_profile_id'])?$admin_payment_setting['mollie_profile_id']:''}}" placeholder="{{ __('Mollie Profile Id') }}"/>
                                                            @if ($errors->has('mollie_profile_id'))
                                                                <span class="invalid-feedback d-block">
                                                                    {{ $errors->first('mollie_profile_id') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="mollie_partner_id" class="form-control-label">{{ __('Mollie Partner Id') }}</label>
                                                            <input type="text" name="mollie_partner_id" id="mollie_partner_id" class="form-control" value="{{ isset($admin_payment_setting['mollie_partner_id'])?$admin_payment_setting['mollie_partner_id']:''}}" placeholder="{{ __('Mollie Partner Id') }}"/>
                                                            @if ($errors->has('mollie_partner_id'))
                                                                <span class="invalid-feedback d-block">
                                                                    {{ $errors->first('mollie_partner_id') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Skrill -->
                                    <div class="card">
                                        <div class="card-header py-4" id="heading-2-8" data-toggle="collapse" role="button" data-target="#collapse-2-13" aria-expanded="false" aria-controls="collapse-2-10">
                                            <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i>{{__('Skrill')}}</h6>
                                        </div>
                                        <div id="collapse-2-13" class="collapse" aria-labelledby="heading-2-7" data-parent="#accordion-2">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-6 py-2">

                                                        <small> {{__('Note: This detail will use for make checkout of plan.')}}</small>
                                                    </div>
                                                    <div class="col-6 py-2 text-right">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" name="is_skrill_enabled" id="is_skrill_enabled" {{ isset($admin_payment_setting['is_skrill_enabled']) && $admin_payment_setting['is_skrill_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                            <label class="custom-control-label form-control-label" for="is_skrill_enabled">{{__('Enable Skrill')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="mollie_api_key" class="form-control-label">{{ __('Skrill Email') }}</label>
                                                            <input type="email" name="skrill_email" id="skrill_email" class="form-control" value="{{ isset($admin_payment_setting['skrill_email'])?$admin_payment_setting['skrill_email']:''}}" placeholder="{{ __('Mollie Api Key') }}"/>
                                                            @if ($errors->has('skrill_email'))
                                                                <span class="invalid-feedback d-block">
                                                                    {{ $errors->first('skrill_email') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- CoinGate -->
                                    <div class="card">
                                        <div class="card-header py-4" id="heading-2-8" data-toggle="collapse" role="button" data-target="#collapse-2-15" aria-expanded="false" aria-controls="collapse-2-10">
                                            <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i>{{__('CoinGate')}}</h6>
                                        </div>
                                        <div id="collapse-2-15" class="collapse" aria-labelledby="heading-2-7" data-parent="#accordion-2">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-6 py-2">

                                                        <small> {{__('Note: This detail will use for make checkout of plan.')}}</small>
                                                    </div>
                                                    <div class="col-6 py-2 text-right">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" name="is_coingate_enabled" id="is_coingate_enabled" {{ isset($admin_payment_setting['is_coingate_enabled']) && $admin_payment_setting['is_coingate_enabled'] == 'on' ? 'checked="checked"' : '' }}>
                                                            <label class="custom-control-label form-control-label" for="is_coingate_enabled">{{__('Enable CoinGate')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 pb-4">
                                                        <label class="coingate-label form-control-label" for="coingate_mode">{{__('CoinGate Mode')}}</label> <br>
                                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                            <label class="btn btn-primary btn-sm {{isset($admin_payment_setting['coingate_mode']) && $admin_payment_setting['coingate_mode'] == 'sandbox' ? 'active' : ''}}">
                                                                <input type="radio" name="coingate_mode" value="sandbox" {{ isset($admin_payment_setting['coingate_mode']) && $admin_payment_setting['coingate_mode'] == '' || isset($admin_payment_setting['coingate_mode']) && $admin_payment_setting['coingate_mode'] == 'sandbox' ? 'checked="checked"' : '' }}>{{__('Sandbox')}}
                                                            </label>
                                                            <label class="btn btn-primary btn-sm {{isset($admin_payment_setting['coingate_mode']) && $admin_payment_setting['coingate_mode'] == 'live' ? 'active' : ''}}">
                                                                <input type="radio" name="coingate_mode" value="live" {{ isset($admin_payment_setting['coingate_mode']) && $admin_payment_setting['coingate_mode'] == 'live' ? 'checked="checked"' : '' }}>{{__('Live')}}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="coingate_auth_token" class="form-control-label">{{ __('CoinGate Auth Token') }}</label>
                                                            <input type="text" name="coingate_auth_token" id="coingate_auth_token" class="form-control" value="{{ isset($admin_payment_setting['coingate_auth_token'])?$admin_payment_setting['coingate_auth_token']:''}}" placeholder="{{ __('CoinGate Auth Token') }}"/>
                                                            @if($errors->has('coingate_auth_token'))
                                                                <span class="invalid-feedback d-block">
                                                                {{ $errors->first('coingate_auth_token') }}
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-12  text-right">
                                    <input type="submit" value="{{__('Save Changes')}}" class="btn-submit text-white">
                                </div>
                                {{Form::close()}}
                            </div>

                        </div>

                    </div>
                    <div id="pusher-settings" class="tab-pane">
                        <div class="col-md-12">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                    <h4 class="h4 font-weight-400 float-left pb-2">{{__('Pusher settings')}}</h4>
                                </div>
                            </div>
                            <div class="card bg-none company-setting">
                                {{Form::open(array('route'=>'pusher.settings','method'=>'post'))}}
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                        {{Form::label('pusher_app_id',__('Pusher App Id'),['class'=>'form-control-label']) }}
                                        {{Form::text('pusher_app_id',env('PUSHER_APP_ID'),array('class'=>'form-control','placeholder'=>__('Enter Pusher App Id')))}}
                                        @error('pusher_app_id')
                                        <span class="invalid-pusher_app_id" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                        {{Form::label('pusher_app_key',__('Pusher App Key'),['class'=>'form-control-label']) }}
                                        {{Form::text('pusher_app_key',env('PUSHER_APP_KEY'),array('class'=>'form-control ','placeholder'=>__('Enter Pusher App Key')))}}
                                        @error('pusher_app_key')
                                        <span class="invalid-pusher_app_key" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                        {{Form::label('pusher_app_secret',__('Pusher App Secret'),['class'=>'form-control-label']) }}
                                        {{Form::text('pusher_app_secret',env('PUSHER_APP_SECRET'),array('class'=>'form-control ','placeholder'=>__('Enter Pusher App Secret')))}}
                                        @error('pusher_app_secret')
                                        <span class="invalid-pusher_app_secret" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                        {{Form::label('pusher_app_cluster',__('Pusher App Cluster'),['class'=>'form-control-label']) }}
                                        {{Form::text('pusher_app_cluster',env('PUSHER_APP_CLUSTER'),array('class'=>'form-control ','placeholder'=>__('Enter Pusher App Cluster')))}}
                                        @error('pusher_app_cluster')
                                        <span class="invalid-pusher_app_cluster" role="alert">
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        </span>
                                        @enderror
                                    </div>


                                </div>
                                <div class="col-lg-12  text-right">
                                    <input type="submit" value="{{__('Save Changes')}}" class="btn-submit text-white">
                                </div>
                                {{Form::close()}}
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </div>
@endsection


