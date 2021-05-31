<?php
$session = \Config\Services::session();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta content="Admin Dashboard" name="description" />
    <meta content="Mannatthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- <link rel="shortcut icon" href="<?= base_url() ?>/assets/images/favicon.ico"> -->
    <link rel="shortcut icon" href="<?= base_url() ?>/assets/images/logo.png">
    <!-- DataTables -->
    <link href="<?= base_url() ?>/assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>/assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="<?= base_url() ?>/assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <link href="<?= base_url() ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/icons/node_modules/@mdi/font/css/materialdesignicons.css" type="tex/css">
    <link href="<?= base_url() ?>/assets/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>/css/select2.min.css" rel="stylesheet" type="text/css">
    <!-- Sweet-Alert  -->
    <link href="<?= base_url() ?>/assets/sweet-alert2/dist/sweetalert2.min.css" rel="stylesheet" type="text/css">
    <script src="<?= base_url() ?>/assets/sweet-alert2/dist/sweetalert2.all.min.js"></script>
    <!-- chart -->
    <link href="<?= base_url() ?>/assets/plugins/morris/morris.css" rel="stylesheet">
    <link href="<?= base_url() ?>/assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>/assets/css/style.css" rel="stylesheet" type="text/css">
    <!-- highChart -->
    <script src="<?= base_url() ?>/js/highcharts.js"></script>
    <!-- <script src="<?= base_url() ?>/js/dataHS.js"></script> -->
    <script src="<?= base_url() ?>/js/exporting.js"></script>
    <!-- <script src="<?= base_url() ?>/js/accessibility.js"></script> -->

</head>


<body>

    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner"></div>
        </div>
    </div>

    <!-- Navigation Bar-->
    <header id="topnav">
        <div class="topbar-main">
            <div class="container-fluid">

                <!-- Logo container-->
                <div class="logo">
                    <!-- Text Logo -->
                    <!--<a href="index.html" class="logo">-->
                    <!--Annex-->
                    <!--</a>-->
                    <!-- Image Logo -->
                    <a href="/Home" class="logo">
                        <img src="<?= base_url() ?>/assets/images/logo-sm.png" alt="" height="22" class="logo-small">
                        <img src="<?= base_url() ?>/assets/images/logo.png" alt="" height="50" class="logo-large">
                    </a>

                </div>
                <!-- End Logo container-->


                <div class="menu-extras topbar-custom">

                    <ul class="list-inline float-right mb-0">
                        <!-- User-->
                        <li class="list-inline-item dropdown notification-list">
                            <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <img src="<?= base_url() ?>/assets/images/users/avatar-1.jpg" alt="user" class="rounded-circle">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                <!-- item-->
                                <div class="dropdown-item noti-title">
                                    <h5>
                                        <?= $session->get('nama_user'); ?>
                                    </h5>
                                </div>
                                <a class="dropdown-item" href="<?= site_url('Login/keluar'); ?>"><i class="mdi mdi-logout m-r-5 text-muted"></i> Keluar</a>
                            </div>
                        </li>
                        <li class="menu-item list-inline-item">
                            <!-- Mobile menu toggle-->
                            <a class="navbar-toggle nav-link">
                                <div class="lines">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </a>
                            <!-- End mobile menu toggle-->
                        </li>

                    </ul>
                </div>
                <!-- end menu-extras -->

                <div class="clearfix"></div>

            </div> <!-- end container -->
        </div>
        <!-- end topbar-main -->

        <!-- MENU Start -->
        <div class="navbar-custom">
            <div class="container-fluid">
                <div id="navigation">
                    <!-- Navigation Menu-->
                    <ul class="navigation-menu">
                        <?= $this->renderSection('menu'); ?>
                    </ul>
                    <!-- End navigation menu -->
                </div> <!-- end #navigation -->
            </div> <!-- end container -->
        </div> <!-- end navbar-custom -->
    </header>
    <!-- End Navigation Bar-->


    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <!-- Page-Title -->
                <!-- -------------------------------------------------------------------------------------------------------------------------------------------------------- -->
                <?= $this->renderSection('isi'); ?>
                <!-- -------------------------------------------------------------------------------------------------------------------------------------------------------- -->

            </div>
            <!-- end page title end breadcrumb -->

        </div> <!-- end container -->
    </div>
    <!-- end wrapper -->
    <!-- Footer -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <?php $d = date('Y') ?>
                    © <?= $d; ?> SMAN 3 Tangerang.
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer -->

    <!-- jQuery  -->
    <script src="<?= base_url() ?>/assets/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/popper.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/modernizr.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/waves.js"></script>
    <script src="<?= base_url() ?>/assets/js/jquery.slimscroll.js"></script>
    <script src="<?= base_url() ?>/assets/js/jquery.nicescroll.js"></script>
    <script src="<?= base_url() ?>/assets/js/jquery.scrollTo.min.js"></script>

    <!-- Required datatable js -->
    <script src="<?= base_url() ?>/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="<?= base_url() ?>/assets/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatables/jszip.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatables/pdfmake.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatables/vfs_fonts.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatables/buttons.html5.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatables/buttons.print.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatables/buttons.colVis.min.js"></script>
    <!-- Responsive examples -->
    <script src="<?= base_url() ?>/assets/plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatables/responsive.bootstrap4.min.js"></script>

    <!-- Datatable init js -->
    <script src="<?= base_url() ?>/assets/pages/datatables.init.js"></script>
    <!-- App js -->
    <script src="<?= base_url() ?>/assets/js/app.js"></script>

    <!-- chart dashborad -->
    <!-- <script src="<?= base_url() ?>/assets/pages/dashborad.js"></script> -->
    <!-- Chart JS -->
    <script src="<?= base_url() ?>/assets/plugins/chart.js/Chart.min.js"></script>
    <!-- <script src="<?= base_url() ?>/assets/pages/chartjs.init.js"></script> -->


    <script src="<?= base_url() ?>/assets/plugins/skycons/skycons.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/raphael/raphael-min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/morris/morris.min.js"></script>
    <!-- <script src="assets/pages/morris.init.js"></script> -->

    <!-- custom js -->
    <script src="<?= base_url() ?>/js/dashboard.js"></script>
    <script src="<?= base_url() ?>/js/data.js"></script>
    <script src="<?= base_url() ?>/js/select2.min.js"></script>

    <!-- <script src="<?= base_url() ?>/js/peringkat.js"></script> -->


</body>

</html>