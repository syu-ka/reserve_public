<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理者画面 | 教室予約管理システム</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-50 min-h-screen">

<header class="bg-white p-4 shadow flex justify-between items-center">
    <h1 class="text-xl font-bold text-gray-800">教室予約管理（管理者用）</h1>

    @if(Auth::guard('admin')->check())
        <nav class="flex items-center space-x-6 text-sm text-gray-700">
            <!-- <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">ダッシュボード</a> -->
            <a href="{{ route('admin.reservations.index') }}" class="hover:text-blue-600">予約管理</a>
            <a href="{{ route('admin.lessons.index') }}" class="hover:text-blue-600">レッスン管理</a>
            <a href="{{ route('admin.students.index') }}" class="hover:text-blue-600">生徒管理</a>
            

            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open"
                        class="hover:text-blue-600 border border-gray-300 rounded px-2 py-1">
                    ログイン中：{{ Auth::guard('admin')->user()->name }}
                </button>
                <div x-show="open" @click.outside="open = false"
                    class="absolute right-0 mt-2 w-40 bg-white border rounded shadow z-50">
                    <form method="POST" action="{{ route('admin.logout') }}" onsubmit="return">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-100">
                            ログアウト
                        </button>
                    </form>
                </div>
            </div>
        </nav>
    @else
        <span class="text-sm text-gray-400">未ログイン</span>
    @endif
</header>


    <main class="p-6">
        @yield('content')
    </main>
</body>
</html>
