@extends('front.layouts.app')
@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
     <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
@section('body')
    <body class="product-page">
    @endsection
    @section('content')
        <main class="checkout-page">

            <!--Page Banner-->
            <div class="page-banner cart-page-banner text-center">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="text-uppercase">PAYMENT</h1>
                            <!--Breadcrums-->
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb justify-content-center mb-0">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('site.home')</a> <span><i
                                                class="cps cp-caret-right"></i></span></li>
                                    <li class="breadcrumb-item active" aria-current="page">@lang('site.payment')</li>
                                </ol>
                            </nav>
                            <!--End Breadcrums-->
                        </div>
                    </div>
                </div>
            </div>
            <!--End Page Banner-->

            <!--Checkout Content-->
           <div class="modal fade" id="paymentModal"
     tabindex="-1"
     style="display:block;">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">
                <h5>Order Created</h5>
            </div>

            <div class="modal-body text-center">

                <h5>
                    Order #{{ $order->id }}
                </h5>

                <p>
                    Amount:
                    ₹{{ number_format($order->total_price, 2) }}
                </p>

                <button type="button"
                        id="payNow"
                        data-name="{{ $order->id }}"
                        class="btn btn-primary">

                    Pay Now

                </button>
            </div>
        </div>
    </div>
</div>
            <!--End Checkout Content-->
        </main>
    @endsection
    @push('js')
<script>

$(document).ready(function() {
     $('#paymentModal').modal({
        backdrop: 'static',
        keyboard: false
    });
    $('#paymentModal').modal('show');
});


$('#payNow').on('click', function () {
    let button = $(this);
    
    let orderId = $(this).data("name");
    button.prop('disabled', true);

    $.ajax({

        url: "{{ route('razorpay.createOrder') }}",

        type: "POST",

        data: {
            _token: "{{ csrf_token() }}",
            order_id: orderId
        },

        success: function (response) {

            if (!response.success) {
                alert('Unable to create payment order.');
                button.prop('disabled', false);
                return;
            }

            let options = {

                key: response.key,

                amount: response.amount,

                currency: response.currency,

                name: "{{ config('app.name') }}",

                description: "Order #" + response.order_id,

                order_id: response.razorpay_order_id,

                prefill: {
                    name: "{{ auth()->user()->name ?? '' }}",
                    email: "{{ auth()->user()->email ?? '' }}",
                    contact: "{{ auth()->user()->phone ?? '' }}"
                },

                theme: {
                    color: "#0d6efd"
                },

                handler: function (payment) {
 // console.log('Razorpay response:', payment);
                    verifyPayment(payment);
                },

                modal: {

                    ondismiss: function () {

                        button.prop('disabled', false);

                        console.log('Payment popup closed');
                    }
                }
            };

            let razorpay = new Razorpay(options);

            razorpay.on('payment.failed', function (response) {

                console.log(response.error);

                alert(
                    response.error.description ||
                    'Payment failed.'
                );

                button.prop('disabled', false);
            });

            razorpay.open();
        },

        error: function (xhr) {

            console.log(xhr.responseText);

            alert('Unable to start payment.');

            button.prop('disabled', false);
        }
    });
});

function verifyPayment(payment) {

    $.ajax({

        url: "{{ route('razorpay.verify') }}",

        type: "POST",

        data: {

            _token: "{{ csrf_token() }}",

            razorpay_payment_id:
                payment.razorpay_payment_id,

            razorpay_order_id:
                payment.razorpay_order_id,

            razorpay_signature:
                payment.razorpay_signature
        },

        success: function (response) {

            if (response.success) {
                   // alert('Payment verified.');
                window.location.href = response.redirect;
             //   window.location.href = "{{ route('users.index') }}";
            }
        },

        error: function (xhr) {
          //  console.log('STATUS:', xhr.status);
          //  console.log('RESPONSE:', xhr.responseText);
            if (xhr.status === 422) {
                console.log('VALIDATION ERRORS:', xhr.responseJSON);
            }
            alert(
                'Payment was completed but verification failed. Please contact support.'
            );
            window.location.href = response.redirect;
          //  window.location.href = "{{ route('users.index') }}";
        }
    });
}
        </script>
    @endpush
