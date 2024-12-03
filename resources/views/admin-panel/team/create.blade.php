@extends('admin-panel.layouts.app')
@section('content')
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <div class="min-h-screen p-6">
        <div class="max-w-4xl mx-auto">
            <!-- Team Registration Form -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Team Registration</h2>
                <form id="teamForm" data-team-id="{{ $data['team_id'] }}" class=" grid grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Team Name</label>
                        <input type="text"
                            class="outline-1 placeholder:text-gray-400  outline-cyan-200 border-2 p-2 mt-1" name="teamName"
                            required class="form-input" placeholder="Enter team name">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Team Email</label>
                        <input type="email" class="outline-1 outline-cyan-200 border-2 p-2 mt-1" name="teamEmail"
                            class="mt-1" required class="form-input" placeholder="Enter team email">
                    </div>
                </form>
            </div>

            <!-- Player Management Section -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Players</h2>
                    <button id="addPlayer"
                        class="btn btn-primary h-6 w-6 rounded-full text-green-500 border-green-400 border-2">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>

                <div id="playersList" class="space-y-4">
                    <!-- Players will be added here dynamically -->
                </div>

                <div class="mt-8 flex justify-end">
                    <button id="submitTeam" class="btn btn-primary">
                        <i class="fa flex items-center justify-center fa-paper-plane btn btn-primary h-6 w-6 rounded-full text-yellow-600 border-yellow-600 border-2"
                            aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        // State management
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                }
            });

            let players = [];
            let playerIdCounter = 1;
            var playerPositions;

            $.ajax({
                url: '{{ route('getPlayerPositions') }}',
                method: 'GET',
                async: false,
                success: function(response) {
                    playerPositions = response;
                }
            })



            // Add player form template
            function playerFormTemplate(id, playerPositions) {

                let html = `
      <form class="player-form"><div class="bg-gray-50 p-4 rounded-lg" data-player-id="${id}">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-semibold text-gray-700">Player ${id}</h3>
          <button class="delete-player  h-6 w-6 rounded-full text-red-500 border-red-400 border-2" data-player-id="${id}">
            <i class="fa-solid fa-minus delete-player" data-player-id="${id}"></i>
          </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Player Name</label>
            <input type="text" name="playerName" required class="form-input" placeholder="Enter player name">
          </div>
           <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Player Email</label>
            <input type="text" name="playerEmail" required class="form-input" placeholder="Enter player email">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Player Position</label>
            <select name="playerPosition" id="playerPosition" required class="form-input">`
                Object.entries(playerPositions).forEach(position => {
                    html += `<option value="${position[1].id}">` + position[1].name + '</option>';
                });
                `</select>
          </div>
        </div>
      </div>
    </form>
    `;
                return html;
            };


            // Event Listeners
            document.getElementById('addPlayer').addEventListener('click', () => {
                const playersList = document.getElementById('playersList');
                playersList.insertAdjacentHTML('beforeend', playerFormTemplate(playerIdCounter++,
                    playerPositions));

            });

            document.getElementById('playersList').addEventListener('click', (e) => {
                if (e.target.classList.contains('delete-player')) {
                    const playerId = e.target.dataset.playerId;
                    const playerForm = document.querySelector(`.player-form[data-player-id="${playerId}"]`);
                    playerForm.remove();
                }
            });


            document.getElementById('submitTeam').addEventListener('click', (e) => {
                e.preventDefault();
                const teamForm = document.getElementById('teamForm');
                let teamData = $('#teamForm').serialize();
                // teamData.append('form_id', teamForm.dataset.teamId);
                let playerData = [];
                $('.player-form').each(function(index, element) {
                    playerData.push($(this).serialize());
                });
                e.preventDefault();
                $.ajax({
                    url: '{{ route('team.register') }}',
                    type: 'POST',
                    data: {
                        team: teamData,
                        playerData: playerData
                    },
                    // contentType: false,
                    // processData: false,
                    success: function(response) {
                        alert(response.message);
                    }
                });
            });

        });

        //ajax request to register team amd players
        //   $(document).ready(function() {
        //     $('#teamForm').on('submit', function(e) {

        //     //   let formData = {
        //     //     team: teamData,
        //     //     players: playerData
        //     //   };
        //     //   $.ajax({
        //     //     url: '{{}}',
        //     //     type: 'POST',
        //     //     data: formData,
        //     //     success: function(response) {
        //     //       alert(response.message);
        //     //     },
        //     //     error: function(xhr, status, error) {
        //     //       alert(xhr.responseText);
        //     //     }
        //     //   });
        //     });
        //   });
    </script>
@endpush
