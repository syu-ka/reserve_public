@extends('layouts.admin.app')

@section('content')
<div class="max-w-xl mx-auto mt-10">
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
            <a href="{{ route('admin.students.index') }}">生徒一覧</a>
        </div>
    @endif

    <h2 class="text-xl font-bold mb-4">生徒を登録</h2>

    <form action="{{ route('admin.students.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="id" class="block">生徒ID</label>
            <input type="text" name="id" id="id" class="w-full border p-2 rounded" value="{{ old('id') }}">
            @error('id')<div class="text-red-600">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label for="name" class="block">名前</label>
            <input type="text" name="name" id="name" class="w-full border p-2 rounded" value="{{ old('name') }}">
            @error('name')<div class="text-red-600">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label for="fixed_lesson_id" class="block">定期授業パターン</label>
            <select name="fixed_lesson_id" id="fixed_lesson_id" class="w-full border p-2 rounded">
                <option value="">選択してください</option>
                @foreach($fixedLessons as $fixed)
                    <option value="{{ $fixed->id }}" {{ old('fixed_lesson_id') == $fixed->id ? 'selected' : '' }}>
                        {{ $fixed->title }}（{{ $fixed->weekday }} {{ \Carbon\Carbon::parse($fixed->start_time)->format('H:i') }}〜）
                    </option>
                @endforeach
            </select>
            @error('fixed_lesson_id')<div class="text-red-600">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block">パスワード</label>
            <input type="password" name="password" id="password" class="w-full border p-2 rounded">
            @error('password')<div class="text-red-600">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block">パスワード確認</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border p-2 rounded">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">登録</button>
    </form>
</div>
@endsection
