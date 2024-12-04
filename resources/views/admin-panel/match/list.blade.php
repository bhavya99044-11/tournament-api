@extends('admin-panel.layouts.app')

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8" />
        <link rel="icon" type="image/svg+xml" href="/vite.svg" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Tournament Brackets</title>
        <link rel="stylesheet" href="/style.css">
    </head>

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
                <button
                    class="px-6 py-3 bg-green-600 text-white rounded-full font-semibold hover:bg-green-700 transition-colors shadow-md active:scale-95 transform">
                    Complete
                </button>
            </div>

            <!-- Tournament Brackets -->
            <div class="flex gap-16 justify-center">
                <!-- Round 1 -->
                <div class="w-64">
                    <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Round 1</h2>
                    <div class="space-y-8">
                        <div class="match-card">
                            <div class="flex justify-between items-center mb-3">
                                <span class="font-semibold text-blue-600">Team A</span>
                                <span class="text-lg font-bold">3</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-600">Team B</span>
                                <span class="text-lg font-bold">1</span>
                            </div>
                        </div>

                        <div class="match-card">
                            <div class="flex justify-between items-center mb-3">
                                <span class="font-semibold text-blue-600">Team C</span>
                                <span class="text-lg font-bold">2</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-600">Team D</span>
                                <span class="text-lg font-bold">0</span>
                            </div>
                        </div>

                        <div class="match-card">
                            <div class="flex justify-between items-center mb-3">
                                <span class="font-semibold text-blue-600">Team E</span>
                                <span class="text-lg font-bold">4</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-600">Team F</span>
                                <span class="text-lg font-bold">2</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Round 2 -->
                <div class="w-64">
                    <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Round 2</h2>
                    <div class="space-y-8 pt-16">
                        <div class="match-card">
                            <div class="flex justify-between items-center mb-3">
                                <span class="font-semibold text-blue-600">Team A</span>
                                <span class="text-lg font-bold">2</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-600">Team C</span>
                                <span class="text-lg font-bold">1</span>
                            </div>
                        </div>

                        <div class="match-card">
                            <div class="flex justify-between items-center mb-3">
                                <span class="font-semibold text-blue-600">Team E</span>
                                <span class="text-lg font-bold">3</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-600">Team G</span>
                                <span class="text-lg font-bold">2</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
@endsection

@push('scripts')
    <script></script>
@endpush
