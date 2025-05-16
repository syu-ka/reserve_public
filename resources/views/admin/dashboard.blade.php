<!DOCTYPE html>
<html>
<head>
    <title>管理者ダッシュボード</title>
</head>
<body>
    <h1>ようこそ、管理者ダッシュボードへ！</h1>

    <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit">ログアウト</button>
    </form>
</body>
</html>
