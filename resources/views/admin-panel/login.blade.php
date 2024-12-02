<div>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf_token" content="{{ csrf_token() }}">

        <title>Tournament Login</title>
        @vite('resources/css/app.css')
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
        </style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    </head>

    <body>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Responsive Table Design</title>
        </head>

        <body>
            <section class="flex min-h-screen justify-center items-center">
                <div class="bg-cyan-100 flex rounded-2xl shadow-lg max-w-4xl p-4">
                    <div class="md:w-1/2 h-1/2 p-10">
                        <div class="font-bold text-xl">Login</div>
                        <p class="text-sm mt-5">please enter your detail</p>

                        <form class="flex flex-col  mt-3 " id="loginSubmit">
                            @csrf
                            <input
                                class="border focus:border-cyan-400 focus:placeholder-opacity-50 outline-none border-cyan-200 placeholder-cyan-300 w-full p-2 rounded-xl"
                                placeholder="email" name="email" type="email"></input>
                            <span class="error error_email h-2 text-sm text-red-600"></span>
                            <input
                                class="border focus:border-cyan-400 mt-4 focus:placeholder-opacity-50 outline-none border-cyan-200 placeholder-cyan-300 w-full p-2 rounded-xl"
                                placeholder="password" name="password" type="password" autocomplete="on"></input>
                            <span class="error error_password h-2 text-sm text-red-600"></span>
                            <button
                                class="w-full p-2 mt-4 rounded-xl text-white bg-blue-500 hover:bg-blue-600">Login</button>
                        </form>

                        <div class="grid grid-cols-7 items-center text-center">
                            <hr class="border col-span-3 border-gray-400">
                            <div class="col-span-1">OR</div>
                            <hr class="border col-span-3 border-gray-400">
                        </div>
                    </div>
                    <div class="hidden md:block w-1/2 h-1/2">
                        <img class="rounded-3xl"
                            src="https://img.freepik.com/free-vector/access-control-system-abstract-concept_335657-3180.jpg?t=st=1732791836~exp=1732795436~hmac=8ec969a32693b93350d5036c506001b774dfe7a5da455227a3ca2b4909b8af4a&w=740">
                    </div>
                </div>
        </body>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function(e) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let form = document.getElementById('loginSubmit');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (loginValidation()) {
                $.ajax({
                    url: "{{ route('admin.login') }}",
                    method: "post",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // [...document.querySelectorAll('.error')].forEach(function(data) {
                        //     data.innerHTML = '';
                        // });
                        if (response.status == 200) {
                            window.location.href="{{route('admin.dashboard')}}"
                        } else if (response.status== 401) {
                            // Object.keys(data.data).forEach(key => {
                            //     document.getElementsByClassName('error_' + key)[0].innerHTML = data
                            //        .data[key];
                            // });
                            // localStorage.setItem('token', data.token);
                            // window.location.href = 'http://127.0.0.1:8000/admin/dashboard';
                        }
                    }
                })
            } else {

            }

        });


        function loginValidation() {
            // validation logic here
            let email = document.getElementsByName('email')[0].value;
            let password = document.getElementsByName('password')[0].value;
            if (email == '' || password == '') {
                document.getElementsByClassName('error_email')[0].innerHTML = "Email is required";
                document.getElementsByClassName('error_password')[0].innerHTML = "Password is required";
                return false;
            }
            return true;
        }
    });
</script>
