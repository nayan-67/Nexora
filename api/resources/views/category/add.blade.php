@extends('layout.layout')

@section('title', 'Category')
@section('cactive', 'active')
@section('acatactive', 'active')
@section('catmenuopen', 'menu-open')

@section('css')
    <style>
        .add-section {
            padding: 0.25rem 0;
        }

        .add-category-shell {
            position: relative;
            overflow: hidden;
            border-radius: 1.3rem;
            background-color: var(--bs-body-bg);
            border: 1px solid var(--bs-border-color-translucent);
            box-shadow: 0 24px 55px rgba(13, 110, 253, 0.14);
            animation: floatGlow 6s ease-in-out infinite;
        }

        [data-bs-theme="dark"] .add-category-shell {
            box-shadow: 0 24px 55px rgba(0, 0, 0, 0.35);
        }

        .add-category-shell::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top left, rgba(var(--bs-primary-rgb), 0.16), transparent 36%),
                radial-gradient(circle at bottom right, rgba(var(--bs-danger-rgb), 0.12), transparent 34%);
            pointer-events: none;
        }

        .add-category-hero {
            position: relative;
            padding: 1.25rem 1.5rem;
            color: #fff;
            background: linear-gradient(120deg, var(--bs-primary) 0%, #4f82ff 45%, #7c4dff 100%);
        }

        .add-category-hero .form-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.45rem 0.8rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.16);
            color: #fff;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            backdrop-filter: blur(6px);
        }

        .form-panel {
            position: relative;
            padding: 1.3rem 1.15rem 1rem;
        }

        .custom-input,
        .custom-select,
        textarea[name='cat-desc'] {
            border: 1px solid var(--bs-border-color);
            border-radius: 0.95rem;
            background-color: var(--bs-body-bg);
            color: var(--bs-body-color);
            padding: 0.8rem 0.95rem;
            transition: all 0.2s ease;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.02);
        }

        .custom-input:focus,
        .custom-select:focus,
        textarea[name='cat-desc']:focus {
            border-color: var(--bs-primary);
            box-shadow: 0 0 0 0.2rem rgba(var(--bs-primary-rgb), 0.16);
            transform: translateY(-1px);
        }

        .upload-card {
            border: 1px dashed var(--bs-primary-border-subtle);
            border-radius: 1rem;
            padding: 1rem;
            background-color: var(--bs-secondary-bg);
        }

        .preview-frame {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 180px;
            border-radius: 1rem;
            background: linear-gradient(135deg, var(--bs-tertiary-bg), var(--bs-secondary-bg));
            border: 1px solid var(--bs-border-color);
            overflow: hidden;
            padding: 0.65rem;
            position: relative;
        }

        .preview-frame::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            border: 1px solid rgba(255, 255, 255, 0.25);
            pointer-events: none;
        }

        .preview-frame img {
            display: block;
            width: 100%;
            height: 168px;
            object-fit: contain;
            object-position: center;
            border-radius: 0.8rem;
            background-color: var(--bs-body-bg);
            box-shadow: 0 10px 26px rgba(0, 0, 0, 0.16);
        }

        .preview-frame .preview-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
            color: var(--bs-secondary-color);
            font-size: 0.9rem;
            text-align: center;
            padding: 0.75rem;
        }

        .action-btn {
            border-radius: 999px;
            padding: 0.7rem 1.15rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(13, 110, 253, 0.18);
        }

        @keyframes floatGlow {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-2px);
            }
        }
    </style>
