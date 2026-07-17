@extends('layout.layout')

@section('title', 'Coupon')
@section('disactive', 'active')
@section('disaddactive', 'active')
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
                        <h3 class="mb-0 page-head fs-4">Add Coupon</h3>
                    </div>
                    <div class="col-sm-4 d-flex align-items-center justify-content-center">
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.discount') }}">Coupon</a></li>
                            <li class="breadcrumb-item active page-head" aria-current="page">Add Coupon</li>
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

            <!-- =========== Add Coupon Section ============== -->
            <section class="bg-white add-section" style="margin:0 10px;">
                <div class="container h-100  border-2 border-top border-primary rounded">
                    {{-- <h5 class="text-secondary my-2">Add Coupon</h5>
                    <hr class="my-1"> --}}
                    <form action="{{ route('discount.store') }}" method="post">
                        @csrf
                        <div class="row h-100">
                            <div class="col-xl-10">
                                <div class="card-body">
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Name<span class="text-danger ps-1">*</span></h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control fs-7 coupon-name text-uppercase"
                                                name="name" placeholder="Coupon Name.." value="{{ old('name') }}"
                                                required />
                                        </div>
                                    </div>
                                    <div class="row py-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Valid From<span class="text-danger ps-1">*</span></h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="date" class="form-control fs-7 valid-from" name="valid-from"
                                                value="{{ old('valid-from') }}" />
                                        </div>
                                    </div>
                                    <div class="row py-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Valid Till</h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="date" class="form-control fs-7" name="valid-till"
                                                value="{{ old('valid-till') }}" />
                                            @error('valid-till')
                                                <div class="err text-danger fs-7 mb-n3">Enter Valid Date</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Type<span class="text-danger ps-1">*</span></h6>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-control form-select fs-7"
                                                aria-label="Default select example" name="type">
                                                <option selected value="1">Percentage</option>
                                                <option value="2">Flat</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Amount<span class="text-danger ps-1">*</span></h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control fs-7" name="amount"
                                                placeholder="Enter Amount ..." value="{{ old('amount') }}" />
                                        </div>
                                    </div>

                                    <div class="row py-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Status</h6>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-control form-select fs-7"
                                                aria-label="Default select example" name="status">
                                                <option selected value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row py-2">
                                        <div class="col-md-3">
                                        </div>
                                        <div class="col-md-9 justify-content-center d-flex gap-2">
                                            <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                                class="btn btn-primary btn-md" name="add-discount">Add Coupon</button>
                                            <button type="reset" data-mdb-button-init data-mdb-ripple-init
                                                class="btn btn-warning btn-md" name="reset">Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>

            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
@endsection

@section('script')

    <script>
        let validFrom = document.querySelector(".valid-from");
        const date = new Date();
        validFrom.value = date.toISOString().slice(0, 10);

        // let addBtn = document.querySelector(".add-btn");
        // let pageSection = document.querySelector(".page-section");
        // let addSection = document.querySelector(".add-section");

        // addBtn.addEventListener("click", () => {
        //     pageSection.style.display = "none";
        //     addSection.style.display = "block";
        // });

        // const searchInput = document.getElementById('search');
        // const resultsDiv = document.querySelector('.results');

        // searchInput.addEventListener('input', () => {
        //     const query = searchInput.value != "" ? searchInput.value : '0';
        //     fetch(`discount/search/${query}`)
        //         .then(response => response.text())
        //         .then(data => {
        //             resultsDiv.innerHTML = data;
        //         })
        //         .catch(error => console.error('Error:', error));
        // });

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
