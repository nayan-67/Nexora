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
                            <li class="breadcrumb-item"><a href="{{ route('admin.user') }}">Customer</a></li>
                            <li class="breadcrumb-item active page-head" aria-current="page">Edit Customer</li>
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

            <!-- =========== Edit Customer Section ============== -->
            @error('e-mail')
                {{ toast($message, 'error') }}
            @enderror
            @error('phone')
                {{ toast($message, 'error') }}
            @enderror
            <section class="bg-body h-100 add-section" style="margin:0 10px;">
                <div class="container h-100  border-2 border-top border-primary rounded">
                    <h6 class="text-secondary my-2">Edit Customer</h6>
                    <hr class="my-1">
                    <form action="{{ route('user.update', $item->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row h-100">
                            <div class="col-xl-12 px-4">
                                <div class="card-body">
                                    <h4 class="text-secondary-emphasis my-2">Personal Details</h4>
                                    <hr class="my-1">
                                    <div class="row pt-1 pb-1">
                                        <div class="col-md-6">
                                            <h6 class="mb-2 fs-7 fw-bold">First Name</h6>
                                            <input type="text" class="form-control fs-7" name="f-name" placeholder=""
                                                value="{{ $item->first_name }}" />
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="mb-2 fs-7 fw-bold">Last Name</h6>
                                            <input type="text" class="form-control fs-7" name="l-name" placeholder=""
                                                value="{{ $item->last_name }}" />
                                        </div>
                                    </div>
                                    <div class="row pt-1 pb-1">
                                        <div class="col-md-6">
                                            <h6 class="mb-2 fs-7 fw-bold">E-mail</h6>
                                            <input type="text" class="form-control fs-7" name="e-mail" placeholder=""
                                                value="{{ $item->email }}" />
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="mb-2 fs-7 fw-bold">Phone</h6>
                                            <input type="text" class="form-control fs-7" name="phone" placeholder=""
                                                value="{{ $item->phone }}" />
                                        </div>
                                    </div>
                                    <div class="row pt-1 pb-1">
                                        <div class="col-md-6">
                                            <h6 class="mb-2 fs-7 fw-bold">Fax</h6>
                                            <input type="text" class="form-control fs-7" name="fax" placeholder=""
                                                value="{{ $item->fax }}" />
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="mb-2 fs-7 fw-bold">Status</h6>
                                            <select class="form-control form-select fs-7"
                                                aria-label="Default select example" name="status">
                                                <option {{ $item->status == '1' ? 'selected' : '' }} value="1">
                                                    Active</option>
                                                <option {{ $item->status == '0' ? 'selected' : '' }}
                                                    value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    @foreach ($billingresult as $key => $add)
                                        <h4 class="text-secondary-emphasis my-2 mt-3">Address <?php echo ++$key; ?></h4>
                                        <hr class="my-1 mb-2">
                                        <div class="row pt-1 pb-2">
                                            <div class="col-md-6">
                                                <h6 class="mb-2 fs-7 fw-bold">Address Line 1</h6>
                                                <textarea class="form-control fs-7" rows="2" name="address1[]">{{ $add->address1 }}</textarea>
                                            </div>
                                            <div class="col-md-6 position-relative">
                                                <h6 class="mb-2 fs-7 fw-bold">Address Line 2</h6>
                                                <textarea class="form-control fs-7" rows="2" name="address2[]">{{ $add->address2 }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row pt-1 pb-2">
                                            <div class="col-md-6">
                                                <h6 class="mb-2 fs-7 fw-bold">Company</h6>
                                                <input class="form-control fs-7" type="text" id=""
                                                    name="company[]" value="{{ $add->company }}">
                                            </div>
                                            <div class="col-md-6 position-relative">
                                                <h6 class="mb-2 fs-7 fw-bold">city</h6>
                                                <input class="form-control fs-7" type="text" id=""
                                                    name="city[]" value="{{ $add->city }}">
                                            </div>
                                        </div>
                                        <div class="row pt-1 pb-2">
                                            <div class="col-md-6">
                                                <h6 class="mb-2 fs-7 fw-bold">Post Code</h6>
                                                <input class="form-control fs-7" type="text" id=""
                                                    name="pin[]" value="{{ $add->postcode }}">
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="mb-2 fs-7 fw-bold">Country</h6>
                                                <input class="form-control fs-7" type="text" id=""
                                                    name="country[]" value="{{ $add->country }}">
                                            </div>
                                        </div>
                                        <div class="row pt-1 pb-2">
                                            <div class="col-md-6">
                                                <h6 class="mb-2 fs-7 fw-bold">Region</h6>
                                                <input class="form-control fs-7" type="text" id=""
                                                    name="state[]" value="{{ $add->state }}">
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="row py-2">
                                        <div class="col-md-12 justify-content-center d-flex gap-2">
                                            <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                                class="btn btn-primary btn-md" name="edit-customer">Update</button>
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
