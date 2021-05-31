<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Login</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="Mannatthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- <link rel="shortcut icon" href="assets/images/favicon.ico"> -->
    <link rel="shortcut icon" href="<?= base_url() ?>/assets/images/logo.png">
    <link href="<?= base_url() ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>/assets/css/style.css" rel="stylesheet" type="text/css">

</head>

<body>
    <style>
        .tex {
            position: sticky;
            margin-top: 1vmin;
            margin-bottom: -2vmin;
        }
    </style>

    <!-- Begin page -->
    <div class="accountbg"></div>
    <div class="wrapper-page">
        <div class="card">
            <div class="card-body">

                <h3 class="text-center mt-0 ">
                    <a class="logo logo-admin"><img src="assets/images/logo.png" height="150" alt="logo"></a>
                    <div class="tex">
                        Silahkan Masuk
                    </div>
                </h3>

                <div class="p-3">
                    <?= form_open('Login/cekuser', ['class' => 'form_login']); ?>
                    <?= csrf_field(); ?>
                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control" type="text" placeholder="Nama Pengguna" autocomplete="off" name="username" id="username" autofocus>
                            <div class="invalid-feedback errorUser">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control" type="password" placeholder="Kata Sandi" name="password" id="password">
                            <div class="invalid-feedback errorPass">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <style>
                            p {
                                color: gray;
                                font-size: 13px;
                                margin-top: -12px;
                                margin-bottom: -12px;
                                text-align: center;
                            }
                        </style>
                        <p>
                            Nama Pengguna : admin dan Kata Sandi : admin
                        </p>
                    </div>
                    <div class="form-group text-center row m-t-20">
                        <div class="col-12">
                            <button class="btn btnlogin btn-danger btn-block waves-effect waves-light" type="submit">Masuk</button>
                        </div>
                    </div>
                    <?= form_close(); ?>
                </div>

            </div>
        </div>
    </div>



    <!-- jQuery  -->
    <script src="<?= base_url() ?>/assets/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/popper.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/modernizr.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/waves.js"></script>
    <script src="<?= base_url() ?>/assets/js/jquery.slimscroll.js"></script>
    <script src="<?= base_url() ?>/assets/js/jquery.nicescroll.js"></script>
    <script src="<?= base_url() ?>/assets/js/jquery.scrollTo.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.form_login').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'post',
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: 'json',
                    beforeSend: function() {
                        $('.btnlogin').prop('disabled', true);
                        $('.btnlogin').html('<i class = "fa  fa-spinner"></i>');
                    },
                    complete: function() {
                        $('.btnlogin').prop('disabled', false);
                        $('.btnlogin').html('Masuk');
                    },
                    success: function(response) {
                        if (response.error) {

                            if (response.error.username) {
                                $('#username').addClass('is-invalid');
                                $('.errorUser').html(response.error.username);
                            } else {
                                $('#username').removeClass('is-invalid');
                                $('.errorUser').html();
                            }

                            if (response.error.password) {
                                $('#password').addClass('is-invalid');
                                $('.errorPass').html(response.error.password);
                            } else {
                                $('#password').removeClass('is-invalid');
                                $('.errorPass').html();
                            }
                        }
                        if (response.sukses) {
                            window.location = response.sukses.link;
                        }
                    },
                    error: function(xhr, ajaxOption, throwError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + throwError);
                    }
                })
            })
        })
    </script>
</body>

</html>