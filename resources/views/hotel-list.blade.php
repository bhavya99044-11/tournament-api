@extends('admin-panel.layouts.app')

@section('content')
    <button id="hotel-create">Create Hotel</button>
    <meta name="csrf_token" content="{{ csrf_token() }}">


    <table id="table-list">

    </tabel>
    <div class="fixed z-10 overflow-y-auto top-0 w-full left-0 hidden" id="modal">
        <div class="flex items-center justify-center min-height-100vh pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-900 opacity-75" />
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-center bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <form id="saveHotel">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <label class="font-medium text-gray-800">Name</label>
                    <input type="text" class="w-full outline-none rounded bg-gray-100 p-2 mt-2 mb-3" name="hotel" id="hotel_name" />
                    <label class="font-medium text-gray-800">Url</label>
                    <input type="file" name="hotel_image" class="w-full outline-none rounded bg-gray-100 p-2 mt-2 mb-3" />
                    <div class="amenitiesbox">
                    <input type="checkbox" name="amenities[]" value=0 id="amenities_0">Hotel service</input>
                    <input type="checkbox" name="amenities[]" value=1 id="amenities_1">Room service</input>
                    </div>
                </div>
                <button class="p-3 bg-blue-300" type="submit" id="saveFormButton" >Save</button>
                <button class="p-3 bg-blue-300" type="submit" id="updateFormButton" >Update</button>

            </form>
                <div class="bg-gray-200 px-4 py-3 text-right">
                    <button type="button" class="py-2 px-4 bg-gray-500 text-white rounded hover:bg-gray-700 mr-2"
                        id="close-modal"><i class="fas fa-times"></i> Cancel</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
    <script>
        $(document).ready(async function() {

            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            }
        });
            $(document).on('click','#saveFormButton',function(e){
                e.preventDefault();
                let form=document.getElementById('saveHotel');
            let formData=new FormData(form);
                $.ajax({
                    url: 'http://192.168.1.200:8000/api/v1/hotel',
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        window.location.reload();
                        console.log(response);
                    }
                })
            })
            $.ajax({
                url: 'http://192.168.1.200:8000/api/v1/hotel',
                method: 'GET',
                success: function(response) {
                    if(response.status==200){
                        let hotelDiv=document.getElementById('table-list');
                        response.data.forEach(hotel => {
                          let innerHTML=`
                            <tr>
                                <td>${hotel.name}</td>
                                <td><img  src="http://192.168.1.200:8000/images/${hotel.image_url}"></img></td>
                                <td><a class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded" href="http://192.168.1.200:8000/hotel-view/${hotel.id}">View</a></td>
                                <td><button class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded" data-id="${hotel.id}" id="edit-button">Edit</button></td>
                                <td><button class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded" data-id="${hotel.id}" id="delete-button" class="delete-button">Delete</button></td>
                            </tr>
                            `;
                            hotelDiv.innerHTML+=innerHTML;
                        });
                    }
                }
            })

            $(document).on('click', '#edit-button', function() {
                let id=$(this).data('id');
                $.ajax({
                    url: `http://192.168.1.200:8000/api/v1/hotel/${id}/edit`,
                    method: 'GET',
                    success: function(response) {
                        if(response.status==200){
                            let form=document.getElementById('saveHotel');
                            form.setAttribute('data-id',response.data.id)
                            let button=$('#updateFormButton').show();
                            let cc=$('#saveFormButton').hide();
                            let hotelDiv=document.getElementById('hotel_name');
                            hotelDiv.value=response.data.name;
                            let hotelImage=document.getElementById('hotel_image');
                            response.data.hotem_amenities.map((data)=>{
                               let select=document.getElementById('amenities_'+parseInt(data.name));
                               select.checked=true;
                            });
                            document.getElementById('modal').classList.toggle('hidden');
                        }
                    }
                })
            })

            $(document).on('click','#delete-button',function(){
                let id=$(this).data('id');
                console.log(id);
                $.ajax({
                    url: `http://192.168.1.200:8000/api/v1/hotel/${id}`,
                    method: 'DELETE',
                    success: function(response) {
                        window.location.reload();
                        console.log(response);
                    }
                })
            })

            $(document).on('click','#updateFormButton',function(e){
                e.preventDefault();
                let form=document.getElementById('saveHotel');
                let formData=new FormData(form);
                formData.append('_token', $('meta[name="csrf_token"]').attr('content'));
                formData.append('_method', 'PUT');
                let id=form.getAttribute('data-id');
                $.ajax({
                    url: `http://192.168.1.200:8000/api/v1/hotel/${id}`,
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        window.location.reload();
                        console.log(response);
                    }
                })
            })
            $(document).on('click', '#hotel-create', function() {
                let button=$('#updateFormButton').hide();
                let cc=$('#saveFormButton').show();
                document.getElementById('modal').classList.toggle('hidden');
            })
            $(document).on('click','#close-modal',function(){
                document.getElementById('modal').classList.toggle('hidden');
            })
        });

    </script>
@endpush
