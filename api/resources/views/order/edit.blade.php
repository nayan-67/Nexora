@extends('layout.layout')

@section('title', 'Order')
@section('oactive', 'active')

@section('content')
    <?php
    $bill_id = $data->billing_address_id;
    $ship_id = $data->shipping_address_id;
    $billingresult = DB::table('order_address')->where('id', $bill_id)->first();
    $shippingresult = DB::table('order_address')->where('id', $ship_id)->first();
    $create = $data->created_at;
    $date = substr($create, 0, 10);
    
    $billingaddress = $billingresult->address1 . ', ' . $billingresult->city . ', ' . $billingresult->postcode . ', ' . $billingresult->state . ', ' . $billingresult->country;
    
    $shippingaddress = $shippingresult->address1 . ', ' . $shippingresult->city . ', ' . $shippingresult->postcode . ', ' . $shippingresult->state . ', ' . $shippingresult->country;
    
    $prdresult = DB::table('order_product')->where('order_id', $data->id)->get();
    
    ?>
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
            <section class="bg-white add-section" style="margin:0 10px;">
                <div class="container h-100  border-2 border-top border-primary rounded">
                    {{-- <h6 class="text-secondary my-2">Edit Order</h6>
                    <hr class="my-1"> --}}
                    <form action="{{ route('order.update', $data->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row h-100">
                            <div class="col-xl-12 px-4">
                                <div class="card-body">
                                    <h4 class="text-secondary-emphasis my-2">Product Details</h4>
                                    <hr class="my-1">
                                    @foreach ($prdresult as $key => $item)
                                        <?php
                                        $p_id = $item->product_id;
                                        $presult = DB::table('products')->where('id', $p_id)->first();
                                        ?>
                                        <div class="row pt-1 pb-1">
                                            <div class="col-md-6">
                                                <h6 class="mb-2 fs-7 fw-bold">Product <?php echo $key + 1; ?></h6>
                                                <input type="text" class="form-control fs-7" name=""
                                                    placeholder="" value="{{ $presult->name }}" disabled />
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="mb-2 fs-7 fw-bold">Quantity</h6>
                                                <input type="text" class="form-control fs-7" name=""
                                                    placeholder="" value="{{ $item->quantity }}" disabled />
                                            </div>
                                        </div>
                                    @endforeach

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

                                    <h4 class="text-secondary-emphasis my-2 mt-3">Billing Details</h4>
                                    <hr class="my-1">
                                    <div class="row pt-1 pb-2">
                                        <div class="col-md-6">
                                            <h6 class="mb-2 fs-7 fw-bold">SubTotal</h6>
                                            <input class="form-control fs-7" type="text" id="" name=""
                                                value="{{ $data->sub_total }}" disabled>
                                        </div>
                                        <div class="col-md-6 position-relative">
                                            <h6 class="mb-2 fs-7 fw-bold">Eco Tax (8%)</h6>
                                            <input class="form-control fs-7" type="text" id="" name=""
                                                value="{{ $data->eco_tax }}" disabled>
                                        </div>
                                    </div>
                                    <div class="row pt-1 pb-2">
                                        <div class="col-md-6">
                                            <h6 class="mb-2 fs-7 fw-bold">VAT (20%)</h6>
                                            <input class="form-control fs-7" type="text" id="" name=""
                                                value="{{ $data->vat }}" disabled>
                                        </div>
                                        <div class="col-md-6 position-relative">
                                            <h6 class="mb-2 fs-7 fw-bold">Discount</h6>
                                            <input class="form-control fs-7" type="text" id="" name=""
                                                value="{{ $data->discount }}" disabled>
                                        </div>
                                    </div>
                                    <div class="row pt-1 pb-2">
                                        <div class="col-md-6">
                                            <h6 class="mb-2 fs-7 fw-bold">Total</h6>
                                            <input class="form-control fs-7" type="text" id="" name=""
                                                value="{{ $data->total_price }}" disabled>
                                        </div>
                                    </div>

                                    <h4 class="text-secondary-emphasis my-2 mt-3">Payment Details</h4>
                                    <hr class="my-1">
                                    <div class="row pt-1 pb-2">
                                        <div class="col-md-6">
                                            <h6 class="mb-2 fs-7 fw-bold">Payment Mode</h6>
                                            <input class="form-control fs-7" type="text" id=""
                                                name="" value="{{ $data->payment_mode }}" disabled>
                                        </div>
                                        <div class="col-md-6 position-relative">
                                            <h6 class="mb-2 fs-7 fw-bold">Order Date</h6>
                                            <input class="form-control fs-7" type="text" id=""
                                                name="" value="{{ date('j-M-y', strtotime($date)) }}" disabled>
                                        </div>
                                    </div>
                                    <div class="row pt-1 pb-2">
                                        <div class="col-md-6">
                                            <h6 class="mb-2 fs-7 fw-bold">Transanction Id</h6>
                                            <input class="form-control fs-7" type="text" id=""
                                                name="" value="" disabled>
                                        </div>
                                        <div class="col-md-6 position-relative">
                                            <h6 class="mb-2 fs-7 fw-bold">Order Status</h6>
                                            <select class="form-control form-select fs-7"
                                                aria-label="Default select example" name="order_status">
                                                <option {{ $data->order_status == 1 ? 'selected' : '' }}
                                                    value="1">Processing</option>
                                                <option {{ $data->order_status == 2 ? 'selected' : '' }}
                                                    value="2">Shipped</option>
                                                <option {{ $data->order_status == 3 ? 'selected' : '' }}
                                                    value="3">Delivered</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row pt-1 pb-2">
                                        <div class="col-md-6">
                                            <h6 class="mb-2 fs-7 fw-bold">Payment Status</h6>
                                            <select class="form-control form-select fs-7"
                                                aria-label="Default select example" name="payment_status">
                                                <option {{ $data->payment_status == 0 ? 'selected' : '' }}
                                                    value="0">Pending</option>
                                                <option {{ $data->payment_status == 1 ? 'selected' : '' }}
                                                    value="1">Paid</option>
                                                <option {{ $data->payment_status == 2 ? 'selected' : '' }}
                                                    value="2">Refunded</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row py-2">
                                        <div class="col-md-12 justify-content-center d-flex gap-2">
                                            <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                                class="btn btn-primary btn-md" name="edit-order">Update</button>
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
