@extends('layout.layout')

@section('title', 'Order')
@section('oactive', 'active')

@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header py-2">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-4 align-items-center d-flex">
                        <h3 class="mb-0 page-head fs-4">Order</h3>
                    </div>
                    <div class="col-sm-4 d-flex align-items-center justify-content-center">
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active page-head" aria-current="page">Order</li>
                        </ol>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content" style="min-height:88%;">
            <!--begin::Container-->

            <!-- ====== Order Section ======= -->

            {{-- <section class="bg-white h-100 page-section" style="margin:0 10px;">
                <div class="container h-100  border-2 border-top border-primary p-0 rounded">
                    <div class="row mx-1 py-3">
                        <div class="col-sm-2 d-flex align-items-center">
                            <h6 class="page-head fs-7 fw-bold">Order ID</h6>
                        </div>
                        <div class="col-sm-8">
                            <form class="d-flex" role="search" action="javascript:void(0)">
                                <input class="form-control me-2 fs-7" type="search" placeholder="Search.."
                                    aria-label="Search" id="search" value="" autocomplete="off" />
                            </form>
                        </div>
                    </div>
                    <div class="container w-auto border-2 border-top border-primary mx-2 py-2">
                        <div class="page-deatails">
                            <div class="header row fs-7 mt-3">
                                <div class="col-sm-2 text-center fw-bold">Order Number</div>
                                <div class="col-sm-3 text-center fw-bold">Deliver To</div>
                                <div class="col-sm-1 text-center fw-bold">Date</div>
                                <div class="col-sm-1 text-center fw-bold">Price</div>
                                <div class="col-sm-1 text-center fw-bold">Status</div>
                                <div class="col-sm-2 text-center fw-bold">Who Ordered</div>
                                <div class="col-sm-2 text-center fw-bold">Action</div>
                            </div>
                            <div class="results">
                                @if (count($data) > 0)
                                    @foreach ($data as $row)
                                        <?php
                                        $bill_id = $row->billing_address_id;
                                        $ship_id = $row->shipping_address_id;
                                        $billingresult = DB::table('order_address')->where('id', $bill_id)->first();
                                        $shippingresult = DB::table('order_address')->where('id', $ship_id)->first();
                                        $create = $row->created_at;
                                        $date = substr($create, 0, 10);
                                        $name = $billingresult->f_name . ' ' . $billingresult->l_name;
                                        $address = $shippingresult->address1 . ', ' . $shippingresult->city . ', ' . $shippingresult->postcode . ', ' . $shippingresult->state . ', ' . $shippingresult->country;
                                        ?>
                                        <hr class='m-2 text-body-tertiary opacity-10'>
                                        <div class='row fs-7'>
                                            <div
                                                class='col-sm-2 text-center d-flex align-items-center justify-content-center'>
                                                {{ $row->order_number }}</div>
                                            <div
                                                class='col-sm-3 text-center d-flex align-items-center justify-content-center text-wrap'>
                                                {{ $address ?? 'not found' }}</div>
                                            <div
                                                class='col-sm-1 text-center d-flex align-items-center justify-content-center'>
                                                {{ date('j-M-y', strtotime($date)) }}</div>
                                            <div
                                                class='col-sm-1 text-center d-flex align-items-center justify-content-center'>
                                                $ {{ $row->total_price }}</div>
                                            <div
                                                class='col-sm-1 text-center d-flex align-items-center justify-content-center'>
                                                <span
                                                    class="list-badge
                                                @if ($row->order_status == 0) {{ 'cancelled' }}
                                                @elseif($row->order_status == 1)
                                                    {{ 'processing' }}
                                                @elseif($row->order_status == 2)
                                                    {{ 'shipped' }}
                                                @else
                                                    {{ 'delivered' }} @endif
                                                ">
                                                    @if ($row->order_status == 0)
                                                        {{ 'Cancelled' }}
                                                    @elseif($row->order_status == 1)
                                                        {{ 'Processing' }}
                                                    @elseif($row->order_status == 2)
                                                        {{ 'Shipped' }}
                                                    @else
                                                        {{ 'Delivered' }}
                                                    @endif
                                                </span>
                                            </div>
                                            <div
                                                class='col-sm-2 text-center d-flex align-items-center justify-content-center'>
                                                {{ $name ?? 'user' }}</div>
                                            <div class='col-sm-2 text-center d-flex gap-2 justify-content-center'>
                                                <a href='{{ route('order.edit', encrypt($row->id)) }}'
                                                    class='btn btn-info fs-8 px-2 py-0 text-white d-flex align-items-center gap-1'
                                                    style='height: 25px;'><i
                                                        class='fa-regular fa-pen-to-square'></i>EDIT</a>
                                                <button type='button'
                                                    class='btn btn-danger fs-8 px-2 py-0 text-white d-flex align-items-center gap-1'
                                                    style='height: 25px;' onclick="openModal('{{ $row->id }}');"><i
                                                        class='fa-regular fa-trash-can'></i>DELETE</button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <hr class='m-2 text-body-tertiary opacity-10'>
                                    <div class='row fs-7'>
                                        <div class='col-sm-12 text-center'>No Order Found</div>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </section> --}}

            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-12">
                        <!--begin::Card-->
                        <div class="card mb-4">
                            <!--begin::Card Header-->
                            <div class="card-header">
                                <div class="row g-2 align-items-center">
                                    <div class="col-12 col-md-6 d-flex gap-4">
                                        <div class="d-flex align-items-center gap-3">
                                            <label>Show Data</label>
                                            <select id="show-data" class="form-select form-select-sm w-auto">
                                                <option value="10" selected>10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="d-flex flex-wrap justify-content-md-end gap-2">
                                            <div class="input-group input-group-sm w-auto">
                                                <span class="input-group-text">
                                                    <i class="bi bi-search" aria-hidden="true"></i>
                                                </span>
                                                <input type="search" id="search" class="form-control"
                                                    placeholder="Search orders" aria-label="Search orders"
                                                    style="width: 180px" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Card Header-->
                            <div id="order-table-content">
                                @include('order.table')
                            </div>
                        </div>
                        <!--end::Card-->
                    </div>
                    <!-- /.col -->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
@endsection


@section('script')

    <script>
        const searchInput = document.getElementById('search');
        const showDataSelect = document.getElementById('show-data');
        let searchTimeout;

        function reloadOrderTable() {
            const query = encodeURIComponent(searchInput.value.trim());
            const perPage = encodeURIComponent(showDataSelect.value);
            loadData(`order?search=${query}&per_page=${perPage}`, '#order-table-content');
        }

        searchInput.addEventListener('input', (e) => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(reloadOrderTable, 500);
        });

        showDataSelect.addEventListener('change', () => {
            reloadOrderTable();
        });
    </script>

@endsection
