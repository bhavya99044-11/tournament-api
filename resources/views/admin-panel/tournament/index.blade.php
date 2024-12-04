@extends('admin-panel.layouts.app')
<meta name="csrf_token" content="{{ csrf_token() }}">
<style>
    tbody>tr {
        background-color: red;
    }
</style>
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>

                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">

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
        //New Tournament Form Modal
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
        });

        //Tournament Datatble
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
                },
                {
                    data: 'action',
                    name: 'action',
                },
            ],
            columnDefs: [{
                    className: "dt-head-center dt-center",
                    targets: '_all'
                },
                {
                    targets: 2,
                    render: function(data) {
                        if (data == 'Completed') {
                            return `<div class="bg-green-500 text-center rounded-full py-2 text-white font-semibold ">${data}</div>`;
                        } else if (data == 'Cancelled') {
                            return `<div class="bg-red-500 text-center rounded-full py-2 text-white font-semibold ">${data}</div>`;
                        } else {
                            return `<div class="bg-blue-500 text-center rounded-full py-2 text-white font-semibold ">${data}</div>`;
                        }
                    }
                }
            ],
            createdRow: function(row, data, dataIndex) {
                $(row).hover(function() {
                    $(this).css('background-color', 'gray');
                }, function() {
                    $(this).css('background-color', '');
                });
                $(row).addClass('tournament-view');
                $(row).attr('data-id', data.id)
                $(row).css('cursor', 'pointer');
            }
        })

        $(document).on('click', '.tournament-view', function(e) {
           if(e.target.classList.contains('fas')){

           }else{
            let id =$(this).attr('data-id');
            let url='{{route('tournament.teams',":id")}}';
            url = url.replace(':id', id);
            window.location.href=url;
           }
        })

        //On edit to show edit delete popup
        $(document).on('click', '.edit-data', function() {
            let id = $(this).data('id');
            let sibling = $(this).siblings('.edit-show');
            if (sibling.length) {
                sibling.remove();
                return;
            } else {
                let parent = $(this).parent();
                let html = `<div class="edit-show absolute right-1 text-gray-500 p-1 font-semibold  bg-white border-2 border-opacity-50 rounded-lg text-center justify-center  border-gray-400 shadow-md flex flex-col space-y-1">\
                    <button class="delete-data" data-id=${id}>Edit</button>\
                    <button class="view-data" data-id=${id}>Delete</button>\
                </div>`;
                parent.append(html);
            }
        })
        //ajax header
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
@endpush
