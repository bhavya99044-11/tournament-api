@extends('admin-panel.layouts.app')

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
        <title>Hotel Cuba</title>
    </head>
    <button id="dateModalClick">date</button>
    <body>
        <div class="container">
            <div class="w-full text-center">
                Welcome to Cuba
            </div>

            <div id="dateModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50">
                <div class="bg-white p-6 rounded-lg shadow-lg w-1/3 relative">
                    <h2 class="text-xl font-bold mb-4" id="modal-title">Add Room</h2>
                    <form id="dateSubmit">
                        <div id="dateFields">
                            <div class="date-group mb-4">
                                <input type="date" name="start_date[]" > Start date
                                <input type="date" name="end_date[]" > End date
                            </div>
                        </div>
                        <button type="button" id="addDateButton" class="bg-blue-500 text-white px-4 py-2 rounded">Add More Dates</button>
                        <button type="submit" class="mt-4 bg-green-500 text-white px-4 py-2 rounded">Submit</button>
                    </form>
                </div>
            </div>

            <div class="flex flex-row mt-5 items-center w-full bg-slate-200 hotel-details" id="hotel-div">
            </div>
        </div>



        <table id="rooms"></table>

        <!-- Modal -->
        <div id="modal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/3 relative">
                <h2 class="text-xl font-bold mb-4" id="modal-title">Add Room</h2>
                <form id="addRoomForm">
                    <label>Room Name</label>
                    <input type="text" name="name" required class="mb-4"></input>
                    <div class="mb-4">
                        <label class="block text-gray-700">Room Type:</label>
                        <input type="checkbox" class="select-box" value="0" name="room[]">Single</input>
                        <input type="checkbox" class="select-box" value="1" name="room[]">Double</input>
                        <input type="checkbox" class="select-box" value="2" name="room[]">Triple</input>
                        <input type="checkbox" class="select-box" value="3" name="room[]">Multi</input>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Meal Plan:</label>
                        <input type="radio" value="0" name="meal">Full</input>
                        <input type="radio" value="1" name="meal">Half</input>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" class="px-4 py-2 bg-blue-500 text-white rounded" id="submit-room">Add
                            Room</button>
                        <button type="button" class="ml-2 px-4 py-2 bg-red-500 text-white rounded"
                            id="close-modal">Close</button>
                    </div>
                </form>
            </div>
        </div>

        @push('scripts')
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $(document).ready(function() {
                    let url = `http://192.168.1.200:8000/api/v1/hotel/${window.location.href.split('/').pop()}`;
                    let data = null;
                    let array=[
                        { value: '0', label: 'Hotel service' },
                        { value: '1', label: 'Room Service' },
                    ];
                    $.ajax({
                        url: url,
                        method: 'GET',
                        async:false,
                        success: function(response) {
                            if (response.status == 200) {

                                data = response.data;
                                let hotelDiv = document.getElementById('hotel-div');
                                let html=
                                    `<div class="flex flex-row mt-5 items-center w-full bg-slate-200 hotel-details" id="hotel-details" data-id=${response.data.id}>
                            <div class="">
                                <img class="h-52 w-52" src="http://192.168.1.200:8000/images/${response.data.image_url}"></img>
                            </div>
                            <div class="p-5 font-bold ">
                                ${response.data.name}
                            </div>
                        </div>
                        <button class="p-2 text-white font-bold bg-blue-400 mr-10 rounded" type="button" id="add-rooms">Add Rooms</button>`;
                       html += '<ul>';
                        data.hotem_amenities.forEach((amenitie) =>{
                             array.filter((item)=>{
                                if(amenitie.name==item.value){
                                   html+=`<li>${item.label}</li>`;
                                }
                            });
                        });
                        html += '</ul>';
                        hotelDiv.innerHTML=html;
                                loadRooms();
                            }
                        }
                    });

                    function loadRooms() {
                        if (data && data.hotel_rooms.length > 0) {
                            let table = document.getElementById('rooms');
                            table.innerHTML = `<thead>
                            <tr>
                                <th>Room Name</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>`;
                            for (let room of data.hotel_rooms) {
                                table.innerHTML += `<tr>
                            <td>${room.name}</td>
                            <td><button class="p-2 text-white font-bold bg-blue-400 mr-10 rounded" id="edit-room" data-id="${room.id}">Edit</button></td>
                            <td><button class="p-2 text-white font-bold bg-red-400 mr-10 rounded" id="delete-room" data-id="${room.id}">Delete</button></td>
                        </tr>`;
                            }
                            table.innerHTML += `</tbody>`;
                        }
                    }

                    $(document).on('click', '#add-rooms', function() {
                        $('#modal').removeClass('hidden').attr('data-room-id', '');
                        $('#modal-title').text('Add Room');
                        $('#addRoomForm')[0].reset();
                    });

                    $(document).on('click', '#edit-room', function() {
                        let roomId = $(this).data('id');
                        $.ajax({
                            url: `http://192.168.1.200:8000/api/v1/room/${roomId}/edit`,
                            method: 'GET',
                            success: function(response) {
                                if (response.status == 200) {
                                    let room = response.data;

                                    $('#addRoomForm [name="name"]').val(room.name);

                                    $('input[name="room[]"]').prop('checked', false);

                                    if (room.room_types && room.room_types.length > 0) {
                                        room.room_types.forEach(function(roomType) {
                                            $('input[name="room[]"][value="' + roomType.type +
                                                '"]').prop('checked', true);
                                        });
                                    }

                                    $('input[name="meal"]').prop('checked', false);
                                    if (room.meal_plan !== null) {
                                        $('input[name="meal"][value="' + room.meal_plan + '"]').prop(
                                            'checked', true);
                                    }

                                    $('#modal').removeClass('hidden').attr('data-room-id', roomId);
                                    $('#modal-title').text('Edit Room');
                                }
                            }
                        });
                    });

                    $(document).on('click', '#submit-room', function() {
                        let roomId = $('#modal').attr('data-room-id');
                        let form = document.getElementById('addRoomForm');
                        let formData = new FormData(form);


                        let apiUrl = roomId ? `http://192.168.1.200:8000/api/v1/room/${roomId}` :
                            `http://192.168.1.200:8000/api/v1/room`;
//                           console.log(formData.get('name'))

                        if(roomId){
                            formData.append('_token', $('meta[name="csrf_token"]').attr('content'));
                            formData.append('_method', 'PUT');
                        }

                        if (!roomId) {
                            let id = document.getElementById('hotel-details').getAttribute('data-id');
                            formData.append('hotel_id', id);
                        }

                        console.log(formData.toJSON);
                        $.ajax({
                            url: apiUrl,
                            type : 'POST',
                            dataType : 'json',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                window.location.reload();
                                console.log(response);
                                $('#modal').addClass('hidden');
                                $('#addRoomForm')[0].reset();
                                loadRooms();
                            }
                        });
                    });

                    $(document).on('click', '#close-modal', function() {
                        $('#modal').addClass('hidden');
                    });

                    $(document).on('click', '#delete-room', function() {
                        if (confirm('Are you sure you want to delete this room?')) {
                            let roomId = $(this).data('id');
                            $.ajax({
                                url: `http://192.168.1.200:8000/api/v1/room/${roomId}`,
                                method: 'DELETE',
                                success: function(response) {
                                    window.location.reload();
                                    loadRooms();
                                }
                            });
                        }
                    });

                    $(document).on('click','.select-box',function(){
                        let cc=document.querySelectorAll('.select-box');
                        if($(this).val()==3){
                            for(let i=0;i<cc.length-1;i++){
                                cc[i].checked=false;
                                }
                        }else{
                            cc[3].checked=false;
                        }
                    })

                    $(document).on('click','#dateModalClick',function(){
                        let id = document.getElementById('hotel-details').getAttribute('data-id');

                        $('#dateModal').removeClass('hidden');

                    });

        document.getElementById('addDateButton').addEventListener('click', function() {
            const dateFieldsContainer = document.getElementById('dateFields');
            const newDateGroup = document.createElement('div');
            newDateGroup.classList.add('date-group', 'mb-4');
            const startDateInput = document.createElement('input');
            startDateInput.type = 'date';
            startDateInput.name = 'start_date[]';
            startDateInput.required = true;
            const endDateInput = document.createElement('input');
            endDateInput.type = 'date';
            endDateInput.name = 'end_date[]';
            endDateInput.required = true;
            newDateGroup.appendChild(startDateInput);
            newDateGroup.appendChild(endDateInput);
            dateFieldsContainer.appendChild(newDateGroup);
        });

        $('#dateSubmit').on('submit',function(){
            let hotelId = document.getElementById('hotel-details').getAttribute('data-id');
            let form = document.getElementById('dateSubmit');
            let formData = new FormData(form);
            formData.append('hotel_id', hotelId);
            $.ajax({
                url: `http://192.168.1.200:8000/api/v1/hotel-date`,
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#dateModal').addClass('hidden');
                    window.location.reload();
                }
            });
            return false;
        })

        if(data.hotel_dates){
            data.hotel_dates.forEach(date => {
                let startDateInput = document.createElement('input');
                startDateInput.type = 'date';
                startDateInput.value = date.start_date;
                startDateInput.name = 'start_date[]';
                startDateInput.required = true;
                let endDateInput = document.createElement('input');
                endDateInput.type = 'date';
                endDateInput.value = date.end_date;
                endDateInput.name = 'end_date[]';
                endDateInput.required = true;
                let newDateGroup = document.createElement('div');
                newDateGroup.classList.add('date-group', 'mb-4');
                let deleteButton=document.createElement('button');
                deleteButton.type = 'button';
                deleteButton.innerText='Delete';
                deleteButton.classList.add('btn', 'btn-danger', 'mr-2');
                deleteButton.addEventListener('click', function(){
                    let hotelId = document.getElementById('hotel-details').getAttribute('data-id');
                    let startDate=date.start_date;
                    let endDate=date.end_date;
                    $.ajax({
                        url: `http://192.168.1.200:8000/api/v1/hotel-date/${date.id}`,
                        method: 'DELETE',
                        success: function(response) {
                            window.location.reload();
                        }
                    });
                });

                newDateGroup.appendChild(startDateInput);
                newDateGroup.appendChild(endDateInput);
                newDateGroup.appendChild(deleteButton);
                document.getElementById('dateFields').appendChild(newDateGroup);
            });
        }

                });
            </script>
        @endpush
    </body>

    </html>
@endsection
