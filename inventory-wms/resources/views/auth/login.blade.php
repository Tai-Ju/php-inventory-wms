<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登入 · 實習倉 WMS</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="gate-body">
    <form class="gate" method="post" action="{{ route('login') }}">
        @csrf
        <p class="eyebrow">NTUNHS · WMS LAB</p>
        <h1>倉管登入</h1>
        <p class="muted">示範帳號 warehouse@example.com / password</p>
        <label>Email
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
        </label>
        @error('email')<small class="err">{{ $message }}</small>@enderror
        <label>密碼
            <input type="password" name="password" required>
        </label>
        <label class="inline">
            <input type="checkbox" name="remember" value="1"> 記住我（Cookie）
        </label>
        <button class="btn">進入倉庫</button>
        <p><a href="{{ route('register') }}">沒有帳號？註冊</a></p>
    </form>
</body>
</html>
