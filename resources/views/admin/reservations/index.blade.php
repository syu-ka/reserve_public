@extends('layouts.admin.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">予約一覧</h2>
        <a href="{{ route('admin.lessons.create') }}"
           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            定期レッスンの追加＆予約
        </a>
    </div>

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show"
             x-init="setTimeout(() => show = false, 3000)"
             class="bg-green-100 text-green-800 p-4 rounded mb-4 transition">
            {{ session('success') }}
        </div>
    @endif

    <table class="table-auto w-full bg-white shadow rounded border-t">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2 text-left">生徒名</th>
                <th class="px-4 py-2 text-left">レッスン名</th>
                <th class="px-4 py-2 text-left">日付</th>
                <th class="px-4 py-2 text-left">開始時間</th>
                <th class="px-4 py-2 text-left">所要時間</th>
                <th class="px-4 py-2 text-left">操作</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reservations as $reservation)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $reservation->student->name }}</td>
                    <td class="px-4 py-2">{{ $reservation->lesson->title }}</td>
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($reservation->lesson->date)->isoFormat('YYYY/MM/DD(dd)') }}</td>
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($reservation->lesson->start_time)->format('H:i') }}</td>
                    <td class="px-4 py-2">{{ $reservation->lesson->required_time }}分</td>
                    <td class="px-4 py-2">
                        <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST"
                              onsubmit="return confirm('この予約をキャンセルしますか？')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-red-600 border border-red-400 rounded px-3 py-1 hover:bg-red-100 transition">
                                キャンセル
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">予約がありません。</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
