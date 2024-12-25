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
        <title>Hotel cuba</title>
    </head>

    <body>
        <div class="container">
            <div class="w-full text-center">
                welcome to cuba
            </div>
            <div class="flex flex-row mt-5 items-center w-full bg-slate-200 hotel-details" id="hotel-div">
            </div>
        </div>
    </body>




    <div class="flex items-center justify-center h-screen">
    </div>
    <div class="fixed z-10 overflow-y-auto top-0 w-full left-0 hidden" id="modal">
        <div class="flex items-center justify-center min-height-100vh pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-900 opacity-75" />
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-center p-10 bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <form id="amenities-save">
                    <div class="grid grid-cols-4">
                        <div class="flex items-center">
                            <input type="checkbox" value="" name="amenities"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="default-radio-1"
                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Room service</label>
                        </div>
                     
                    </div>
                    <button type="button"
                    class="py-2 mt-5 px-4 bg-blue-500 text-white rounded font-medium hover:bg-blue-700 mr-2 transition duration-500"
                    id="default-modal"><i class="fas fa-plus"></i> Save</button>
                </form>

            </div>
        </div>
    </div>

    </html>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let url = `http://192.168.1.200:8000/api/v1/hotel/${window.location.href.split('/').pop()}`;
            console.log(url)
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    if (response.status == 200) {
                        let hotelDiv = document.getElementById('hotel-div');
                        hotelDiv.innerHTML = `<div class="flex flex-row mt-5 items-center w-full bg-slate-200 hotel-details" id="hotel-details" data-id=${response.data.id}> <div class="">
                    <img class="h-52 w-52" src="http://192.168.1.200:8000/images/${response.data.image_url}"></img>
                </div>
                <div class="p-5 font-bold ">
                    ${response.data.name}
                </div>
                </div>
                <button  class="p-2 text-white font-bold bg-blue-400 mr-10 rounded" type="button" id="default-modal">ammenities</button>
                <button class="p-2 text-white font-bold bg-blue-400 mr-10 rounded" id="add-rooms">add rooms</button>

        </div>`;
                    }
                }

            })
            $(document).on('click', '#default-modal', function() {
                let hotelId=document.getElementById('hotel-id');
                // let url = `http://192.168.1.200:8000/api/v1/hotel/${window.location.href.split('/').pop()}`;

                $.ajax({

                })
                document.getElementById('modal').classList.toggle('hidden')
            })
        })
    </script>
@endpush
