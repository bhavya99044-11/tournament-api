@extends('admin-panel.layouts.app')

<head>
    <meta name="csrf_token" content="{{ csrf_token() }}">
</head>
@section('content')
    <div class="h-full w-full p-10  font-sans bg-gray-200">
        <div class="font-extrabold text-4xl pt-4 text-center ">{{ $data['match']['tournament']->name }}</div>
        <div class="flex w-full items-center justify-center">
            <div><i class="fa-solid fa-location-dot text-lg text-red-600"></i></div>
            <div class="ml-1 text-gray-600 font-bold">
                {{ $data['match']['tournament']->location }}<span
                    class="ml-2">{{ \Carbon\Carbon::parse($data['match']['tournament']->start_datetime)->format('Y-m-d') }}</span>
            </div>
        </div>

        <div class="flex justify-between mt-5 p-5 bg-white shadow-lg text-center">
            <div class="flex flex-col">
                <div class="font-semibold text-2xl">{{ $data['match']['home_team_name'] }}</div>
                <div class="flex items-center h-5"><i class="fa-solid fa-users-line text-blue-500"></i><span
                        class="font-semibold ml-1 text-base">{{ $data['match']['home_team_player_count'] }}</span></div>
            </div>
            <div class="flex flex-col">
                <div class="text-4xl font-[1000] text-gray-400">VS</div>
                <button id="generateRecord" class="p-1 text-white font-semibold rounded-lg bg-blue-500" data-id="{{ $data['match']->id }}">Start Match</button>
            </div>
            <div class="flex flex-col">
                <div class="font-semibold text-2xl">{{ $data['match']['opponent_team_name'] }}</div>
                <div class="flex items-center h-5"><i class="fa-solid fa-users-line text-blue-500"></i><span
                        class="font-semibold ml-1 text-base">{{ $data['match']['opponent_team_player_count'] }}</span></div>
            </div>
        </div>

        <div class="grid grid-cols-2 mt-5 gap-5">
                @forelse ($data['match']['matchRecords'] as $key => $match)
                    <div class="bg-white p-5 shadow-md rounded-lg">
                        <div class="flex justify-between">
                            <div>Record{{ $key + 1 }}</div>
                            <div><i class="fa-regular fa-clock"></i>
                                <span class="">{{ \Carbon\Carbon::parse($match->created_at)->format('H:i') }}</span>
                            </div>
                        </div>
                        <div class="flex font-bold justify-between">
                            <div class="text-2xl text-green-400">{{$match->home_team_score}}</div>
                            <div class="">vs</div>
                            <div class="text-2xl text-red-500">{{$match->opponent_team_score}}</div>
                        </div>
                    </div>
                    @empty
                    <div>No records available</div>
                @endforelse
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                }
            });

            $(document).on('click', '#generateRecord', function() {
                let match_id = $(this).attr('data-id');
                document.getElementById('generateRecord').classList.add('cursor-not-allowed');
                $.ajax({
                    url: '{{ route('match.cron') }}',
                    method: 'POST',
                    data: {
                        match_id: match_id,
                    },
                    success: function(response) {
                        console.log(response);
                    }
                });
            });
        });
    </script>
@endpush
