@extends('layout.layout')

@section('title', 'Customer')
@section('uactive', 'active')

@section('css')
    <style>
        .order-box {
            transition: all .5s;
        }

        .order-box.close {
            height: 0;
            overflow: hidden;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
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
                        <h3 class="mb-0 page-head fs-4">Customer</h3>
                    </div>
                    <div class="col-sm-4 d-flex align-items-center justify-content-center">
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.user') }}">Customer</a></li>
                            <li class="breadcrumb-item active page-head" aria-current="page">Customer Order</li>
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

            <!-- ========= Modal ============ -->

            <div class="delete-modal" id="del-modal">
                <div class="delete-modal-dialog rounded-3">

                    <!-- Modal content-->
                    <div class="row modal-top d-flex align-items-center px-4 py-3">
                        <div class="col-sm-3 fs-1">
                            <i class="fa-solid fa-triangle-exclamation text-danger"></i>
                        </div>
                        <div class=" col-sm-9 m-content">
                            <h5 class="p-0 m-0 fw-bold">DELETE ORDER</h5>
                            <p class="p-0 m-0">This action cannot be undone.</p>
                        </div>
                    </div>
                    <hr class="m-0 text-secondery opacity-10">
                    <div class="row modal-btn d-flex align-items-center justify-content-space-between px-4 py-3">
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-outline-secondary btn-md w-100 shadow-sm del-close"
                                name="">CANCEL</button>
                        </div>
                        <form action="{{ route('order.delete') }}" method="POST" class=" col-sm-6 m-content">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" id="modal-id" value="" name="id">
                            <input type="submit" class="btn btn-danger btn-md w-100 shadow-sm" value="DELETE">
                        </form>
                    </div>

                </div>
            </div>

            <!-- =========== Customer Order Section ============== -->
            
            <section class="bg-body h-100 add-section" style="margin:0 10px;">
                <div class="container h-100 border-2 border-top border-primary rounded pb-5">
                    <h6 class="text-secondary my-2 mb-3">Customer Order</h6>
                    <div class="row h-100 border-2 border-top border-primary rounded shadow"
                        style="margin:0 10px;overflow:hidden;">
                        @if (count($data) > 0)
                            @foreach ($data as $ordkey => $ord)
                                <?php
                                $ord_id = $ord->id;
                                
                                $create = $ord->created_at;
                                $date = substr($create, 0, 10);
                                
                                $bill_id = $ord->billing_address_id;
                                $ship_id = $ord->shipping_address_id;
                                
                                $billingresult = DB::table('address')->where('id', $bill_id)->first();
                                $shippingresult = DB::table('address')->where('id', $ship_id)->first();
                                
                                $billingaddress = $billingresult->address1 . ', ' . $billingresult->city . ', ' . $billingresult->postcode . ', ' . $billingresult->state . ', ' . $billingresult->country;
                                
                                $shippingaddress = $shippingresult->address1 . ', ' . $shippingresult->city . ', ' . $shippingresult->postcode . ', ' . $shippingresult->state . ', ' . $shippingresult->country;
                                
                                $prdresult = DB::table('order_product')->where('order_id', $ord_id)->get();
                                $subtotal = 0;
                                ?>

                                <div class="col-xl-12 p-0">
                                    <h6 class="text-primary py-2 ps-3 m-0 order-h6" style="cursor: pointer;">Order
                                        <?php echo ++$ordkey; ?></h6>
                                    <hr class="m-0">
                                    <div class="card-body px-3 py-1 order-box close">
                                        @foreach ($prdresult as $key => $item)
                                            <?php
                                            $p_id = $item->product_id;
                                            $presult = DB::table('products')->where('id', $p_id)->first();
                                            $subtotal += $presult->price * $item->quantity;
                                            ?>
                                            <div class="row pt-1 pb-1">
                                                <div class="col-md-6">
                                                    <h6 class="mb-2 fs-7 fw-bold">Product <?php echo $key + 1; ?></h6>
                                                    <input type="text" class="form-control fs-7" name=""
                                                        placeholder="" value="<?php echo htmlspecialchars($presult->name); ?>" disabled />
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="mb-2 fs-7 fw-bold">Quantity</h6>
                                                    <input type="text" class="form-control fs-7" name=""
                                                        placeholder="" value="<?php echo htmlspecialchars($item->quantity); ?>" disabled />
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="row pt-1 pb-2">
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
                                            <div class="col-md-6">
                                                <h6 class="mb-2 fs-7 fw-bold">SubTotal</h6>
                                                <input class="form-control fs-7" type="text" id=""
                                                    name="" value="{{ $subtotal }}" disabled>
                                            </div>
                                            <div class="col-md-6 position-relative">
                                                <h6 class="mb-2 fs-7 fw-bold">Eco Tax (-2.00)</h6>
                                                <input class="form-control fs-7" type="text" id=""
                                                    name="" value="{{ $ord->eco_tax }}" disabled>
                                            </div>
                                        </div>
                                        <div class="row pt-1 pb-2">
                                            {{-- <div class="col-md-6">
                                                <h6 class="mb-2 fs-7 fw-bold">VAT (20%)</h6>
                                                <input class="form-control fs-7" type="text" id=""
                                                    name="" value="{{ $ord->vat }}" disabled>
                                            </div> --}}
                                            <div class="col-md-6 position-relative">
                                                <h6 class="mb-2 fs-7 fw-bold">Total</h6>
                                                <input class="form-control fs-7" type="text" id=""
                                                    name="" value="{{ $ord->total_price }}" disabled>
                                            </div>
                                        </div>
                                        <div class="row pt-1 pb-2">
                                            <div class="col-md-6">
                                                <h6 class="mb-2 fs-7 fw-bold">Payment Mode</h6>
                                                <input class="form-control fs-7" type="text" id=""
                                                    name="" value="{{ $ord->payment_mode }}" disabled>
                                            </div>

                                            <div class="col-md-6">
                                                <h6 class="mb-2 fs-7 fw-bold">Payment Status</h6>
                                                <input class="form-control fs-7" type="text" id=""
                                                    name="" value="{{ $ord->payment_status }}" disabled>
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
                                                <input class="form-control fs-7" type="text" id=""
                                                    name="" value="{{ $ord->order_status }}" disabled>
                                            </div>
                                        </div>
                                        <div class="row pt-1 pb-2">
                                            <div class="col-md-6 position-relative">
                                                <h6 class="mb-2 fs-7 fw-bold">Order Date</h6>
                                                <input class="form-control fs-7" type="text" id=""
                                                    name="" value="{{ date('j-M-y', strtotime($date)) }}"
                                                    disabled>
                                            </div>
                                        </div>

                                        <div class="row py-2" style="border-bottom: 1px solid #ccc;">
                                            <div class="col-md-12 justify-content-end d-flex gap-2">
                                                <a href='{{ route('order.edit', encrypt($ord->id)) }}'
                                                    class='btn btn-success fs-7 p-3 text-white d-flex align-items-center gap-1'
                                                    style='height: 25px;'><i
                                                        class='fa-regular fa-pen-to-square'></i>EDIT</a>
                                                <button type='button'
                                                    class='btn btn-danger fs-7 p-3 text-white d-flex align-items-center gap-1'
                                                    style='height: 25px;' onclick="openModal('{{ $ord->id }}');"><i
                                                        class='fa-regular fa-trash-can'></i>DELETE</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-xl-12 p-0">
                                <h5 class="text-center text-secondary mt-3">No Order Found</h5>
                            </div>
                        @endif

                    </div>
                </div>
            </section>

            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            itemBox[0].classList.remove("close");
        });
        let item = document.querySelectorAll(".order-h6");
        let itemBox = document.querySelectorAll(".order-box");

        item.forEach((v, i) => {
            v.addEventListener("click", () => {
                if (itemBox[i].classList.contains('close')) {
                    itemBox[i].classList.remove('close');
                } else {
                    itemBox[i].classList.add('close');
                }
            });
        });
    </script>
@endsection
