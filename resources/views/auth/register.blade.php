<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrasi Pengguna</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

    <style>
        /* Background styling */
        body {
            background-image: url('{{ asset('img/login.jpg') }}');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        /* Styling untuk card registrasi */
        .register-box {
            width: 400px;
            background-color: rgba(255, 255, 255, 0.1); /* Efek transparan */
            backdrop-filter: blur(15px); /* Efek blur */
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0px 4px 30px rgba(0, 0, 0, 0.2); /* Efek bayangan */
        }

        .register-box .card-header {
            background: none;
            border-bottom: none;
            text-align: center;
        }

        .register-box .h1 {
            font-weight: 700;
            color: #6c5ce7;
        }

        /* Styling untuk input fields */
        .form-control {
            background: rgba(255, 255, 255, 0.8); /* Transparansi input */
            border: none;
            color: #a29bfe;
        }

        .input-group-text {
            background: rgba(255, 255, 255, 0.8);
            border: none;
            color: #a29bfe;
        }

        /* Styling untuk tombol */
        .btn-primary {
            background-color: #6c5ce7;
            border: none;
            width: 100%;
            font-weight: bold;
            border-radius: 30px;
        }

        .btn-primary:hover {
            background-color: #a29bfe;
        }

        /* Styling untuk link login */
        .register-box a {
            color: #6d63fd;
        }

        .register-box a:hover {
            color: white;
        }

        /* Rounded input fields */
        .input-group .form-control {
            border-radius: 30px;
        }

        .input-group .input-group-text {
            border-radius: 30px;
        }
    </style>
</head>

<body>
    <div class="register-box">
        <!-- /.register-logo -->
        <div class="card-header text-center">
            <a href="{{ url('/') }}" class="h1"><b>Register</b></a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('register') }}" id="form-register">
                @csrf
                <div class="input-group mb-3">
                    <select class="form-control" id="level_id" name="level_id" required>
                        <option value="">- Pilih Level -</option>
                        @foreach ($level as $item)
                            <option value="{{ $item->level_id }}">{{ $item->level_nama }}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-layer-group"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="text" id="username" name="username" class="form-control" placeholder="Username"
                        value="{{ old('username') }}" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama"
                        value="{{ old('nama') }}" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-id-card"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password"
                        required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </div>
                </div>

                <!-- Tambahan untuk teks login -->
                <div class="row mt-2">
                    <div class="col-12 text-center">
                        <p>Sudah punya akun? <a href="{{ url('login') }}">Login</a></p>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#form-register").validate({
                rules: {
                    level_id: {
                        required: true,
                    },
                    username: {
                        required: true,
                        minlength: 4,
                        maxlength: 20
                    },
                    password: {
                        required: true,
                        minlength: 5,
                    }
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                }).then(function() {
                                    window.location = response.redirect;
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        }
                    });
                    return false;
                }
            });
        });
    </script>
</body>

</html>
