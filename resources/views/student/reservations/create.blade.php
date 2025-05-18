@extends('layouts.student.app')

@section('content')
<div class="mb-4">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-semibold text-gray-800">予約可能なレッスン</h2>
        <p class="text-sm text-gray-700">あと <span class="font-semibold">{{ $remainingTickets }}</span> 回 予約可能です</p>
    </div>

    @if ($remainingTickets <= 0)
        <div class="mt-2 bg-yellow-100 text-yellow-800 p-3 rounded">
            <p>新規予約したい場合は、予約済レッスンをキャンセルしてください。</p>
            <a href="{{ route('student.reservations.index') }}"
               class="text-blue-600 underline  hover:font-semibold transition duration-200 inline-block mt-1">
                予約済レッスンを見る
            </a>
        </div>
    @endif
</div>

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show"
             x-init="setTimeout(() => show = false, 3000)"
             class="bg-green-100 text-green-800 p-4 rounded mb-4 transition">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" x-show="show"
             x-init="setTimeout(() => show = false, 3000)"
             class="bg-red-100 text-red-800 p-4 rounded mb-4 transition">
            {{ session('error') }}
        </div>
    @endif

    <table class="table-auto w-full bg-white shadow rounded border-t">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2 text-left">レッスン名</th>
                <th class="px-4 py-2 text-left">日付</th>
                <th class="px-4 py-2 text-left">開始時間</th>
                <th class="px-4 py-2 text-left">所要時間</th>
                <th class="px-4 py-2 text-left">残り座席数</th>
                <th class="px-4 py-2 text-left">操作</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($lessons as $lesson)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $lesson->title }}</td>
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($lesson->date)->isoFormat('YYYY/MM/DD(dd)') }}</td>
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($lesson->start_time)->format('H:i') }}</td>
                    <td class="px-4 py-2">{{ $lesson->required_time }}分</td>
                    <td class="px-4 py-2">{{ $lesson->capacity - $lesson->reservations_count }}名</td>
                    <td class="px-4 py-2">
                        @if (in_array($lesson->id, $reservedLessonIds))
                            <span class="text-gray-500">予約済</span>
                        @elseif ($lesson->capacity - $lesson->reservations_count <= 0)
                            <span class="text-red-500">満席</span>
                        @elseif ($remainingTickets <= 0)
                            <span class="text-red-500">チケット不足</span>
                        @else
                            <form action="{{ route('student.reservations.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="lesson_id" value="{{ $lesson->id }}">
                                <button type="submit"
                                        class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition">
                                    予約する
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">予約可能な授業がありません。</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
