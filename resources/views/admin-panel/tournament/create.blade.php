<div class="bg-white rounded-lg p-8 max-w-2xl mx-auto mt-20">

    <h3 class="text-xl font-semibold mb-4">Add New Tournament</h3>

    <form id="tournamentForm">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" name="name" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                <input type="text" name="location" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Maximum Teams</label>
                <input type="number" name="max_teams" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Minimum Teams</label>
                <input type="number" name="min_teams" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                <div class="relative">
                <input id="dateTimePicker" name="start_date" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <div class="absolute flex items-center pointer-events-none inset-y-0 right-3">
                    <i class="fa-regular fa-calendar"></i>
                </div>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                <div class="relative">
                <input  id="dateTimePicker" name="end_date" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <div class="absolute flex items-center pointer-events-none inset-y-0 right-3">
                    <i class="fa-regular fa-calendar"></i>
                </div>
            </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tournament Type</label>
                <select name="tournament_type" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="teams">Players</option>
                    <option value="players">Teams</option>
                </select>
            </div>

        </div>
        <div class="mt-6 flex justify-end space-x-3">
            <button type="button" class="px-4 py-2 border rounded-lg hover:bg-gray-50">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save Tournament</button>
        </div>
    </form>
</div>


<script>
document.addEventListener("DOMContentLoaded", (event) => {
    flatpickr("#dateTimePicker", {
        enableTime: true,
        allowInput: true,
        minDate: "today",
    });
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            }
        });
 $('#tournamentForm').on('submit',function(e){
    e.preventDefault();
    let formData=new FormData(this);
    $.ajax({
        url: "{{ route('tournament.store') }}",
        method: "post",
        data:formData,
        contentType: false,
        processData: false,
        success: function(response) {
            console.log(response);
        }
    })
})

});
    </script>
