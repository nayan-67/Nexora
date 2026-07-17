@extends('layout.layout')

@section('dactive','active')

@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header py-2">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6 align-items-center d-flex">
                        <h3 class="mb-0 fs-4">Dashboard</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <!--begin::Col-->
                    <div class="col-lg-3 col-6">
                        <!--begin::Small Box Widget 1-->
                        <div class="small-box text-bg-primary">
                            <div class="inner">
                                <h3><?php echo $catdata ?? '0'; ?></h3>
                                <p>Category</p>
                            </div>
                            <i class="small-box-icon bi bi-layers-fill"></i>
                        </div>
                        <!--end::Small Box Widget 1-->
                    </div>
                    <!--end::Col-->
                    <div class="col-lg-3 col-6">
                        <!--begin::Small Box Widget 2-->
                        <div class="small-box text-bg-success">
                            <div class="inner">
                                <h3><?php echo $subcatdata ?? '0'; ?></h3>
                                <p>SUB Category</p>
                            </div>
                            <i class="small-box-icon bi bi-layers-half"></i>
                        </div>
                        <!--end::Small Box Widget 2-->
                    </div>
                    <!--end::Col-->
                    <div class="col-lg-3 col-6">
                        <!--begin::Small Box Widget 2-->
                        <div class="small-box text-bg-info">
                            <div class="inner">
                                <h3><?php echo $productdata ?? '0'; ?></h3>
                                <p>Product</p>
                            </div>
                            <i class="small-box-icon bi bi-box-seam-fill"></i>
                        </div>
                        <!--end::Small Box Widget 2-->
                    </div>
                    <!--end::Col-->
                    <div class="col-lg-3 col-6">
                        <!--begin::Small Box Widget 2-->
                        <div class="small-box text-bg-warning">
                            <div class="inner">
                                <h3><?php echo $discountdata ?? '0'; ?></h3>
                                <p>Discount Coupon</p>
                            </div>
                            <i class="small-box-icon bi bi-percent"></i>
                        </div>
                        <!--end::Small Box Widget 2-->
                    </div>
                    <!--end::Col-->
                    <div class="col-lg-3 col-6">
                        <!--begin::Small Box Widget 2-->
                        <div class="small-box text-bg-danger">
                            <div class="inner">
                                <h3><?php echo $orderdata ?? '0'; ?></h3>
                                <p>Orders</p>
                            </div>
                            <i class="small-box-icon bi bi-cart3"></i>
                        </div>
                        <!--end::Small Box Widget 2-->
                    </div>
                    <!--end::Col-->
                    <div class="col-lg-3 col-6">
                        <!--begin::Small Box Widget 2-->
                        <div class="small-box bg-info-subtle">
                            <div class="inner">
                                <h3><?php echo $userdata ?? '0'; ?></h3>
                                <p>Customer</p>
                            </div>
                            <i class="small-box-icon bi bi-person-fill"></i>
                        </div>
                        <!--end::Small Box Widget 2-->
                    </div>
                    <!--end::Col-->

                </div>
                <!--end::Row-->
                <!-- /.row (main row) -->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
@endsection
