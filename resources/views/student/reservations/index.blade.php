@extends('layouts.student.app')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800 mb-1">予約済レッスン</h2>
            <p class="text-sm text-gray-600">
                レッスン開始時間までにキャンセルされた場合は、予約可能回数の払い戻しがされます。
            </p>
        </div>

        <div class="text-right text-sm text-gray-700">
            <p class="mb-2">あと <span class="font-semibold">{{ $remainingTickets }}</span> 回 予約可能です</p>
            @if ($remainingTickets > 0)
                <a href="{{ route('student.reservations.create') }}"
                   class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    ＋新規予約をする
                </a>
            @endif
        </div>
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
                <th class="px-4 py-2 text-left">レッスン名</th>
                <th class="px-4 py-2 text-left">日付</th>
                <th class="px-4 py-2 text-left">開始時間</th>
                <th class="px-4 py-2 text-left">所要時間</th>
                <th class="px-4 py-2 text-left">操作</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservations as $reservation)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $reservation->lesson->title }}</td>
                    <td class="px-4 py-2">
                        {{ \Carbon\Carbon::parse($reservation->lesson->date)->isoFormat('YYYY/MM/DD(dd)') }}
                    </td>
                    <td class="px-4 py-2">
                        {{ \Carbon\Carbon::parse($reservation->lesson->start_time)->format('H:i') }}
                    </td>
                    <td class="px-4 py-2">{{ $reservation->lesson->required_time }}分</td>
                    <td class="px-4 py-2">
                        <form action="{{ route('student.reservations.destroy', $reservation->id) }}" method="POST"
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
                    <td colspan="5" class="px-4 py-6 text-center text-gray-500">予約がありません。</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
