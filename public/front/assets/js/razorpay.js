$('#razorpay-button').on('click', function () {
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

           // alert('Unable to start payment.');

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

                window.location.href =
                    response.redirect;

            } else {

                alert('Payment verification failed.');
            }
        },

        error: function (xhr) {

            console.log(xhr.responseText);

            alert(
                'Payment was completed but verification failed. Please contact support.'
            );
        }
    });
}
