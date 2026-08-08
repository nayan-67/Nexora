@extends('layout.layout')

@section('title', 'Order')
@section('oactive', 'active')

@section('css')
    <style>
        .cancel-modal {
            height: 100vh;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background: #000000cc;
            z-index: 2000;
            display: grid;
            place-items: center;
            display: none;
        }

        .cancel-modal-dialog {
            height: auto;
            width: 325px;
            opacity: 0;
            transition: .8s;
        }
    </style>
@endsection

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
            
            <!-- ========= Modal ============ -->
            <div class="cancel-modal" id="cancel-modal">
                <div class="cancel-modal-dialog bg-body rounded-3">
                    <!-- Modal content-->
                    <div class="row modal-top d-flex align-items-center px-4 py-3">
                        <div class="col-sm-3 fs-1">
                            <i class="fa-solid fa-triangle-exclamation text-danger"></i>
                        </div>
                        <div class=" col-sm-9 m-content">
                            <h5 class="p-0 m-0 fw-bold text-uppercase">Cancel Order</h5>
                            <p class="p-0 m-0">This action cannot be undone.</p>
                        </div>
                    </div>
                    <hr class="m-0 text-secondery opacity-10">
                    <div class="row modal-btn d-flex align-items-center justify-content-space-between px-4 py-3">
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-outline-secondary btn-md w-100 shadow-sm modal-close"
                                name="">CANCEL</button>
                        </div>
                        <form action="{{ route('order.cancel') }}" method="POST" class=" col-sm-6 m-content">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" id="order-id" value="" name="id">
                            <input type="submit" class="btn btn-danger btn-md w-100 shadow-sm" value="CANCEL ORDER">
                        </form>
                    </div>

                </div>
            </div>

            <!-- ======= Order Section ======= -->

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

        let cancelModal = document.querySelector("#cancel-modal");
        let cancelModalBox = document.querySelector(".cancel-modal-dialog");
        let modalClose = document.querySelector(".modal-close");
        let OrderId = document.querySelector("#order-id");

        function openCancelModal(val) {
            OrderId.value = val;
            cancelModal.style.display = "grid";
            cancelModalBox.style.opacity = "1";
        }
        modalClose.addEventListener("click", () => {
            cancelModal.style.display = "none";
            cancelModalBox.style.opacity = "0";
        });
        cancelModal.addEventListener("click", () => {
            cancelModal.style.display = "none";
            cancelModalBox.style.opacity = "0";
        });
    </script>

@endsection
