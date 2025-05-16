<!DOCTYPE html>
<html>
<head>
    <title>生徒ログイン</title>
</head>
<body>
    <h1>生徒ログイン</h1>

    @if(session('error'))
        <div>{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('student.login') }}">
        @csrf
        <div>
            <label for="id">生徒ID</label>
            <input type="text" name="id" required>
        </div>
        <div>
            <label for="password">パスワード</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">ログイン</button>
    </form>
</body>
</html>
