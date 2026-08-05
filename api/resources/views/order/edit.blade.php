@extends('layout.layout')

@section('title', 'Order')
@section('oactive', 'active')

@section('content')
    @php
        $bill_id = $data->billing_address_id;
        $ship_id = $data->shipping_address_id;
        $billingresult = DB::table('order_address')->where('id', $bill_id)->first();
        $shippingresult = DB::table('order_address')->where('id', $ship_id)->first();
        $date = substr($data->created_at, 0, 10);

        $billingaddress =
            $billingresult->address1 .
            ', ' .
            $billingresult->city .
            ', ' .
            $billingresult->postcode .
            ', ' .
            $billingresult->state .
            ', ' .
            $billingresult->country;

        $shippingaddress =
            $shippingresult->address1 .
            ', ' .
            $shippingresult->city .
            ', ' .
            $shippingresult->postcode .
            ', ' .
            $shippingresult->state .
            ', ' .
            $shippingresult->country;

        $prdresult = DB::table('order_items')->where('order_id', $data->id)->get();

        if ($data->order_status == '1') {
            $statusClass = 'text-bg-warning';
            $statusText = 'Processing';
        } elseif ($data->order_status == '2') {
            $statusClass = 'text-bg-success';
            $statusText = 'Completed';
        } else {
            $statusClass = 'text-bg-danger';
            $statusText = 'Cancelled';
        }
        if ($data->payment_mode == '1') {
            $method = 'Cash on Delivery';
            $icon = '<i class="bi bi-cash-coin me-1" aria-hidden="true"></i>';
        } elseif ($data->payment_mode == '2') {
            $method = 'Razorpay';
            $icon = '<i class="bi bi-credit-card me-1" aria-hidden="true"></i>';
        } else {
            $method = 'Wallet';
            $icon = '<i class="bi bi-wallet2 me-1" aria-hidden="true"></i>';
        }
        if ($data->payment_status == '1') {
            $paymentStatusClass = 'border border-warning-subtle';
        } elseif ($data->payment_status == '2') {
            $paymentStatusClass = 'border border-success';
        } else {
            $paymentStatusClass = 'border border-danger-subtle';
        }
        // if ($data->discount) {
        //    $discountData= DB::table('discounts')->where('id', $data->discount_id)->first();
        // }
        // $discountValue = $data->discount;
    @endphp
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header py-2">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-4 align-items-center d-flex">
                        <h3 class="mb-0 page-head fs-4">Edit Order</h3>
                    </div>
                    <div class="col-sm-4 d-flex align-items-center justify-content-center">
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.order') }}">Order</a></li>
                            <li class="breadcrumb-item active page-head" aria-current="page">Edit Order</li>
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

            <!-- =========== Edit Order Section ============== -->
            <section class="bg-body add-section" style="margin:0 10px;">
                <div class="container h-100  border-2 border-top border-primary rounded">
                    <h6 class="my-3 d-flex align-items-center gap-4">
                        <span class="text-primary">#{{ $data->order_number }}</span>
                        <span class="">{{ $data->created_at }}</span>
                        <span class="list-badge {{ $statusClass }}">{{ $statusText }}</span>
                    </h6>
                    <hr class="my-1">
                    <form action="{{ route('order.update', $data->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row h-100">
                            <div class="col-xl-12 px-4">
                                <div class="card-body">
                                    <table class="table table-hover align-middle m-0">
                                        <thead class="fs-7">
                                            <tr align="center">
                                                <th class="text-left">Products</th>
                                                <th>SKU</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="fs-7 data-results">
                                            @foreach ($prdresult as $orderItem)
                                                @php
                                                    $product = DB::table('products')
                                                        ->where('id', $orderItem->product_id)
                                                        ->first();
                                                    $isVariableProduct = $product->type == 2;
                                                    if ($isVariableProduct) {
                                                        $varProduct = DB::table('variants')
                                                            ->where('sku', $orderItem->sku)
                                                            ->first();
                                                    }
                                                    $attributes = $isVariableProduct
                                                        ? json_decode($varProduct->attributes, true)
                                                        : [];
                                                    $img = $isVariableProduct
                                                        ? 'uploads/var_sm_' . $varProduct->featured_image
                                                        : 'uploads/prd_sm_' . $product->featured_image;
                                                    if ($orderItem->status == '1') {
                                                        $statusClass = 'border border-warning-subtle';
                                                    } elseif ($orderItem->status == '2') {
                                                        $statusClass = 'border border-primary-subtle';
                                                    } elseif ($orderItem->status == '3') {
                                                        $statusClass = 'border border-success';
                                                    } else {
                                                        $statusClass = 'border border-danger-subtle';
                                                    }
                                                @endphp
                                                <tr align="center">
                                                    <td align="left">
                                                        <div class="d-flex align-items-center justify-content-start">
                                                            <img src="{{ asset($img) }}" alt=""
                                                                class="rounded me-2" style="width: 60px;" />
                                                            <div class="d-flex flex-column">
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
                                                    <td>{{ $orderItem->sku }}</td>
                                                    <td>{{ $orderItem->quantity }}</td>
                                                    <td>₹ {{ $orderItem->price }}</td>
                                                    <td>
                                                        <select class="form-control form-select fs-7 {{ $statusClass }}"
                                                            aria-label="Default select example"
                                                            name="item_status_{{ $orderItem->id }}">
                                                            <option {{ $orderItem->status == 1 ? 'selected' : '' }}
                                                                value="1">
                                                                Processing</option>
                                                            <option {{ $orderItem->status == 2 ? 'selected' : '' }}
                                                                value="2">
                                                                Shipped</option>
                                                            <option {{ $orderItem->status == 3 ? 'selected' : '' }}
                                                                value="3">
                                                                Delivered</option>
                                                            <option {{ $orderItem->status == 0 ? 'selected' : '' }}
                                                                value="0">
                                                                Canceled</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <h4 class="text-secondary-emphasis my-2 mt-3">Address Details</h4>
                                    <hr class="my-1">
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-6">
                                            <h6 class="mb-2 fs-7 fw-bold">Delivery Address</h6>
                                            <textarea class="form-control fs-7" rows="3" name="description" disabled>{{ $shippingaddress }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="mb-2 fs-7 fw-bold">Billing Address</h6>
                                            <textarea class="form-control fs-7" rows="3" name="description" disabled>{{ $billingaddress }}</textarea>
                                        </div>
                                    </div>

                                    <div class="row pt-1 pb-2">
                                        <div class="col-md-8 position-relative">
                                            <h4 class="text-secondary-emphasis my-2 mt-3">Payment Details</h4>
                                            <hr class="my-1">
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
                                                        <select
                                                            class="form-control form-select fs-7 {{ $paymentStatusClass }}"
                                                            aria-label="Default select example" name="payment_status">
                                                            <option {{ $data->payment_status == 1 ? 'selected' : '' }}
                                                                value="1">
                                                                Pending</option>
                                                            <option {{ $data->payment_status == 2 ? 'selected' : '' }}
                                                                value="2">
                                                                Paid</option>
                                                            <option {{ $data->payment_status == 3 ? 'selected' : '' }}
                                                                value="3">
                                                                Refunded</option>
                                                        </select>
                                                    </p>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Transaction
                                                        ID</label>
                                                    <p class="mb-0 fs-7 form-control" style="min-height: 2.1rem;">
                                                        {{ $data->transaction_id }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <h4 class="text-secondary-emphasis my-2 mt-3">Billing Details</h4>
                                            <hr class="my-1">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="d-flex justify-content-between">
                                                        <span>Subtotal :</span>
                                                        <span>₹
                                                            {{ $data->sub_total }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span>Discount :</span>
                                                        <span>- ₹
                                                            {{ $data->discount }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span>Shipping :</span>
                                                        <span>₹
                                                            {{ $data->shipping }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span>GST(8%) :</span>
                                                        <span>₹
                                                            {{ $data->eco_tax }}</span>
                                                    </div>
                                                    <hr>
                                                    <div class="d-flex justify-content-between">
                                                        <span class="fw-semibold">Total
                                                            :</span>
                                                        <span class="fw-semibold">₹
                                                            {{ $data->total_price }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row py-2">
                                        <div class="col-md-12 justify-content-center d-flex gap-2">
                                            <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                                class="btn btn-primary btn-sm d-flex align-items-center"
                                                name="order_update" id="order_update">
                                                <i class="bi bi-arrow-repeat me-1 d-flex" id="arrow_repeat"></i>
                                                Update Status
                                            </button>
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
        let button = document.querySelector("#order_update");
        let icon = document.querySelector("#arrow_repeat");
        button.addEventListener("click", async function() {
            icon.style.animation = "spin 1s linear infinite";
            await new Promise(resolve => setTimeout(resolve, 500));
            this.disabled = true;
        });
    </script>
@endsection
