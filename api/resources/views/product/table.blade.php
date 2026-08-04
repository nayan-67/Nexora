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
                            if ($row->type == 2) {
                                $stock = DB::table('variants')->where('product_id', $row->id)->sum('stock');
                            } else {
                                $stock = $row->stock;
                            }
                            $img =
                                $row->type == 2
                                    ? 'uploads/var_sm_' . $row->featured_image
                                    : 'uploads/prd_sm_' . $row->featured_image;
                            $date = substr($row->created_at, 0, 10);
                        @endphp
                        <tr align="center">
                            <td>
                                <div class="d-flex align-items-center justify-content-start">
                                    <img src="{{ asset($img) }}" alt="" class="rounded me-2"
                                        style="height: 80px;" />
                                    <span class="fw-medium p-name">{{ $row->name }}</span>
                                </div>
                            </td>
                            <td>{{ $cat->name }}</td>
                            <td>{{ $subcat->name }}</td>
                            <td>₹ {{ $row->sale_price ?? $row->price }}</td>
                            <td>{{ $row->type == '1' ? 'Simple' : 'Variable' }}</td>
                            <td>
                                <span
                                    class='{{ $stock > 0 ? 'text-success' : 'text-danger' }}'>{{ $stock }}</span>
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
