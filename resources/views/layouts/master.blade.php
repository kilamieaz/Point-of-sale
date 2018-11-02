<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->

<body class="hold-transition skin-red sidebar-mini">
    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="index2.html" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>P</b></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>P</b>OS</span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <img src="{{ Storage::url(Auth::user()->photo()) }}" class="user-image" alt="User Image">
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">{{ auth()->user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    <img src="{{ Storage::url(Auth::user()->photo()) }}" class="img-circle" alt="User Image">

                                    <p>
                                        {{ auth()->user()->name }}
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <a href="user/profile" class="btn btn-default btn-flat">
                                        Change Profile
                                    </a>
                                    <a href="{{ route('logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- Sidebar user panel (optional) -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="{{ Storage::url(Auth::user()->photo()) }}" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p>{{ auth()->user()->name }}</p>
                        <!-- Status -->
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">MENU NAVIGASI</li>
                    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>

                    @if( Auth::user()->level == 1 )
                    <li><a href="{{ route('category.index') }}"><i class="fa fa-cube"></i> <span>Kategori</span></a></li>
                    <li><a href="{{ route('product.index') }}"><i class="fa fa-cubes"></i> <span>Produk</span></a></li>
                    <li><a href="{{ route('member.index') }}"><i class="fa fa-credit-card"></i> <span>Member</span></a></li>
                    <li><a href="{{ route('supplier.index') }}"><i class="fa fa-truck"></i> <span>Supplier</span></a></li>
                    <li><a href="{{ route('expenses.index') }}"><i class="fa fa-money"></i> <span>Pengeluaran</span></a></li>
                    <li><a href="{{ route('user.index') }}""><i class=" fa fa-user"></i> <span>User</span></a></li>
                    <li><a href="{{ route('sales.index') }}"><i class="fa fa-upload"></i> <span>Penjualan</span></a></li>
                    <li><a href="{{ route('purchase.index') }}"><i class="fa fa-download"></i> <span>Pembelian</span></a></li>
                    <li><a href="{{ route('report.index') }}"><i class="fa fa-file-pdf-o"></i> <span>Laporan</span></a></li>
                    <li><a href="{{ route('setting.index') }}"><i class="fa fa-gears"></i> <span>Setting</span></a></li>
                    @else
                    <li><a href="{{ route('transaction.index') }}"><i class="fa fa-shopping-cart"></i> <span>Transaksi</span></a></li>
                    <li><a href="{{ route('transaction.new') }}"><i class="fa fa-cart-plus"></i> <span>Transaksi Baru</span></a></li>
                    @endif
                </ul>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    @yield('title')
                </h1>
                <ol class="breadcrumb">
                    @section('breadcrumb')
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    @show
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                @yield('content')
                <!-- Default box -->
                {{-- <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Title</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                                <i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                                title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">

                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                    </div>
                    <!-- /.box-footer-->
                </div> --}}
                <!-- /.box -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="pull-right hidden-xs">
                Aplikasi POS oleh: Sultan Imam Muttaqin
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2018 <a href="#">Company</a>.</strong> All rights reserved.
        </footer>
        <!-- End Footer -->
    </div>
    <!-- REQUIRED JS SCRIPTS -->
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('script')
    <!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
</body>

</html>