@extends('layout.layout')

@section('title', 'Product')
@section('pactive', 'active')
@section('addpactive', 'active')
@section('smpactive', 'active')
@section('pmenuopen', 'menu-open')
@section('addpmenuopen', 'menu-open')

@section('css')
    <style>
        /* .imginput::-webkit-file-upload-button {
                        visibility: hidden;
                    }

                    .imginput::before {
                        content: 'Choose Image Above 800 x 800 px';
                        display: inline-block;
                        background: #eeeeeee0;
                        padding: 0.45rem;
                        margin-right: -4rem;
                    } */

        .form-check-input:checked {
            background-color: #495057 !important;
            border-color: #495057 !important;
        }

        input:active {
            outline: none !important;
        }

        .gimage {
            /* position: relative; */
            border: 1px solid;
            border-radius: 6px;
            padding: 3px;

            & img {
                height: 80px;
                filter: drop-shadow(0 0 1px #000000d3);
            }
        }

        /* .fa-xmark {
                        color: #862828;
                        position: absolute;
                        top: 0;
                        right: 0;
                        cursor: pointer;
                        backdrop-filter: blur(10px);
                    } */
        .img-remove-icon {
            position: absolute;
            right: 0;
            top: 0;
            border-left: 1px solid;
            border-bottom: 1px solid;
            border-top-right-radius: 5px;
            transition: all 0.3s ease;
            cursor: pointer;
            padding: 2px;
        }
    </style>
@endsection

@section('content')
    <?php
    $subcatresult = DB::table('sub_category')->where('category_id', $item->category_id)->where('is_delete', '0')->orderBy('id', 'ASC')->get();
    $oldImg = $item->gallery_image;
    $features = $item->features ? implode(' | ', $item->features) : '';
    ?>
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header py-2">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-4 align-items-center d-flex">
                        <h3 class="mb-0 page-head fs-4">Edit Simple Product</h3>
                    </div>
                    <div class="col-sm-4 d-flex align-items-center justify-content-center">
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.product') }}">Product</a></li>
                            <li class="breadcrumb-item active page-head" aria-current="page">Edit Simple Product</li>
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

            <!-- =========== Edit Product Section ============== -->

            <section class="bg-body h-100 add-section" style="margin:0 10px;">
                <div class="container h-100  border-2 border-top border-primary rounded">
                    {{-- <h5 class="text-secondary my-2">Edit Product</h5>
                    <hr class="my-1"> --}}
                    <form action="{{ route('product.simpleupdate', $item->id) }}" method="post"
                        onsubmit="return validate()" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row h-100 py-3">
                            <div class="col-xl-10 mx-auto">
                                <div class="card-body">
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">SKU<span class="text-danger ps-1">*</span></h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control fs-7" name="sku"
                                                placeholder="Enter SKU ..." value="{{ $item->sku }}" required />
                                        </div>
                                    </div>
                                    <div class="row py-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Category<span class="text-danger ps-1">*</span>
                                            </h6>
                                        </div>
                                        <div class="col-md-9">
                                            <select name="cat_id" class="form-control form-select fs-7 cat" required>
                                                <option selected disabled value="">-- SELECT CATEGORY --</option>
                                                <?php
                                                $result = DB::table('category')->orderBy('id', 'ASC')->get();
                                                ?>
                                                @foreach ($result as $catrow)
                                                    <option {{ $item->category_id == $catrow->id ? 'selected' : '' }}
                                                        value="{{ $catrow->id }}">{{ $catrow->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row py-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Sub Category<span
                                                    class="text-danger ps-1">*</span>
                                            </h6>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-control form-select fs-7 sub-cat"
                                                aria-label="Default select example" name="sub_cat_id" required>
                                                <option selected value="0">-- SELECT SUB CATEGORY --
                                                </option>
                                                @foreach ($subcatresult as $subcat)
                                                    <option {{ $item->sub_category_id == $subcat->id ? 'selected' : '' }}
                                                        value="{{ $subcat->id }}">
                                                        {{ $subcat->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Name<span class="text-danger ps-1">*</span></h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control fs-7 p-name" name="name"
                                                placeholder="Enter Name ..." value="{{ $item->name }}" required />
                                        </div>
                                    </div>
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Slug<span class="text-danger ps-1">*</span></h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control fs-7 p-slug" name="slug"
                                                placeholder="Enter Slug.." value="{{ $item->slug }}" required />
                                        </div>
                                    </div>

                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Description</h6>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control fs-7" rows="3" name="description" placeholder="Description ..." value="">{{ $item->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Features</h6>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control fs-7" rows="3" name="features" placeholder="Use | to separate features"
                                                value="">{{ $features }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Price<span class="text-danger ps-1">*</span>
                                            </h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control fs-7 price" name="price"
                                                placeholder="Enter Price.." value="{{ $item->price }}" required />
                                            <div class="price-error text-danger fs-7 mt-1"></div>
                                        </div>
                                    </div>
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Sale Price</h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control fs-7 sale-price" name="sale_price"
                                                placeholder="Enter Sale Price.." value="{{ $item->sale_price }}" />
                                            <div class="sale-price-error text-danger fs-7 mt-1"></div>
                                        </div>
                                    </div>
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Featured Image<span
                                                    class="text-danger ps-1">*</span></h6>
                                        </div>
                                        <div class="col-md-9 position-relative">
                                            <img src="{{ asset('uploads/prd_lg_') . $item->featured_image }}"
                                                class="img-fluid rounded mb-2" alt="" id="p-image"
                                                style="height: 90px;filter:drop-shadow(0 0 2px #000000d3);" />
                                            <div class="input-group mb-3">
                                                <input class="form-control fs-7 p-imginput imginput" type="file"
                                                    id="formFile" name="p-img" accept="image/*">
                                            </div>
                                            <div class="text-info fs-8 mt-n3">*** Choose new image above (800 x 800 px) if
                                                want to change ***</div>
                                            <div class="img-error text-danger fs-7 mt-1"></div>
                                        </div>
                                    </div>

                                    <div class="row py-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Stock<span class="text-danger ps-1">*</span>
                                            </h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control fs-7" name="stock"
                                                placeholder="0" value="{{ $item->stock }}" min="0" />
                                        </div>
                                    </div>
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Gallery Image</h6>
                                        </div>
                                        <div class="col-md-9 position-relative">
                                            <div class="gimg-box-old d-flex gap-2 flex-wrap mb-2"></div>
                                            <div class="gimg-box d-flex gap-2 flex-wrap mb-2"></div>
                                            <div class="input-group mb-3">
                                                <input class="form-control fs-7 g-imginput imginput" type="file"
                                                    id="formFile" name="g-img[]" accept="image/*" multiple>
                                            </div>
                                            <input type="text" hidden name="old_glr" id="oldInput" value="">
                                            <div class="text-info fs-8 mt-n3">*** You can select multiple images from here
                                                for product gallery ***</div>
                                            <div class="gimg-error text-danger fs-7 mt-1"></div>
                                        </div>
                                    </div>
                                    <div class="row pb-2">
                                        <div class="col-md-3">
                                        </div>
                                        {{-- <div class="col-md-3 fs-7">
                                            <input class="form-check-input outline-0" type="checkbox" value="special"
                                                id="checkDefault" name="special"
                                                {{ $item->special == 'special' ? 'checked' : '' }}>
                                            <label class="form-check-label ps-1 text-body" for="checkDefault">
                                                Add to Special Product
                                            </label>
                                        </div> --}}
                                        <div class="col-md-3 fs-7">
                                            <input class="form-check-input" type="checkbox" value="1"
                                                id="checkChecked" name="feature"
                                                {{ $item->is_feature == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label ps-1 text-body" for="checkChecked">
                                                Add to Featured Product
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row py-2">
                                        <div class="col-md-3">
                                        </div>
                                        <div class="col-md-9 justify-content-center d-flex gap-2">
                                            <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                                class="btn btn-primary btn-md" name="edit-product">Update</button>
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
        let ProductImage = document.querySelector("#p-image");
        let galleryImages = document.querySelectorAll(".gimg-box img");

        let pimageInput = document.querySelector(".p-imginput");
        let gimageInput = document.querySelector(".g-imginput");
        let imageError = document.querySelector(".img-error");
        let gimageError = document.querySelector(".gimg-error");

        let catSelect = document.querySelector(".cat");
        let subcatSelect = document.querySelector(".sub-cat");
        let imgBox = document.querySelector(".gimg-box");
        let imgBoxOld = document.querySelector(".gimg-box-old");
        let oldInput = document.querySelector("#oldInput");

        catSelect.addEventListener("change", (e) => {
            let dataUrl = "{{ route('product.subcat', ['name' => 'PLACEHOLDER']) }}";
            const finalUrl = dataUrl.replace('PLACEHOLDER', encodeURIComponent(catSelect.value));
            fetch(finalUrl)
                .then(response => response.text())
                .then(data => {
                    subcatSelect.innerHTML = data;
                })
                .catch(error => console.error('Error:', error));
        });

        pimageInput.addEventListener("change", (e) => {
            ProductImage.removeAttribute("hidden");
            let file = e.target.files[0];
            if (!file.type.startsWith("image")) {
                imageError.innerHTML = "Please select Image File";
                return;
            } else {
                let reader = new FileReader();
                reader.onload = (e) => {
                    ProductImage.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        let dt = new DataTransfer();
        gimageInput.addEventListener("change", (e) => {
            imgBox.style.display = "block";
            imgBox.innerHTML = "";
            let file = e.target.files;

            for (let i = 0; i < file['length']; i++) {
                if (!file[i].type.startsWith("image")) {
                    gimageError.innerHTML = "Please select Image File";
                    return;
                }
                dt.items.add(file[i]);
            }

            for (let i = 0; i < dt.files['length']; i++) {
                let reader = new FileReader();
                reader.onload = (e) => {
                    let gimg = document.createElement("div");
                    gimg.classList.add("gimage");
                    gimg.innerHTML = `<div class="position-relative">
                                        <img src="${e.target.result}" class="img-fluid rounded" alt="" />
                                        <i class="fa-solid fa-xmark img-remove-icon bg-body" onclick="removeImage(${i})"></i>
                                    </div>`;
                    imgBox.appendChild(gimg);
                };
                reader.readAsDataURL(dt.files[i]);
            }

            e.target.files = dt.files;
        });


        function removeImage(ind) {
            imgBox.innerHTML = "";
            dt.items.remove(ind);
            for (let i = 0; i < dt.files['length']; i++) {
                let reader = new FileReader();
                reader.onload = (e) => {
                    let gimg = document.createElement("div");
                    gimg.classList.add("gimage");
                    gimg.innerHTML = `<div class="position-relative">
                                        <img src="${e.target.result}" class="img-fluid rounded" alt="" />
                                        <i class="fa-solid fa-xmark img-remove-icon bg-body" onclick="removeImage(${i})"></i>
                                    </div>`;
                    imgBox.appendChild(gimg);
                };
                reader.readAsDataURL(dt.files[i]);
            }
            gimageInput.files = dt.files;
        }

        @if ($oldImg != null)
            let oldImg = @json($oldImg);
            for (let i = 0; i < oldImg.length; i++) {
                let gimg = document.createElement("div");
                gimg.classList.add("gimage");
                gimg.innerHTML = `<div class="position-relative">
                                    <img src="{{ asset('uploads/glr_lg_') }}${oldImg[i]}" class="img-fluid rounded" alt="" />
                                    <i class="fa-solid fa-xmark img-remove-icon bg-body" onclick="removeoldImage(${i})"></i>
                            </div>`;
                imgBoxOld.appendChild(gimg);
            }
            oldInput.value = oldImg;
        @endif

        function removeoldImage(i) {
            imgBoxOld.innerHTML = "";
            oldImg.splice(i, 1);
            for (let i = 0; i < oldImg.length; i++) {
                let gimg = document.createElement("div");
                gimg.classList.add("gimage");
                gimg.innerHTML = `<div class="position-relative">
                                    <img src="{{ asset('uploads/glr_lg_') }}${oldImg[i]}" class="img-fluid rounded" alt="" />
                                    <i class="fa-solid fa-xmark img-remove-icon bg-body" onclick="removeoldImage(${i})"></i>
                            </div>`;
                imgBoxOld.appendChild(gimg);
            }
            oldInput.value = oldImg;
        }

        let price = document.querySelector(".price");
        let priceMessage = document.querySelector(".price-error");
        let val = price.value;
        price.addEventListener("input", () => {
            if (isNaN(price.value)) {
                price.value = val;
                priceMessage.innerHTML = "Please enter Valid Price";
            } else {
                val = price.value;
            }
        });

        function validate() {
            if (ProductImage.naturalWidth < 600) {
                imageError.innerHTML = "Please Select Image Above 400 x 400 px";
                return false;
            }
            galleryImages.forEach(val => {
                if (val.naturalWidth < 600) {
                    gimageError.innerHTML = "Please Select Image Above 400 x 400 px";
                    return false;
                }
            });

            price.value = Number(price.value).toFixed(2);
            return true;
        }

        function generateSlug(text) {
            return text
                .toString()
                .toLowerCase()
                .trim()
                .replace(/\s+/g, '-') // Replace spaces with -
                .replace(/[^\w\-]+/g, '') // Remove all non-word chars
                .replace(/\-\-+/g, '-'); // Replace multiple - with single -
        }

        let pNameInput = document.querySelector(".p-name");
        let slugInput = document.querySelector(".p-slug");

        pNameInput.addEventListener("input", () => {
            slugInput.value = generateSlug(pNameInput.value);
        });
    </script>
@endsection
