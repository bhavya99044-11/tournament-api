@extends('admin-panel.layouts.app')
<meta name="csrf_token" content="{{ csrf_token() }}">

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tournament Details</title>
        <script src="https://unpkg.com/lucide@latest"></script>
    </head>

    <body class="">
        <div class="max-w-7xl mx-auto mt-5">
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <div class="flex flex-row justify-between">
                    <div class="">
                        <div class="text-2xl flex flex-row items-center space-x-2 font-bold text-yellow-600">
                            <i data-lucide="trophy"></i>
                            <div>{{ $data['tournament']['name'] }}</div>
                        </div>
                        <div class="space-y-2">
                            <p class="flex items-center text-gray-600 gap-2">
                                <i data-lucide="map-pin" class="h-5 w-5"></i>
                                {{ $data['tournament']['location'] }}
                            </p>
                            <p class="flex items-center text-gray-600 gap-2">
                                <i data-lucide="calendar" class="h-5 w-5"></i>
                                {{ $data['tournament']['start_date'] }}
                            </p>
                            <p class="flex items-center text-gray-600 gap-2">
                                <i data-lucide="users" class="h-5 w-5"></i>
                                {{ $data['tournament']['end_date'] }}
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <span
                            class="inline-flex items-center justify-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            @if (\Carbon\Carbon::now() < \Carbon\Carbon::parse($data['tournament']->start_date)->subDays(2) &&
                                    $data['tournament']['current_teams'] < $data['tournament']['max_teams'])
                                <span>
                                    <a href="{{ route('team.create', ['id' => $data['tournament']['id']]) }}"> Registration
                                        Open</a>
                                </span>
                            @else
                                <span class="text-red-600">
                                    Registration closed
                                </span>
                            @endif
                        </span>
                        <button id="generateMatch"
                            class="inline-flex items-center px-6 py-3 rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200 ">
                            Generate Matches
                        </button>
                        <a href="{{ route('tournament.rounds', ['id' => $data['tournament']['id']]) }}"
                            class="inline-flex items-center px-6 py-3 rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                            Match rounds
                        </a>
                    </div>
                </div>
            </div>
            <!-- Teams Section -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <i data-lucide="shield" class="h-6 w-6 text-blue-500"></i>
                    Participating Teams
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($data['tournament']['teams'] as $team)
                        {{-- {{dd()}} --}}
                        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-200">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900">{{ $team['name'] }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">Group A</p>
                                </div>
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ count($team['players']) }} Players
                                </span>
                            </div>
                            <div class="mt-4 flex justify-end">
                                <a href="{{ route('getTeamPlayers', ['id' => $team['id']]) }}"
                                    class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                    View Details →
                                </a>
                            </div>
                        </div>
                    @empty
                        <p>no team registered</p>
                    @endforelse
                </div>
            </div>
        </div>
    </body>
    </html>
@endsection
@push('scripts')
    <script>
        lucide.createIcons();

        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                }
            });
            // generate match button click event handler
            $(document).on('click', '#generateMatch', function() {
                $.ajax({
                    url: "{{ route('match.create') }}",
                    type: 'Post',
                    data: {
                        round:1,
                        tournament_id: '{{ $data['tournament']['id'] }}'
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            })
        });
    </script>
@endpush
