@extends('layout.layout')

@section('title', 'Discount')
@section('disactive', 'active')

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
                            <li class="breadcrumb-item"><a href="{{ route('admin.discount') }}">Discount</a></li>
                            <li class="breadcrumb-item active page-head" aria-current="page">Edit Discount</li>
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

            <!-- =========== Edit Discount Section ============== -->

            <section class="bg-white add-section" style="margin:0 10px;">
                <div class="container h-100  border-2 border-top border-primary rounded">
                    <h5 class="text-secondary my-2">Edit Discount</h5>
                    <hr class="my-1">
                    <form action="{{route('discount.update',$item->id)}}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row h-100">
                            <div class="col-xl-10">
                                <div class="card-body">
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Name<span class="text-danger ps-1">*</span></h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control fs-7" name="name"
                                                placeholder="Enter Name.." value="{{$item->name}}" required />
                                        </div>
                                    </div>
                                    <div class="row py-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Valid From</h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="date" class="form-control fs-7 valid-from" name="valid-from"
                                                value="{{$item->valid_from}}" />
                                        </div>
                                    </div>
                                    <div class="row py-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Valid Till</h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="date" class="form-control fs-7" name="valid-till"
                                                value="{{$item->valid_till}}" />
                                        </div>
                                    </div>
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Type<span class="text-danger">*</span></h6>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-control form-select fs-7"
                                                aria-label="Default select example" name="type">
                                                <option value="1" {{$item->type == '1' ? 'selected' : ''}}>PERCENTAGE</option>
                                                <option value="2" {{$item->type == '2' ? 'selected' : ''}}>FLAT</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Amount<span class="text-danger">*</span></h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control fs-7" name="amount"
                                                placeholder="Enter Amount ..." value="{{$item->amount}}" required />
                                        </div>
                                    </div>

                                    <div class="row py-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Status</h6>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-control form-select fs-7"
                                                aria-label="Default select example" name="status">
                                                <option {{$item->status == '1' ? 'selected' : ''}} value="1">Active</option>
                                                <option {{$item->status == '0' ? 'selected' : ''}} value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row py-2">
                                        <div class="col-md-3">
                                        </div>
                                        <div class="col-md-9 justify-content-center d-flex gap-2">
                                            <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                                class="btn btn-primary btn-md" name="edit-discount">Update</button>
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
