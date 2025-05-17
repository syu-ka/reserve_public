@extends('layouts.student.app')

@section('content')
<h2>授業を予約する</h2>

@if ($errors->any())
    <div>
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<form action="{{ route('student.reservations.store') }}" method="POST">
    @csrf
    <label for="lesson_id">授業選択:</label>
    <select name="lesson_id" id="lesson_id">
        @foreach ($lessons as $lesson)
            <option value="{{ $lesson->id }}">{{ $lesson->name }} ({{ $lesson->start_time }})</option>
        @endforeach
    </select>

    <button type="submit">予約する</button>
</form>
@endsection
