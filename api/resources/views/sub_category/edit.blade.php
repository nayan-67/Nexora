@extends('layout.layout')

@section('title', 'Sub Category')
@section('scactive', 'active')

@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header py-2">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-4 align-items-center d-flex">
                        <h3 class="mb-0 page-head fs-4">Sub Category</h3>
                    </div>
                    <div class="col-sm-4 d-flex align-items-center justify-content-center">
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.subcategory') }}">Sub Category</a></li>
                            <li class="breadcrumb-item active page-head" aria-current="page">Edit Sub Category</li>
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

            <!-- =========== Edit Sub Category Section ============== -->
            <section class="bg-white add-section" style="margin:0 10px;">
                <div class="container h-100  border-2 border-top border-primary rounded">
                    <h5 class="text-secondary my-2">Edit Sub Category</h5>
                    <hr class="my-1">
                    <form action="{{ route('subcategory.update', $data->id) }}" method="post">
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
                                            <input type="text" class="form-control fs-7 sub_cat" name="name"
                                                placeholder="Enter Name.." value="{{ $data->name }}" required />
                                        </div>
                                    </div>
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Slug<span class="text-danger ps-1">*</span></h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control fs-7 slug" name="slug"
                                                placeholder="Enter Slug.." value="{{ $data->slug }}" required />
                                        </div>
                                    </div>
                                    <div class="row py-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Parent Category<span
                                                    class="text-danger ps-1">*</span>
                                            </h6>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-control form-select fs-7"
                                                aria-label="Default select example" name="cat_id" required>
                                                <?php
                                                $result = DB::table('category')->orderBy('id', 'ASC')->get();
                                                ?>
                                                @foreach ($result as $catrow)
                                                    <option {{ $data->category_id == $catrow->id ? 'selected' : '' }}
                                                        value="{{ $catrow->id }}">
                                                        {{ $catrow->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Order Number</h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control fs-7" name="order_number"
                                                placeholder="Enter Order Number" value="{{ $data->order_number }}" />
                                        </div>
                                    </div>

                                    <div class="row py-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Status</h6>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-control form-select fs-7"
                                                aria-label="Default select example" name="status">
                                                <option {{ $data->status == '1' ? 'selected' : '' }} value="1">
                                                    ACTIVE</option>
                                                <option {{ $data->status == '0' ? 'selected' : '' }} value="0">INACTIVE
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row py-2">
                                        <div class="col-md-3">
                                        </div>
                                        <div class="col-md-9 justify-content-center d-flex gap-2">
                                            <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                                class="btn btn-primary btn-md" name="edit-subcat">Update</button>
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
        function generateSlug(text) {
            return text
                .toString()
                .toLowerCase()
                .trim()
                .replace(/\s+/g, '-') // Replace spaces with -
                .replace(/[^\w\-]+/g, '') // Remove all non-word chars
                .replace(/\-\-+/g, '-'); // Replace multiple - with single -
        }

        let subCatInput = document.querySelector(".sub_cat");
        let slugInput = document.querySelector(".slug");

        subCatInput.addEventListener("input", () => {
            slugInput.value = generateSlug(subCatInput.value);
        });
    </script>
@endsection
