@extends('layout.layout')

@section('title', 'Category')
@section('cactive', 'active')
@section('catlactive', 'active')
@section('catmenuopen', 'menu-open')

@section('modal-head', 'CATEGORY')
@section('delete-route', route('category.destroy'))


@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header py-2">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-4 align-items-center d-flex">
                        <h3 class="mb-0 page-head fs-4">Category</h3>
                    </div>
                    <div class="col-sm-4 d-flex align-items-center justify-content-center">
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active page-head" aria-current="page">Category</li>
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

            <!-- ====== Category Section ======= -->

            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-12">
                        <!--begin::Card-->
                        <div class="card mb-4">
                            <!--begin::Card Header-->
                            <div class="card-header">
                                <div class="row g-2 align-items-center">
                                    <div class="col-12 col-md-4 d-flex gap-4">
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
                                    <div class="col-12 col-md-8">
                                        <div class="d-flex flex-wrap justify-content-md-end gap-2">
                                            <div class="input-group input-group-sm w-auto">
                                                <span class="input-group-text">
                                                    <i class="bi bi-search" aria-hidden="true"></i>
                                                </span>
                                                <input type="search" id="search" class="form-control"
                                                    placeholder="Search category" aria-label="Search category"
                                                    style="width: 180px" />
                                            </div>
                                            <a href="{{ route('category.add') }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-plus-circle me-1" aria-hidden="true"> </i>
                                                New category
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Card Header-->
                            <div id="cat-table-content">
                                @include('category.table')
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
        let appURL = <?= json_encode(url('/')) ?>;

        document.addEventListener('change', (e) => {
            if (e.target.classList.contains('cat-st')) {
                fetch(`${appUrl}/category/status/${e.target.id}`)
                    .then(response => response.text())
                    .then(data => {
                        if (data == 'success') {
                            swalToast('success', 'Status Updated Successfully');
                        } else {
                            swalToast('error', 'Status Update Failed');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        });

        const searchInput = document.getElementById('search');
        const showDataSelect = document.getElementById('show-data');
        let searchTimeout;

        function reloadCategoryTable() {
            const query = encodeURIComponent(searchInput.value.trim());
            const perPage = encodeURIComponent(showDataSelect.value);
            loadData(`${appURL}/category?search=${query}&per_page=${perPage}`, '#cat-table-content');
        }

        searchInput.addEventListener('input', (e) => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(reloadCategoryTable, 500);
        });

        showDataSelect.addEventListener('change', () => {
            reloadCategoryTable();
        });
    </script>
@endsection
