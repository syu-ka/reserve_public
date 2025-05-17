@extends('layouts.admin.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">授業一覧</h1>

    <table class="table-auto w-full">
        <thead>
            <tr>
                <th class="px-4 py-2">タイトル</th>
                <th class="px-4 py-2">日付</th>
                <th class="px-4 py-2">開始時間</th>
                <th class="px-4 py-2">所要時間（分）</th>
                <th class="px-4 py-2">曜日</th>
                <th class="px-4 py-2">定員</th>
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
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
