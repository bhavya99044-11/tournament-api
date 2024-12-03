@extends('admin-panel.layouts.app')
<meta name="csrf_token" content="{{ csrf_token() }}">

@section('content')
    <div class="bg-white rounded-lg shadow-md overflow-hidden">

        <button class="new-tournament float-right m-2 rounded-lg p-2 text-white text-semiboldfloat-right  bg-blue-400"
            type="button">Add Tournament</button>
        <table class="min-w-full " id="tournamentTable">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Id</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Teams
                    </th>
                    <th name="current_teams"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Date</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    {{-- <td class="px-6 py-4 whitespace-nowrap">Summer Championship</td>
                <td class="px-6 py-4 whitespace-nowrap">New York</td>
                <td class="px-6 py-4 whitespace-nowrap">8/12</td>
                <td class="px-6 py-4 whitespace-nowrap">Jun 1 - Jun 15</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        Active
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <button class="text-blue-600 hover:text-blue-900 mr-3">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="text-red-600 hover:text-red-900">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr> --}}
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Tournament Form Modal -->
    <div class="fixed inset-0 bg-black bg-opacity-50 hidden">
        @include('admin-panel.tournament.create')
    </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", (event) => {
            let form = document.getElementById("tournamentForm");
            const newTournamentBtn = document.querySelector('.new-tournament');
            const modal = document.querySelector('.fixed.inset-0');
            const cancelBtn = modal.querySelector('button[type="button"]');
            newTournamentBtn.addEventListener('click', () => {
                form.reset();
                modal.classList.remove('hidden');
            });
            cancelBtn.addEventListener('click', () => {
                form.reset();
                modal.classList.add('hidden');
            });
            // modal.addEventListener('click', (e) => {
            //     if (e.target === modal) {
            //         modal.classList.add('hidden');
            //     }
            // });

        });
        const table = $('#tournamentTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('tournament.index') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'current_teams',
                    name: 'current_teams'
                },
                {
                    data: 'start_date',
                    name: 'start_date'
                },
                {
                    data: 'end_date',
                    name: 'end_date'
                }
            ],
            columnDefs: [
                { className: "dt-head-center dt-center", targets: '_all' },
        {
            targets: 2,
            render:function(data){
                if(data=='Completed'){
                    return `<div class="bg-green-500 text-center rounded-full py-2 text-white font-semibold ">${data}</div>`;
                }else if(data=='Cancelled'){
                    return `<div class="bg-red-500 text-center rounded-full py-2 text-white font-semibold ">${data}</div>`;
                }else{
                    return `<div class="bg-blue-500 text-center rounded-full py-2 text-white font-semibold ">${data}</div>`;
                }
            }
        }
    ]
        })


        // table.row( $(this) ).invalidate().draw();
        //             var cc = $('#tournamentTable').dataTable();

        // console.log(cc)


        // new DataTable('#tournamentTable');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    </script>
@endpush
