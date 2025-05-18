@extends('layouts.admin.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">授業一覧</h1>

    {{-- 成功メッセージ --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- 警告メッセージ --}}
    @if(session('warnings'))
        <div class="bg-yellow-100 text-yellow-800 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach (session('warnings') as $warning)
                    <li>{{ $warning }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 授業追加ボタン --}}
    <div class="mb-4">
        <a href="{{ route('admin.lessons.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            定期授業の追加
        </a>
    </div>

    <table class="table-auto w-full">
        <thead>
            <tr>
                <th class="px-4 py-2">タイトル</th>
                <th class="px-4 py-2">日付</th>
                <th class="px-4 py-2">開始時間</th>
                <th class="px-4 py-2">所要時間（分）</th>
                <th class="px-4 py-2">曜日</th>
                <th class="px-4 py-2">定員</th>
                <th class="px-4 py-2">予約数</th>
                <th class="px-4 py-2">操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lessons as $lesson)
                <tr>
                    <td class="border px-4 py-2">{{ $lesson->title }}</td>
                    <td class="border px-4 py-2">{{ $lesson->date }}</td>
                    <td class="border px-4 py-2">{{ $lesson->start_time }}</td>
                    <td class="border px-4 py-2">{{ $lesson->required_time }}</td>
                    <td class="border px-4 py-2">{{ $lesson->weekday }}</td>
                    <td class="border px-4 py-2">{{ $lesson->capacity }}</td>
                    <td class="border px-4 py-2">{{ $lesson->reservations->count() }} 名</td>
                    <td class="border px-4 py-2">
                        <form action="{{ route('admin.lessons.destroy', $lesson->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                削除
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
