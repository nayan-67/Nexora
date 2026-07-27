@extends('layout.layout')

@section('title', 'Customer')
@section('uactive', 'active')

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
            {{-- <section class="bg-body h-100 add-section" style="margin:0 10px;">
                <div class="container h-100  border-2 border-top border-primary rounded">
                    <form action="{{ route('user.update', $item->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row h-100 py-3">
                            <div class="col-xl-12 px-4">
                                <div class="card-body">
                                    <h4 class="text-secondary-emphasis my-2">Personal Details</h4>
                                    <hr class="my-1">
                                    <div class="row pt-1 pb-1">
                                        <div class="col-md-6">
                                            <h6 class="mb-2 fs-7 fw-bold">First Name</h6>
                                            <input type="text" class="form-control fs-7" name="f-name" placeholder=""
                                                value="{{ $item->first_name }}" readonly/>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="mb-2 fs-7 fw-bold">Last Name</h6>
                                            <input type="text" class="form-control fs-7" name="l-name" placeholder=""
                                                value="{{ $item->last_name }}" readonly/>
                                        </div>
                                    </div>
                                    <div class="row pt-1 pb-1">
                                        <div class="col-md-6">
                                            <h6 class="mb-2 fs-7 fw-bold">E-mail</h6>
                                            <input type="email" class="form-control fs-7" name="e-mail" placeholder=""
                                                value="{{ $item->email }}" readonly/>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="mb-2 fs-7 fw-bold">Phone</h6>
                                            <input type="text" class="form-control fs-7" name="phone" placeholder=""
                                                value="{{ $item->phone }}" readonly/>
                                        </div>
                                    </div>
                                    <div class="row pt-1 pb-1">
                                        <div class="col-md-6">
                                            <h6 class="mb-2 fs-7 fw-bold">Fax</h6>
                                            <input type="text" class="form-control fs-7" name="fax" placeholder=""
                                                value="{{ $item->fax }}" readonly/>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="mb-2 fs-7 fw-bold">Status</h6>
                                            <select class="form-control form-select fs-7"
                                                aria-label="Default select example" name="status">
                                                <option {{ $item->status == '1' ? 'selected' : '' }} value="1">
                                                    Active</option>
                                                <option {{ $item->status == '0' ? 'selected' : '' }}
                                                    value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    @foreach ($billingresult as $key => $add)
                                        <h4 class="text-secondary-emphasis my-2 mt-3">Address <?php echo ++$key; ?></h4>
                                        <hr class="my-1 mb-2">
                                        <div class="row pt-1 pb-2">
                                            <div class="col-md-6">
                                                <h6 class="mb-2 fs-7 fw-bold">Address Line 1</h6>
                                                <textarea class="form-control fs-7" rows="2" name="address1[]">{{ $add->address1 }}</textarea>
                                            </div>
                                            <div class="col-md-6 position-relative">
                                                <h6 class="mb-2 fs-7 fw-bold">Address Line 2</h6>
                                                <textarea class="form-control fs-7" rows="2" name="address2[]">{{ $add->address2 }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row pt-1 pb-2">
                                            <div class="col-md-6">
                                                <h6 class="mb-2 fs-7 fw-bold">Company</h6>
                                                <input class="form-control fs-7" type="text" id=""
                                                    name="company[]" value="{{ $add->company }}">
                                            </div>
                                            <div class="col-md-6 position-relative">
                                                <h6 class="mb-2 fs-7 fw-bold">city</h6>
                                                <input class="form-control fs-7" type="text" id=""
                                                    name="city[]" value="{{ $add->city }}">
                                            </div>
                                        </div>
                                        <div class="row pt-1 pb-2">
                                            <div class="col-md-6">
                                                <h6 class="mb-2 fs-7 fw-bold">Post Code</h6>
                                                <input class="form-control fs-7" type="text" id=""
                                                    name="pin[]" value="{{ $add->postcode }}">
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="mb-2 fs-7 fw-bold">Country</h6>
                                                <input class="form-control fs-7" type="text" id=""
                                                    name="country[]" value="{{ $add->country }}">
                                            </div>
                                        </div>
                                        <div class="row pt-1 pb-2">
                                            <div class="col-md-6">
                                                <h6 class="mb-2 fs-7 fw-bold">Region</h6>
                                                <input class="form-control fs-7" type="text" id=""
                                                    name="state[]" value="{{ $add->state }}">
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="row py-2">
                                        <div class="col-md-12 justify-content-center d-flex gap-2">
                                            <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                                class="btn btn-primary btn-md" name="edit-customer">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section> --}}
            <div class="container-fluid">
                <div class="row g-3">
                    <!-- Profile sidebar -->
                    <div class="col-md-3">
                        <!-- About card -->
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="rounded-circle bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center mb-3"
                                    style="width: 96px; height: 96px; font-size: 2rem" aria-hidden="true">
                                    JD
                                </div>
                                <h3 class="h5 mb-0">Jane Doe</h3>
                                <ul class="list-group list-group-flush text-start small">
                                    <li class="list-group-item d-flex justify-content-between px-0">
                                        <span class="text-secondary">Followers</span>
                                        <span class="fw-semibold">1,322</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between px-0">
                                        <span class="text-secondary">Following</span>
                                        <span class="fw-semibold">543</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between px-0">
                                        <span class="text-secondary">Friends</span>
                                        <span class="fw-semibold">13,287</span>
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
                                                <input type="text" class="form-control" id="profile-first"
                                                    value="{{ $item->first_name }}" readonly />
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="profile-last"> Last name </label>
                                                <input type="text" class="form-control" id="profile-last"
                                                    value="{{ $item->last_name }}" readonly />
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="profile-email"> Email </label>
                                                <input type="email" class="form-control" id="profile-email"
                                                    value="{{ $item->email }}" readonly />
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="profile-phone"> Phone </label>
                                                <input type="text" class="form-control" id="profile-phone"
                                                    value="{{ $item->phone }}" readonly />
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
                                                        <h3 class="card-title">Address {{ $key + 1 }}</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <label class="form-label" for="settings-name"> Full name
                                                                </label>
                                                                <input type="text" class="form-control"
                                                                    id="settings-name" value="Jane Doe" />
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label" for="settings-email"> Email
                                                                </label>
                                                                <input type="email" class="form-control"
                                                                    id="settings-email" value="jane@example.com" />
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label" for="settings-tz"> Time zone
                                                                </label>
                                                                <select class="form-select" id="settings-tz">
                                                                    <option>UTC</option>
                                                                    <option selected>America/Los_Angeles</option>
                                                                    <option>Europe/London</option>
                                                                    <option>Asia/Tokyo</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label" for="settings-lang"> Language
                                                                </label>
                                                                <select class="form-select" id="settings-lang">
                                                                    <option selected>English</option>
                                                                    <option>Español</option>
                                                                    <option>Français</option>
                                                                    <option>Deutsch</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-12">
                                                                <button type="submit" class="btn btn-primary">Save
                                                                    changes</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
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

                                    <!-- Timeline tab -->
                                    <div class="tab-pane fade" id="timeline" role="tabpanel"
                                        aria-labelledby="timeline-tab">
                                        <ul class="list-unstyled mb-0">
                                            <li class="d-flex gap-3 mb-3">
                                                <span
                                                    class="badge text-bg-success rounded-pill shrink-0 align-self-start mt-1">
                                                    <i class="bi bi-check-lg" aria-hidden="true"></i>
                                                </span>
                                                <div>
                                                    <p class="mb-0 fw-semibold">Released v2.4 of the design system</p>
                                                    <small class="text-secondary">May 16, 2026</small>
                                                </div>
                                            </li>
                                            <li class="d-flex gap-3 mb-3">
                                                <span
                                                    class="badge text-bg-info rounded-pill shrink-0 align-self-start mt-1">
                                                    <i class="bi bi-mic" aria-hidden="true"></i>
                                                </span>
                                                <div>
                                                    <p class="mb-0 fw-semibold">Spoke at the local UX meetup</p>
                                                    <small class="text-secondary">April 22, 2026</small>
                                                </div>
                                            </li>
                                            <li class="d-flex gap-3">
                                                <span
                                                    class="badge text-bg-warning rounded-pill shrink-0 align-self-start mt-1">
                                                    <i class="bi bi-briefcase" aria-hidden="true"></i>
                                                </span>
                                                <div>
                                                    <p class="mb-0 fw-semibold">
                                                        Joined the product team as Senior Designer
                                                    </p>
                                                    <small class="text-secondary">March 1, 2026</small>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Status tab -->
                                    <div class="tab-pane fade" id="status" role="tabpanel"
                                        aria-labelledby="status-tab">
                                        <form class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label" for="profile-first"> First name </label>
                                                <input type="text" class="form-control" id="profile-first"
                                                    value="Jane" />
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="profile-last"> Last name </label>
                                                <input type="text" class="form-control" id="profile-last"
                                                    value="Doe" />
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="profile-email"> Email </label>
                                                <input type="email" class="form-control" id="profile-email"
                                                    value="jane@example.com" />
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="profile-role"> Role </label>
                                                <input type="text" class="form-control" id="profile-role"
                                                    value="Product Designer" />
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label" for="profile-bio">Bio</label>
                                                <textarea class="form-control" id="profile-bio" rows="4">
                                                    Designer with a soft spot for design tokens and accessibility.
                                                </textarea>
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                                <button type="reset" class="btn btn-outline-secondary ms-1">
                                                    Cancel
                                                </button>
                                            </div>
                                        </form>
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
