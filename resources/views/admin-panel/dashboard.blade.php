@extends('admin-panel.layouts.app')
@section('content')
    <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Card 1 -->
            <a href="#">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500">Old Tournaments</p>
                        <h3 class="text-2xl font-bold">100</h3>
                        <p class="text-green-500 text-sm">Lets see</p>
                    </div>
                    <div class="bg-indigo-100 p-3 rounded-full">
                        <i class="fa-solid fa-trophy text-indigo-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </a>
            <!-- Card 2 -->
            <a href="#">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500">Upcoming Tournaments</p>
                        <h3 class="text-2xl font-bold">2</h3>
                        <p class="text-green-500 text-sm">Check here</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fa-solid fa-trophy text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </a>

            <!-- Card 3 -->
            <a href="#">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500">Live Tournaments</p>
                        <h3 class="text-2xl font-bold">14</h3>
                        <p class="text-red-500 text-sm">-Check here</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <i class="fa-solid fa-trophy text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </a>

            <!-- Card 4 -->
            <a href="#">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500">Cancelled Tournaments</p>
                        <h3 class="text-2xl font-bold">0</h3>
                        <p class="text-green-500 text-sm">check here</p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <i class="fa-solid fa-trophy text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </a>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            let logout = document.getElementById('logout');
            logout.addEventListener('click', function(e) {
                Swal.fire({
                    title: "Are you sure you want to logout",
                    showCancelButton: true,
                    confirmButtonText: "Logout",
                }).then((result) => {
                    if (result.isConfirmed) {
                       $.ajax({
                        url: "{{ route('auth.logout') }}",
                        method: "get",
                        success: function(response){
                            Swal.fire({
                                title: "Logged Out",
                                icon: "success",
                                confirmButtonText: "Okay"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "{{ route('admin.login') }}";
                                }
                            });
                        },
                        error: function(xhr, status, error){
                            Swal.fire({
                                title: "Error",
                                text: error,
                                icon: "error",
                                confirmButtonText: "Okay"
                            });
                        }
                       })
                    }
                });
            });
        });
    </script>
@endpush
