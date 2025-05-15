<x-app-layout>
    <x-slot name="header">

    @if (Auth::user()->role === 'staff')
    <h1>スタッフ用ダッシュボード</h1>
    <a href="{{ route('lessons.index') }}">授業一覧</a>
    <a href="{{ route('students.index') }}">生徒管理</a>
    @elseif (Auth::user()->role === 'parent')
    <h1>保護者用ダッシュボード</h1>
    <a href="{{ route('reservations.index') }}">予約一覧</a>
    @endif

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
