@extends('layouts.admin.app') {{-- 管理者用レイアウト --}}

@section('content')
<h1>予約一覧（管理者用）</h1>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>ID</th>
            <th>生徒名</th>
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
                <td>{{ $reservation->student->name }}</td>
                <td>{{ $reservation->lesson->title }}</td>
                <td>{{ $reservation->lesson->start_time }}</td>
                <td>{{ $reservation->lesson->required_time }}</td>
                <td>
                    {{-- 編集や削除など --}}
                    {{-- <a href="{{ route('admin.reservations.edit', $reservation->id) }}">編集</a> --}}
                    {{-- <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST"> --}}
                    {{--     @csrf --}}
                    {{--     @method('DELETE') --}}
                    {{--     <button type="submit">削除</button> --}}
                    {{-- </form> --}}
                    （操作未実装）
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection

