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
            {{-- <section class="bg-white h-100 page-section"
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
            </section> --}}

            <div class="container-fluid">
                <div class="row g-3">
                    <!-- Left rail -->
                    <div class="col-md-3">
                        <div class="list-group list-group-flush nav nav-pills flex-column" id="settings-nav" role="tablist">
                            <a href="#account" class="list-group-item list-group-item-action active" data-bs-toggle="pill"
                                role="tab" aria-selected="true">
                                <i class="bi bi-person me-2" aria-hidden="true"></i>Account
                            </a>
                            <a href="#notifications" class="list-group-item list-group-item-action" data-bs-toggle="pill"
                                role="tab">
                                <i class="bi bi-bell me-2" aria-hidden="true"></i>Notifications
                            </a>
                        </div>
                    </div>

                    <!-- Tab content -->
                    <div class="col-md-9">
                        <div class="tab-content">
                            <!-- Account -->
                            <div class="tab-pane fade show active" id="account" role="tabpanel">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Account</h3>
                                    </div>
                                    <div class="card-body">
                                        <form class="row g-3" action="{{ route('admin.update', $data->id) }}"
                                            method="post">
                                            @csrf
                                            @method('PUT')
                                            <div class="col-md-6">
                                                <label class="form-label" for="settings-email"> Email (Admin) </label>
                                                <input type="email" class="form-control" id="settings-email" name="email"
                                                    value="{{ $data->email }}" />
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="pass"> Password </label>
                                                <div class="pass-box form-control">
                                                    <input class="me-2 fs-7 bg-body" type="password" id="pass"
                                                        name="password" value="{{ $data->password }}" autocomplete="off"
                                                        style="outline: none;" />
                                                    <i class="fa-regular fa-eye-slash show-btn"></i>
                                                </div>
                                            </div>
                                            <div class="col-12 text-end">
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Notifications -->
                            <div class="tab-pane fade" id="notifications" role="tabpanel">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Notifications</h3>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-secondary">Choose what to be notified about.</p>
                                        <div class="d-flex justify-content-between align-items-start py-2 border-bottom">
                                            <div>
                                                <p class="mb-0 fw-semibold">Product updates</p>
                                                <small class="text-secondary">Major releases and changelogs</small>
                                            </div>
                                            <div class="form-check form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="notif-0" checked />
                                                <label class="visually-hidden" for="notif-0">
                                                    Toggle Product updates
                                                </label>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-start py-2 border-bottom">
                                            <div>
                                                <p class="mb-0 fw-semibold">Security alerts</p>
                                                <small class="text-secondary">Sign-in attempts and account changes</small>
                                            </div>
                                            <div class="form-check form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="notif-1" checked />
                                                <label class="visually-hidden" for="notif-1">
                                                    Toggle Security alerts
                                                </label>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-start py-2 border-bottom">
                                            <div>
                                                <p class="mb-0 fw-semibold">Weekly digest</p>
                                                <small class="text-secondary">A summary of activity in your
                                                    workspace</small>
                                            </div>
                                            <div class="form-check form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="notif-2" />
                                                <label class="visually-hidden" for="notif-2">
                                                    Toggle Weekly digest
                                                </label>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-start py-2 border-bottom">
                                            <div>
                                                <p class="mb-0 fw-semibold">Mentions</p>
                                                <small class="text-secondary">When a teammate @mentions you</small>
                                            </div>
                                            <div class="form-check form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="notif-3" />
                                                <label class="visually-hidden" for="notif-3"> Toggle Mentions </label>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary mt-3">Save preferences</button>
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
