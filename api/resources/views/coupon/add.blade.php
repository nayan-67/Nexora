@extends('layout.layout')

@section('title', 'Coupon')
@section('discactive', 'active')
@section('disaddactive', 'active')
@section('dismenuopen', 'menu-open')

@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header py-2">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-4 align-items-center d-flex">
                        <h3 class="mb-0 page-head fs-4">Add Coupon</h3>
                    </div>
                    <div class="col-sm-4 d-flex align-items-center justify-content-center">
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.coupon') }}">Coupon</a></li>
                            <li class="breadcrumb-item active page-head" aria-current="page">Add Coupon</li>
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

            <!-- =========== Add Coupon Section ============== -->
            <section class="bg-body h-100 add-section" style="margin:0 10px;">
                <div class="container h-100  border-2 border-top border-primary rounded">
                    {{-- <h5 class="text-secondary my-2">Add Coupon</h5>
                    <hr class="my-1"> --}}
                    <form action="{{ route('coupon.store') }}" method="post" onsubmit="return validate()" novalidate>
                        @csrf
                        <div class="row py-3">
                            <div class="col-xl-10 mx-auto">
                                <div class="card-body">
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Coupon Code<span class="text-danger ps-1">*</span>
                                            </h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control fs-7 coupon-code text-uppercase"
                                                name="coupon_code" placeholder="COUPON2026" value="{{ old('coupon_code') }}"
                                                required />
                                            <div class="coupon-code-error text-danger fs-7 mt-1"></div>
                                            @error('coupon_code')
                                                <div class="err text-danger fs-7 mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row py-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Valid From<span class="text-danger ps-1">*</span>
                                            </h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="date" class="form-control fs-7 valid-from" name="valid-from"
                                                value="{{ old('valid-from') }}" />
                                            <div class="valid-from-error text-danger fs-7 mt-1"></div>
                                            @error('valid-from')
                                                <div class="err text-danger fs-7 mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row py-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Valid Till</h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="date" class="form-control fs-7 valid-till" name="valid-till"
                                                value="{{ old('valid-till') }}" />
                                            @error('valid-till')
                                                <div class="err text-danger fs-7 mb-n3">Enter Valid Date</div>
                                            @enderror
                                            <div class="valid-till-error text-danger fs-7 mt-1"></div>
                                        </div>
                                    </div>
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Type<span class="text-danger ps-1">*</span></h6>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-control form-select fs-7"
                                                aria-label="Default select example" name="type">
                                                <option selected value="1">Percentage</option>
                                                <option value="2">Flat</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Discount Value<span
                                                    class="text-danger ps-1">*</span></h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" step="0.01" class="form-control fs-7 discount-value"
                                                name="discount_value" placeholder="Enter discount amount or percentage"
                                                value="{{ old('discount_value') }}" />
                                            <div class="discount-value-error text-danger fs-7 mt-1"></div>
                                            @error('discount_value')
                                                <div class="err text-danger fs-7 mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row py-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Max Discount</h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" step="0.01" class="form-control fs-7"
                                                name="max_discount" placeholder="Maximum discount amount (optional)"
                                                value="{{ old('max_discount') }}" />
                                            @error('max_discount')
                                                <div class="err text-danger fs-7 mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row py-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Minimum Order</h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" step="0.01" class="form-control fs-7"
                                                name="minimum_order" placeholder="Minimum order value to apply coupon"
                                                value="{{ old('minimum_order') }}" />
                                            @error('minimum_order')
                                                <div class="err text-danger fs-7 mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row py-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Usage Limit</h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control fs-7" name="usage_limit"
                                                placeholder="Total usage limit (optional)"
                                                value="{{ old('usage_limit') }}" />
                                            @error('usage_limit')
                                                <div class="err text-danger fs-7 mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row py-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Usage Per User</h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control fs-7" name="usage_per_user"
                                                placeholder="Usage limit per user (optional)"
                                                value="{{ old('usage_per_user') }}" />
                                            @error('usage_per_user')
                                                <div class="err text-danger fs-7 mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row py-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">First Order Only</h6>
                                        </div>
                                        <div class="col-md-9 d-flex align-items-center">
                                            <input type="checkbox" name="first_order_only" id="first_order_only"
                                                value="1" {{ old('first_order_only') ? 'checked' : '' }} />
                                            <label for="first_order_only" class="ms-2 fs-7 text-muted">Only for customer's
                                                first order</label>
                                        </div>
                                    </div>

                                    <div class="row py-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Description</h6>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea name="description" class="form-control fs-7" rows="3" placeholder="Optional description">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="err text-danger fs-7 mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row py-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Status</h6>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-control form-select fs-7"
                                                aria-label="Default select example" name="status">
                                                <option selected value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                            @error('status')
                                                <div class="err text-danger fs-7 mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row py-2">
                                        <div class="col-md-3">
                                        </div>
                                        <div class="col-md-9 justify-content-center d-flex gap-2">
                                            <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                                class="btn btn-primary btn-md" name="add-discount" id="add_discount">Add
                                                Coupon</button>
                                            <button type="reset" data-mdb-button-init data-mdb-ripple-init
                                                class="btn btn-warning btn-md" name="reset">Reset</button>
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
        let couponCodeInput = document.querySelector(".coupon-code");
        let validFrom = document.querySelector(".valid-from");
        let validTill = document.querySelector(".valid-till");
        let discountValueInput = document.querySelector(".discount-value");
        let couponCodeError = document.querySelector(".coupon-code-error");
        let validFromError = document.querySelector(".valid-from-error");
        let validTillError = document.querySelector(".valid-till-error");
        let discountValueError = document.querySelector(".discount-value-error");
        let addBtn = document.getElementById("add_discount");
        let loader = document.getElementById("loader");
        let couponForm = document.querySelector("form");

        const date = new Date();
        if (!validFrom.value) {
            validFrom.value = date.toISOString().slice(0, 10);
        }

        function clearFieldError(field) {
            if (field) {
                field.textContent = '';
            }
        }

        function clearAllFieldErrors() {
            [couponCodeError, validFromError, validTillError, discountValueError].forEach(field => {
                clearFieldError(field);
            });
        }

        function setInvalidField(input, errorField, message) {
            if (errorField) {
                errorField.textContent = message;
            }
            if (input) {
                input.classList.add('is-invalid');
                input.style.borderColor = '#dc3545';
                input.style.boxShadow = '0 0 0 .2rem rgba(220,53,69,.25)';
            }
        }

        function clearFieldValidation(field) {
            if (field) {
                field.classList.remove('is-invalid');
                field.style.borderColor = '';
                field.style.boxShadow = '';
            }
        }

        function clearAllFieldValidation() {
            [couponCodeInput, validFrom, validTill, discountValueInput].forEach(field => {
                clearFieldValidation(field);
            });
        }

        function validate() {
            let couponCode = couponCodeInput.value.trim();
            let fromDate = validFrom.value;
            let tillDate = validTill.value;
            let discountValue = discountValueInput.value.trim();

            clearAllFieldErrors();
            clearAllFieldValidation();

            if (couponCode === "") {
                setInvalidField(couponCodeInput, couponCodeError, 'Coupon code is required.');
                couponCodeInput.focus();
                return false;
            }

            if (fromDate === "") {
                setInvalidField(validFrom, validFromError, 'Valid from date is required.');
                validFrom.focus();
                return false;
            }

            if (tillDate !== "" && tillDate < fromDate) {
                setInvalidField(validTill, validTillError, 'Valid till date cannot be before valid from date.');
                validTill.focus();
                return false;
            }

            if (discountValue === "" || Number(discountValue) <= 0) {
                setInvalidField(discountValueInput, discountValueError, 'Discount value must be greater than zero.');
                discountValueInput.focus();
                return false;
            }

            return true;
        }

        couponForm?.addEventListener("submit", (event) => {
            if (!validate()) {
                event.preventDefault();
            } else {
                loader.classList.replace("d-none", "d-flex");
            }
        });

        // addBtn?.addEventListener("click", (event) => {
        //     if (!validate()) {
        //         event.preventDefault();
        //     }
        // });
    </script>
@endsection
