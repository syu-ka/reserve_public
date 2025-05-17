@extends('layouts.student.app') {{-- 生徒用レイアウト（例） --}}

@section('content')
<h1>自分の予約一覧</h1>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>予約ID</th>
            <th>授業名</th>
            <th>開始時間</th>
            <th>終了時間</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reservations as $reservation)
            <tr>
                <td>{{ $reservation->id }}</td>
                <td>{{ $reservation->lesson->title }}</td>
                <td>{{ $reservation->lesson->start_time }}</td>
                <td>{{ $reservation->lesson->end_time }}</td>
                <td>
                    {{-- キャンセル機能など --}}
                    {{-- <form action="{{ route('student.reservations.cancel', $reservation->id) }}" method="POST"> --}}
                    {{--     @csrf --}}
                    {{--     <button type="submit">キャンセル</button> --}}
                    {{-- </form> --}}
                    （操作未実装）
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
