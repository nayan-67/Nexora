@extends('layout.layout')

@section('title', 'Product')
@section('plactive', 'active')
@section('pactive', 'active')
@section('pmenuopen', 'menu-open')

@section('modal-head', 'Product')
@section('delete-route', route('product.destroy'))


@section('css')
    <style>
        .p-name {
            max-width: 320px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .dot {
            height: 10px;
            width: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }

        .product-detail-panel {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity 0.25s ease, visibility 0.25s ease;
            z-index: 1050;
        }

        .product-detail-panel.open {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
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
                        <h3 class="mb-0 page-head fs-4">Products</h3>
                    </div>
                    <div class="col-sm-4 d-flex align-items-center justify-content-center">
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active page-head" aria-current="page">Products</li>
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

            <!-- ====== Product Section ======= -->

            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-12">
                        <!--begin::Card-->
                        <div class="card mb-4">
                            <!--begin::Card Header-->
                            <div class="card-header">
                                <div class="row g-2 align-items-center">
                                    <div class="col-12 col-md-6 d-flex gap-4">
                                        <div class="d-flex align-items-center gap-3">
                                            <label>Show Data</label>
                                            <select id="show-data" class="form-select form-select-sm w-auto">
                                                <option value="10" selected>10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <button id="export-csv" type="button" class="btn btn-sm btn-primary">
                                                <i class="bi bi-filetype-csv me-1" aria-hidden="true"></i>
                                                Export CSV
                                            </button>
                                            <button id="print-table" type="button" class="btn btn-sm btn-success">
                                                <i class="bi bi-printer me-1" aria-hidden="true"></i>
                                                Print
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="d-flex flex-wrap justify-content-md-end gap-2">
                                            <div class="input-group input-group-sm w-auto">
                                                <span class="input-group-text">
                                                    <i class="bi bi-search" aria-hidden="true"></i>
                                                </span>
                                                <input type="search" id="search" class="form-control"
                                                    placeholder="Search products" aria-label="Search products"
                                                    style="width: 180px" />
                                            </div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-plus-circle me-1" aria-hidden="true"></i>
                                                    New Product
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item fs-7"
                                                            href="{{ route('admin.simple-product') }}">
                                                            <i class="nav-icon bi bi-node-plus me-1"></i>
                                                            Simple Product
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider" />
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item fs-7"
                                                            href="{{ route('admin.variable-product') }}">
                                                            <i class="nav-icon bi bi-node-plus me-1"></i>
                                                            Variant Product
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Card Header-->
                            <div id="product-table-content">
                                @include('product.table')
                            </div>
                        </div>
                        <!--end::Card-->
                    </div>
                    <!-- /.col -->
                </div>
                <!--end::Row-->
            </div>

            <!--end::Container-->
        </div>
        <!--end::App Content-->

        <!-- Product detail slide panel -->
        <div id="product-detail-panel"
            class="product-detail-panel position-fixed end-0 w-50 bg-opacity-50 d-flex justify-content-end p-4 card"
            style="top: 57px;transition: opacity 0.25s ease, visibility 0.25s ease;height: calc(100% - 57px);">
            <div class="product-detail-inner bg-body shadow-sm overflow-auto position-relative mw-50">
                <div class="d-flex align-items-center justify-content-end">
                    {{-- <h5 class="mb-0">Product Details</h5> --}}
                    <button type="button" id="product-detail-close" class="btn-close" aria-label="Close"></button>
                </div>
                <div id="product-detail-content" class="product-detail-content min-vh-25">
                    <div class="text-center py-5 text-muted">Select a product row to view details.</div>
                </div>
            </div>
        </div>
        <!--end::App Content-->
    </main>

@endsection


@section('script')

    <script>
        const appURL = @php echo json_encode(url('/')) @endphp;

        const searchInput = document.getElementById('search');
        const showDataSelect = document.getElementById('show-data');
        const detailPanel = document.getElementById('product-detail-panel');
        const detailCloseBtn = document.getElementById('product-detail-close');
        const detailContent = document.getElementById('product-detail-content');
        let searchTimeout;

        function reloadProductTable() {
            const query = encodeURIComponent(searchInput.value.trim());
            const perPage = encodeURIComponent(showDataSelect.value);
            loadData(`${appURL}/product?search=${query}&per_page=${perPage}`, '#product-table-content',
                attachProductHandlers);
        }

        searchInput.addEventListener('input', (e) => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(reloadProductTable, 500);
        });

        showDataSelect.addEventListener('change', () => {
            reloadProductTable();
        });

        function attachProductHandlers() {
            document.querySelectorAll('.product-row').forEach((row) => {
                row.addEventListener('click', async (event) => {
                    if (event.target.closest('a') || event.target.closest('button')) {
                        return;
                    }
                    const productId = row.dataset.productId;
                    if (!productId) return;
                    await showProductDetails(productId);
                });
            });
        }

        async function showProductDetails(productId) {
            try {
                const response = await fetch(`${appURL}/product/details/${productId}`);
                if (!response.ok) {
                    throw new Error('Unable to load product details');
                }
                const payload = await response.json();
                renderProductDetails(payload);
                openDetailPanel();
            } catch (error) {
                detailContent.innerHTML = `<div class="text-danger p-4">${error.message}</div>`;
                openDetailPanel();
            }
        }

        function openDetailPanel() {
            detailPanel.classList.add('open');
        }

        function closeDetailPanel() {
            detailPanel.classList.remove('open');
        }

        function renderProductDetails(product) {
            const typeLabel = product.type == 2 ? 'Variant Product' : 'Simple Product';
            const featuredImage = product.featured_image ?
                `${appURL}/uploads/${product.type == 2 ? 'var_md_' + product.featured_image : 'prd_md_' + product.featured_image}` :
                null;
            const priceLabel = product.type == 2 ?
                product.variant_price_range || '₹ ' + product.price :
                product.sale_price ? `₹ ${product.sale_price} <del class='ms-2 fs-6 text-muted'>₹ ${product.price}</del>` : '₹ ' + product.price;
            const categoryLabel = product.category?.name || '-';
            const subCategoryLabel = product.sub_category?.name || '-';
            const featuresHtml = Array.isArray(product.features) && product.features.length ?
                `<ul class="list-unstyled mb-0 fs-7">${product.features.map(item => `<li>• ${item}</li>`).join('')}</ul>` :
                '<span class="text-muted">No features available</span>';
            const descriptionHtml = product.description ?
                `<p class="mb-0 fs-7">${product.description}</p>` :
                '<span class="text-muted">No description available</span>';

            let variantHtml = '';
            if (product.type == 2 && Array.isArray(product.variants) && product.variants.length) {
                variantHtml = `
                    <div class="product-variant-section mt-4">
                        <h6 class="mb-3">Variants (${product.variants.length})</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover align-middle">
                                <thead>
                                    <tr class="text-center fs-7">
                                        <th>Image</th>
                                        <th>SKU</th>
                                        <th>Price</th>
                                        <th>Sale Price</th>
                                        <th>Stock</th>
                                        <th>Attributes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${product.variants.map(function(variant) {
                                        const attrText = Array.isArray(variant.attributes)
                                            ? variant.attributes.map(function(attr){
                                                if (attr && typeof attr.value === 'object' && attr.value !== null) {
                                                    return (attr.name || '') + ': ' + (attr.value.name || JSON.stringify(attr.value));
                                                }
                                                return (attr.name || '') + ': ' + (attr.value ?? '');
                                            }).join(', ')
                                            : '-';
                                            let img=`${appURL}/uploads/var_sm_${variant.featured_image}`;
                                        return `
                                            <tr class="text-center fs-7">
                                                <td>
                                                    <img src="${img}" alt="${product.name}" class="img-fluid rounded" style="max-height: 80px;" />
                                                </td>
                                                <td>${variant.sku || '-'}</td>
                                                <td>₹ ${variant.price ?? '-'}</td>
                                                <td>₹ ${variant.sale_price ?? '-'}</td>
                                                <td><span class='dot bg-${variant.stock >= 20 ? 'success' : variant.stock >= 10 ? 'primary' : variant.stock >= 5 ? 'warning' : 'danger'}'></span>${variant.stock ?? '-'}</td>
                                                <td>${attrText}</td>
                                            </tr>
                                        `;
                                    }).join('')}
                                </tbody>
                            </table>
                        </div>
                    </div>
                `;
            }

            detailContent.innerHTML = `
                <div class="product-detail-image mb-3 text-center">
                    ${featuredImage ? `<img src="${featuredImage}" alt="${product.name}" class="img-fluid rounded" style="max-height: 180px;" />` : '<div class="text-muted">No image available</div>'}
                </div>
                <div class="product-detail-summary mb-3">
                    <h5 class="mb-1">${product.name}</h5>
                    <h5>${priceLabel}</h5>
                    <div class="fs-7 text-secondary mb-2">${typeLabel}</div>
                    <div class="d-flex flex-wrap gap-2 mb-2">
                        <span class="list-badge bg-success">Category: ${categoryLabel}</span>
                        <span class="list-badge bg-success">Sub Category: ${subCategoryLabel}</span>
                    </div>
                    <span class="list-badge bg-primary">SKU: ${product.sku}</span>
                    <div class="d-flex gap-2 my-2">
                        <span class="list-badge ${product.stock >= 20 ? 'bg-success' : product.stock >= 10 ? 'primary' : product.stock >= 5 ? 'bg-warning text-black' : 'bg-danger'}">Stock: ${product.stock ?? '—'}</span>
                        ${product.type == 2 ? `<span class="list-badge bg-info-subtle">Variants: ${product.variants.length}</span>` : ''}
                    </div>
                </div>
                <div class="product-detail-section mb-3">
                    <h6 class="mb-2">Description</h6>
                    ${descriptionHtml}
                </div>
                <div class="product-detail-section mb-3">
                    <h6 class="mb-2">Features</h6>
                    ${featuresHtml}
                </div>
                ${variantHtml}
            `;
        }

        function handleClickOutside(event) {
            if (!detailPanel.classList.contains('open')) return;
            const isInsidePanel = event.target.closest('.product-detail-panel');
            const isRow = event.target.closest('.product-row');
            if (!isInsidePanel && !isRow) {
                closeDetailPanel();
            }
        }

        detailCloseBtn.addEventListener('click', closeDetailPanel);
        document.addEventListener('click', handleClickOutside);

        attachProductHandlers();
    </script>

@endsection
