@extends('admin-panel.layouts.app')
@section('content')
    <div class="min-h-screen bg-gray-100 py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow">
            <div class="border border-gray-400 p-6">
                <h1 class="text-xl font-semibold text-gray-500 flex items-center justify-center p-2 border-b ">Task Manager
                </h1>
                <div class="divide-y divide-gray-200">
                    <div class="flex items-center justify-between p-4 border-b border-gray-200">
                        <div class="flex items-center space-x-4">
                            <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                checked>
                            <span class="text-gray-700">Tried Passport api with web</span>
                        </div>
                        <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            1d
                        </span>
                    </div>
                    <div class="flex items-center justify-between p-4 border-b border-gray-200">
                        <div class="flex items-center space-x-4">
                            <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                checked>
                            <span class="text-gray-700">Dashboard page with side bar and header login page</span>
                        </div>
                        <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            1d
                        </span>
                    </div>
                    <div class="flex items-center justify-between p-4 border-b border-gray-200">
                        <div class="flex items-center space-x-4">
                            <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                checked>
                            <span class="text-gray-700">Tournament status cards,integration o add
                            </span>
                        </div>
                        <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            1d
                        </span>
                    </div>
                    <div class="flex items-center justify-between p-4 border-b border-gray-200">
                        <div class="flex items-center space-x-4">
                            <input type="checkbox"
                                class="min-w-4 min-h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" checked>
                            <span class="text-gray-700">Auto match generation functionality with round page card
                                boxes</span>
                        </div>
                        <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            2d
                        </span>
                    </div>
                    <div class="flex items-center justify-between p-4 border-b border-gray-200">
                        <div class="flex items-center space-x-4">
                            <input type="checkbox"
                                class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-gray-700">User,player mobile api
                                (sub tasks will be added soon)
                            </span>
                        </div>
                        <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            0
                        </span>
                    </div>
                    <div class="flex items-center justify-between p-4 border-b border-gray-200">
                        <div class="flex items-center space-x-4">
                            <input type="checkbox"
                                class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-gray-700">Role permission</span>
                        </div>
                        <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            0
                        </span>
                    </div>
                    <div class="flex items-center justify-between p-4 border-b border-gray-200">
                        <div class="flex items-center space-x-4">
                            <input type="checkbox"
                                class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-gray-700">Tournament Score board</span>
                        </div>
                        <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            0
                        </span>
                    </div>
                    <div class="flex items-center justify-between p-4 border-b border-gray-200">
                        <div class="flex items-center space-x-4">
                            <input type="checkbox"
                                class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-gray-700">Design improvement implement card body</span>
                        </div>
                        <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            0
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
