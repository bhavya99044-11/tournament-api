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

                        <div class="flex items-center justify-center mt-3">
                            <a href="{{ route('auth.social.redirect') }}" class="text-white bg-white rounded-full p-2">
                                <svg height="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                    <path fill="#fbc02d"
                                        d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12	s5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24s8.955,20,20,20	s20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z" />
                                    <path fill="#e53935"
                                        d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039	l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z" />
                                    <path fill="#4caf50"
                                        d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36	c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z" />
                                    <path fill="#1565c0"
                                        d="M43.611,20.083L43.595,20L42,20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571	c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z" />
                                </svg> </span>
                            </a>
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
                            window.location.href = "{{ route('admin.dashboard') }}"
                        } else if (response.status == 401) {
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
