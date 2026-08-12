@extends('layout.layout')

@section('title', 'Customer')
@section('uactive', 'active')

@section('css')
    <style>
        .block-switch:checked {
            background-color: #d31616 !important;
            border-color: #d31616 !important;
        }

        .inactive-switch:checked {
            background-color: #ffbb00 !important;
            border-color: #ffbb00 !important;
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
                        <h3 class="mb-0 page-head fs-4">Customer Profile</h3>
                    </div>
                    <div class="col-sm-4 d-flex align-items-center justify-content-center">
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.user') }}">Customer</a></li>
                            <li class="breadcrumb-item active page-head" aria-current="page">Customer Profile</li>
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

            <!-- =========== Edit Customer Section ============== -->
            @error('e-mail')
                {{ toast($message, 'error') }}
            @enderror
            @error('phone')
                {{ toast($message, 'error') }}
            @enderror
            <div class="container-fluid">
                <div class="row g-3">
                    <!-- Profile sidebar -->
                    <div class="col-md-3">
                        <!-- About card -->
                        <div class="card">
                            <div class="card-body text-center">
                                @php
                                    $codeName = Str::upper(
                                        substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1),
                                    );
                                    if ($user->profile_image) {
                                        $element =
                                            "<img src='" .
                                            asset('uploads/' . $user->profile_image) .
                                            "' alt='Profile Image' class='rounded-circle mb-3' style='width: 96px; height: 96px; object-fit: cover;' />";
                                    } else {
                                        $element =
                                            "<div class='rounded-circle bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center mb-3' style='width: 96px; height: 96px; font-size: 2rem' aria-hidden='true'>
                                                    " .
                                            $codeName .
                                            '</div>';
                                    }
                                @endphp
                                {!! $element !!}
                                <h3 class="h5 mb-0">{{ $user->first_name }} {{ $user->last_name }}</h3>
                                <ul class="list-group list-group-flush text-start small">
                                    <li class="list-group-item d-flex justify-content-between px-0">
                                        <span class="text-secondary">Total Orders</span>
                                        <span class="fw-semibold">{{ count($orders) }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between px-0">
                                        <span class="text-secondary">Total Ordered Items</span>
                                        <span class="fw-semibold">{{ count($order_items) }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between px-0">
                                        <span class="text-secondary">Total Order Value</span>
                                        <span class="fw-semibold">₹ {{ $order_value }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Tabbed content -->
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" id="profile-tabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="details-tab" data-bs-toggle="tab"
                                            data-bs-target="#details" type="button" role="tab" aria-selected="false">
                                            Details
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="address-tab" data-bs-toggle="tab"
                                            data-bs-target="#address" type="button" role="tab" aria-selected="false">
                                            Addresses
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="orders-tab" data-bs-toggle="tab"
                                            data-bs-target="#orders" type="button" role="tab" aria-selected="false">
                                            Orders
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="status-tab" data-bs-toggle="tab"
                                            data-bs-target="#status" type="button" role="tab" aria-selected="false">
                                            Status
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="activity-tab" data-bs-toggle="tab"
                                            data-bs-target="#activity" type="button" role="tab" aria-selected="true">
                                            Activity
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <!-- Details tab -->
                                    <div class="tab-pane fade show active" id="details" role="tabpanel"
                                        aria-labelledby="details-tab">
                                        <form class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label" for="profile-first"> First name </label>
                                                <span class="form-control">{{ $user->first_name }}</span>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="profile-last"> Last name </label>
                                                <span class="form-control">{{ $user->last_name }}</span>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="profile-email"> Email </label>
                                                <span class="form-control">{{ $user->email }}</span>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="profile-phone"> Phone </label>
                                                <span class="form-control">{{ $user->phone }}</span>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Addresses tab -->
                                    <div class="tab-pane fade" id="address" role="tabpanel"
                                        aria-labelledby="address-tab">
                                        <div class="tab-pane fade show" id="account" role="tabpanel">
                                            <div class="card">
                                                @foreach ($billingresult as $key => $add)
                                                    <div class="card-header">
                                                        <h3 class="card-title">Address {{ $key + 1 }}
                                                            ({{ $add->addr_name }})
                                                        </h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <label class="form-label" for="settings-name"> Full name
                                                                </label>
                                                                <span class="form-control">{{ $add->first_name }}
                                                                    {{ $add->last_name }}</span>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label" for="settings-email"> Phone
                                                                </label>
                                                                <span class="form-control">{{ $add->phone }}</span>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label" for="settings-tz"> Address Line
                                                                    1
                                                                </label>
                                                                <textarea class="form-control" readonly>{{ $add->address1 }}</textarea>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label" for="settings-tz"> Address Line
                                                                    2
                                                                </label>
                                                                <textarea class="form-control" readonly>{{ $add->address2 }}</textarea>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label" for="settings-lang"> City
                                                                </label>
                                                                <span class="form-control">{{ $add->city }}</span>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label" for="settings-lang"> Pin Code
                                                                </label>
                                                                <span class="form-control">{{ $add->postcode }}</span>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label" for="settings-lang"> country
                                                                </label>
                                                                <span class="form-control">{{ $add->country }}</span>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label" for="settings-lang"> State
                                                                </label>
                                                                <span class="form-control">{{ $add->state }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Orders tab -->
                                    <div class="tab-pane fade" id="orders" role="tabpanel"
                                        aria-labelledby="orders-tab">
                                        <!--begin::Body-->
                                        <div class="card-body">
                                            <div class="accordion" id="accordionExample">
                                                @if (count($orders) > 0)
                                                    @foreach ($orders as $key => $item)
                                                        @php
                                                            $orderItems = DB::table('order_items')
                                                                ->where('order_id', $item->id)
                                                                ->get();
                                                            $shippingAddress = DB::table('order_address')
                                                                ->where('id', $item->shipping_address_id)
                                                                ->first();
                                                            $billingAddress = DB::table('order_address')
                                                                ->where('id', $item->billing_address_id)
                                                                ->first();
                                                            $fullShippingAddress = $shippingAddress
                                                                ? $shippingAddress->address1 .
                                                                    ', ' .
                                                                    $shippingAddress->city .
                                                                    ', ' .
                                                                    $shippingAddress->state .
                                                                    ', ' .
                                                                    $shippingAddress->postcode .
                                                                    ', ' .
                                                                    $shippingAddress->country
                                                                : '';
                                                            $fullBillingAddress = $billingAddress
                                                                ? $billingAddress->address1 .
                                                                    ', ' .
                                                                    $billingAddress->city .
                                                                    ', ' .
                                                                    $billingAddress->state .
                                                                    ', ' .
                                                                    $billingAddress->postcode .
                                                                    ', ' .
                                                                    $billingAddress->country
                                                                : '';
                                                            if ($item->order_status === 1) {
                                                                $statusClass = 'text-bg-warning';
                                                                $statusText = 'Processing';
                                                            } elseif ($item->order_status === 2) {
                                                                $statusClass = 'text-bg-success';
                                                                $statusText = 'Completed';
                                                            } else {
                                                                $statusClass = 'text-bg-danger';
                                                                $statusText = 'Cancelled';
                                                            }
                                                            if ($item->payment_status === 1) {
                                                                $paymentStatusClass = 'text-bg-warning';
                                                                $paymentStatusText = 'Pending';
                                                            } elseif ($item->payment_status === 2) {
                                                                $paymentStatusClass = 'text-bg-success';
                                                                $paymentStatusText = 'Paid';
                                                            } else {
                                                                $paymentStatusClass = 'text-bg-danger';
                                                                $paymentStatusText = 'Refunded';
                                                            }
                                                            if ($item->payment_mode === 1) {
                                                                $method = 'Cash on Delivery';
                                                                $icon =
                                                                    '<i class="bi bi-cash-coin me-1" aria-hidden="true"></i>';
                                                            } elseif ($item->payment_mode === 2) {
                                                                $method = 'Razorpay';
                                                                $icon =
                                                                    '<i class="bi bi-credit-card me-1" aria-hidden="true"></i>';
                                                            } else {
                                                                $method = 'Wallet';
                                                                $icon =
                                                                    '<i class="bi bi-wallet2 me-1" aria-hidden="true"></i>';
                                                            }
                                                        @endphp
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header">
                                                                <button
                                                                    class="accordion-button gap-4 {{ $key !== 0 ? 'collapsed' : '' }}"
                                                                    type="button" data-bs-toggle="collapse"
                                                                    data-bs-target="#collapse-{{ $item->id }}"
                                                                    aria-expanded="{{ $key === 0 ? 'true' : 'false' }}"
                                                                    aria-controls="collapse-{{ $item->id }}">
                                                                    Order: #{{ $item->order_number }}
                                                                    <span class="">{{ $item->created_at }}</span>
                                                                    <span
                                                                        class="list-badge {{ $statusClass }}">{{ $statusText }}</span>
                                                                </button>
                                                            </h2>
                                                            <div id="collapse-{{ $item->id }}"
                                                                class="accordion-collapse collapse {{ $key === 0 ? 'show' : '' }}"
                                                                data-bs-parent="#accordionExample">
                                                                <div class="accordion-body">
                                                                    <table class="table table-hover align-middle m-0">
                                                                        <thead class="fs-7">
                                                                            <tr align="center">
                                                                                <th class="text-left">Products</th>
                                                                                <th>Quantity</th>
                                                                                <th>Price</th>
                                                                                <th>Status</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="fs-7 data-results">
                                                                            @foreach ($orderItems as $orderItem)
                                                                                @php
                                                                                    $product = DB::table('products')
                                                                                        ->where(
                                                                                            'id',
                                                                                            $orderItem->product_id,
                                                                                        )
                                                                                        ->first();
                                                                                    $isVariableProduct =
                                                                                        $product->type == 2;
                                                                                    if ($isVariableProduct) {
                                                                                        $varProduct = DB::table(
                                                                                            'variants',
                                                                                        )
                                                                                            ->where(
                                                                                                'sku',
                                                                                                $orderItem->sku,
                                                                                            )
                                                                                            ->first();
                                                                                    }
                                                                                    $attributes = $isVariableProduct
                                                                                        ? json_decode(
                                                                                            $varProduct->attributes,
                                                                                            true,
                                                                                        )
                                                                                        : [];
                                                                                    $img = $isVariableProduct
                                                                                        ? 'uploads/var_sm_' .
                                                                                            $varProduct->featured_image
                                                                                        : 'uploads/prd_sm_' .
                                                                                            $product->featured_image;
                                                                                    if ($orderItem->status == 1) {
                                                                                        $statusClass =
                                                                                            'text-bg-warning';
                                                                                        $statusText = 'Processing';
                                                                                    } elseif ($orderItem->status == 2) {
                                                                                        $statusClass =
                                                                                            'text-bg-primary';
                                                                                        $statusText = 'Shipped';
                                                                                    } elseif ($orderItem->status == 3) {
                                                                                        $statusClass =
                                                                                            'text-bg-success';
                                                                                        $statusText = 'Delivered';
                                                                                    } else {
                                                                                        $statusClass = 'text-bg-danger';
                                                                                        $statusText = 'Cancelled';
                                                                                    }
                                                                                @endphp
                                                                                <tr align="center">
                                                                                    <td align="left">
                                                                                        <div
                                                                                            class="d-flex align-items-center justify-content-start">
                                                                                            <img src="{{ asset($img) }}"
                                                                                                alt=""
                                                                                                class="img-size-32 rounded me-2" />
                                                                                            <div
                                                                                                class="d-flex flex-column">
                                                                                                <span>
                                                                                                    {{ $product->name }}
                                                                                                </span>
                                                                                                <span class="fs-8">
                                                                                                    @foreach ($attributes as $key => $val)
                                                                                                        {{ $val['name'] }}:
                                                                                                        &nbsp;
                                                                                                        {{ $val['value']['name'] ?? $val['value'] }}
                                                                                                        &nbsp;
                                                                                                        {{ $key < count($attributes) - 1 ? '|' : '' }}
                                                                                                        &nbsp;
                                                                                                    @endforeach
                                                                                                </span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>{{ $orderItem->quantity }}</td>
                                                                                    <td>₹ {{ $orderItem->price }}</td>
                                                                                    <td>
                                                                                        <span
                                                                                            class="list-badge {{ $statusClass }}">
                                                                                            {{ $statusText }}
                                                                                        </span>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                    <div class="card mt-3">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title mb-0">Order Details</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="row g-3 fs-7">
                                                                                <div class="col-md-8">
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <label
                                                                                                class="form-label">Billing
                                                                                                Address</label>
                                                                                            <p class="mb-0 fs-7 form-control"
                                                                                                style="min-height: 3.5rem;">
                                                                                                {{ $billingAddress->address2 ? $billingAddress->address2 . ', ' : '' }}
                                                                                                {{ $fullBillingAddress }}
                                                                                            </p>
                                                                                        </div>
                                                                                        <div class="col-md-12 mt-2">
                                                                                            <label
                                                                                                class="form-label">Shipping
                                                                                                Address</label>
                                                                                            <p class="mb-0 fs-7 form-control"
                                                                                                style="min-height: 3.5rem;">
                                                                                                {{ $shippingAddress->address2 ? $shippingAddress->address2 . ', ' : '' }}
                                                                                                {{ $fullShippingAddress }}
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4"
                                                                                    style="border-left: 1px solid #dee2e638;">
                                                                                    <div class="row">
                                                                                        <h6 class="text-center">Order
                                                                                            Summary</h6>
                                                                                        <div class="col-md-12">
                                                                                            <div
                                                                                                class="d-flex justify-content-between">
                                                                                                <span>Subtotal :</span>
                                                                                                <span>₹
                                                                                                    {{ $item->sub_total }}</span>
                                                                                            </div>
                                                                                            <div
                                                                                                class="d-flex justify-content-between">
                                                                                                <span>Discount :</span>
                                                                                                <span>- ₹
                                                                                                    {{ $item->discount_value }}</span>
                                                                                            </div>
                                                                                            <div
                                                                                                class="d-flex justify-content-between">
                                                                                                <span>Shipping :</span>
                                                                                                <span>₹
                                                                                                    {{ $item->shipping_fee }}</span>
                                                                                            </div>
                                                                                            <div
                                                                                                class="d-flex justify-content-between">
                                                                                                <span>GST(8%) :</span>
                                                                                                <span>₹
                                                                                                    {{ $item->tax }}</span>
                                                                                            </div>
                                                                                            <hr>
                                                                                            <div
                                                                                                class="d-flex justify-content-between">
                                                                                                <span
                                                                                                    class="fw-semibold">Total
                                                                                                    :</span>
                                                                                                <span class="fw-semibold">₹
                                                                                                    {{ $item->total_price }}</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="card-header">
                                                                            <h6 class="card-title mb-0">Payment Details
                                                                            </h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="row g-3 fs-7">
                                                                                <div class="col-md-4">
                                                                                    <label class="form-label">Payment
                                                                                        Method</label>
                                                                                    <p class="mb-0 fs-7 form-control">
                                                                                        {!! $icon !!}
                                                                                        {{ $method }}
                                                                                    </p>
                                                                                </div>
                                                                                <div class="col-md-2">
                                                                                    <label class="form-label">Payment
                                                                                        Status</label>
                                                                                    <p class="mb-0 d-flex align-items-center justify-content-center"
                                                                                        style="min-height: 2.1rem;">
                                                                                        <span
                                                                                            class="list-badge {{ $paymentStatusClass }}">
                                                                                            {{ $paymentStatusText }}
                                                                                        </span>
                                                                                    </p>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <label class="form-label">Transaction
                                                                                        ID</label>
                                                                                    <p class="mb-0 fs-7 form-control"
                                                                                        style="min-height: 2.1rem;">
                                                                                        {{ $item->transaction_id }}
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-flex justify-content-end mt-3 gap-2">
                                                                        <a href="javascript:void(0)"
                                                                            class="btn btn-sm btn-secondary mt-2">
                                                                            <i class="bi bi-file-earmark-pdf me-1"
                                                                                aria-hidden="true"></i>
                                                                            Invoice
                                                                        </a>
                                                                        <a href="javascript:void(0)"
                                                                            class="btn btn-sm btn-success mt-2">
                                                                            <i class="bi bi-printer me-1"
                                                                                aria-hidden="true"></i>
                                                                            Print
                                                                        </a>
                                                                        <a href="javascript:void(0)"
                                                                            class="btn btn-sm btn-warning mt-2">
                                                                            <i class="bi bi-truck me-1"
                                                                                aria-hidden="true"></i>
                                                                            Track
                                                                        </a>
                                                                        <a href="javascript:void(0)"
                                                                            class="btn btn-sm btn-primary mt-2">
                                                                            <i class="bi bi-chat-left-text me-1"
                                                                                aria-hidden="true"></i>
                                                                            Feedback
                                                                        </a>
                                                                        <a href="{{ route('order.edit', encrypt($item->id)) }}"
                                                                            class="btn btn-sm btn-info mt-2">
                                                                            <i class="bi bi-pencil-square me-1"
                                                                                aria-hidden="true"></i>
                                                                            Edit
                                                                        </a>
                                                                        @if ($item->order_status == 1)
                                                                            <a href="javascript:void(0)"
                                                                                class="btn btn-sm btn-danger mt-2"
                                                                                onclick="openCancelModal('{{ $item->id }}');">
                                                                                <i class="bi bi-x-circle me-1"
                                                                                    aria-hidden="true"></i>
                                                                                Cancel
                                                                            </a>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div>No Orders Found</div>
                                                @endif
                                            </div>
                                        </div>
                                        <!--end::Body-->
                                    </div>

                                    <!-- Status tab -->
                                    <div class="tab-pane fade" id="status" role="tabpanel"
                                        aria-labelledby="status-tab">
                                        <div class="row pb-2">
                                            <div class="col-md-3 d-flex align-items-center gap-3">
                                                <label for="active" class="d-flex align-items-center gap-2">
                                                    <i class="bi bi-person-check bg-success fs-5 px-1 rounded-3"></i>
                                                    Active
                                                </label>
                                                <div class="form-check form-switch mb-0">
                                                    <input class="form-check-input" type="radio" role="switch"
                                                        id="active" name="user_status" value="1"
                                                        {{ $user->status === 1 ? 'checked' : '' }} />
                                                    <label class="visually-hidden" for="active">
                                                        Toggle User Status
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 d-flex align-items-center gap-3">
                                                <label for="inactive" class="d-flex align-items-center gap-2">
                                                    <i class="bi bi-person-x text-black bg-warning fs-5 px-1 rounded-3"></i>
                                                    Inactive
                                                </label>
                                                <div class="form-check form-switch mb-0">
                                                    <input class="form-check-input inactive-switch" type="radio"
                                                        role="switch" id="inactive" name="user_status" value="2"
                                                        {{ $user->status === 2 ? 'checked' : '' }} />
                                                    <label class="visually-hidden" for="inactive">
                                                        Toggle User Status
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 d-flex align-items-center gap-3">
                                                <label for="block" class="d-flex align-items-center gap-2">
                                                    <i class="bi bi-person-slash bg-danger fs-5 px-1 rounded-3"></i>
                                                    Block
                                                </label>
                                                <div class="form-check form-switch mb-0">
                                                    <input class="form-check-input block-switch" type="radio"
                                                        role="switch" id="block" name="user_status" value="3"
                                                        {{ $user->status === 3 ? 'checked' : '' }} />
                                                    <label class="visually-hidden" for="block">
                                                        Toggle User Status
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <button data-mdb-button-init data-mdb-ripple-init
                                                    class="btn btn-primary btn-sm d-flex align-items-center float-end"
                                                    name="status_update" id="update_status">
                                                    <i class="bi bi-arrow-repeat me-1 d-flex" id="arrow_repeat"></i>
                                                    Update Status
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Activity tab -->
                                    <div class="tab-pane fade" id="activity" role="tabpanel"
                                        aria-labelledby="activity-tab">
                                        <article class="d-flex gap-3 mb-4">
                                            <div class="shrink-0 rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 40px" aria-hidden="true">
                                                JD
                                            </div>
                                            <div class="grow">
                                                <div class="d-flex justify-content-between">
                                                    <h4 class="h6 mb-0">Jane Doe</h4>
                                                    <small class="text-secondary">2 hours ago</small>
                                                </div>
                                                <p class="mb-2">
                                                    Shipped <a href="#">design-system v2.4</a> with a refreshed
                                                    color
                                                    palette and new motion primitives.
                                                </p>
                                                <a href="#" class="btn btn-sm btn-outline-secondary">
                                                    <i class="bi bi-hand-thumbs-up me-1" aria-hidden="true"></i>
                                                    Like
                                                </a>
                                                <a href="#" class="btn btn-sm btn-outline-secondary ms-1">
                                                    <i class="bi bi-chat me-1" aria-hidden="true"></i>
                                                    Comment
                                                </a>
                                            </div>
                                        </article>
                                        <article class="d-flex gap-3 mb-4">
                                            <div class="shrink-0 rounded-circle bg-info-subtle text-info d-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 40px" aria-hidden="true">
                                                JD
                                            </div>
                                            <div class="grow">
                                                <div class="d-flex justify-content-between">
                                                    <h4 class="h6 mb-0">Jane Doe</h4>
                                                    <small class="text-secondary">Yesterday</small>
                                                </div>
                                                <p class="mb-2">
                                                    Posted a question in
                                                    <a href="#">#design-help</a>: how should we handle focus
                                                    rings on
                                                    dark-themed CTA buttons?
                                                </p>
                                            </div>
                                        </article>
                                        <article class="d-flex gap-3">
                                            <div class="shrink-0 rounded-circle bg-warning-subtle text-warning d-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 40px" aria-hidden="true">
                                                JD
                                            </div>
                                            <div class="grow">
                                                <div class="d-flex justify-content-between">
                                                    <h4 class="h6 mb-0">Jane Doe</h4>
                                                    <small class="text-secondary">3 days ago</small>
                                                </div>
                                                <p class="mb-0">
                                                    Updated her bio and added <em>Research</em> to her skills.
                                                </p>
                                            </div>
                                        </article>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
@endsection

@section('script')
    <script>
        let appURL = @json(url('/'));

        const button = document.getElementById('update_status');
        const arrowIcon = document.getElementById('arrow_repeat');

        button.addEventListener('click', async (e) => {
            e.preventDefault();
            const status = document.querySelector("input[name='user_status']:checked").value;
            const userId = {{ $user->id }};

            arrowIcon.style.animation = 'spin 1s linear infinite';

            try {
                const tokenMeta = document.querySelector('meta[name="csrf-token"]');
                const token = tokenMeta ? tokenMeta.getAttribute('content') : '';

                const res = await fetch(`${appURL}/update/status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        id: userId,
                        status
                    })
                });

                const data = await res.json();
                if (data.status === 'success') {
                    swalToast('success', 'Status Updated Successfully');
                } else {
                    swalToast('error', data.message || 'Status Update Failed');
                }
            } catch (err) {
                console.error(err);
                swalToast('error', 'Status Update Failed');
            } finally {
                arrowIcon.style.animation = '';
            }
        });
    </script>
@endsection
