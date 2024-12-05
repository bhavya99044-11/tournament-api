@extends('admin-panel.layouts.app')
<meta name="csrf_token" content="{{ csrf_token() }}">
@section('content')

    <body class="bg-gray-100 min-h-screen">
        <div class="container mx-auto px-4 py-8">
            <!-- Tournament Brackets -->
            <div class="flex gap-16 justify-center">
                <!-- Round  -->
                @foreach($data['matches'] as $roundMatch)
                <div class="w-64">
                    <div class="flex flex-col gap-y-1 mb-4 items-center justify-center">
                        <h2 class="text-2xl font-bold text-center text-gray-800">Round {{ $roundMatch->first()->round }}</h2>
                        @if(count($roundMatch)>1)
                        <button id="tournamentComplete" data-tournament-id="{{ $roundMatch->first()->tournament_id }}"
                            data-round="{{ $roundMatch->first()->round }}"
                            class="px-4 py-2  bg-green-600 text-white rounded-full font-semibold hover:bg-green-700 transition-colors shadow-md active:scale-95 transform">
                            Complete
                        </button>
                        @else
                        <div class="mb-5">Last Round</div>
                        @endif
                    </div>
                    <div class="space-y-8">
                        @foreach ($roundMatch as $match)
                            <div class="match-card">
                                <div class="flex justify-between items-center mb-3">
                                    <span
                                        class=" flex items-center font-semibold text-blue-600">{{ $match->homeTeam->name }}
                                        @if (empty($match->opponentTeam))
                                            <p class="text-green-400 text-sm font-sans font-normal">(Qualified for next
                                                round)</p>
                                        @endif
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="font-semibold text-red-500">
                                        @if (!empty($match->opponentTeam))
                                            {{ $match->opponentTeam->name }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
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

               $(document).on('click', '#tournamentComplete', function() {
                let tournamentId=$(this).attr('data-tournament-id');
                let round=parseInt($(this).attr('data-round')) ;
                ++round;
                    $.ajax({
                        url: '{{ route('match.create') }}',
                        type: 'Post',
                        data: {
                            tournament_id: tournamentId,
                            round: round
                        },
                        success: function(data) {
                           console.log(data);
                        }
                    })
                })
            });
        </script>
    @endpush
