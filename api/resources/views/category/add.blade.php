@extends('layout.layout')

@section('title', 'Category')
@section('cactive', 'active')
@section('acatactive', 'active')
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
                        <h3 class="mb-0 page-head fs-4">Add Category</h3>
                    </div>
                    <div class="col-sm-4 d-flex align-items-center justify-content-center">
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.category') }}">Category</a></li>
                            <li class="breadcrumb-item active page-head" aria-current="page">Add Category</li>
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

            <!-- =========== Add Category Section ============== -->
            @error('cat-img')
                {{ toast($message, 'error') }}
            @enderror

            <section class="bg-body h-100 add-section" style="margin:0 10px;">
                <div class="container h-100  border-2 border-top border-primary rounded">
                    {{-- <h5 class="text-secondary my-2">Add Category</h5>
                    <hr class="my-1"> --}}
                    <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row h-100">
                            <div class="col-xl-10">
                                <div class="card-body">
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Name<span class="text-danger ps-1">*</span></h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control fs-7 cat-name" name="cat-name"
                                                placeholder="Enter Name.." value="{{ old('cat-name') }}" required />
                                        </div>
                                    </div>
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Slug<span class="text-danger ps-1">*</span></h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control fs-7 slug" name="slug"
                                                placeholder="Enter Slug.." value="{{ old('cat-name') }}" required />
                                        </div>
                                    </div>
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Description<span class="text-danger ps-1">*</span>
                                            </h6>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control fs-7" name="cat-desc" placeholder="Enter Description.." required>{{ old('cat-desc') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Order</h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control fs-7" name="order"
                                                placeholder="Enter Order Number" value="{{ old('order') ?? '0' }}" />
                                        </div>
                                    </div>
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Image<span class="text-danger ps-1">*</span>
                                            </h6>
                                        </div>
                                        <div class="col-md-9 position-relative">
                                            <img src="" class="img-fluid rounded mb-2" alt="" hidden
                                                id="image"
                                                style="height: 100px;filter:drop-shadow(0 0 10px #000000d3);" />
                                            <div class="input-group mb-3">
                                                <input class="form-control fs-7 imginput" type="file" id="formFile"
                                                    accept="image/*" name="cat-img" required>
                                            </div>
                                            <div class="img-error text-danger fs-7 mt-1"></div>
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
                                                class="btn btn-primary btn-md" name="add-category">Add Category</button>
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
        let image = document.querySelector("#image");
        let imageInput = document.querySelector(".imginput");
        let imageError = document.querySelector(".img-error");

        imageInput.addEventListener("change", (e) => {
            image.removeAttribute("hidden");
            let file = e.target.files[0];
            if (!file.type.startsWith("image")) {
                imageError.innerHTML = "Please select Image File";
                return;
            } else {

                let reader = new FileReader();
                reader.onload = (e) => {
                    image.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        function generateSlug(text) {
            return text
                .toString()
                .toLowerCase()
                .trim()
                .replace(/\s+/g, '-') // Replace spaces with -
                .replace(/[^\w\-]+/g, '') // Remove all non-word chars
                .replace(/\-\-+/g, '-'); // Replace multiple - with single -
        }

        let catNameInput = document.querySelector(".cat-name");
        let slugInput = document.querySelector(".slug");

        catNameInput.addEventListener("input", () => {
            slugInput.value = generateSlug(catNameInput.value);
        });
    </script>
@endsection
