<!DOCTYPE html>
<html>
<head>
    <title>管理者ログイン</title>
</head>
<body>
    <h1>管理者ログイン</h1>

    @if(session('error'))
        <div>{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login') }}">
        @csrf
        <div>
            <label for="email">メールアドレス</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label for="password">パスワード</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">ログイン</button>
    </form>
</body>
</html>
