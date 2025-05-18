@extends('layouts.admin.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">生徒一覧</h2>
        <a href="{{ route('admin.students.create') }}"
           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            新規生徒登録
        </a>
    </div>

    @if (session('success'))
        <div 
            x-data="{ show: true }" 
            x-init="setTimeout(() => show = false, 3000)" 
            x-show="show"
            x-transition
            class="bg-green-100 text-green-800 p-4 rounded mb-4"
        >
            {{ session('success') }}
        </div>
    @endif

    <table class="table-auto w-full bg-white shadow rounded border-t">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2 text-left">ID</th>
                <th class="px-4 py-2 text-left">名前</th>
                <th class="px-4 py-2 text-left">所属レッスン</th>
                <th class="px-4 py-2 text-left">操作</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $student->id }}</td>
                    <td class="px-4 py-2">{{ $student->name }}</td>
                    <td class="px-4 py-2">
                        {{ optional($student->fixedLesson)->title ?? '未設定' }}
                    </td>
                    <td class="px-4 py-2 space-x-2">
                        <a href="{{ route('admin.students.edit', $student->serial_num) }}"
                           class="text-blue-600 hover:underline">編集</a>

                        <form action="{{ route('admin.students.destroy', $student->serial_num) }}" method="POST" class="inline-block"
                              onsubmit="return confirm('本当に削除しますか？')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">削除</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-4 py-6 text-center text-gray-500">登録された生徒がいません。</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
