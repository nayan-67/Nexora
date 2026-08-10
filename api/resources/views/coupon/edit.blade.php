@extends('layout.layout')

@section('title', 'Discount')
@section('discactive', 'active')


@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header py-2">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-4 align-items-center d-flex">
                        <h3 class="mb-0 page-head fs-4">Edit Coupon</h3>
                    </div>
                    <div class="col-sm-4 d-flex align-items-center justify-content-center">
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.coupon') }}">Coupon</a></li>
                            <li class="breadcrumb-item active page-head" aria-current="page">Edit Coupon</li>
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

            <!-- =========== Edit Discount Section ============== -->

            <section class="bg-body h-100 add-section" style="margin:0 10px;">
                <div class="container h-100  border-2 border-top border-primary rounded">
                    {{-- <h5 class="text-secondary my-2">Edit Discount</h5>
                    <hr class="my-1"> --}}
                    <form action="{{ route('coupon.update', $item->id) }}" method="post" onsubmit="return validate()"
                        novalidate>
                        @csrf
                        @method('PUT')
                        <div class="row py-3">
                            <div class="col-xl-10 mx-auto">
                                <div class="card-body">
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Coupon Code<span class="text-danger ps-1">*</span>
                                            </h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control fs-7" name="coupon_code"
                                                placeholder="Enter Coupon Code ..." value="{{ $item->coupon_code }}"
                                                required />
                                            <div class="name-error text-danger fs-7 mt-1"></div>
                                        </div>
                                    </div>
                                    <div class="row py-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Valid From</h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="date" class="form-control fs-7 valid-from" name="valid-from"
                                                value="{{ $item->valid_from }}" />
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
                                                value="{{ $item->valid_till }}" />
                                            <div class="valid-till-error text-danger fs-7 mt-1"></div>
                                            @error('valid-till')
                                                <div class="err text-danger fs-7 mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Type<span class="text-danger ps-1">*</span></h6>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-control form-select fs-7"
                                                aria-label="Default select example" name="type">
                                                <option value="1" {{ $item->type == '1' ? 'selected' : '' }}>PERCENTAGE
                                                </option>
                                                <option value="2" {{ $item->type == '2' ? 'selected' : '' }}>FLAT
                                                </option>
                                            </select>
                                            @error('type')
                                                <div class="err text-danger fs-7 mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row pt-3 pb-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Amount<span class="text-danger ps-1">*</span></h6>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" step="0.01" class="form-control fs-7 discount-value"
                                                name="discount_value" placeholder="Enter discount amount or percentage"
                                                value="{{ old('discount_value', $item->discount_value ?? $item->amount) }}"
                                                required />
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
                                                value="{{ old('max_discount', $item->max_discount) }}" />
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
                                                value="{{ old('minimum_order', $item->minimum_order) }}" />
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
                                                value="{{ old('usage_limit', $item->usage_limit) }}" />
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
                                                value="{{ old('usage_per_user', $item->usage_per_user) }}" />
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
                                                value="1"
                                                {{ old('first_order_only', $item->first_order_only) ? 'checked' : '' }} />
                                            <label for="first_order_only" class="ms-2 fs-7 text-muted">Only for customer's
                                                first order</label>
                                        </div>
                                    </div>

                                    <div class="row py-2">
                                        <div class="col-md-3">
                                            <h6 class="mb-0 fs-7 fw-bold">Description</h6>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea name="description" class="form-control fs-7" rows="3" placeholder="Optional description">{{ old('description', $item->description) }}</textarea>
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
                                                <option {{ $item->status == '1' ? 'selected' : '' }} value="1">Active
                                                </option>
                                                <option {{ $item->status == '0' ? 'selected' : '' }} value="0">
                                                    Inactive</option>
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
                                                class="btn btn-primary btn-md" name="edit-discount"
                                                id="update_coupon">Update</button>
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
        let nameInput = document.querySelector("input[name='coupon_code']");
        let validFrom = document.querySelector(".valid-from");
        let validTill = document.querySelector(".valid-till");
        let discountValueInput = document.querySelector(".discount-value");
        let nameError = document.querySelector(".name-error");
        let validFromError = document.querySelector(".valid-from-error");
        let validTillError = document.querySelector(".valid-till-error");
        let discountValueError = document.querySelector(".discount-value-error");

        function clearFieldError(field) {
            if (field) field.textContent = '';
        }

        function clearAllFieldErrors() {
            [nameError, validFromError, validTillError, discountValueError].forEach(clearFieldError);
        }

        function clearFieldValidation(field) {
            if (field) {
                field.style.borderColor = '';
                field.style.boxShadow = '';
            }
        }

        function clearAllFieldValidation() {
            [nameInput, validFrom, validTill, discountValueInput].forEach(clearFieldValidation);
        }

        function setInvalidField(input, errorField, message) {
            if (errorField) errorField.textContent = message;
            if (input) {
                input.style.borderColor = '#dc3545';
                input.style.boxShadow = '0 0 0 .2rem rgba(220,53,69,.25)';
            }
        }

        function validate() {
            let nameValue = nameInput.value.trim();
            let fromDate = validFrom.value;
            let tillDate = validTill.value;
            let discountValue = discountValueInput.value.trim();

            clearAllFieldErrors();
            clearAllFieldValidation();

            if (nameValue === '') {
                setInvalidField(nameInput, nameError, 'Name is required.');
                nameInput.focus();
                return false;
            }

            if (fromDate === '') {
                setInvalidField(validFrom, validFromError, 'Valid from date is required.');
                validFrom.focus();
                return false;
            }

            if (tillDate !== '' && tillDate < fromDate) {
                setInvalidField(validTill, validTillError, 'Valid till date cannot be before valid from date.');
                validTill.focus();
                return false;
            }

            if (discountValue === '' || Number(discountValue) <= 0) {
                setInvalidField(discountValueInput, discountValueError, 'Amount must be greater than zero.');
                discountValueInput.focus();
                return false;
            }

            return true;
        }

        let editBtn = document.getElementById("update_coupon");
        let loader = document.getElementById("loader");

        editBtn.addEventListener("click", () => {
            if (validate() && loader) {
                loader.classList.replace("d-none", "d-flex");
            }
        });
    </script>
@endsection
