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
                            <!--begin::Card Body-->
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle m-0">
                                        <thead class="fs-7">
                                            <tr align="center">
                                                <th>User</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Total Orders</th>
                                                <th>Created</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="fs-7 results">
                                            @if (count($data) > 0)
                                                @foreach ($data as $row)
                                                    @php
                                                        $name = $row->first_name . ' ' . $row->last_name;
                                                        $ordresult = DB::table('orders')
                                                            ->where('user_id', $row->id)
                                                            ->get();
                                                        $profile = $row->profile_image
                                                            ? 'uploads/' . $row->profile_image
                                                            : 'avatar.jpg';
                                                        $date = substr($row->created_at, 0, 10);
                                                    @endphp
                                                    <tr align="center">
                                                        <td>
                                                            <div class="d-flex align-items-center justify-content-center">
                                                                <img src="{{ asset($profile) }}" alt=""
                                                                    class="img-size-32 rounded-circle me-2" />
                                                                <span class="fw-medium">{{ $name ?? 'user' }}</span>
                                                            </div>
                                                        </td>
                                                        <td>{{ $row->email }}</td>
                                                        <td>{{ $row->phone }}</td>
                                                        <td>{{ count($ordresult) }}</td>
                                                        <td>{{ date('M j, Y', strtotime($date)) }}</td>
                                                        <td>
                                                            <span
                                                                class='list-badge {{ $row->status == '1' ? 'text-bg-success' : 'text-bg-warning' }}'>{{ $row->status == '1' ? 'Active' : 'Inactive' }}</span>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                <a href="{{ route('user.view', encrypt($row->id)) }}"
                                                                    class="btn btn-outline-info d-flex" data-bs-toggle="tooltip"
                                                                    data-bs-title="View">
                                                                    <i class="bi bi-eye d-flex py-1" aria-hidden="true"> </i>
                                                                </a>
                                                                <a href="{{ route('user.order', encrypt($row->id)) }}"
                                                                    class="btn btn-outline-primary d-flex align-items-center"
                                                                    data-bs-toggle="tooltip" data-bs-title="Orders">
                                                                    <i class="bi bi-cart3 d-flex" aria-hidden="true"> </i>
                                                                </a>
                                                                {{-- <button type="button" class="btn btn-outline-danger"
                                                                    data-bs-toggle="tooltip" data-bs-title="Delete"
                                                                    onclick="openModal('{{ $row->id }}');">
                                                                    <i class="bi bi-trash d-flex" aria-hidden="true"> </i>
                                                                </button> --}}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr align="center">
                                                    <td colspan="7">No User Found</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!--end::Card Body-->
                            <!--begin::Card Footer-->
                            <div class="card-footer clearfix">
                                <div class="float-start pt-1 fs-7 text-body-secondary">
                                    Showing 1 to 9 of 42 users
                                </div>
                                <ul class="pagination pagination-sm m-0 float-end">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" aria-label="Previous"> &laquo; </a>
                                    </li>
                                    <li class="page-item active">
                                        <a class="page-link" href="#">1</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">2</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">3</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">4</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">5</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Next"> &raquo; </a>
                                    </li>
                                </ul>
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
        const searchInput = document.getElementById('search');
        const resultsDiv = document.querySelector('.results');

        searchInput.addEventListener('input', () => {
            const query = searchInput.value != "" ? searchInput.value : "0";
            fetch(`customer/search/${query}`)
                .then(response => response.text())
                .then(data => {
                    resultsDiv.innerHTML = data;
                })
                .catch(error => console.error('Error:', error));
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
