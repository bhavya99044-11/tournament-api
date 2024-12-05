@extends('admin-panel.layouts.app')

@section('content')

    <body class="bg-gray-100 min-h-screen">
        <div class="container mx-auto px-4 py-8">
            <!-- Round Buttons -->
            <div class="flex justify-center gap-4 mb-12">
                <button
                    class="px-6 py-3 bg-blue-600 text-white rounded-full font-semibold hover:bg-blue-700 transition-colors shadow-md active:scale-95 transform">
                    Round 1
                </button>
                <button
                    class="px-6 py-3 bg-gray-600 text-white rounded-full font-semibold hover:bg-gray-700 transition-colors shadow-md active:scale-95 transform">
                    Round 2
                </button>

            </div>
            <!-- Tournament Brackets -->
            <div class="flex gap-16 justify-center">
                <!-- Round 1 -->
                <div class="w-64">
                    <div class="flex flex-col gap-y-1 mb-4 items-center justify-center">
                        <h2 class="text-2xl font-bold text-center text-gray-800">Round 1</h2>
                        <button
                            class="px-4 py-2  bg-green-600 text-white rounded-full font-semibold hover:bg-green-700 transition-colors shadow-md active:scale-95 transform">
                            Complete
                        </button>
                    </div>
                    <div class="space-y-8">
                        @foreach ($data['matches'] as $match)
                            <div class="match-card">
                                <div class="flex justify-between items-center mb-3">
                                    <span class=" flex items-center font-semibold text-blue-600">{{ $match['homeTeam']['name'] }}
                                        @if (empty($match->opponentTeam))
                                        <p class="text-green-400 text-sm font-sans font-normal">(Qualified for next round)</p>
                                    @endif
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="font-semibold text-red-500">
                                        @if (!empty($match->opponentTeam))
                                            {{ $match['opponentTeam']['name'] }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    @endsection

    @push('scripts')
        <script>

        </script>
    @endpush
