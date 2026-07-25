@extends('layout.layout')

@section('title', 'Category')
@section('cactive', 'active')
@section('catlactive', 'active')
@section('catmenuopen', 'menu-open')

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

            <!-- ========= Modal ============ -->

            <div class="delete-modal" id="del-modal">
                <div class="delete-modal-dialog rounded-3">
                    <!-- Modal content-->
                    <div class="row modal-top d-flex align-items-center px-4 py-3">
                        <div class="col-sm-3 fs-1">
                            <i class="fa-solid fa-triangle-exclamation text-danger"></i>
                        </div>
                        <div class=" col-sm-9 m-content">
                            <h5 class="p-0 m-0 fw-bold">DELETE CATEGORY</h5>
                            <p class="p-0 m-0">This action cannot be undone.</p>
                        </div>
                    </div>
                    <hr class="m-0 text-secondery opacity-10">
                    <div class="row modal-btn d-flex align-items-center justify-content-space-between px-4 py-3">
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-outline-secondary btn-md w-100 shadow-sm del-close"
                                name="add-subpage">CANCEL</button>
                        </div>
                        <form action="{{ route('category.destroy') }}" method="POST" class=" col-sm-6 m-content">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" id="modal-id" value="" name="id">
                            <input type="submit" class="btn btn-danger btn-md w-100 shadow-sm" value="DELETE">
                        </form>
                    </div>
                </div>
            </div>

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
                            <!--begin::Card Body-->
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <!--begin::Data Table-->
                                    @include('category.table')
                                    <!--end::Data Table-->
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!--end::Card Body-->
                            <!--begin::Card Footer-->
                            <div class="card-footer clearfix">
                                {{-- <div class="float-start pt-1 fs-7 text-body-secondary">
                                    @php
                                        if ($catdata->total() == 1) {
                                            $showResults = 'Showing 1 of ' . $catdata->total() . ' categories';
                                        } else {
                                            $showResults =
                                                'Showing ' .
                                                $catdata->firstItem() .
                                                ' to ' .
                                                $catdata->lastItem() .
                                                ' of ' .
                                                $catdata->total() .
                                                ' categories';
                                        }
                                    @endphp
                                    {{ $showResults }}
                                </div>
                                <ul class="pagination pagination-sm m-0 float-end">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" aria-label="Previous"> &laquo; </a>
                                    </li>
                                    <li class="page-item active">
                                        <a class="page-link" href="#">1</a>
                                    </li>
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" aria-label="Next"> &raquo; </a>
                                    </li>
                                </ul> --}}
                                {{ $catdata->links() }}
                            </div>
                            <!--end::Card Footer-->
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

        searchInput.addEventListener('input', () => {
            // const query = this.value.trim() == "" ? '0' : this.value.trim();
            setTimeout(() => {
                // fetch(`${appUrl}/category/search/${query}`)
                //     .then(response => response.text())
                //     .then(data => {
                //         resultsDiv.innerHTML = data;
                //     })
                //     .catch(error => console.error('Error:', error));
                loadData(`${appURL}/category?search=${encodeURIComponent(this.value)}`)
            }, 500);
        });
    </script>
@endsection
