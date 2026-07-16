@extends('layout.layout')

@section('title', 'Setting')
@section('sactive', 'active')

@section('css')
    <style>
        .pass-box {
            padding: 0.3rem 0.75rem !important;
            display: flex;
            align-items: center;
            justify-content: space-between;

            & input {
                width: 90%;
                border: none;
            }

            & i {
                cursor: pointer;
            }
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
                        <h3 class="mb-0 page-head fs-4">Setting</h3>
                    </div>
                    <div class="col-sm-4 d-flex align-items-center justify-content-center">
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active page-head" aria-current="page">Setting</li>
                        </ol>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->

            <!-- ====== Discount Section ======= -->
            @error('email')
                {{ toast($message, 'error') }}
            @enderror
            @error('password')
                {{ toast($message, 'error') }}
            @enderror
            <section class="bg-white h-100 page-section"
                style="margin:0 10px;border-radius: 10px;box-shadow: 0 0px 4px #00000057;">
                <div class="container h-100 border-2 border-top border-primary p-3 rounded">
                    <form action="{{ route('admin.update', $data->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row mx-1 py-3">
                            <div class="col-sm-6">
                                <h6 class="mb-2 page-head fs-7 fw-bold">Username (Admin Mail)</h6>
                                <input class="form-control me-2 fs-7" type="email" name="email"
                                    value="{{ $data->email }}" autocomplete="off" />
                            </div>
                            <div class="col-sm-6">
                                <h6 class="mb-2 page-head fs-7 fw-bold">Password</h6>
                                <div class="pass-box form-control">
                                    <input class="me-2 fs-7 bg-white" type="password" id="pass" name="password"
                                        value="{{ $data->password }}" autocomplete="off"
                                        style="outline: none;color:#212529;" />
                                    <i class="fa-regular fa-eye-slash show-btn"></i>
                                </div>
                            </div>
                        </div>
                        <div class="row mx-1">
                            <div class="col-sm-12 d-flex justify-content-end">
                                <button class="btn btn-success fs-7" type="submit" name="edit-admin">SAVE</button>
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
        let passInput = document.querySelector('#pass');
        let showBtn = document.querySelector('.show-btn');
        showBtn.addEventListener("click", () => {
            if (passInput.type == "password") {
                passInput.type = "text";
                showBtn.classList.replace('fa-eye-slash', 'fa-eye');
            } else {
                passInput.type = "password";
                showBtn.classList.replace('fa-eye', 'fa-eye-slash');
            }
        });
    </script>
@endsection
