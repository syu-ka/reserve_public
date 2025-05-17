@extends('layouts.admin.app')

@section('content')
<div class="max-w-xl mx-auto mt-10">
    <h2 class="text-xl font-bold mb-4">授業の登録</h2>

    {{-- エラーメッセージ --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 成功メッセージ --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.lessons.store') }}">
        @csrf

        <div class="mb-4">
            <label for="date" class="block">授業日</label>
            <input type="date" name="date" id="date" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label for="time_slot" class="block">開始時間</label>
            <input type="time" name="time_slot" id="time_slot" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label for="capacity" class="block">定員</label>
            <input type="number" name="capacity" id="capacity" class="w-full border p-2 rounded" min="1" required>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            登録する
        </button>
    </form>
</div>
@endsection
