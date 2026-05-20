<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

    /* Lingkaran kuning kiri */
    .circle-yellow {
        position: absolute;
        top: 50px;
        left: 80px;
        width: 160px;
        height: 160px;
        background: #f5c900;
        border-radius: 50%;
        z-index: 1;
    }

    /* Lingkaran biru kanan */
    .circle-blue {
        position: absolute;
        top: 30px;
        right: 80px;
        width: 150px;
        height: 150px;
        background: #8bd4ff;
        border-radius: 50%;
        z-index: 1;
    }

    /* Wave bawah */
    .bottom-wave {
        position: absolute;
        width: 100%;
        bottom: -10px;
        left: 0;
        z-index: 1;
    }

    /* Card login tetap sama */
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
        margin-bottom: 10px;
    }
</style>

</head>
<body>

    <div class="circle-yellow"></div>
    <div class="circle-blue"></div>
    <img class="bottom-wave" src="{{ asset('images/wave-yellow-blue.png') }}">


    <div class="login-card">

        <img src="{{ asset('images/taspenlogo.jpg') }}" alt="Logo">

        <h3 class="title">Register Admin</h3>

        @if (session('error'))
            <div class="alert alert-danger py-2">{{ session('error') }}</div>
        @endif
        @if (session('success'))
            <div class="alert alert-success py-2">{{ session('success') }}</div>
        @endif

        <form action="{{ route('register.process') }}" method="POST">
            @csrf

            <div class="form-group text-start mb-3">
                <label class="fw-bold">Username</label>
                <input type="text" class="form-control" name="username" required>
            </div>

            <div class="form-group text-start mb-3">
                <label class="fw-bold">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>

            <div class="form-group text-start mb-3">
                <label class="fw-bold">Konfirmasi Password</label>
                <input type="password" class="form-control" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Register</button>

            <a href="{{ route('admin.login') }}" class="d-block mt-3">Sudah punya akun? Login</a>

        </form>
    </div>

</body>
</html>
