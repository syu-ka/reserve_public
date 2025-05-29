@extends('layouts.admin.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">レッスン管理</h2>
        <a href="{{ route('admin.lessons.create') }}"
           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            定期レッスンの追加＆予約
        </a>
    </div>

    @if(session('success'))
        <div 
            x-data="{ show: true }" 
            x-init="setTimeout(() => show = false, 3000)" 
            x-show="show"
            x-transition
            class="bg-green-100 text-green-800 p-4 rounded mb-4"
        >
            {{ session('success') }}
        </div>
    @endif

    @if(session('warnings'))
        <div 
            x-data="{ show: true }" 
            x-init="setTimeout(() => show = false, 3000)" 
            x-show="show" 
            x-transition
            class="bg-yellow-100 text-yellow-800 p-4 rounded mb-4"
        >
            <ul class="list-disc pl-5">
                @foreach (session('warnings') as $warning)
                    <li>{{ $warning }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <table class="table-auto w-full bg-white shadow rounded border-t">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-2">レッスン名</th>
                <th class="px-4 py-2">日付</th>
                <th class="px-4 py-2">開始時間</th>
                <th class="px-4 py-2">所要時間</th>
                <th class="px-4 py-2">定員</th>
                <th class="px-4 py-2">予約数</th>
                <th class="px-4 py-2">操作</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lessons as $lesson)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $lesson->title }}</td>

                    <td class="px-4 py-2">
                        {{ \Carbon\Carbon::parse($lesson->date)->format('Y/m/d') }}
                        ({{ \Carbon\Carbon::parse($lesson->date)->isoFormat('dd') }})
                    </td>

                    <td class="px-4 py-2">
                        {{ \Carbon\Carbon::parse($lesson->start_time)->format('H:i') }}
                    </td>

                    <td class="px-4 py-2">{{ $lesson->required_time }}分</td>
                    <td class="px-4 py-2">{{ $lesson->capacity }}名</td>
                    <td class="px-4 py-2">{{ $lesson->reservations_count }}名</td>

                    <td class="px-4 py-2">
                        <form action="{{ route('admin.lessons.destroy', $lesson->id) }}" method="POST"
                              onsubmit="return confirm('この授業を削除しますか？')" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">削除</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">登録された授業はありません。</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
