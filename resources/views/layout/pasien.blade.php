<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title')</title>
    
    <!-- Custom fonts for this template -->
    <link href="{{ asset('template/vendor/fontawesome-free/css/all.min.css') }}"
    rel="stylesheet" type="text/css">
    <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('template/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="{{
    asset('template/vendor/datatables/dataTables.bootstrap4.min.css') }}"
    rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Stylesheets SB Admin 2 -->
    <link href="{{ asset('template/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    </head>

    <body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
    id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-icon rotate-n-15">
    <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Alya Hospital</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
    <a class="nav-link" href="{{route ('dashboard-pasien') }}">
    <i class="fas fa-fw fa-tachometer-alt"></i>
    <span>Dashboard</span></a>
    </li>


    <!-- Nav Item - Pendaftaran -->
    <li class="nav-item">
    <a class="nav-link" href="{{route ('pendaftaran.index') }}">
    <i class="fas fa-fw fa-solid fa-calendar-plus"></i>
    <span>Pendaftaran</span></a>
    </li>

    <!-- Nav Item - Riwayat Pendaftaran -->
    <li class="nav-item">
    <a class="nav-link" href="{{route ('antrian.index2') }}">
    <i class="fas fa-fw fa-solid fa-calendar-plus"></i>
    <span>Riwayat Pendaftaran</span></a>
    </li>


    <!-- Nav Item - Data Diri -->
    <li class="nav-item">
    <a class="nav-link" href="{{ route('pasien.show', auth()->user()->id) }}">
    <i class="fas fa-fw fa-solid fa-table"></i>
    <span>Data Pribadi</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0"
    id="sidebarToggle"></button>
    </div>
    </ul>
    <!-- End of Sidebar -->
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <form class="form-inline">
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa fa-bars"></i>
    </button>
    </form>
    

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">


    <div class="topbar-divider d-none d-sm-block"></div>

    <!-- Nav Item - User Information -->
    <li class="nav-item dropdown no-arrow">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
       aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->nama_user }}</span>
        <img class="img-profile rounded-circle" src="{{ Auth::user()->foto_user ? asset('storage/foto_user/' . Auth::user()->foto_user) : asset('default.jpg') }}" alt="User Image">
    </a>

    <!-- Dropdown - User Information -->
    <div class="dropdown-menu dropdown-menu-right 
    shadow animated--grow-in" aria-labelledby="userDropdown">
    <a class="dropdown-item" href="{{ route('user.profile') }}">
    <i class="fas fa-user fa-sm fa-fw mr-2 
    text-gray-400"></i>
    Profile
    </a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
    <i class="fas fa-sign-out-alt fa-sm fa-fw 
    mr-2 text-gray-400"></i>
    Logout
    </a>
    </div>
    </li>
    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Yakin untuk keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">Pilih "Logout" jika kamu yakin untuk meninggalkan halaman ini.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </ul>
    </nav>
    <!-- End of Topbar -->
    <!-- Begin Page Content -->
    <div class="container-fluid">
    @yield('content')
    </div>
    <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
    <!-- Footer -->
    <footer class="sticky-footer bg-white">

    <div class="container my-auto">
    <div class="copyright text-center my-auto">
    <span>Copyright &copy; Your Website 2021</span>
    </div>
    </div>
    </footer>
    <!-- End of Footer -->
    </div>
    <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Ready to 
    Leave?</h5>
    <button class="close" type="button" data-dismiss="modal"
    aria-label="Close">
    <span aria-hidden="true">×</span>
    </button>
    </div>
    <div class="modal-body">Select "Logout" below if you are ready to 
    end your current session.</div>
    <div class="modal-footer">
    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
    <a class="btn btn-primary" href="login.html">Logout</a>
    </div>
    </div>
    </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') 
    }}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') 
    }}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('template/js/sb-admin-2.min.js') }}"></script>
    <!-- Page level plugins -->
    <script src="{{ asset('template/vendor/datatables/jquery.dataTables.min.js') 
    }}"></script>
    <script src="{{
    asset('template/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Page level custom scripts -->
    <script src="{{ asset('template/js/demo/datatables-demo.js') }}"></script>
    </body>