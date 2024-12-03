@extends('admin-panel.layouts.app')
@section('content')

            @if ($data['tournaments']->isNotEmpty())
            <main class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Card 1 -->
                @foreach ($data['tournaments'] as $tournament)
                    <a href="{{route('team.create',['id'=>$tournament->id])}}">
                        <div class="bg-white rounded-lg hover:scale-105 shadow-xl ">
                            <div class="flex items-center justify-between p-3">
                                <div>
                                    <p
                                        class="text-white bg-cover p-1 tracking-wider  font-bold bg-blue-300 rounded-full text-xl inline-block">
                                        {{ $tournament['name'] }}</p>
                                    <h3 class="mt-2 text-lg">Teams Registered:<span>
                                            {{ $tournament['current_teams'] }}</span></h3>
                                </div>
                                <div class="bg-indigo-100 p-3 rounded-full">
                                    <i class="fa-solid fa-trophy text-indigo-500 text-xl"></i>
                                </div>
                            </div>
                            <div
                                class="bg-blue-300 p-2/4 rounded-b-lg font-bold text-white font-outline-2 h-10 flex items-center justify-center  w-full">
                                Add Team
                            </div>
                        </div>
                    </a>
                @endforeach
        </div>
    </main>

    @else
        <div class="flex justify-center items-center h-5/6">
        <p class="text-xl">No tournaments available.</p>
        </div>
        @endif
@endsection
