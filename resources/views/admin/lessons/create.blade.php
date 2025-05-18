@extends('layouts.admin.app')

@section('content')
<div class="max-w-xl mx-auto mt-10">
    <h2 class="text-xl font-bold mb-4">授業日を選んで登録</h2>

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

    {{-- 授業日だけの登録フォーム --}}
    <form action="{{ route('admin.lessons.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="date" class="block font-semibold">授業日</label>
            <input type="date" name="date" id="date" value="{{ old('date') }}" class="w-full border p-2 rounded">
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded">
                授業を登録
            </button>
        </div>
    </form>
</div>
@endsection
