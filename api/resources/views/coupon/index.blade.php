@extends('layout.layout')

@section('title', 'Discount')
@section('disactive', 'active')
@section('dislactive', 'active')
@section('dismenuopen', 'menu-open')

@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header py-2">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-4 align-items-center d-flex">
                        <h3 class="mb-0 page-head fs-4">Discount</h3>
                    </div>
                    <div class="col-sm-4 d-flex align-items-center justify-content-center">
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active page-head" aria-current="page">Discount</li>
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
                            <h5 class="p-0 m-0 fw-bold">DELETE DISCOUNT</h5>
                            <p class="p-0 m-0">This action cannot be undone.</p>
                        </div>
                    </div>
                    <hr class="m-0 text-secondery opacity-10">
                    <div class="row modal-btn d-flex align-items-center justify-content-space-between px-4 py-3">
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-outline-secondary btn-md w-100 shadow-sm del-close"
                                name="">CANCEL</button>
                        </div>
                        <form action="{{ route('discount.destroy') }}" method="POST" class=" col-sm-6 m-content">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" id="modal-id" value="" name="id">
                            <input type="submit" class="btn btn-danger btn-md w-100 shadow-sm" value="DELETE">
                        </form>
                    </div>

                </div>
            </div>

            <!-- ====== Discount Section ======= -->

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
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="d-flex flex-wrap justify-content-md-end gap-2">
                                            <div class="input-group input-group-sm w-auto">
                                                <span class="input-group-text">
                                                    <i class="bi bi-search" aria-hidden="true"></i>
                                                </span>
                                                <input type="search" id="user-search" class="form-control"
                                                    placeholder="Search coupon" aria-label="Search coupon"
                                                    style="width: 180px" />
                                            </div>
                                            <a href="{{ route('discount.add') }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-plus-circle me-1" aria-hidden="true"></i>
                                                New Coupon
                                            </a>
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
                                                <th>Coupon</th>
                                                <th>Valid From</th>
                                                <th>Valid Till</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Created</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="fs-7">
                                            @if (count($data) > 0)
                                                @foreach ($data as $row)
                                                    @php
                                                        $date = substr($row->created_at, 0, 10);
                                                    @endphp
                                                    <tr align="center">
                                                        <td>{{ $row->name }}</td>
                                                        <td>{{ date('M j, Y', strtotime($row->valid_from)) }}</td>
                                                        <td>{{ $row->valid_till ? date('M j, Y', strtotime($row->valid_till)) : 'Not Set' }}
                                                        </td>
                                                        <td>{{ $row->type == '1' ? $row->amount . ' %' : '$ ' . $row->amount }}
                                                        </td>
                                                        <td>
                                                            <span
                                                                class='list-badge {{ $row->status == '1' ? 'text-bg-success' : 'text-bg-warning' }}'>{{ $row->status == '1' ? 'Active' : 'Inactive' }}</span>
                                                        </td>
                                                        <td>{{ date('M j, Y', strtotime($date)) }}</td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                <a href="{{ route('discount.edit', encrypt($row->id)) }}"
                                                                    class="btn btn-outline-info" data-bs-toggle="tooltip"
                                                                    data-bs-title="Edit">
                                                                    <i class="bi bi-pencil d-flex" aria-hidden="true"> </i>
                                                                </a>
                                                                <button type="button" class="btn btn-outline-danger"
                                                                    data-bs-toggle="tooltip" data-bs-title="Delete"
                                                                    onclick="openModal('{{ $row->id }}');">
                                                                    <i class="bi bi-trash d-flex" aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr align="center">
                                                    <td colspan="7">No Coupon Found</td>
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
                                    Showing 1 to 9 of 42 Coupon
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
        // let addBtn = document.querySelector(".add-btn");
        // let pageSection = document.querySelector(".page-section");
        // let addSection = document.querySelector(".add-section");

        // addBtn.addEventListener("click", () => {
        //     pageSection.style.display = "none";
        //     addSection.style.display = "block";
        // });

        const searchInput = document.getElementById('search');
        const resultsDiv = document.querySelector('.results');

        searchInput.addEventListener('input', () => {
            const query = searchInput.value != "" ? searchInput.value : '0';
            fetch(`discount/search/${query}`)
                .then(response => response.text())
                .then(data => {
                    resultsDiv.innerHTML = data;
                })
                .catch(error => console.error('Error:', error));
        });

        // const sBtn = document.querySelectorAll(".s-btn");

        // sBtn.forEach(btn => {
        //     btn.style.background = "#198754";
        //     btn.style.color = "#fff";
        //     btn.addEventListener("click", () => {
        //         searchInput.value = "";
        //         sBtn.forEach(button => {
        //             button.style.background = "#198754";
        //         });
        //         const btnVal = btn.value != "" ? btn.value : '0';
        //         fetch(`discount/search/${btnVal}`)
        //             .then(response => response.text())
        //             .then(data => {
        //                 resultsDiv.innerHTML = data;
        //             })
        //             .catch(error => console.error('Error:', error));

        //         btn.style.background = "#196d54";
        //     });
        // });
    </script>
@endsection
