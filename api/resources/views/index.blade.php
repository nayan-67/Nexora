@extends('layout.layout')

@section('dactive', 'active')

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
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
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
                            <i class="small-box-icon bi bi-grid"></i>
                        </div>
                        <!--end::Small Box Widget 1-->
                    </div>
                    <!--end::Col-->
                    <div class="col-lg-3 col-6">
                        <!--begin::Small Box Widget 2-->
                        <div class="small-box text-bg-success">
                            <div class="inner">
                                <h3><?php echo $subcatdata ?? '0'; ?></h3>
                                <p>Sub Category</p>
                            </div>
                            <i class="small-box-icon bi bi-diagram-3"></i>
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
                            <i class="small-box-icon bi bi-box-seam"></i>
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
                            <i class="small-box-icon bi bi-ticket-perforated"></i>
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
                            <i class="small-box-icon bi bi-person"></i>
                        </div>
                        <!--end::Small Box Widget 2-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->

                <!--begin::Row-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title">Monthly Recap Report</h5>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                    </button>
                                    {{-- <div class="btn-group">
                                        <button type="button" class="btn btn-tool dropdown-toggle"
                                            data-bs-toggle="dropdown">
                                            <i class="bi bi-wrench"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" role="menu">
                                            <a href="#" class="dropdown-item">Action</a>
                                            <a href="#" class="dropdown-item">Another action</a>
                                            <a href="#" class="dropdown-item"> Something else here </a>
                                            <a class="dropdown-divider"></a>
                                            <a href="#" class="dropdown-item">Separated link</a>
                                        </div>
                                    </div> --}}
                                    {{-- <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                                        <i class="bi bi-x-lg"></i>
                                    </button> --}}
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <!--begin::Row-->
                                <div class="row">
                                    <div class="col-md-8">
                                        <p class="text-center">
                                            <strong>Sales: 1 Jan, 2023 - 30 Jul, 2023</strong>
                                        </p>
                                        <div id="sales-chart"></div>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-4">
                                        <p class="text-center"><strong>Goal Completion</strong></p>
                                        <div class="progress-group">
                                            Add Products to Cart
                                            <span class="float-end"><b>160</b>/200</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar text-bg-primary" style="width: 80%"></div>
                                            </div>
                                        </div>
                                        <!-- /.progress-group -->
                                        <div class="progress-group">
                                            Complete Purchase
                                            <span class="float-end"><b>310</b>/400</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar text-bg-danger" style="width: 75%"></div>
                                            </div>
                                        </div>
                                        <!-- /.progress-group -->
                                        <div class="progress-group">
                                            <span class="progress-text">Visit Premium Page</span>
                                            <span class="float-end"><b>480</b>/800</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar text-bg-success" style="width: 60%"></div>
                                            </div>
                                        </div>
                                        <!-- /.progress-group -->
                                        <div class="progress-group">
                                            Send Inquiries
                                            <span class="float-end"><b>250</b>/500</span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar text-bg-warning" style="width: 50%"></div>
                                            </div>
                                        </div>
                                        <!-- /.progress-group -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!--end::Row-->
                            </div>
                            <!-- ./card-body -->
                            <div class="card-footer">
                                <!--begin::Row-->
                                <div class="row">
                                    <div class="col-md-3 col-6">
                                        <div class="text-center border-end">
                                            <span class="text-success">
                                                <i class="bi bi-caret-up-fill"></i> 17%
                                            </span>
                                            <h5 class="fw-bold mb-0">$35,210.43</h5>
                                            <span class="text-uppercase">TOTAL REVENUE</span>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-3 col-6">
                                        <div class="text-center border-end">
                                            <span class="text-info"> <i class="bi bi-caret-left-fill"></i> 0% </span>
                                            <h5 class="fw-bold mb-0">$10,390.90</h5>
                                            <span class="text-uppercase">TOTAL COST</span>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-3 col-6">
                                        <div class="text-center border-end">
                                            <span class="text-success">
                                                <i class="bi bi-caret-up-fill"></i> 20%
                                            </span>
                                            <h5 class="fw-bold mb-0">$24,813.53</h5>
                                            <span class="text-uppercase">TOTAL PROFIT</span>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-3 col-6">
                                        <div class="text-center">
                                            <span class="text-danger">
                                                <i class="bi bi-caret-down-fill"></i> 18%
                                            </span>
                                            <h5 class="fw-bold mb-0">1200</h5>
                                            <span class="text-uppercase">GOAL COMPLETIONS</span>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Row-->
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row">
                    <!-- Start col -->
                    <div class="col-md-8 mb-4">
                        <!-- PRODUCT LIST -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Recently Added Products</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                    </button>
                                    {{-- <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                                        <i class="bi bi-x-lg"></i>
                                    </button> --}}
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <div class="px-2">
                                    <div class="d-flex border-top py-2 px-1">
                                        <div class="col-2">
                                            <img src="./assets/img/default-150x150.png" alt="Product Image"
                                                class="img-size-50" />
                                        </div>
                                        <div class="col-10">
                                            <a href="javascript:void(0)" class="fw-bold">
                                                Samsung TV
                                                <span class="badge text-bg-warning float-end"> $1800 </span>
                                            </a>
                                            <div class="text-truncate">Samsung 32" 1080p 60Hz LED Smart HDTV.</div>
                                        </div>
                                    </div>
                                    <!-- /.item -->
                                    <div class="d-flex border-top py-2 px-1">
                                        <div class="col-2">
                                            <img src="./assets/img/default-150x150.png" alt="Product Image"
                                                class="img-size-50" />
                                        </div>
                                        <div class="col-10">
                                            <a href="javascript:void(0)" class="fw-bold">
                                                Bicycle
                                                <span class="badge text-bg-info float-end"> $700 </span>
                                            </a>
                                            <div class="text-truncate">
                                                26" Mongoose Dolomite Men's 7-speed, Navy Blue.
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.item -->
                                    <div class="d-flex border-top py-2 px-1">
                                        <div class="col-2">
                                            <img src="./assets/img/default-150x150.png" alt="Product Image"
                                                class="img-size-50" />
                                        </div>
                                        <div class="col-10">
                                            <a href="javascript:void(0)" class="fw-bold">
                                                Xbox One
                                                <span class="badge text-bg-danger float-end"> $350 </span>
                                            </a>
                                            <div class="text-truncate">
                                                Xbox One Console Bundle with Halo Master Chief Collection.
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.item -->
                                    <div class="d-flex border-top py-2 px-1">
                                        <div class="col-2">
                                            <img src="./assets/img/default-150x150.png" alt="Product Image"
                                                class="img-size-50" />
                                        </div>
                                        <div class="col-10">
                                            <a href="javascript:void(0)" class="fw-bold">
                                                PlayStation 4
                                                <span class="badge text-bg-success float-end"> $399 </span>
                                            </a>
                                            <div class="text-truncate">PlayStation 4 500GB Console (PS4)</div>
                                        </div>
                                    </div>
                                    <!-- /.item -->
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-center">
                                <a href="javascript:void(0)" class="btn btn-sm btn-primary float-end">
                                    View All Products
                                </a>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4">
                        <!-- USERS LIST -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Latest Members</h3>
                                <div class="card-tools">
                                    <span class="badge text-bg-danger"> 8 New Members </span>
                                    <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <div class="row text-center m-1">
                                    <div class="col-3 p-2">
                                        <img class="img-fluid rounded-circle" src="./assets/img/user1-128x128.jpg"
                                            alt="User Image" />
                                        <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="#">
                                            Alexander Pierce
                                        </a>
                                        <div class="fs-8">Today</div>
                                    </div>
                                    <div class="col-3 p-2">
                                        <img class="img-fluid rounded-circle" src="./assets/img/user1-128x128.jpg"
                                            alt="User Image" />
                                        <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="#">
                                            Norman
                                        </a>
                                        <div class="fs-8">Yesterday</div>
                                    </div>
                                    <div class="col-3 p-2">
                                        <img class="img-fluid rounded-circle" src="./assets/img/user7-128x128.jpg"
                                            alt="User Image" />
                                        <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="#">
                                            Jane
                                        </a>
                                        <div class="fs-8">12 Jan</div>
                                    </div>
                                    <div class="col-3 p-2">
                                        <img class="img-fluid rounded-circle" src="./assets/img/user6-128x128.jpg"
                                            alt="User Image" />
                                        <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="#">
                                            John
                                        </a>
                                        <div class="fs-8">12 Jan</div>
                                    </div>
                                    <div class="col-3 p-2">
                                        <img class="img-fluid rounded-circle" src="./assets/img/user2-160x160.jpg"
                                            alt="User Image" />
                                        <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="#">
                                            Alexander
                                        </a>
                                        <div class="fs-8">13 Jan</div>
                                    </div>
                                    <div class="col-3 p-2">
                                        <img class="img-fluid rounded-circle" src="./assets/img/user5-128x128.jpg"
                                            alt="User Image" />
                                        <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="#">
                                            Sarah
                                        </a>
                                        <div class="fs-8">14 Jan</div>
                                    </div>
                                    <div class="col-3 p-2">
                                        <img class="img-fluid rounded-circle" src="./assets/img/user4-128x128.jpg"
                                            alt="User Image" />
                                        <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="#">
                                            Nora
                                        </a>
                                        <div class="fs-8">15 Jan</div>
                                    </div>
                                    <div class="col-3 p-2">
                                        <img class="img-fluid rounded-circle" src="./assets/img/user3-128x128.jpg"
                                            alt="User Image" />
                                        <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="#">
                                            Nadia
                                        </a>
                                        <div class="fs-8">15 Jan</div>
                                    </div>
                                </div>
                                <!-- /.users-list -->
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-center">
                                <a href="javascript:"
                                    class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">View
                                    All Users</a>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <!--begin::Latest Order Widget-->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Latest Orders</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                    </button>
                                    {{-- <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                                        <i class="bi bi-x-lg"></i>
                                    </button> --}}
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table m-0">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Item</th>
                                                <th>Status</th>
                                                <th>Popularity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <a href="pages/examples/invoice.html"
                                                        class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR9842</a>
                                                </td>
                                                <td>Call of Duty IV</td>
                                                <td><span class="badge text-bg-success"> Shipped </span></td>
                                                <td>
                                                    <div id="table-sparkline-1"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="pages/examples/invoice.html"
                                                        class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR1848</a>
                                                </td>
                                                <td>Samsung Smart TV</td>
                                                <td><span class="badge text-bg-warning">Pending</span></td>
                                                <td>
                                                    <div id="table-sparkline-2"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="pages/examples/invoice.html"
                                                        class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR7429</a>
                                                </td>
                                                <td>iPhone 6 Plus</td>
                                                <td><span class="badge text-bg-danger"> Delivered </span></td>
                                                <td>
                                                    <div id="table-sparkline-3"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="pages/examples/invoice.html"
                                                        class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR7429</a>
                                                </td>
                                                <td>Samsung Smart TV</td>
                                                <td><span class="badge text-bg-info">Processing</span></td>
                                                <td>
                                                    <div id="table-sparkline-4"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="pages/examples/invoice.html"
                                                        class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR1848</a>
                                                </td>
                                                <td>Samsung Smart TV</td>
                                                <td><span class="badge text-bg-warning">Pending</span></td>
                                                <td>
                                                    <div id="table-sparkline-5"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="pages/examples/invoice.html"
                                                        class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR7429</a>
                                                </td>
                                                <td>iPhone 6 Plus</td>
                                                <td><span class="badge text-bg-danger"> Delivered </span></td>
                                                <td>
                                                    <div id="table-sparkline-6"></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="pages/examples/invoice.html"
                                                        class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR9842</a>
                                                </td>
                                                <td>Call of Duty IV</td>
                                                <td><span class="badge text-bg-success">Shipped</span></td>
                                                <td>
                                                    <div id="table-sparkline-7"></div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <a href="javascript:void(0)" class="btn btn-sm btn-primary float-end">
                                    View all order
                                </a>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                    </div>
                </div>
                <!--end::Row-->
                <!-- /.row (main row) -->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
