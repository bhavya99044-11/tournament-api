@extends('admin-panel.layouts.app')

<head>
    <meta name="csrf_token" content="{{ csrf_token() }}">
</head>
@section('content')
    <div class="h-full w-full p-10  font-sans bg-gray-200">
        <div class="font-extrabold text-4xl pt-4 text-center ">{{ $data['match']['tournament_name'] }}</div>
        <div class="flex w-full items-center justify-center">
            <div><i class="fa-solid fa-location-dot text-lg text-red-600"></i></div>
            <div class="ml-1 text-gray-600 font-bold">
                gujarat<span
                    class="ml-2">{{ \Carbon\Carbon::parse($data['match']['tournament_start'])->format('Y-m-d') }}</span>
            </div>
        </div>

        <div class="flex justify-between mt-5 p-5 bg-white shadow-lg text-center">
            <div class="flex flex-col">
                <div class="font-semibold text-2xl">{{ $data['match']['home_team_name'] }}</div>
                <div class="flex items-center h-5"><i class="fa-solid fa-users-line text-blue-500"></i><span
                        class="font-semibold ml-1 text-base">11</span></div>
            </div>
            <div class="flex flex-col">
                <div class="text-4xl font-[1000] text-gray-400">VS</div>
                <button id="generateRecord" class="p-1 text-white font-semibold rounded-lg bg-blue-500" data-id="{{ $data['match']->id }}" @if($data['match']['matchRecords']->isNotEmpty()) disabled  @endif>Start Match</button>
            </div>
            <div class="flex flex-col">
                <div class="font-semibold text-2xl">{{ $data['match']['opponent_team_name'] }}</div>
                <div class="flex items-center h-5"><i class="fa-solid fa-users-line text-blue-500"></i><span
                        class="font-semibold ml-1 text-base">{{ $data['match']['opponent_team_player_count'] }}</span></div>
            </div>
        </div>

        <div class="w-full border border-gray-200 bg-white rounded-xl mt-5 overflow-x-auto shadow-md">
            <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-xl font-bold text-white p-2">
                {{ $data['match']['home_team_name'] }}
            </div>
            <table class="w-full divide-y divide-gray-300">
              <tbody class="divide-y divide-gray-300 bg-white text-slate-800">
                 <tr class="divide-x divide-gray-300">
                  <th class="px-4 py-2">Records</th>
                  @forelse($data['match']['matchRecords'] as $match)
                  <th class="px-4 py-2">{{\Carbon\Carbon::parse($match->created_at)->format('H:i')}}</th>
                  @empty
                  hello
                  @endforelse
                </tr>
                <tr class="divide-x text-center divide-gray-300">
                  <td class="px-4 py-2">#</td>
                  @forelse($data['match']['matchRecords'] as $match)
                  <td class="px-4 py-2">{{$match->home_team_score}}</td>
                  @empty
                  @endforelse
                </tr>
              </tbody>
            </table>
          </div>
          <div class="w-full border border-gray-200 bg-white rounded-xl mt-5 overflow-x-auto shadow-md">
            <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-xl font-bold text-white p-2">
                {{ $data['match']['opponent_team_name'] }}
            </div>
            <table class="w-full divide-y divide-gray-300">
              <tbody class="divide-y divide-gray-300 bg-white text-slate-800">
                 <tr class="divide-x divide-gray-300">
                  <th class="px-4 py-2">Records</th>
                  @forelse($data['match']['matchRecords'] as $match)
                  <th class="px-4 py-2">{{\Carbon\Carbon::parse($match->created_at)->format('H:i')}}</th>
                  @empty
                  hello
                  @endforelse
                </tr>
                <tr class="divide-x text-center divide-gray-300">
                  <td class="px-4 py-2">#</td>
                  @forelse($data['match']['matchRecords'] as $match)
                  <td class="px-4 py-2">{{$match->opponent_team_score}}</td>
                  @empty
                  @endforelse
                </tr>
              </tbody>
            </table>
          </div>


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
                document.getElementById('generateRecord').disabled=true;
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
