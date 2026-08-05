<!--begin::Card Body-->
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle m-0">
            <thead class="fs-7">
                <tr align="center">
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Sub Category</th>
                    <th>Price</th>
                    <th>Type</th>
                    <th>Stock</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="fs-7">
                @if (count($data) > 0)
                    @foreach ($data as $row)
                        @php
                            $cat = DB::table('category')->where('id', $row->category_id)->first();
                            $subcat = DB::table('sub_category')->where('id', $row->sub_category_id)->first();
                            $isVariant = $row->type == 2;
                            if ($isVariant) {
                                $stClass = 'text-bg-primary';
                                $type = 'Variant';
                                $stock = DB::table('variants')->where('product_id', $row->id)->sum('stock');
                                $totalVariants = DB::table('variants')->where('product_id', $row->id)->count();
                                $minPrice = DB::table('variants')->where('product_id', $row->id)->min('sale_price');
                                $maxPrice = DB::table('variants')->where('product_id', $row->id)->max('sale_price');
                                $priceDisplay =
                                    $minPrice == $maxPrice ? '₹ ' . $minPrice : '₹ ' . $minPrice . ' - ₹ ' . $maxPrice;
                            } else {
                                $stClass = 'text-bg-success';
                                $type = 'Simple';
                                $stock = $row->stock;
                                $priceDisplay = '₹ ' . ($row->sale_price ?? $row->price);
                            }
                            $img =
                                $row->type == 2
                                    ? 'uploads/var_sm_' . $row->featured_image
                                    : 'uploads/prd_sm_' . $row->featured_image;
                            $date = substr($row->created_at, 0, 10);
                            if ($stock >= 20) {
                                $stockClass = 'bg-success';
                            } elseif ($stock >= 10) {
                                $stockClass = 'bg-primary';
                            } elseif ($stock >= 5) {
                                $stockClass = 'bg-warning';
                            } else {
                                $stockClass = 'bg-danger';
                            }
                        @endphp
                        <tr align="center">
                            <td class="product-row" data-product-id="{{ $row->id }}" style="cursor: pointer;">
                                <div class="d-flex align-items-center justify-content-start row">
                                    <div class="col-md-4">
                                        <img src="{{ asset($img) }}" alt="" class="rounded me-2"
                                            style="height: 80px;" />
                                    </div>
                                    <div class="col-md-8 d-flex flex-column align-items-start justify-content-center">
                                        <span class="fw-medium p-name mb-1">{{ $row->name }}</span>
                                        <span class="fs-8">SKU: {{ $row->sku }}</span>
                                        <span class="fs-8">{{ $isVariant ? $totalVariants . ' Variants' : '' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $cat->name }}</td>
                            <td>{{ $subcat->name }}</td>
                            <td>{{ $priceDisplay }}</td>
                            <td><span class='list-badge {{ $stClass }}'>{{ $type }}</span></td>
                            <td>
                                <div class="d-flex align-items-center justify-content-start">
                                    <span class="dot {{ $stockClass }}"></span>
                                    {{ $stock }}
                                </div>
                            </td>
                            <td>{{ date('M j, Y', strtotime($date)) }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('product.edit', encrypt($row->id)) }}"
                                        class="btn btn-outline-info" data-bs-toggle="tooltip" data-bs-title="Edit">
                                        <i class="bi bi-pencil d-flex" aria-hidden="true">
                                        </i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="tooltip"
                                        data-bs-title="Delete" onclick="openModal('{{ $row->id }}');">
                                        <i class="bi bi-trash d-flex" aria-hidden="true"> </i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr align="center">
                        <td colspan="8">No Product Found</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <!-- /.table-responsive -->
</div>
<!--end::Card Body-->
<!--begin::Card Footer-->
<div class="card-footer clearfix">
    <div class="float-start pt-1 fs-7 text-body-secondary">
        @if ($data->total() == 1)
            Showing 1 Product
        @elseif($data->total() > 1)
            Showing {{ $data->firstItem() }} - {{ $data->lastItem() }} of {{ $data->total() }} Products
        @else
            Showing 0 of 0 Product
        @endif
    </div>
    <div class="float-end">
        {{ $data->links() }}
    </div>
</div>
<!--end::Card Footer-->
