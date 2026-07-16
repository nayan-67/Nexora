@extends('layout.layout')

@section('title', 'Add Variant Product')
@section('pactive', 'active')
@section('addpactive', 'active')
@section('varactive', 'active')
@section('pmenuopen', 'menu-open')
@section('addpmenuopen', 'menu-open')

@section('css')
    <style>
        .imginput::-webkit-file-upload-button {
            visibility: hidden;
        }

        .imginput::before {
            content: 'Choose Image Above 800 x 800 px';
            display: inline-block;
            background: #eeeeeee0;
            padding: 0.45rem;
            margin-right: -4rem;
        }

        .form-check-input:checked {
            background-color: #495057 !important;
            border-color: #495057 !important;
        }

        input:active {
            outline: none !important;
        }

        .gallery-remove-btn {
            align-items: center;
            background: rgba(255, 255, 255, 0.88);
            border: 1px solid #862828;
            border-radius: 50%;
            color: #862828;
            cursor: pointer;
            display: flex;
            font-size: 14px;
            font-weight: 700;
            height: 22px;
            justify-content: center;
            line-height: 1;
            position: absolute;
            right: -7px;
            top: -7px;
            width: 22px;
            backdrop-filter: blur(10px);
        }

        .img-remove-icon {
            position: absolute;
            right: 1px;
            top: 1px;
            background: #fff;
            border-top-right-radius: 5px;
            opacity: 0;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .glr-image:hover .img-remove-icon {
            opacity: 1;
        }

        .attribute-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .variant-table {
            margin-top: 20px;
        }

        .variant-row {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 10px;
            border-left: 4px solid #0d6efd;
        }

        .btn-remove-variant {
            appearance: none;
            background: #ffffff;
            color: #dc3545;
            cursor: pointer;
            padding: 0;
            font-weight: 900;
            position: absolute;
            top: -11px;
            right: -10px;
            border: 1.5px solid blueviolet;
            border-radius: 50%;
            width: 25px;
            height: 25px;
        }

        .color-picker-row {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .color-input {
            width: 50px;
            height: 50px;
            border-radius: 100%;
            border: 2px solid #ddd;
            cursor: pointer;
            background-color: transparent;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        .color-input::-webkit-color-swatch {
            border-radius: 100%;
            border: none;
        }

        .color-input::-moz-color-swatch {
            border-radius: 100%;
            border: none;
        }

        .variant-preview-img {
            height: 80px;
            width: 80px;
            object-fit: cover;
            filter: drop-shadow(0 0 2px #000000d3);
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
                        <h3 class="mb-0 page-head fs-4">Add Product</h3>
                    </div>
                    <div class="col-sm-4 d-flex align-items-center justify-content-center">
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.product') }}">Products</a></li>
                            <li class="breadcrumb-item active page-head" aria-current="page">Add Variant Product</li>
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
            <section class="bg-white add-section" style="margin:0 10px;">
                <div class="container h-100 border-2 border-top border-primary rounded">
                    <h5 class="text-secondary my-2">Add Variable Product</h5>
                    <hr class="my-1">
                    <form action="{{ route('variant-product.store') }}" method="post"
                        onsubmit="return handleFormSubmit(event)" enctype="multipart/form-data" id="variant-product-form">
                        @csrf
                        @method('POST')

                        <div class="row h-100">
                            <div class="col-xl-10 mx-auto">
                                <div class="card-body">
                                    <!-- Basic Product Info -->
                                    <h6 class="text-info mb-3 mt-3">Basic Product Information</h6>

                                    <div class="row py-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Category<span class="text-danger ps-1">*</span>
                                            </h6>
                                        </div>
                                        <div class="col-md-9">
                                            <select name="cat_id" class="form-control form-select fs-7 cat" required>
                                                <option selected disabled value="">-- SELECT CATEGORY --</option>
                                                <?php
                                                $result = DB::table('category')->where('status', 1)->orderBy('id', 'ASC')->get();
                                                ?>
                                                @foreach ($result as $catrow)
                                                    <option value="{{ $catrow->id }}">{{ $catrow->name }}</option>
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
                                                <option selected disabled value="">-- SELECT SUB CATEGORY --
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Name<span class="text-danger ps-1">*</span></h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control fs-7 p-name" name="name"
                                                placeholder="Enter Product Name.." value="" required />
                                        </div>
                                    </div>
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Slug<span class="text-danger ps-1">*</span></h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control fs-7 p-slug" name="slug"
                                                placeholder="Enter Product Slug.." value="" required />
                                        </div>
                                    </div>
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Description</h6>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control fs-7" rows="3" name="description" placeholder="Enter Description..." value=""></textarea>
                                        </div>
                                    </div>
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Features</h6>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control fs-7" rows="3" name="features" placeholder="Use | to separate features"
                                                value=""></textarea>
                                        </div>
                                    </div>

                                    <div class="row pb-2">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3 fs-7">
                                            <input class="form-check-input" type="checkbox" value="1" id="checkChecked"
                                                name="feature">
                                            <label class="form-check-label ps-1 text-body" for="checkChecked">
                                                Add to Featured Product
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Variant Attributes Section -->
                                    <hr class="my-3">
                                    <h6 class="text-info mb-3 mt-3">Product Variants Setup</h6>

                                    <div class="attribute-section">
                                        <h6 class="mb-3">Add Attributes<span class="text-danger ps-1">*</span></h6>
                                        <div class="row attribute-item mb-3">
                                            <div class="col-md-3">
                                                <input type="text" class="form-control fs-7 attr-name"
                                                    placeholder="e.g., Color" />
                                            </div>
                                            <div class="col-md-7">
                                                <div class="d-flex gap-2">
                                                    <input type="text" class="form-control fs-7 attr-value-input"
                                                        placeholder="e.g., Red, Blue, Green (comma separated)" />
                                                    <button type="button" class="btn btn-sm btn-primary add-attr-btn">
                                                        Add
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-secondary d-none"
                                                        id="cancel-attr-edit">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-2 d-flex align-items-center">
                                                <small class="text-muted fs-8">Pick color or use name</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Added Attributes Display -->
                                    <div id="added-attributes" class="mb-4">
                                        <!-- Attributes will be displayed here -->
                                    </div>

                                    <!-- Variants Table -->
                                    <hr class="my-3">
                                    <h6 class="text-info mb-3">Product Variants</h6>
                                    <div class="variant-table">
                                        <div id="variants-container">
                                            <p class="text-muted fs-7">Add attributes and click "Generate Variants" to
                                                create variant combinations</p>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-info btn-sm mb-3" id="generate-variants-btn">
                                        Generate Variants
                                    </button>

                                    <!-- Hidden input for variants data -->
                                    <input type="hidden" name="variants-data" id="variants-data-input"
                                        value="[]" />
                                    <!-- Hidden input for attributes metadata (type info) -->
                                    <input type="hidden" name="attributes-metadata" id="attributes-metadata-input"
                                        value="[]" />

                                    <div class="row py-2">
                                        {{-- <div class="col-md-3"></div> --}}
                                        <div class="col-md-12 justify-content-center d-flex gap-2">
                                            <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                                class="btn btn-primary btn-md" name="add-product">Add Product</button>
                                            <a href="{{ route('admin.product') }}" class="btn btn-warning btn-md">Back</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </main>
@endsection

@section('script')
    <script>
        const appURL = <?= json_encode(url('/')) ?>;

        let productName = '';
        let attributes = [];
        let variants = [];
        let editingAttributeIndex = null;

        // Category change handler
        const catSelect = document.querySelector(".cat");
        const subcatSelect = document.querySelector(".sub-cat");
        const variantsContainer = document.getElementById('variants-container');
        const addedAttributesContainer = document.getElementById('added-attributes');

        if (variantsContainer) {
            variantsContainer.addEventListener('click', (e) => {
                const removeBtn = e.target.closest('[data-remove-variant]');
                if (!removeBtn) return;

                e.preventDefault();
                removeVariant(Number(removeBtn.dataset.removeVariant));
            });
        }

        if (addedAttributesContainer) {
            addedAttributesContainer.addEventListener('click', (e) => {
                const removeBtn = e.target.closest('[data-remove-attribute]');
                const editBtn = e.target.closest('[data-edit-attribute]');

                if (editBtn) {
                    e.preventDefault();
                    editAttribute(Number(editBtn.dataset.editAttribute));
                    return;
                }

                if (!removeBtn) return;

                e.preventDefault();
                removeAttribute(Number(removeBtn.dataset.removeAttribute));
            });
        }
        catSelect.addEventListener("change", (e) => {
            let query = catSelect.value;
            fetch(`${appURL}/product/subcat/${query}`)
                .then(response => response.text())
                .then(data => {
                    subcatSelect.innerHTML = data;
                })
                .catch(error => console.error('Error:', error));
        });
        subcatSelect.addEventListener("change", (e) => {
            productName = subcatSelect.options[subcatSelect.selectedIndex].text;
        });
        const attrNameInput = document.querySelector('.attr-name');
        const attrValueInput = document.querySelector('.attr-value-input');
        const addAttrBtn = document.querySelector('.add-attr-btn');
        const cancelAttrEditBtn = document.getElementById('cancel-attr-edit');

        addAttrBtn.addEventListener('click', (e) => {
            e.preventDefault();
            saveAttributeFromForm();
        });

        cancelAttrEditBtn.addEventListener('click', (e) => {
            e.preventDefault();
            clearAttributeForm();
        });

        function getAttributeType(name) {
            return name.trim().toLowerCase() === 'color' ? 'color_picker' : 'radio';
        }

        function saveAttributeFromForm() {
            const name = attrNameInput.value.trim();
            const values = attrValueInput.value.trim();

            if (!name || !values) {
                swalToast('error', 'Please enter attribute name and values');
                return;
            }

            const valueArray = values.split(',').map(v => v.trim()).filter(Boolean);
            if (valueArray.length === 0) {
                swalToast('error', 'Please enter at least one attribute value');
                return;
            }

            const attrType = getAttributeType(name);

            // For color attributes, store both color name and code from color pickers or defaults
            let processedValues = valueArray;
            if (attrType === 'color_picker') {
                processedValues = valueArray.map((colorName, i) => {
                    // If editing, try to use stored color codes, otherwise use default
                    const storedCode = editingAttributeIndex !== null && window.currentColorCodes && window
                        .currentColorCodes[i];
                    return {
                        name: colorName,
                        code: storedCode || getColorValue(colorName)
                    };
                });
            }

            const attr = {
                name,
                values: processedValues,
                type: attrType
            };

            const existingIndex = editingAttributeIndex !== null ?
                editingAttributeIndex :
                attributes.findIndex(a => a.name.toLowerCase() === name.toLowerCase());

            if (existingIndex >= 0) {
                attributes[existingIndex] = attr;
            } else {
                attributes.push(attr);
            }

            clearAttributeForm();
            window.currentColorCodes = {};
            renderAttributes();
        }

        function clearAttributeForm() {
            editingAttributeIndex = null;
            attrNameInput.value = '';
            attrValueInput.value = '';
            addAttrBtn.textContent = 'Add';
            cancelAttrEditBtn.classList.add('d-none');
            attrNameInput.focus();
        }

        function renderAttributes() {
            const container = document.getElementById('added-attributes');
            container.innerHTML = '';

            attributes.forEach((attr, idx) => {
                const attrDiv = document.createElement('div');
                attrDiv.className = 'attribute-section';
                let valuesHTML = '';

                if (attr.type === 'color_picker') {
                    valuesHTML = `<div class="color-picker-row">
                        ${attr.values.map((v, i) => {
                            const colorName = typeof v === 'object' ? v.name : v;
                            const colorCode = typeof v === 'object' ? v.code : getColorValue(v);
                            return `
                                            <div>
                                                <input type="color" class="color-input" value="${colorCode}" 
                                                    data-attr="${idx}" data-val="${i}" />
                                                <small>${colorName}</small>
                                            </div>
                                        `;
                        }).join('')}
                    </div>`;
                    // Add event listeners to color pickers after rendering
                    setTimeout(() => {
                        const colorInputs = container.querySelectorAll(`input[data-attr="${idx}"]`);
                        colorInputs.forEach(input => {
                            input.addEventListener('change', (e) => {
                                const attrIdx = Number(e.target.dataset.attr);
                                const valIdx = Number(e.target.dataset.val);
                                if (attributes[attrIdx] && attributes[attrIdx].values[
                                        valIdx]) {
                                    if (typeof attributes[attrIdx].values[valIdx] ===
                                        'object') {
                                        attributes[attrIdx].values[valIdx].code = e.target
                                            .value;
                                    } else {
                                        attributes[attrIdx].values[valIdx] = {
                                            name: attributes[attrIdx].values[valIdx],
                                            code: e.target.value
                                        };
                                    }
                                }
                            });
                        });
                    }, 0);
                } else {
                    valuesHTML = `<div>${attr.values.join(', ')}</div>`;
                }

                attrDiv.innerHTML = `
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-2"><strong>${attr.name}</strong> (${attr.type === 'color_picker' ? 'Color Picker' : 'Radio'})</h6>
                            ${valuesHTML}
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-outline-primary" data-edit-attribute="${idx}">
                                Edit
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" data-remove-attribute="${idx}">
                                Remove
                            </button>
                        </div>
                    </div>
                `;
                container.appendChild(attrDiv);
            });
        }

        function editAttribute(idx) {
            const attr = attributes[idx];
            if (!attr) return;

            editingAttributeIndex = idx;
            attrNameInput.value = attr.name;

            // For color attributes, extract just the names; for others, use values as-is
            if (attr.type === 'color_picker') {
                attrValueInput.value = attr.values.map(v => typeof v === 'object' ? v.name : v).join(', ');

                // Store current color codes for restoration if needed
                window.currentColorCodes = {};
                attr.values.forEach((v, i) => {
                    window.currentColorCodes[i] = typeof v === 'object' ? v.code : getColorValue(v);
                });
            } else {
                attrValueInput.value = attr.values.join(', ');
            }

            addAttrBtn.textContent = 'Update';
            cancelAttrEditBtn.classList.remove('d-none');
            attrNameInput.focus();
        }

        function removeAttribute(idx) {
            const wasEditing = editingAttributeIndex === idx;
            attributes.splice(idx, 1);
            renderAttributes();
            variants = [];
            document.getElementById('variants-container').innerHTML =
                '<p class="text-muted fs-7">Add attributes and click "Generate Variants" to create variant combinations</p>';

            if (wasEditing) {
                clearAttributeForm();
            } else if (editingAttributeIndex !== null && idx < editingAttributeIndex) {
                editingAttributeIndex -= 1;
            }
        }

        function getColorValue(colorName) {
            const colorMap = {
                'red': '#FF0000',
                'blue': '#0000FF',
                'green': '#008000',
                'black': '#000000',
                'white': '#FFFFFF',
                'yellow': '#FFFF00',
                'orange': '#FFA500',
                'purple': '#800080',
                'pink': '#FFC0CB',
                'brown': '#8B4513',
                'gray': '#808080',
                'navy': '#1e3a5f',
                'silver': '#c0c0c0',
                'gold': '#FFD700'
            };
            return colorMap[colorName.toLowerCase()] || '#000000';
        }

        // Generate Variants
        document.getElementById('generate-variants-btn').addEventListener('click', (e) => {
            e.preventDefault();
            if (productName === '') {
                swalToast('error', 'Please fill basic product information first');
                return;
            }
            if (attributes.length === 0) {
                swalToast('error', 'Please add at least one attribute');
                return;
            }

            variants = generateVariantCombinations(attributes);
            renderVariants();
        });

        function generateVariantCombinations(attrs) {
            const combinations = [];

            function generate(index, current) {
                if (index === attrs.length) {
                    combinations.push({
                        attributes: [...current],
                        sku: generateSku(productName || 'PROD'),
                        price: '',
                        stock: '',
                        is_sale: false,
                        sale_price: '',
                        is_active: true,
                        featured_image: null,
                        gallery_images: []
                    });
                    return;
                }

                attrs[index].values.forEach(value => {
                    current.push({
                        name: attrs[index].name,
                        value: value
                    });
                    generate(index + 1, current);
                    current.pop();
                });
            }

            generate(0, []);
            return combinations;
        }

        function generateSku(productName) {
            const prefix = productName
                .replace(/[^a-zA-Z]/g, '')
                .substring(0, 3)
                .toUpperCase();

            const suffix = Math.random().toString(36).substring(2, 6).toUpperCase();

            return `NX-${prefix}-${suffix}`;
        }

        function renderVariants() {
            const container = document.getElementById('variants-container');
            if (variants.length === 0) return;

            container.innerHTML = '';
            variants.forEach((variant, idx) => {
                const attrString = variant.attributes.map(a => {
                    const displayValue = typeof a.value === 'object' ? a.value.name : a.value;
                    return `${a.name}: ${displayValue}`;
                }).join(', ');
                const sku = variant.sku || generateSku(productName || 'PROD');

                const variantDiv = document.createElement('div');
                variantDiv.className = 'variant-row position-relative';
                variantDiv.innerHTML = `
                    <button type="button" class="btn-remove-variant" data-remove-variant="${idx}">✕</button>
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="mb-2"><strong>${attrString}</strong></h6>
                            <small class="text-muted">SKU: ${sku}</small>
                        </div>

                        <select class="form-control w-auto form-select fs-7 is-active"
                                            aria-label="Default select example" name="is_active[]" required>
                            <option value=1 ${variant.is_active?'selected':''}>Active</option>
                            <option value=0 ${!variant.is_active?'selected':''}>Inactive</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="fs-7">SKU</label>
                            <input type="text" class="form-control fs-7 variant-sku" value="${sku}" />
                        </div>
                        <div class="col-md-4">
                            <label class="fs-7">Price<span class="text-danger ps-1">*</span></label>
                            <input type="number" class="form-control fs-7 variant-price" step="0.01" placeholder="0.00" value="${variant.price}" required />
                            <div class="form-check mt-2">
                                <input class="form-check-input variant-is-sale" type="checkbox" id="variant-sale-${idx}" ${variant.is_sale ? 'checked' : ''} />
                                <label class="form-check-label fs-7" for="variant-sale-${idx}">Is Sale</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="fs-7">Stock<span class="text-danger ps-1">*</span></label>
                            <input type="number" class="form-control fs-7 variant-stock" placeholder="0" value="${variant.stock}" required />
                        </div>
                    </div>
                    <div class="row mt-3 variant-sale-price-row" ${variant.is_sale ? '' : 'hidden'}>
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <label class="fs-7">Sale Price</label>
                            <input type="number" class="form-control fs-7 variant-sale-price" step="0.01" placeholder="0.00" value="${variant.sale_price || ''}" />
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <div class="">
                                <label class="fs-7">Featured Image<span class="text-danger ps-1">*</span></label>
                                <input type="file" class="form-control fs-7 variant-featured-image" name="variant_featured_images[${idx}]" accept="image/*" data-variant-idx="${idx}" />
                                <small class="text-info fs-8">*** Choose image above 800 x 800 px ***</small>
                            </div>
                            <div class="">
                                <div class="variant-image-preview d-flex gap-2 flex-wrap mt-2" id="featured-preview-${idx}"></div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="">
                                <label class="fs-7">Gallery Images</label>
                                <input type="file" class="form-control fs-7 variant-gallery-images" name="variant_gallery_images[${idx}][]" accept="image/*" data-variant-idx="${idx}" multiple />
                                <small class="text-info fs-8">*** You can select multiple images for this variant gallery ***</small>
                            </div>
                            <div class="">
                                <div class="variant-gallery-preview d-flex gap-2 flex-wrap mt-1" id="gallery-preview-${idx}"></div>
                            </div>
                        </div>
                    </div>
                `;
                container.appendChild(variantDiv);

                // Add image preview listeners
                const imageInput = variantDiv.querySelector('.variant-featured-image');
                imageInput.addEventListener('change', handleVariantImageChange);
                const galleryInput = variantDiv.querySelector('.variant-gallery-images');
                galleryInput.addEventListener('change', handleVariantGalleryChange);
                const saleCheckbox = variantDiv.querySelector('.variant-is-sale');
                saleCheckbox.addEventListener('change', () => toggleVariantSalePrice(variantDiv));

                const skuInput = variantDiv.querySelector('.variant-sku');
                const priceInput = variantDiv.querySelector('.variant-price');
                const stockInput = variantDiv.querySelector('.variant-stock');
                const salePriceInput = variantDiv.querySelector('.variant-sale-price');

                skuInput.addEventListener('input', () => {
                    variants[idx].sku = skuInput.value;
                });
                priceInput.addEventListener('input', () => {
                    variants[idx].price = priceInput.value;
                });
                stockInput.addEventListener('input', () => {
                    variants[idx].stock = stockInput.value;
                });
                salePriceInput.addEventListener('input', () => {
                    variants[idx].sale_price = salePriceInput.value;
                });

                restoreVariantFiles(idx);
            });

            document.getElementById('generate-variants-btn').textContent = 'Regenerate Variants';
        }

        function toggleVariantSalePrice(variantDiv) {
            const saleCheckbox = variantDiv.querySelector('.variant-is-sale');
            const saleRow = variantDiv.querySelector('.variant-sale-price-row');
            const salePriceInput = variantDiv.querySelector('.variant-sale-price');

            saleRow.hidden = !saleCheckbox.checked;
            salePriceInput.required = saleCheckbox.checked;

            if (!saleCheckbox.checked) {
                salePriceInput.value = '';
            }
        }

        function handleVariantImageChange(e) {
            const input = e.target;
            const idx = Number(input.dataset.variantIdx);
            const file = e.target.files[0];
            if (!file) return;

            if (!file.type.startsWith('image')) {
                swalToast('error', 'Please select an image file');
                return;
            }

            variants[idx].featured_image = file;

            const reader = new FileReader();
            reader.onload = (event) => {
                const preview = document.getElementById(`featured-preview-${idx}`);
                preview.innerHTML = `
                    <img src="${event.target.result}" class="img-fluid rounded variant-preview-img" alt="Variant preview" />
                `;
            };
            reader.readAsDataURL(file);
        }

        function handleVariantGalleryChange(e) {
            const input = e.target;
            const idx = Number(input.dataset.variantIdx);
            const files = Array.from(e.target.files || []);
            if (files.some(file => !file.type.startsWith('image'))) {
                swalToast('error', 'Please select image files only');
                e.target.value = '';
                renderVariantGalleryPreview(idx);
                return;
            }

            variants[idx].gallery_images = files;
            renderVariantGalleryPreview(idx);
        }

        function renderVariantGalleryPreview(idx) {
            const preview = document.getElementById(`gallery-preview-${idx}`);
            const input = document.querySelector(`.variant-gallery-images[data-variant-idx="${idx}"]`);
            const files = (variants[idx] && variants[idx].gallery_images) ? variants[idx].gallery_images : [];
            const dt = new DataTransfer();

            preview.innerHTML = '';

            files.forEach((file, fileIndex) => {
                if (!file.type.startsWith('image')) {
                    return;
                }

                dt.items.add(file);

                const reader = new FileReader();
                reader.onload = (event) => {
                    const item = document.createElement('div');
                    item.className = 'text-center';
                    item.innerHTML = `
                        <div class="glr-image position-relative">
                            <img src="${event.target.result}" class="img-fluid rounded variant-preview-img" alt="Variant gallery preview" />
                            <i class="fa-solid fa-xmark img-remove-icon" onclick="removeVariantGalleryImage(${idx}, ${fileIndex})"></i>
                        </div>
                    `;
                    preview.appendChild(item);
                };
                reader.readAsDataURL(file);
            });

            if (input) {
                input.files = dt.files;
            }
        }

        function removeVariantGalleryImage(idx, fileIndex) {
            const files = (variants[idx] && variants[idx].gallery_images) ? variants[idx].gallery_images : [];
            files.splice(fileIndex, 1);
            variants[idx].gallery_images = files;
            renderVariantGalleryPreview(idx);
        }

        function restoreVariantFiles(idx) {
            const variant = variants[idx];
            if (!variant) return;

            const featuredInput = document.querySelector(`.variant-featured-image[data-variant-idx="${idx}"]`);
            if (featuredInput && variant.featured_image) {
                const dt = new DataTransfer();
                dt.items.add(variant.featured_image);
                featuredInput.files = dt.files;

                const reader = new FileReader();
                reader.onload = (event) => {
                    const preview = document.getElementById(`featured-preview-${idx}`);
                    preview.innerHTML = `
                        <img src="${event.target.result}" class="img-fluid rounded variant-preview-img" alt="Variant preview" />
                    `;
                };
                reader.readAsDataURL(variant.featured_image);
            }

            renderVariantGalleryPreview(idx);
        }

        function handleFormSubmit(event) {
            // event.preventDefault();

            if (!validate()) {
                return false;
            }

            // const form = document.getElementById('variant-product-form');
            // const formData = new FormData(form);

            // Submit form using fetch
            // fetch(form.action, {
            //         method: 'POST',
            //         body: formData
            //     })
            //     .then(response => {
            //         if (response.ok) {
            //             window.location.href = '{{ route('admin.product') }}';
            //         } else {
            //             return response.text().then(text => {
            //                 throw new Error(text);
            //             });
            //         }
            //     })
            //     .catch(error => {
            //         console.error('Error:', error);
            //         swalToast('error', 'An error occurred while saving the product');
            //     });

            return true;
        }

        function removeVariant(idx) {
            variants.splice(idx, 1);
            renderVariants();
        }

        function validate() {

            if (attributes.length === 0) {
                swalToast('error', 'Please add at least one attribute');
                return false;
            }

            if (variants.length === 0) {
                swalToast('error', 'Please generate variants');
                return false;
            }

            // Collect variant data
            const variantsData = [];
            const formData = new FormData();

            document.querySelectorAll('.variant-row').forEach((row, idx) => {
                const sku = row.querySelector('.variant-sku').value;
                const price = parseFloat(row.querySelector('.variant-price').value);
                const stock = parseInt(row.querySelector('.variant-stock').value);
                const isSale = row.querySelector('.variant-is-sale').checked;
                const salePriceInput = row.querySelector('.variant-sale-price');
                const salePrice = isSale ? parseFloat(salePriceInput.value) : null;

                if (!sku || isNaN(price) || isNaN(stock)) {
                    swalToast('error', `Please fill all fields for variant ${idx + 1}`);
                    throw new Error('Invalid variant data');
                }

                if (isSale && (isNaN(salePrice) || salePrice <= 0 || salePrice >= price)) {
                    swalToast('error',
                        `Please enter a valid sale price less than regular price for variant ${idx + 1}`);
                    salePriceInput.focus();
                    throw new Error('Invalid sale price');
                }

                variantsData.push({
                    attributes: variants[idx].attributes,
                    sku: sku,
                    price: price,
                    stock: stock,
                    is_sale: isSale,
                    sale_price: salePrice,
                    is_default: row.querySelector('.is-active').value,
                    imageIndex: idx
                });
            });

            document.getElementById('variants-data-input').value = JSON.stringify(variantsData);

            // Store attribute metadata (type information)
            const attributesMetadata = attributes.map(attr => ({
                name: attr.name,
                type: attr.type
            }));
            document.getElementById('attributes-metadata-input').value = JSON.stringify(attributesMetadata);

            // Store formData in window for later use in form submission
            window.variantImagesFormData = formData;

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

        let productNameInput = document.querySelector(".p-name");
        let slugInput = document.querySelector(".p-slug");

        productNameInput.addEventListener("input", () => {
            slugInput.value = generateSlug(productNameInput.value);
        });
    </script>
@endsection