@endsection

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
                <div class="container h-100">
                    <div class="add-category-shell rounded-4 shadow-sm border-0">
                        <div class="add-category-hero">
                            <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                                <div>
                                    <div class="form-pill">
                                        <i class="fa-solid fa-layer-group"></i>
                                        Creative category setup
                                    </div>
                                    <h4 class="mt-2 mb-1 fw-bold">Add a new category with a bold look</h4>
                                    <p class="mb-0 opacity-75">Give your product groups a polished, high-energy entrance.
                                    </p>
                                </div>
                                <div class="badge rounded-pill bg-light text-primary px-3 py-2 fw-semibold">Fresh & ready
                                </div>
                            </div>
                        </div>

                        <div class="form-panel">
                            <form action="{{ route('category.store') }}" method="POST" onsubmit="return validate()"
                                enctype="multipart/form-data" novalidate>
                                @csrf
                                <div class="row h-100 py-3">
                                    <div class="col-xl-10 mx-auto">
                                        <div class="card-body p-0">
                                            <div class="row pt-3 pb-2 align-items-center">
                                                <div class="col-md-3">
                                                    <h6 class="mb-0 fs-7 fw-bold">Name<span
                                                            class="text-danger ps-1">*</span></h6>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control fs-7 cat-name custom-input"
                                                        name="cat-name" placeholder="Enter Name.."
                                                        value="{{ old('cat-name') }}" required />
                                                    <div class="name-error text-danger fs-7 mt-1"></div>
                                                </div>
                                            </div>
                                            <div class="row pt-3 pb-2 align-items-center">
                                                <div class="col-md-3">
                                                    <h6 class="mb-0 fs-7 fw-bold">Slug<span
                                                            class="text-danger ps-1">*</span></h6>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control fs-7 slug custom-input"
                                                        name="slug" placeholder="Enter Slug.."
                                                        value="{{ old('slug') }}" required />
                                                    <div class="slug-error text-danger fs-7 mt-1"></div>
                                                </div>
                                            </div>
                                            <div class="row pt-3 pb-2 align-items-center">
                                                <div class="col-md-3">
                                                    <h6 class="mb-0 fs-7 fw-bold">Description<span
                                                            class="text-danger ps-1">*</span>
                                                    </h6>
                                                </div>
                                                <div class="col-md-9">
                                                    <textarea class="form-control fs-7 custom-input" name="cat-desc" placeholder="Enter Description.." required>{{ old('cat-desc') }}</textarea>
                                                    <div class="desc-error text-danger fs-7 mt-1"></div>
                                                </div>
                                            </div>
                                            <div class="row pt-3 pb-2 align-items-center">
                                                <div class="col-md-3">
                                                    <h6 class="mb-0 fs-7 fw-bold">Image<span
                                                            class="text-danger ps-1">*</span>
                                                    </h6>
                                                </div>
                                                <div class="col-md-9 position-relative">
                                                    <div class="upload-card">
                                                        <div class="preview-frame mb-3">
                                                            <img src="" class="img-fluid" alt="" hidden
                                                                id="image" />
                                                            <div class="preview-placeholder text-body-secondary small"
                                                                id="image-placeholder">
                                                                <i class="fa-solid fa-image fa-lg"></i>
                                                                <span>Preview will appear here</span>
                                                            </div>
                                                        </div>
                                                        <div class="input-group">
                                                            <input class="form-control fs-7 imginput" type="file"
                                                                id="formFile" accept="image/*" name="cat-img" required>
                                                        </div>
                                                        <div class="text-info fs-8 mt-2">*** Please choose image above
                                                            (800px * 800px)
                                                            dimension ***</div>
                                                        <div class="img-error text-danger fs-7 mt-1"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row py-3 align-items-center">
                                                <div class="col-md-3">
                                                    <h6 class="mb-0 fs-7 fw-bold">Status</h6>
                                                </div>
                                                <div class="col-md-9">
                                                    <select class="form-control form-select fs-7 custom-select"
                                                        aria-label="Default select example" name="status">
                                                        <option selected value="1">Active</option>
                                                        <option value="0">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row py-3">
                                                <div class="col-md-3">
                                                </div>
                                                <div class="col-md-9 justify-content-center d-flex gap-2 flex-wrap">
                                                    <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                                        class="btn btn-primary btn-md action-btn" name="add-category"
                                                        id="add_category">Add
                                                        Category</button>
                                                    <button type="reset" data-mdb-button-init data-mdb-ripple-init
                                                        class="btn btn-warning btn-md action-btn"
                                                        name="reset">Reset</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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
        let imagePlaceholder = document.querySelector("#image-placeholder");
        let categoryForm = document.querySelector("form[action='{{ route('category.store') }}']");

        let imageValid = false;

        function clearImagePreview() {
            image.setAttribute('hidden', '');
            image.src = '';
            if (imagePlaceholder) {
                imagePlaceholder.classList.remove('d-none');
            }
        }

        function showImagePreview() {
            if (imagePlaceholder) {
                imagePlaceholder.classList.add('d-none');
            }
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
                    showImagePreview();
                    imageValid = true;
                };
                previewImage.src = event.target.result;
            };
            reader.readAsDataURL(file);
        }

        imageInput.addEventListener("change", (e) => {
            validateImageFile(e.target.files[0]);
        });

        if (categoryForm) {
            categoryForm.addEventListener('reset', () => {
                imageValid = false;
                clearImagePreview();
                clearAllFieldErrors();
                clearAllFieldValidation();
            });
        }

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
