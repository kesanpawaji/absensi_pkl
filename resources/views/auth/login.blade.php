<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #d9e6f5 0%, #b9d3f2 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        /* background circle */
        .circle-yellow {
            position: absolute;
            top: 40px;
            left: 40px;
            width: 150px;
            height: 150px;
            background: #f5c900;
            border-radius: 50%;
        }

        .circle-blue {
            position: absolute;
            top: 20px;
            right: 40px;
            width: 130px;
            height: 130px;
            background: #8bd4ff;
            border-radius: 50%;
        }

        .bottom-wave {
            position: absolute;
            bottom: -40px;
            left: 0;
            width: 100%;
        }

        .login-card {
            width: 430px;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            text-align: center;
            position: relative;
            z-index: 10;
        }

        .login-card img {
            width: 150px;
            margin-bottom: 15px;
        }

        .input-group {
            text-align: left;
            margin-top: 20px;
        }

        .input-group label {
            font-weight: 600;
            font-size: 14px;
            display: block;
            margin-bottom: 5px;
        }

        .input-group input {
            width: 100%;
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .btn-login {
            width: 100%;
            margin-top: 30px;
            padding: 12px;
            background: #2d47f7;
            border: none;
            color: white;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-login:hover {
            background: #1b32c8;
        }

        .forgot {
            text-align: left;
            margin-top: 10px;
            font-size: 13px;
            color: #555;
        }

        .register {
            margin-top: 25px;
            font-size: 14px;
        }

        .register a {
            color: #2d47f7;
            font-weight: 600;
            text-decoration: none;
        }
    </style>

</head>
<body>

    <div class="circle-yellow"></div>
    <div class="circle-blue"></div>

  <img class="bottom-wave" src="{{ asset('images/wave-yellow-blue.png') }}">

  <div class="login-card">
    <img src="{{ asset('images/taspenlogo.jpg') }}" alt="Taspen Logo">


        <h3 style="font-weight:600; margin-top:10px;">SELAMAT DATANG DI HALAMAN LOGIN</h3>

        @if(session('error'))
            <div style="color:red; margin-top:10px;">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('login.process') }}">
            @csrf

            <div class="input-group">
                <label>Email</label>
                <input type="text" name="username" placeholder="Masukkan email" required>
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan Password" required>
            </div>

            <div class="forgot">Lupa Password?</div>

            <button class="btn-login">Login</button>
        </form>
        <div class="register">
              Belum Mempunyai Akun? <a href="{{ route('admin.register') }}">Daftar disini</a>
       </div>

    </div>

</body>
</html>
