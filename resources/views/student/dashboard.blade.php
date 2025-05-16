<!DOCTYPE html>
<html>
<head>
    <title>生徒ダッシュボード</title>
</head>
<body>
    <h1>ようこそ、生徒ダッシュボードへ！</h1>

    <form method="POST" action="{{ route('student.logout') }}">
        @csrf
        <button type="submit">ログアウト</button>
    </form>
</body>
</html>
