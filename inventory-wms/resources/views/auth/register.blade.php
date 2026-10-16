<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>註冊 · 實習倉 WMS</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="gate-body">
    <form class="gate" method="post" action="{{ route('register') }}">
        @csrf
        <p class="eyebrow">NTUNHS · WMS LAB</p>
        <h1>建立倉管帳號</h1>
        <label>姓名 <input name="name" value="{{ old('name') }}" required></label>
        @error('name')<small class="err">{{ $message }}</small>@enderror
        <label>Email <input type="email" name="email" value="{{ old('email') }}" required></label>
        @error('email')<small class="err">{{ $message }}</small>@enderror
        <label>密碼（至少 8 碼，會用 password_hash）
            <input type="password" name="password" required>
        </label>
        @error('password')<small class="err">{{ $message }}</small>@enderror
        <label>確認密碼 <input type="password" name="password_confirmation" required></label>
        <button class="btn">註冊並登入</button>
        <p><a href="{{ route('login') }}">回登入</a></p>
    </form>
</body>
</html>
