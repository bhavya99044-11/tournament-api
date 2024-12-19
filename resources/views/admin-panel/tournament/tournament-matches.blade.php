@extends('admin-panel.layouts.app')
@section('content')
    <div class="h-screen w-full text-center pt-5 bg-gray-200 font-sans">
        <div class=" font-serif text-2xl font-bold">{{$data['tournament']->name}}</div>
        <div class=" font-serif text-gray-900 text-lg mt-5 ">Matches</div>

        <div class="grid grid-cols-3 m-10 gap-4">
            @foreach($data['tournament']['matches'] as $match)
            <a href="{{route('match.show',['id'=>$match->id])}}" class="body bg-white h-44 shadow-md hover:border-green-400 border rounded-lg">
                <div class="flex flex-col items-strech">
                    <div class="flex justify-between p-3">
                        <div class="text-blue-500 text-xl flex ">{{$match->homeTeam->name}}</div>
                        <div class=" text-xl text-blue-500 float-end">10</div>
                    </div>
                    <div class="flex justify-between p-3">
                        <div class=" text-xl text-red-500 float-end">{{$match->opponentTeam->name}}</div>
                        <div class=" text-xl text-red-500 float-end">10</div>
                    </div>
                <div class="flex justify-between p-3 mt-3">
                    <div class="text-gray-700 text-lg font-bold">Round 1</div>
                    @if(!empty($match->result_id))
                    <div class="text-green-500 font-bold text-lg">completed</div>
                    @else
                    <div class="text-yellow-500 font-bold text-lg">Not started</div>
                    @endif
                </div>
            </div>
            </a>
            @endforeach
        </div>
    </div>
@endsection
@push('scripts')

@endpush
