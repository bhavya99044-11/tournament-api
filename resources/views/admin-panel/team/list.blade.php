@extends('admin-panel.layouts.app')

@section('content')
<div class=" text-center w-full inline-block text-2xl   font-semibold bg-gradient-to-r from-blue-600 to-green-500 via-indigo-400 text-transparent bg-clip-text">{{$data['team']['name']}}</div>


    <div>
    <table class="p-2 " id="teamPlayersTable">
        <thead class="bg-gray-50">
            <tr>
                {{-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th> --}}
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Player Position
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">

        </tbody>
    </table>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {


            let url = '{{ route('getTeamPlayers', ['id' => $data['team']->id]) }}';
            console.log(url);
            const table = $('#teamPlayersTable').dataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('getTeamPlayers', ['id' => $data['team']->id]) }}',
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'player_position',
                        name: 'player_position'
                    }
                ],
            });



        });
    </script>
@endpush
