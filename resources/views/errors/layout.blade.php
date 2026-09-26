<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Error' }} | Jamwal Motors and Spares</title>

    <link rel="stylesheet"
          href="{{ asset('front/assets/css/plugins.css') }}">

    <link rel="stylesheet"
          href="{{ asset('front/assets/css/style.css') }}">

    <link rel="stylesheet"
          href="{{ asset('front/assets/css/responsive.css') }}">

    <style>
        .error-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 15px;
            background: #f8f8f8;
            text-align: center;
        }

        .error-box {
            width: 100%;
            max-width: 650px;
            padding: 45px 25px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
        }

        .error-code {
            font-size: clamp(70px, 15vw, 150px);
            font-weight: 700;
            line-height: 1;
            margin-bottom: 20px;
        }

        .error-title {
            font-size: clamp(22px, 4vw, 36px);
            margin-bottom: 15px;
        }

        .error-message {
            font-size: 16px;
            color: #666;
            margin-bottom: 25px;
        }

        .error-button {
            display: inline-block;
            padding: 12px 25px;
            color: #fff;
            background: #222;
            border-radius: 5px;
            text-decoration: none;
            transition: 0.2s ease;
        }

        .error-button:hover {
            color: #fff;
            opacity: 0.85;
        }

        @media (max-width: 575px) {
            .error-box {
                padding: 35px 18px;
            }

            .error-message {
                font-size: 14px;
            }

            .error-button {
                width: 100%;
                max-width: 250px;
            }
        }
    </style>
</head>

<body>

    <main class="error-page">
        <div class="error-box">

            <div class="error-code">
                {{ $code ?? 'Error' }}
            </div>

            <h1 class="error-title">
                {{ $title ?? 'Something went wrong' }}
            </h1>

            <p class="error-message">
                {{ $message ?? 'Sorry, an unexpected error occurred.' }}
            </p>

            <a href="{{ url('/en') }}" class="error-button">
                Back to Home
            </a>

        </div>
    </main>

</body>
</html>