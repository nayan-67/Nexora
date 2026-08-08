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
                    <form action="{{ route('category.store') }}" method="POST" onsubmit="return validate()"
                        enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row h-100 py-3">
                            <div class="col-xl-10 mx-auto">
                                <div class="card-body">
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Name<span class="text-danger ps-1">*</span></h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control fs-7 cat-name" name="cat-name"
                                                placeholder="Enter Name.." value="{{ old('cat-name') }}" required />
                                            <div class="name-error text-danger fs-7 mt-1"></div>
                                        </div>
                                    </div>
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Slug<span class="text-danger ps-1">*</span></h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control fs-7 slug" name="slug"
                                                placeholder="Enter Slug.." value="{{ old('slug') }}" required />
                                            <div class="slug-error text-danger fs-7 mt-1"></div>
                                        </div>
                                    </div>
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Description<span class="text-danger ps-1">*</span>
                                            </h6>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control fs-7" name="cat-desc" placeholder="Enter Description.." required>{{ old('cat-desc') }}</textarea>
                                            <div class="desc-error text-danger fs-7 mt-1"></div>
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
                                            <div class="text-info fs-8 mt-n3">*** Please choose image above (800px * 800px)
                                                dimension ***</div>
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
                                                class="btn btn-primary btn-md" name="add-category" id="add_category">Add
                                                Category</button>
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
        let nameError = document.querySelector(".name-error");
        let slugError = document.querySelector(".slug-error");
        let descError = document.querySelector(".desc-error");
        let catNameInput = document.querySelector(".cat-name");
        let slugInput = document.querySelector(".slug");
        let descInput = document.querySelector("textarea[name='cat-desc']");
        let addBtn = document.querySelector("#add_category");
        let loader = document.querySelector("#loader");

        let imageValid = false;

        function clearImagePreview() {
            image.setAttribute('hidden', '');
            image.src = '';
        }

        function clearFieldError(field) {
            field.textContent = '';
        }

        function clearAllFieldErrors() {
            [nameError, slugError, descError, imageError].forEach(field => {
                clearFieldError(field);
            });
        }

        function setInvalidField(field) {
            field.style.borderColor = '#dc3545';
            // field.style.boxShadow = '0 0 0 .2rem rgba(220,53,69,.25)';
        }

        function clearFieldValidation(field) {
            field.style.borderColor = '';
            // field.style.boxShadow = '';
        }

        function clearAllFieldValidation() {
            [catNameInput, slugInput, descInput, imageInput].forEach(field => {
                clearFieldValidation(field);
            });
        }

        function setImageError(message) {
            imageError.innerHTML = message;
            imageValid = false;
        }

        function validateImageFile(file) {
            imageValid = false;
            imageError.innerHTML = '';

            if (!file) {
                setImageError('Please select an image file.');
                clearImagePreview();
                return;
            }

            if (!file.type.startsWith("image")) {
                setImageError('Please select a valid image file.');
                clearImagePreview();
                return;
            }

            let reader = new FileReader();
            reader.onload = (event) => {
                let previewImage = new Image();
                previewImage.onload = () => {
                    if (previewImage.width < 800 || previewImage.height < 800) {
                        setImageError('Please select an image at least 800 x 800 px.');
                        clearImagePreview();
                        return;
                    }
                    image.src = event.target.result;
                    image.removeAttribute('hidden');
                    imageValid = true;
                };
                previewImage.src = event.target.result;
            };
            reader.readAsDataURL(file);
        }

        imageInput.addEventListener("change", (e) => {
            validateImageFile(e.target.files[0]);
        });

        function generateSlug(text) {
            return text
                .toString()
                .toLowerCase()
                .trim()
                .replace(/\s+/g, '-')
                .replace(/[^\w\-]+/g, '')
                .replace(/\-\-+/g, '-');
        }

        catNameInput.addEventListener("input", () => {
            slugInput.value = generateSlug(catNameInput.value);
        });

        function validate() {
            let catNameValue = catNameInput.value.trim();
            let slugValue = slugInput.value.trim();
            let descValue = descInput.value.trim();
            let imageFile = imageInput.files[0];

            clearAllFieldErrors();
            clearAllFieldValidation();
            imageError.innerHTML = '';

            if (catNameValue === '') {
                nameError.textContent = 'Please enter a category name.';
                setInvalidField(catNameInput);
                return false;
            }
            if (slugValue === '') {
                slugError.textContent = 'Please enter a slug for the category.';
                setInvalidField(slugInput);
                return false;
            }
            if (descValue === '') {
                descError.textContent = 'Please enter a description.';
                setInvalidField(descInput);
                return false;
            }
            if (!imageFile) {
                imageError.textContent = 'Please select an image for the category.';
                setInvalidField(imageInput);
                return false;
            }
            if (!imageValid) {
                imageError.textContent = 'Please select a valid image that is at least 800 x 800 px.';
                setInvalidField(imageInput);
                return false;
            }

            return true;
        }

        addBtn.addEventListener("click", () => {
            if (validate() && loader) {
                loader.classList.replace("d-none", "d-flex");
            }
        });
    </script>
@endsection
