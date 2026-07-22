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
            right: 0;
            top: 0;
            border-left: 1px solid;
            border-bottom: 1px solid;
            border-top-right-radius: 5px;
            transition: all 0.3s ease;
            cursor: pointer;
            padding: 2px;
        }

        /* .glr-image:hover .img-remove-icon {
                opacity: 1;
            } */

        .glr-image {
            border: 1px solid;
            padding: 3px;
            border-radius: 6px;
        }

        .attribute-section {
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
            margin-bottom: 20px;
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
            width: 45px;
            height: 43px;
            border-radius: 100%;
            border: 1px solid transparent;
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

        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 2px solid #0d6efd;
        }

        .btn-success:hover {
            background-color: #198754;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection

@section('content')
    @php
        $features = $item->features ? implode(' | ', $item->features) : '';
    @endphp
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header py-2">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-4 align-items-center d-flex">
                        <h3 class="mb-0 page-head fs-4">Edit Variant Product</h3>
                    </div>
                    <div class="col-sm-4 d-flex align-items-center justify-content-center">
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.product') }}">Products</a></li>
                            <li class="breadcrumb-item active page-head" aria-current="page">Edit Variant Product</li>
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
            <section class="bg-body add-section" style="margin:0 10px;">
                <div class="container h-100 border-2 border-top border-primary rounded">
                    {{-- <h5 class="text-secondary my-2">Edit Variable Product</h5>
                    <hr class="my-1"> --}}
                    <form action="{{ route('product.variableupdate', $item->id) }}" method="post"
                        onsubmit="return handleFormSubmit(event)" enctype="multipart/form-data" id="variant-product-form">
                        @csrf
                        @method('PUT')

                        <div class="row h-100 py-3">
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
                                                $result = DB::table('category')->orderBy('id', 'ASC')->get();
                                                ?>
                                                @foreach ($result as $catrow)
                                                    <option value="{{ $catrow->id }}"
                                                        {{ $item->category_id == $catrow->id ? 'selected' : '' }}>
                                                        {{ $catrow->name }}</option>
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
                                            @php
                                                $subcategories = DB::table('sub_category')
                                                    ->where('category_id', $item->category_id)
                                                    ->orderBy('id', 'ASC')
                                                    ->get();
                                            @endphp
                                            <select class="form-control form-select fs-7 sub-cat"
                                                aria-label="Default select example" name="sub_cat_id" required>
                                                <option selected disabled value="">-- SELECT SUB CATEGORY --
                                                </option>
                                                @foreach ($subcategories as $subcat)
                                                    <option value="{{ $subcat->id }}"
                                                        {{ $item->sub_category_id == $subcat->id ? 'selected' : '' }}>
                                                        {{ $subcat->name }}</option>
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
                                                placeholder="Enter Product Name.." value="{{ $item->name }}" required />
                                        </div>
                                    </div>
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Slug<span class="text-danger ps-1">*</span></h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control fs-7 p-slug" name="slug"
                                                placeholder="Enter Product Slug.." value="{{ $item->slug }}" required />
                                        </div>
                                    </div>

                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Description</h6>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control fs-7" rows="3" name="description" placeholder="Enter Description..." value="">{{ $item->description }}</textarea>
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

                                    <div class="row pb-2">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3 fs-7">
                                            <input class="form-check-input" type="checkbox" value="1" id="checkChecked"
                                                name="feature" {{ $item->is_feature == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label ps-1 text-body" for="checkChecked">
                                                Add to Featured Product
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Variant Attributes Section -->
                                    <hr class="my-3">
                                    <h6 class="text-info mb-3 mt-3">Manage Product Attributes</h6>
                                    <p class="text-muted fs-8">Add new values to existing attributes. After adding values,
                                        you can generate new variants with those values.</p>

                                    @php
                                        $attributes = DB::table('variant_attributes')
                                            ->where('product_id', $item->id)
                                            ->get();
                                    @endphp
                                    <!-- Display Existing Attributes with Add Value Option -->
                                    <div id="added-attributes" class="mb-4">
                                        @foreach ($attributes as $attr)
                                            <div class="attribute-section bg-body-tertiary"
                                                data-attr-index="{{ $loop->index }}"
                                                data-attr-name="{{ $attr->attribute_name }}">
                                                <div class="d-flex justify-content-between align-items-start mb-3">
                                                    <div style="flex: 1;">
                                                        <h6 class="mb-2"><strong>{{ $attr->attribute_name }}</strong>
                                                            ({{ $attr->display_type === 'color_picker' ? 'Color Picker' : 'Radio' }})
                                                        </h6>
                                                        @if ($attr->display_type === 'color_picker')
                                                            <div class="color-picker-row">
                                                                @php
                                                                    $colors = is_array($attr->attribute_values)
                                                                        ? $attr->attribute_values
                                                                        : json_decode($attr->attribute_values, true);
                                                                @endphp
                                                                @foreach ($colors as $color)
                                                                    <div>
                                                                        <input type="color" class="color-input"
                                                                            value="{{ isset($color['code']) ? $color['code'] : '#000000' }}"
                                                                            disabled />
                                                                        <small>{{ isset($color['name']) ? $color['name'] : $color }}</small>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @else
                                                            <div>
                                                                {{ implode(', ', is_array($attr->attribute_values) ? $attr->attribute_values : json_decode($attr->attribute_values, true)) }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="ms-3">
                                                        <button type="button" class="btn btn-success btn-sm"
                                                            data-add-value="{{ $loop->index }}"
                                                            data-attr-type="{{ $attr->display_type }}">+ Add
                                                            Value</button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Variants Table -->
                                    <hr class="my-3">
                                    <h6 class="text-info mb-3">Product Variants</h6>
                                    <div class="variant-table">
                                        <div id="variants-container">
                                            <p class="text-muted fs-7">Existing variants will be shown below. Click "Add
                                                Variant" to add new combinations.</p>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-success btn-sm mb-3" id="add-variant-btn">
                                        + Add Variant
                                    </button>

                                    <!-- Hidden input for variants data -->
                                    <input type="hidden" name="variants-data" id="variants-data-input"
                                        value="[]" />
                                    <!-- Hidden input for existing variants to track changes -->
                                    <input type="hidden" name="existing-variants" id="existing-variants-input"
                                        value="{{ json_encode($item->variants()->get()->toArray()) }}" />

                                    <div class="row py-2">
                                        {{-- <div class="col-md-3"></div> --}}
                                        <div class="col-md-12 justify-content-center d-flex gap-2">
                                            <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                                class="btn btn-primary btn-md" name="add-product">Update Product</button>
                                            <a href="{{ route('admin.product') }}"
                                                class="btn btn-warning btn-md">Back</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>

            <!-- Modal for Adding New Attribute Value -->
            <div class="modal fade" id="addValueModal" tabindex="-1" aria-labelledby="addValueModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addValueModalLabel">Add New Value</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="modal-content"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="save-new-value-btn">Add Value</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for Adding New Variant -->
            <div class="modal fade" id="addVariantModal" tabindex="-1" aria-labelledby="addVariantModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addVariantModalLabel">Select Variant Combination</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="variant-modal-content"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="confirm-add-variant-btn">Add
                                Variant</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script>
        let appURL = <?= json_encode(url('/')) ?>;
        let productId = {{ $item->id }};
        let attributes = [];
        let variants = [];
        let editingAttributeIndex = null;
        let newAttributeValues = {}; // Track newly added values
        let editingAttrIdx = null; // Track which attribute we're adding value to
        let variantGalleryDT = {};
        // Load existing attributes and variants on page load
        window.addEventListener('DOMContentLoaded', () => {
            loadExistingAttributes();
            loadExistingVariants();
            setupAttributeValueHandlers();
        });

        function setupAttributeValueHandlers() {
            document.querySelectorAll('[data-add-value]').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const attrIdx = Number(btn.dataset.addValue);
                    const attrType = btn.dataset.attrType;
                    openAddValueModal(attrIdx, attrType);
                });
            });
        }

        function openAddValueModal(attrIdx, attrType) {
            editingAttrIdx = attrIdx;
            const attr = attributes[attrIdx];
            const modalContent = document.getElementById('modal-content');

            let html = '';
            if (attrType === 'color_picker') {
                html = `
                    <div class="mb-3">
                        <label for="new-color-name" class="form-label">Color Name</label>
                        <input type="text" class="form-control" id="new-color-name" placeholder="e.g., Midnight Blue">
                    </div>
                    <div class="mb-3">
                        <label for="new-color-code" class="form-label">Color Code</label>
                        <div class="d-flex gap-2">
                            <input type="color" class="color-input" id="new-color-code">
                            <input type="text" class="form-control" id="color-hex-display" readonly placeholder="#000000" style="max-width: 85%;">
                        </div>
                        <small class="text-info fs-8">*** The color code can't be modified once added ***</small>
                    </div>
                `;
            } else {
                html = `
                    <div class="mb-3">
                        <label for="new-value-name" class="form-label">Value</label>
                        <input type="text" class="form-control" id="new-value-name" placeholder="Enter attribute value">
                    </div>
                `;
            }

            modalContent.innerHTML = html;

            // Setup color picker live update
            if (attrType === 'color_picker') {
                const colorInput = document.getElementById('new-color-code');
                const hexDisplay = document.getElementById('color-hex-display');
                colorInput.addEventListener('change', (e) => {
                    hexDisplay.value = e.target.value;
                });
                // Set initial hex value
                hexDisplay.value = colorInput.value;
            }

            const modal = new bootstrap.Modal(document.getElementById('addValueModal'));
            document.getElementById('addValueModalLabel').textContent = `Add Value to ${attr.name}`;
            modal.show();
        }

        document.getElementById('save-new-value-btn').addEventListener('click', () => {
            if (editingAttrIdx === null) return;

            const attr = attributes[editingAttrIdx];
            const attrType = attr.type;
            let newValue = null;

            if (attrType === 'color_picker') {
                const colorName = document.getElementById('new-color-name').value.trim();
                const colorCode = document.getElementById('new-color-code').value;

                if (!colorName) {
                    swalToast('error', 'Please enter a color name');
                    return;
                }

                newValue = {
                    code: colorCode == '#000000' ? getColorValue(colorName) : colorCode,
                    name: colorName
                };
            } else {
                const valueName = document.getElementById('new-value-name').value.trim();
                if (!valueName) {
                    swalToast('error', 'Please enter a value');
                    return;
                }
                newValue = valueName;
            }

            // Add to attributes array
            attributes[editingAttrIdx].values.push(newValue);

            // Track new values for sending to backend
            if (!newAttributeValues[editingAttrIdx]) {
                newAttributeValues[editingAttrIdx] = [];
            }
            newAttributeValues[editingAttrIdx].push(newValue);

            // Re-render attributes section
            reRenderAttributeSection(editingAttrIdx);

            // Show add variant button
            document.getElementById('add-variant-btn').style.display = 'inline-block';

            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('addValueModal'));
            modal.hide();

            swalToast('success', 'Value added successfully! You can now generate new variants.');
        });

        function reRenderAttributeSection(attrIdx) {
            const attr = attributes[attrIdx];
            const section = document.querySelector(`[data-attr-index="${attrIdx}"]`);
            if (!section) return;

            let valuesHtml = '';
            if (attr.type === 'color_picker') {
                valuesHtml = `
                    <div class="color-picker-row">
                        ${attr.values.map(color => `
                                <div>
                                    <input type="color" class="color-input" value="${typeof color === 'object' ? color.code : '#000000'}" disabled />
                                    <small>${typeof color === 'object' ? color.name : color}</small>
                                    </div>
                                `).join('')}
                    </div>
                `;
            } else {
                valuesHtml = `<div>${attr.values.join(', ')}</div>`;
            }

            section.querySelector('div.d-flex').innerHTML = `
                <div style=\"flex: 1;\">
                    <h6 class=\"mb-2\"><strong>${attr.name}</strong>
                        (${attr.type === 'color_picker' ? 'Color Picker' : 'Radio'})
                    </h6>
                    ${valuesHtml}
                </div>
                <div class=\"ms-3\">
                    <button type=\"button\" class=\"btn btn-success btn-sm\" data-add-value=\"${attrIdx}\" data-attr-type=\"${attr.type}\">+ Add Value</button>
                </div>
            `;

            setupAttributeValueHandlers();
        }

        function loadExistingAttributes() {
            @php
                $attributesData = [];
                foreach ($attributes as $attr) {
                    $values = is_array($attr->attribute_values) ? $attr->attribute_values : json_decode($attr->attribute_values, true);
                    $attributesData[] = [
                        'name' => $attr->attribute_name,
                        'values' => $values,
                        'type' => $attr->display_type,
                    ];
                }
            @endphp
            attributes = <?= json_encode($attributesData) ?>;
        }

        function loadExistingVariants() {
            const existingVariantsJson = document.getElementById('existing-variants-input').value;
            const existingVariants = JSON.parse(existingVariantsJson);

            variants = existingVariants.map(v => ({
                id: v.id,
                sku: v.sku,
                price: v.price,
                stock: v.stock,
                is_sale: v.is_sale,
                sale_price: v.sale_price,
                featured_image: v.featured_image,
                gallery_image: v.gallery_image,
                is_active: v.is_active,
                attributes: v.attributes ? (typeof v.attributes === 'string' ? JSON.parse(v.attributes) : v
                    .attributes) : [],
                gallery_images: []
            }));

            if (variants.length > 0) {
                renderVariants();
            }
        }

        // Category change handler
        const catSelect = document.querySelector(".cat");
        const subcatSelect = document.querySelector(".sub-cat");
        const variantsContainer = document.getElementById('variants-container');
        const addedAttributesContainer = document.getElementById('added-attributes');
        productName = subcatSelect.options[subcatSelect.selectedIndex].text ?? '';

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
            fetch(`${appURL}product/subcat/${encodeURIComponent(query)}`)
                .then(response => response.text())
                .then(data => {
                    subcatSelect.innerHTML = data;
                })
                .catch(error => console.error('Error:', error));
        });

        // Attributes section is read-only on edit page

        // Attribute editing functions removed - attributes are read-only on edit page

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

        function generateSku(productName) {
            const prefix = productName
                .replace(/[^a-zA-Z]/g, '')
                .substring(0, 3)
                .toUpperCase();

            const suffix = Math.random().toString(36).substring(2, 6).toUpperCase();

            return `NX-${prefix}-${suffix}`;
        }

        // Add Variant - Opens modal to select attribute combination
        document.getElementById('add-variant-btn').addEventListener('click', (e) => {
            e.preventDefault();
            if (attributes.length === 0) {
                swalToast('error', 'Please add at least one attribute before adding variants');
                return;
            }

            openAddVariantModal();
        });

        function openAddVariantModal() {
            const modalContent = document.getElementById('variant-modal-content');
            let html = '<div class="mb-3">';

            attributes.forEach((attr, attrIdx) => {
                html += `
                    <div class="mb-3">
                        <label class="form-label fw-bold">${attr.name}</label>
                        <div>
                `;

                attr.values.forEach((value, valIdx) => {
                    const valueId = `attr-${attrIdx}-val-${valIdx}`;
                    const displayValue = typeof value === 'object' ? value.name : value;

                    if (attr.type === 'color_picker') {
                        const colorCode = typeof value === 'object' ? value.code : '#000000';
                        html += `
                            <div class="form-check">
                                <input class="form-check-input variant-attr-select" type="radio" name="attr-${attrIdx}" id="${valueId}" value="${valIdx}" data-attr-idx="${attrIdx}" />
                                <label class="form-check-label" for="${valueId}">
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width: 30px; height: 30px; border-radius: 50%; border: 1px solid #ddd; cursor: default; background-color: ${colorCode};"></div>
                                        <span>${displayValue}</span>
                                    </div>
                                </label>
                            </div>
                        `;
                    } else {
                        html += `
                            <div class="form-check">
                                <input class="form-check-input variant-attr-select" type="radio" name="attr-${attrIdx}" id="${valueId}" value="${valIdx}" data-attr-idx="${attrIdx}" />
                                <label class="form-check-label" for="${valueId}">
                                    ${displayValue}
                                </label>
                            </div>
                        `;
                    }
                });

                html += '</div></div>';
            });

            html += '</div>';
            modalContent.innerHTML = html;

            const modal = new bootstrap.Modal(document.getElementById('addVariantModal'));
            modal.show();
        }

        document.getElementById('confirm-add-variant-btn').addEventListener('click', () => {
            const selectedAttrs = [];
            let isValid = true;

            attributes.forEach((attr, attrIdx) => {
                const selected = document.querySelector(`input[name="attr-${attrIdx}"]:checked`);
                if (!selected) {
                    swalToast('error', `Please select a value for ${attr.name}`);
                    isValid = false;
                    return;
                }

                const valIdx = Number(selected.value);
                const value = attr.values[valIdx];
                selectedAttrs.push({
                    name: attr.name,
                    value: value
                });
            });

            if (!isValid) return;

            // Check if this combination already exists
            const attrString = selectedAttrs.map(a =>
                `${a.name}:${typeof a.value === 'object' ? a.value.name : a.value}`).join('|');
            const exists = variants.some(v => {
                const vAttrString = v.attributes.map(a =>
                    `${a.name}:${typeof a.value === 'object' ? a.value.name : a.value}`).join('|');
                return vAttrString === attrString;
            });

            if (exists) {
                swalToast('error', 'This variant combination already exists');
                return;
            }

            // Add new variant to list
            const newVariant = {
                sku: generateSku(productName || 'PROD'),
                price: '',
                stock: '',
                is_sale: false,
                sale_price: '',
                featured_image: null,
                gallery_images: [],
                attributes: selectedAttrs,
                is_new: true // Mark as newly added
            };

            variants.push(newVariant);
            renderVariants();

            const modal = bootstrap.Modal.getInstance(document.getElementById('addVariantModal'));
            modal.hide();

            swalToast('success', 'Variant added successfully');
        });

        function renderVariants() {
            const container = document.getElementById('variants-container');
            if (variants.length === 0) {
                container.innerHTML = '<p class="text-muted fs-7">No variants yet. Click "Add Variant" to create one.</p>';
                return;
            }

            container.innerHTML = '';
            variants.forEach((variant, idx) => {
                const attrString = variant.attributes.map(a => {
                    const displayValue = typeof a.value === 'object' ? a.value.name : a.value;
                    return `${a.name}: ${displayValue}`;
                }).join(', ');
                const sku = variant.sku || `SKU-${variant.id}`;
                const isExisting = variant.id && !variant.is_new;

                const variantDiv = document.createElement('div');
                variantDiv.className = 'variant-row position-relative bg-body-tertiary';
                variantDiv.innerHTML = `
                    <button type="button" class="btn-remove-variant bg-body" data-remove-variant="${idx}">✕</button>
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="mb-2"><strong>${attrString}</strong></h6>
                            <small class="text-muted">SKU: ${sku}</small>
                            ${isExisting ? '<small class="badge bg-info ms-2">Existing</small>' : '<small class="badge bg-success ms-2">New</small>'}
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
                                <input type="file" class="form-control fs-7 variant-featured-image" name="variant_featured_images[${idx}]" accept="image/*" data-variant-idx="${idx}" ${!isExisting?'required':''} />
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
                                <input type="text" hidden class="form-control fs-7 old-variant-gallery-images" name="old_variant_gallery_images[${idx}]" data-variant-idx="${idx}" value=""/>
                                <small class="text-info fs-8">*** You can select multiple images for this variant gallery ***</small>
                            </div>
                            <div class="">
                                <div class="variant-gallery-preview d-flex gap-2 flex-wrap mt-1" id="gallery-preview-${idx}"></div>
                                <div class="variant-gallery-preview d-flex gap-2 flex-wrap mt-2" id="new-gallery-preview-${idx}"></div>
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
                alert('Please select an image file');
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
            if (!variantGalleryDT[idx]) {
                variantGalleryDT[idx] = new DataTransfer();
            }
            files.forEach(file => {
                variantGalleryDT[idx].items.add(file);
            });
            e.target.files = variantGalleryDT[idx].files;

            // variants[idx].gallery_images = files;
            variants[idx].gallery_images = Array.from(
                variantGalleryDT[idx].files
            );
            renderVariantGalleryPreview(idx);
        }

        function renderVariantGalleryPreview(idx) {
            const preview = document.getElementById(`new-gallery-preview-${idx}`);
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
                    item.className = 'glr-image';
                    item.innerHTML = `
                        <div class="position-relative">
                            <img src="${event.target.result}" class="img-fluid rounded variant-preview-img" alt="Variant gallery preview" />
                            <i class="fa-solid fa-xmark img-remove-icon bg-body" onclick="removeVariantGalleryImage(${idx}, ${fileIndex})"></i>
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

        function renderExistingVariantGallery(idx) {
            const variant = variants[idx];
            const galleryPreview = document.getElementById(`gallery-preview-${idx}`);
            galleryPreview.innerHTML = '';

            if (!variant.gallery_image) return;

            const galleryImages = variant.gallery_image;
            galleryImages.forEach((img, gIdx) => {
                const item = document.createElement('div');
                item.className = 'glr-image';
                const imagePath = `{{ asset('uploads') }}/var_glr_lg_${img}`;
                item.innerHTML = `
                    <div class="position-relative">
                        <img src="${imagePath}" class="img-fluid rounded variant-preview-img" alt="Variant gallery preview" />
                        <i class="fa-solid fa-xmark img-remove-icon bg-body" onclick="removeOldVariantGalleryImage(${idx}, ${gIdx})" style="cursor: pointer;"></i>
                    </div>
                `;
                galleryPreview.appendChild(item);
            });
        }

        function removeVariantGalleryImage(idx, fileIndex) {
            variantGalleryDT[idx].items.remove(fileIndex);
            variants[idx].gallery_images = Array.from(
                variantGalleryDT[idx].files
            );
            renderVariantGalleryPreview(idx);
        }

        function removeOldVariantGalleryImage(idx, fileIndex) {
            const oldInput = document.querySelector(`.old-variant-gallery-images[data-variant-idx="${idx}"]`);
            if (!oldInput) return;
            const variant = variants[idx];
            let images = variant.gallery_image;

            images.splice(fileIndex, 1);

            variant.gallery_image = images;
            oldInput.value = variant.gallery_image;
            renderExistingVariantGallery(idx);
        }

        function restoreVariantFiles(idx) {
            const variant = variants[idx];
            const oldInput = document.querySelector(`.old-variant-gallery-images[data-variant-idx="${idx}"]`);
            if (!variant) return;

            // Display existing featured image from server
            if (variant.featured_image) {
                const preview = document.getElementById(`featured-preview-${idx}`);
                const imagePath = `{{ asset('uploads') }}/var_lg_${variant.featured_image}`;
                preview.innerHTML =
                    `<img src="${imagePath}" class="img-fluid rounded variant-preview-img" alt="Variant preview" />`;
            }

            // Display existing gallery images from server
            if (variant.gallery_image) {
                const galleryImages = variant.gallery_image;
                const galleryPreview = document.getElementById(`gallery-preview-${idx}`);
                galleryImages.forEach((img, gIdx) => {
                    const item = document.createElement('div');
                    item.className = 'glr-image';
                    const imagePath = `{{ asset('uploads') }}/var_glr_lg_${img}`;
                    item.innerHTML = `
                        <div class="position-relative">
                            <img src="${imagePath}" class="img-fluid rounded variant-preview-img" alt="Variant gallery preview" />
                            <i class="fa-solid fa-xmark img-remove-icon bg-body" onclick="removeOldVariantGalleryImage(${idx}, ${gIdx})" style="cursor: pointer;"></i>
                        </div>
                    `;
                    galleryPreview.appendChild(item);
                });
                oldInput.value = galleryImages;
            }

            // Restore newly added gallery images from current session
            if (variantGalleryDT[idx] && variantGalleryDT[idx].files.length > 0) {
                renderVariantGalleryPreview(idx);
            }
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

            if (variants.length === 0) {
                swalToast('error', 'No variants found');
                return false;
            }

            // Collect variant data for update
            const variantsData = [];

            document.querySelectorAll('.variant-row').forEach((row, idx) => {
                const sku = row.querySelector('.variant-sku').value;
                const price = parseFloat(row.querySelector('.variant-price').value);
                const stock = parseInt(row.querySelector('.variant-stock').value);
                const isSale = row.querySelector('.variant-is-sale').checked;
                const salePriceInput = row.querySelector('.variant-sale-price');
                const salePrice = isSale ? parseFloat(salePriceInput.value) : null;
                const isActive = row.querySelector('.is-active').value;

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
                    id: variants[idx].id,
                    sku: sku,
                    price: price,
                    stock: stock,
                    is_sale: isSale,
                    sale_price: salePrice,
                    is_active: isActive,
                    attributes: variants[idx].attributes,
                    imageIndex: idx
                });
            });

            document.getElementById('variants-data-input').value = JSON.stringify(variantsData);

            // Add new attribute values if any were added
            const newAttrValuesInput = document.createElement('input');
            newAttrValuesInput.type = 'hidden';
            newAttrValuesInput.name = 'new-attribute-values';
            newAttrValuesInput.value = JSON.stringify(newAttributeValues);
            document.getElementById('variant-product-form').appendChild(newAttrValuesInput);

            // Store formData in window for later use in form submission
            // window.variantImagesFormData = formData;

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
