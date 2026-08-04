<!--begin::Card Body-->
<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle m-0">
            <thead class="fs-7">
                <tr align="center">
                    <th>Order Number</th>
                    <th>Shipping Address</th>
                    <th>Date</th>
                    <th>Price</th>
                    <th>Customer</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="fs-7 data-results">
                @if (count($data) > 0)
                    @foreach ($data as $row)
                        @php
                            $bill_id = $row->billing_address_id;
                            $ship_id = $row->shipping_address_id;
                            $billingresult = DB::table('order_address')->where('id', $bill_id)->first();
                            $shippingresult = DB::table('order_address')->where('id', $ship_id)->first();
                            $date = substr($row->created_at, 0, 10);
                            $name = $billingresult->f_name . ' ' . $billingresult->l_name;
                            $address =
                                $shippingresult->address1 .
                                ', ' .
                                $shippingresult->city .
                                ', ' .
                                $shippingresult->postcode .
                                ', ' .
                                $shippingresult->state .
                                ', ' .
                                $shippingresult->country;
                            if ($row->order_status == 1) {
                                $stCalss = 'text-bg-warning';
                                $status = 'Processing';
                            } elseif ($row->order_status == 2) {
                                $stCalss = 'text-bg-success';
                                $status = 'Completed';
                            } else {
                                $stCalss = 'text-bg-danger';
                                $status = 'Cancelled';
                            }
                        @endphp
                        <tr align="center">
                            <td>{{ $row->order_number }}</td>
                            <td>{{ $address ?? 'Not found' }}</td>
                            <td>{{ date('M j, Y', strtotime($date)) }}</td>
                            <td>₹ {{ $row->total_price }}</td>
                            <td>{{ $name ?? 'User' }}</td>
                            <td>
                                <span
                                    class='list-badge {{ $stCalss }}'>{{ $status }}</span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('order.edit', encrypt($row->id)) }}"
                                        class="btn btn-outline-info d-flex" data-bs-toggle="tooltip"
                                        data-bs-title="Edit">
                                        <i class="bi bi-pencil d-flex" aria-hidden="true"></i>
                                    </a>
                                    {{-- <a href="{{ route('user.order', encrypt($row->id)) }}"
                                        class="btn btn-outline-primary d-flex align-items-center"
                                        data-bs-toggle="tooltip" data-bs-title="Orders">
                                        <i class="bi bi-cart3 d-flex" aria-hidden="true">
                                        </i>
                                    </a> --}}
                                    {{-- <button type="button" class="btn btn-outline-danger"
                                        data-bs-toggle="tooltip" data-bs-title="Delete"
                                        onclick="openModal('{{ $row->id }}');">
                                        <i class="bi bi-trash d-flex" aria-hidden="true"> </i>
                                    </button> --}}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr align="center">
                        <td colspan="7">No Order Found</td>
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
            Showing 1 Order
        @elseif($data->total() > 1)
            Showing {{ $data->firstItem() }} - {{ $data->lastItem() }} of {{ $data->total() }} Orders
        @else
            Showing 0 of 0 Order
        @endif
    </div>
    <div class="float-end">
        {{ $data->links() }}
    </div>
</div>
<!--end::Card Footer-->