@endsection

@section('script')
    <!-- apexcharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
        integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8=" crossorigin="anonymous"></script>
    <script>
        // NOTICE!! DO NOT USE ANY OF THIS JAVASCRIPT
        // IT'S ALL JUST JUNK FOR DEMO
        // ++++++++++++++++++++++++++++++++++++++++++

        /* apexcharts
         * -------
         * Here we will create a few charts using apexcharts
         */

        //-----------------------
        // - MONTHLY SALES CHART -
        //-----------------------

        const sales_chart_options = {
            series: [{
                    name: 'Digital Goods',
                    data: [28, 48, 40, 19, 86, 27, 90],
                },
                {
                    name: 'Electronics',
                    data: [65, 59, 80, 81, 56, 55, 40],
                },
            ],
            chart: {
                height: 180,
                type: 'area',
                toolbar: {
                    show: false,
                },
            },
            legend: {
                show: false,
            },
            colors: ['#0d6efd', '#20c997'],
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: 'smooth',
            },
            xaxis: {
                type: 'datetime',
                categories: [
                    '2023-01-01',
                    '2023-02-01',
                    '2023-03-01',
                    '2023-04-01',
                    '2023-05-01',
                    '2023-06-01',
                    '2023-07-01',
                ],
            },
            tooltip: {
                x: {
                    format: 'MMMM yyyy',
                },
            },
        };

        const sales_chart = new ApexCharts(
            document.querySelector('#sales-chart'),
            sales_chart_options,
        );
        sales_chart.render();

        //---------------------------
        // - END MONTHLY SALES CHART -
        //---------------------------

        function createSparklineChart(selector, data) {
            const options = {
                series: [{
                    data
                }],
                chart: {
                    type: 'line',
                    width: 150,
                    height: 30,
                    sparkline: {
                        enabled: true,
                    },
                },
                colors: ['var(--bs-primary)'],
                stroke: {
                    width: 2,
                },
                tooltip: {
                    fixed: {
                        enabled: false,
                    },
                    x: {
                        show: false,
                    },
                    y: {
                        title: {
                            formatter() {
                                return '';
                            },
                        },
                    },
                    marker: {
                        show: false,
                    },
                },
            };

            const chart = new ApexCharts(document.querySelector(selector), options);
            chart.render();
        }

        const table_sparkline_1_data = [25, 66, 41, 89, 63, 25, 44, 12, 36, 9, 54];
        const table_sparkline_2_data = [12, 56, 21, 39, 73, 45, 64, 52, 36, 59, 44];
        const table_sparkline_3_data = [15, 46, 21, 59, 33, 15, 34, 42, 56, 19, 64];
        const table_sparkline_4_data = [30, 56, 31, 69, 43, 35, 24, 32, 46, 29, 64];
        const table_sparkline_5_data = [20, 76, 51, 79, 53, 35, 54, 22, 36, 49, 64];
        const table_sparkline_6_data = [5, 36, 11, 69, 23, 15, 14, 42, 26, 19, 44];
        const table_sparkline_7_data = [12, 56, 21, 39, 73, 45, 64, 52, 36, 59, 74];

        createSparklineChart('#table-sparkline-1', table_sparkline_1_data);
        createSparklineChart('#table-sparkline-2', table_sparkline_2_data);
        createSparklineChart('#table-sparkline-3', table_sparkline_3_data);
        createSparklineChart('#table-sparkline-4', table_sparkline_4_data);
        createSparklineChart('#table-sparkline-5', table_sparkline_5_data);
        createSparklineChart('#table-sparkline-6', table_sparkline_6_data);
        createSparklineChart('#table-sparkline-7', table_sparkline_7_data);

        //-------------
        // - PIE CHART -
        //-------------

        const pie_chart_options = {
            series: [700, 500, 400, 600, 300, 100],
            chart: {
                type: 'donut',
            },
            labels: ['Chrome', 'Edge', 'FireFox', 'Safari', 'Opera', 'IE'],
            dataLabels: {
                enabled: false,
            },
            colors: ['#0d6efd', '#20c997', '#ffc107', '#d63384', '#6f42c1', '#adb5bd'],
        };

        const pie_chart = new ApexCharts(document.querySelector('#pie-chart'), pie_chart_options);
        pie_chart.render();

        //-----------------
        // - END PIE CHART -
        //-----------------
    </script>
    <!--end::Script-->
@endsection
