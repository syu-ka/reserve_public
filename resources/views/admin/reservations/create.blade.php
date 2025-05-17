@extends('layouts.admin.app') {{-- 管理者用レイアウト --}}

@section('content')
<h2>予約作成</h2>

@if(session('success'))
    <div>{{ session('success') }}</div>
@endif

<form action="{{ route('admin.reservations.store') }}" method="POST">
    @csrf
    <div>
        <label>生徒:</label>
        <select name="student_serial_num" required>
            @foreach ($students as $student)
                <option value="{{ $student->serial_num }}">{{ $student->serial_num }} - {{ $student->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label>授業:</label>
        <select name="lesson_id" required>
            @foreach ($lessons as $lesson)
                <option value="{{ $lesson->id }}">{{ $lesson->title }} ({{ $lesson->start_time }})</option>
            @endforeach
        </select>
    </div>
    <button type="submit">予約する</button>
</form>
@endsection