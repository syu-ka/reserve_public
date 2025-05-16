@extends('layouts.admin.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10">
    <h2 class="text-xl font-bold mb-4">生徒一覧</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.students.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">+ 新規登録</a>

    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2">ID</th>
                <th class="border p-2">生徒ID</th>
                <th class="border p-2">名前</th>
                <th class="border p-2">操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td class="border p-2">{{ $student->id }}</td>
                    <td class="border p-2">{{ $student->id }}</td>
                    <td class="border p-2">{{ $student->name }}</td>
                    <td class="border p-2">
                        <a href="{{ route('admin.students.edit', $student->id) }}" class="text-blue-500">編集</a>
                        <form action="{{ route('admin.students.destroy', $student) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('本当に削除しますか？')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $students->links() }} {{-- ページネーション --}}
    </div>
</div>
@endsection

