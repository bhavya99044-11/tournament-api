<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js">
        < script src = "https://code.jquery.com/jquery-3.7.1.js" >
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script href="https://cdn.datatables.net/fixedcolumns/5.0.4/js/dataTables.fixedColumns.js"></script>
    <script href="https://cdn.datatables.net/fixedcolumns/5.0.4/js/fixedColumns.dataTables.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cuba</title>
    @vite('resources/css/app.css')
</head>

<body class="font-display">
    <div class="flex h-screen">
        @include('admin-panel.layouts.sidebar')
        @include('admin-panel.layouts.header')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        @yield('content')
    </div>
    </div>

</body>
<script src="https://js.pusher.com/8.3.0/pusher.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.getElementById('menu-toggle').addEventListener('click', function() {
            const sidebar = document.querySelector('aside');
            const mainContent = document.querySelector('.ml-64');

            sidebar.classList.toggle('-translate-x-full');
            mainContent.classList.toggle('ml-0');
            mainContent.classList.toggle('ml-64');
        });

        var pusher = new Pusher('0519053939aefd09aa7d', {
            cluster: 'ap2'
        });

        var channel = pusher.subscribe('records-notification');
        channel.bind('RecordNotificationEvent', function(data) {
            let collection=data.data;
            console.log(collection);

            let html='';
            for( let item in collection){
                 html += `Match${item} Score 1 : ${collection[item].home_team_score} Score 2 : ${collection[item].opponent_team_score} </br>`;
            }
            console.log(html);
            Swal.fire({
                title: 'Last 10 records',
                html: html,
                animation: false,
                position: 'top',
                showCloseButton: true,
                showConfirmButton: false,
                timer: 5000,
            })
        })
    });
</script>
@stack('scripts')

</html>
