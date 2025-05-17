@extends('layouts.admin.app')

@section('content')
<div class="max-w-xl mx-auto mt-10">
    <h2 class="text-xl font-bold mb-4">授業の登録</h2>

    {{-- エラー表示 --}}
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

    {{-- フォーム開始 --}}
    <form method="POST" action="{{ route('admin.lessons.store') }}">
        @csrf

        <div class="mb-4">
            <label for="date" class="block font-bold">授業日</label>
            <input type="date" name="date" id="date" class="w-full border p-2 rounded" required>
        </div>

        <!-- <div class="mb-4">
            <label for="fixed_lesson_id" class="block font-bold">定期授業パターンの選択</label>
            <select name="fixed_lesson_id" id="fixed_lesson_id" class="w-full border p-2 rounded" required>
                <option value="">選択してください</option>
                @foreach ($fixedLessons as $pattern)
                    <option value="{{ $pattern->id }}">
                        {{ $pattern->title }}（{{ $pattern->weekday }} {{ \Carbon\Carbon::parse($pattern->start_time)->format('H:i') }}〜）
                    </option>
                @endforeach
            </select>
        </div> -->


        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            授業を登録
        </button>
    </form>
</div>
@endsection
