@extends('layouts.admin.app')

@section('content')
<div class="max-w-xl mx-auto mt-10">
    <h2 class="text-xl font-bold mb-4">レッスン日を選んで登録</h2>

    {{-- 成功メッセージ --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- バリデーションエラー表示 --}}
    @if($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="ml-4">
        <p class="text-sm text-gray-700 mb-6">
            選択した「レッスン日」の<strong>曜日</strong>に該当する全ての「定期レッスン」を一括で作成します。<br>
            作成されるレッスンには、その定期レッスンに所属する全生徒の<strong>予約が自動で追加</strong>されます。
        </p>
    </div>

    {{-- レッスン日だけの登録フォーム --}}
    <form action="{{ route('admin.lessons.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="date" class="block font-semibold">レッスン日</label>
            <input type="date" name="date" id="date" value="{{ old('date') }}" class="w-full border p-2 rounded">
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                登録する
            </button>
        </div>
    </form>
</div>
@endsection
