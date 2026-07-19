@extends('layout.layout')

@section('title', 'Category')
@section('cactive', 'active')
@section('catlactive', 'active')
@section('catmenuopen', 'menu-open')

@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header py-2">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-4 align-items-center d-flex">
                        <h3 class="mb-0 page-head fs-4">Category</h3>
                    </div>
                    <div class="col-sm-4 d-flex align-items-center justify-content-center">
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active page-head" aria-current="page">Category</li>
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
                            <h5 class="p-0 m-0 fw-bold">DELETE CATEGORY</h5>
                            <p class="p-0 m-0">This action cannot be undone.</p>
                        </div>
                    </div>
                    <hr class="m-0 text-secondery opacity-10">
                    <div class="row modal-btn d-flex align-items-center justify-content-space-between px-4 py-3">
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-outline-secondary btn-md w-100 shadow-sm del-close"
                                name="add-subpage">CANCEL</button>
                        </div>
                        <form action="{{ route('category.destroy') }}" method="POST" class=" col-sm-6 m-content">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" id="modal-id" value="" name="id">
                            <input type="submit" class="btn btn-danger btn-md w-100 shadow-sm" value="DELETE">
                        </form>
                    </div>
                </div>
            </div>


            <!-- ====== Category Section ======= -->

            <section class="bg-white h-100 page-section" style="margin:0 10px;">
                <div class="container h-100  border-2 border-top border-primary p-0 rounded">
                    <div class="row mx-1 py-3">
                        <div class="col-sm-2 d-flex align-items-center">
                            <h6 class="page-head fs-7 fw-bold">Category Name</h6>
                        </div>
                        <div class="col-sm-8">
                            <form class="d-flex" role="search" action="javascript:void(0)">
                                <input class="form-control me-2 fs-7" type="search" placeholder="Search.."
                                    aria-label="Search" id="search" value="" autocomplete="off" />
                                {{-- <button class="btn btn-success fs-7" type="submit"><i
                                        class="fa-solid fa-magnifying-glass"></i></button> --}}
                            </form>
                        </div>
                    </div>
                    <div class="container w-auto border-2 border-top border-primary mx-2 py-2">
                        {{-- <div class="">
                            <button type="button" class="btn btn-success add-btn fs-7">
                                <i class="fa-solid fa-plus fs-8"></i>
                                Add New
                            </button>
                        </div> --}}
                        <div class="page-deatails">
                            {{-- <hr class="m-2 text-secondery opacity-10"> --}}
                            <div class="header row fs-7">
                                <div class="col-sm-2 text-center fw-bold">Category Name</div>
                                <div class="col-sm-2 text-center fw-bold">Slug</div>
                                <div class="col-sm-1 text-center fw-bold">Order</div>
                                <div class="col-sm-1 text-center fw-bold">Status</div>
                                <div class="col-sm-2 text-center fw-bold">Total Product</div>
                                <div class="col-sm-2 text-center fw-bold">Number of Sub-Category</div>
                                <div class="col-sm-2 text-center fw-bold">Action</div>
                            </div>
                            <div class="results">
                                @if (count($catdata) > 0)
                                    @foreach ($catdata as $row)
                                        <?php
                                        $sub_cat = DB::table('sub_category')->where('category_id', $row->id)->get();
                                        ?>
                                        <hr class='m-2 text-body-tertiary opacity-10'>
                                        <div class='row fs-7'>
                                            <div
                                                class='col-sm-2 text-center d-flex align-items-center justify-content-center'>
                                                {{ $row->name }}
                                            </div>
                                            <div
                                                class='col-sm-2 text-center d-flex align-items-center justify-content-center'>
                                                {{ $row->slug }}
                                            </div>
                                            <div
                                                class='col-sm-1 text-center d-flex align-items-center justify-content-center'>
                                                {{ $row->order_number }}
                                            </div>
                                            <div
                                                class='col-sm-1 text-center d-flex align-items-center justify-content-center'>
                                                <span
                                                    class='list-badge {{ $row->status == '1' ? 'active' : 'inactive' }}'>{{ $row->status == '1' ? 'Active' : 'Inactive' }}</span>
                                            </div>
                                            <div
                                                class='col-sm-2 text-center d-flex align-items-center justify-content-center'>
                                                {{ $row->total_products }}
                                            </div>
                                            <div
                                                class='col-sm-2 text-center d-flex align-items-center justify-content-center'>
                                                {{ count($sub_cat) }}
                                            </div>
                                            <div class='col-sm-2 text-center d-flex gap-2 justify-content-center'>
                                                <a href="{{ route('category.edit', encrypt($row->id)) }}"
                                                    class='btn btn-info fs-8 px-2 py-0 text-white d-flex align-items-center gap-1'
                                                    style='height: 25px;'><i
                                                        class='fa-regular fa-pen-to-square'></i>EDIT</a>
                                                <button type='button'
                                                    class='btn btn-danger fs-8 px-2 py-0 text-white d-flex align-items-center gap-1'
                                                    style='height: 25px;' onclick="openModal('{{ $row->id }}');"><i
                                                        class='fa-regular fa-trash-can'></i>DELETE</button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <hr class='m-2 text-body-tertiary opacity-10'>
                                    <div class='row fs-7'>
                                        <div class='col-sm-12 text-center'>No Category Found</div>
                                    </div>
                                @endif
                            </div>

                        </div>
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
        let appUrl = <?= json_encode(url('/')) ?>;

        const searchInput = document.getElementById('search');
        const resultsDiv = document.querySelector('.results');

        searchInput.addEventListener('input', () => {
            const query = searchInput.value.trim() == "" ? '0' : searchInput.value.trim();
            setTimeout(() => {
                fetch(`${appUrl}/category/search/${query}`)
                    .then(response => response.text())
                    .then(data => {
                        resultsDiv.innerHTML = data;
                    })
                    .catch(error => console.error('Error:', error));
            }, 500);
        });

    </script>
@endsection
