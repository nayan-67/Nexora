@extends('layout.layout')

@section('title', 'Customer')
@section('uactive', 'active')

@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header py-2">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-4 align-items-center d-flex">
                        <h3 class="mb-0 page-head fs-4">Customer</h3>
                    </div>
                    <div class="col-sm-4 d-flex align-items-center justify-content-center">
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active page-head" aria-current="page">Customer</li>
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

            <div class="delete-modal" id="del-modal">
                <div class="delete-modal-dialog rounded-3">
                    <!-- Modal content-->
                    <div class="row modal-top d-flex align-items-center px-4 py-3">
                        <div class="col-sm-3 fs-1">
                            <i class="fa-solid fa-triangle-exclamation text-danger"></i>
                        </div>
                        <div class=" col-sm-9 m-content">
                            <h5 class="p-0 m-0 fw-bold">DELETE CUSTOMER</h5>
                            <p class="p-0 m-0">This action cannot be undone.</p>
                        </div>
                    </div>
                    <hr class="m-0 text-secondery opacity-10">
                    <div class="row modal-btn d-flex align-items-center justify-content-space-between px-4 py-3">
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-outline-secondary btn-md w-100 shadow-sm del-close"
                                name="">CANCEL</button>
                        </div>
                        <form action="{{ route('user.destroy') }}" method="POST" class=" col-sm-6 m-content">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" id="modal-id" value="" name="id">
                            <input type="submit" class="btn btn-danger btn-md w-100 shadow-sm" value="DELETE">
                        </form>
                    </div>

                </div>
            </div>

            <!-- ====== Customer Section ======= -->

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
                                        <div class="d-flex gap-2">
                                            <button id="export-csv" type="button" class="btn btn-sm btn-primary">
                                                <i class="bi bi-filetype-csv me-1" aria-hidden="true"></i>
                                                Export CSV
                                            </button>
                                            {{-- <button id="export-json" type="button"
                                                class="btn btn-sm btn-outline-secondary">
                                                <i class="bi bi-filetype-json me-1" aria-hidden="true"></i>
                                                Export JSON
                                            </button> --}}
                                            <button id="print-table" type="button" class="btn btn-sm btn-success">
                                                <i class="bi bi-printer me-1" aria-hidden="true"></i>
                                                Print
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="d-flex flex-wrap justify-content-md-end gap-2">
                                            <div class="input-group input-group-sm w-auto">
                                                <span class="input-group-text">
                                                    <i class="bi bi-search" aria-hidden="true"></i>
                                                </span>
                                                <input type="search" id="search" class="form-control"
                                                    placeholder="Search users" aria-label="Search users"
                                                    style="width: 180px" />
                                            </div>
                                            {{-- <select id="user-role-filter" class="form-select form-select-sm w-auto"
                                                aria-label="Filter by role">
                                                <option value="all" selected>All roles</option>
                                                <option value="administrator">Administrator</option>
                                                <option value="editor">Editor</option>
                                                <option value="author">Author</option>
                                                <option value="subscriber">Subscriber</option>
                                            </select>
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#modal-add-user">
                                                <i class="bi bi-person-plus-fill me-1" aria-hidden="true"> </i>
                                                New user
                                            </button> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Card Header-->
                            <div id="user-table-content">
                                @include('user.table')
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

        function reloadUserTable() {
            const query = encodeURIComponent(searchInput.value.trim());
            const perPage = encodeURIComponent(showDataSelect.value);
            loadData(`customer?search=${query}&per_page=${perPage}`, '#user-table-content');
        }

        searchInput.addEventListener('input', (e) => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(reloadUserTable, 500);
        });

        showDataSelect.addEventListener('change', () => {
            reloadUserTable();
        });
        // document
        //   .getElementById('export-csv')
        //   .addEventListener('click', () => table.download('csv', 'users.csv'));
        // document
        //   .getElementById('export-json')
        //   .addEventListener('click', () => table.download('json', 'users.json'));
        // document
        //   .getElementById('print-table')
        //   .addEventListener('click', () => table.print(false, true));
    </script>
@endsection
