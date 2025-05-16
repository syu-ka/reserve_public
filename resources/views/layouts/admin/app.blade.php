<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', '管理者ページ')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100">
    <nav class="bg-white p-4 shadow">
        <div class="container mx-auto">
            <a href="{{ route('admin.dashboard') }}" class="text-lg font-bold">管理者ダッシュボード</a>
        </div>
    </nav>
    <main class="container mx-auto mt-6">
        @yield('content')
    </main>
</body>
</html>