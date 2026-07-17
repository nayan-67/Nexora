@extends('layout.layout')

@section('title', 'Product')
@section('plactive', 'active')
@section('pactive', 'active')
@section('pmenuopen', 'menu-open')



@section('css')
    <style>
        .imginput::-webkit-file-upload-button {
            visibility: hidden;
        }

        .imginput::before {
            content: 'Choose Image Above 600 x 600 px';
            display: inline-block;
            background: #eeeeeee0;
            padding: 0.45rem;
            margin-right: -4rem;
        }

        .form-check-input:checked {
            background-color: #495057 !important;
            border-color: #495057 !important;
        }

        input:active {
            outline: none !important;
        }

        .gimage {
            position: relative;

            & img {
                height: 80px;
                filter: drop-shadow(0 0 2px #000000d3);
            }
        }

        .fa-xmark {
            color: #862828;
            position: absolute;
            top: 0;
            right: 0;
            cursor: pointer;
            backdrop-filter: blur(10px);
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
                        <h3 class="mb-0 page-head fs-4">Product</h3>
                    </div>
                    <div class="col-sm-4 d-flex align-items-center justify-content-center">
                    </div>
                    <div class="col-sm-4">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active page-head" aria-current="page">Product</li>
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

            <!-- =========== Modal ============ -->

            <div class="delete-modal" id="del-modal">
                <div class="delete-modal-dialog rounded-3">

                    <!-- Modal content-->
                    <div class="row modal-top d-flex align-items-center px-4 py-3">
                        <div class="col-sm-3 fs-1">
                            <i class="fa-solid fa-triangle-exclamation text-danger"></i>
                        </div>
                        <div class=" col-sm-9 m-content">
                            <h5 class="p-0 m-0 fw-bold">DELETE PRODUCT</h5>
                            <p class="p-0 m-0">This action cannot be undone.</p>
                        </div>
                    </div>
                    <hr class="m-0 text-secondery opacity-10">
                    <div class="row modal-btn d-flex align-items-center justify-content-space-between px-4 py-3">
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-outline-secondary btn-md w-100 shadow-sm del-close"
                                name="">CANCEL</button>
                        </div>
                        <form action="{{ route('product.destroy') }}" method="POST" class=" col-sm-6 m-content">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" id="modal-id" value="" name="id">
                            <input type="submit" class="btn btn-danger btn-md w-100 shadow-sm" value="DELETE">
                        </form>
                    </div>

                </div>
            </div>


            <!-- ====== Product Section ======= -->

            <section class="bg-white h-100 page-section" style="margin:0 10px;">
                <div class="container h-100  border-2 border-top border-primary p-0 rounded">
                    {{-- <div class="d-flex align-items-center justify-content-center py-2" style="gap:1px;">
                        <button type="button" class="btn s-btn fs-8" value="">ALL</button>
                        <button type="button" class="btn s-btn fs-8" value="A">A</button>
                        <button type="button" class="btn s-btn fs-8" value="B">B</button>
                        <button type="button" class="btn s-btn fs-8" value="C">C</button>
                        <button type="button" class="btn s-btn fs-8" value="D">D</button>
                        <button type="button" class="btn s-btn fs-8" value="E">E</button>
                        <button type="button" class="btn s-btn fs-8" value="F">F</button>
                        <button type="button" class="btn s-btn fs-8" value="G">G</button>
                        <button type="button" class="btn s-btn fs-8" value="H">H</button>
                        <button type="button" class="btn s-btn fs-8" value="I">I</button>
                        <button type="button" class="btn s-btn fs-8" value="J">J</button>
                        <button type="button" class="btn s-btn fs-8" value="K">K</button>
                        <button type="button" class="btn s-btn fs-8" value="L">L</button>
                        <button type="button" class="btn s-btn fs-8" value="M">M</button>
                        <button type="button" class="btn s-btn fs-8" value="N">N</button>
                        <button type="button" class="btn s-btn fs-8" value="O">O</button>
                        <button type="button" class="btn s-btn fs-8" value="P">P</button>
                        <button type="button" class="btn s-btn fs-8" value="Q">Q</button>
                        <button type="button" class="btn s-btn fs-8" value="R">R</button>
                        <button type="button" class="btn s-btn fs-8" value="S">S</button>
                        <button type="button" class="btn s-btn fs-8" value="T">T</button>
                        <button type="button" class="btn s-btn fs-8" value="U">U</button>
                        <button type="button" class="btn s-btn fs-8" value="V">V</button>
                        <button type="button" class="btn s-btn fs-8" value="W">W</button>
                        <button type="button" class="btn s-btn fs-8" value="X">X</button>
                        <button type="button" class="btn s-btn fs-8" value="Y">Y</button>
                        <button type="button" class="btn s-btn fs-8" value="Z">Z</button>
                    </div>
                    <hr class="m-0"> --}}
                    <div class="row mx-1 py-3">
                        <div class="col-sm-2 d-flex align-items-center">
                            <h6 class="page-head fs-7 fw-bold">Product Name</h6>
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
                        {{-- <div class="btn-section d-flex justify-content-end">
                            <a href="{{ route('product.add') }}" class="btn btn-success add-btn fs-7">
                                <i class="fa-solid fa-plus fs-8"></i>
                                Add New
                            </a>
                        </div> --}}
                        <div class="page-deatails pt-2">
                            {{-- <hr class="m-2 text-secondery opacity-10"> --}}
                            <div class="header row fs-7">
                                <div class="col-sm-3 text-center fw-bold">Product Name</div>
                                <div class="col-sm-2 text-center fw-bold">Category Name</div>
                                <div class="col-sm-2 text-center fw-bold">Sub Category Name</div>
                                <div class="col-sm-1 text-center fw-bold">($)Price</div>
                                <div class="col-sm-1 text-center fw-bold">Type</div>
                                <div class="col-sm-1 text-center fw-bold">Total Stock</div>
                                <div class="col-sm-2 text-center fw-bold">Action</div>
                            </div>
                            <div class="results">
                                <?php if (count($data) > 0):
                                        foreach ($data as $row):
                                        $cat=DB::table('category')->where('id',$row->category_id)->first();
                                        $subcat=DB::table('sub_category')->where('id',$row->sub_category_id)->first();
                                        if ($row->type==2) {
                                            $stock=DB::table('variants')->where('product_id',$row->id)->sum('stock');
                                        }else{
                                            $stock=$row->stock;
                                        }
                                        ?>
                                <hr class='m-2 text-body-tertiary opacity-10'>
                                <div class='row fs-7'>
                                    <div class='col-sm-3 text-center d-flex align-items-center justify-content-center'>
                                        {{ $row->name }}</div>
                                    <div class='col-sm-2 text-center d-flex align-items-center justify-content-center'>
                                        {{ $cat->name }}</div>
                                    <div class='col-sm-2 text-center d-flex align-items-center justify-content-center'>
                                        {{ $subcat->name }}</div>
                                    <div class='col-sm-1 text-center d-flex align-items-center justify-content-center'>
                                        {{ $row->sale_price ?? $row->price }}</div>
                                    <div class='col-sm-1 text-center d-flex align-items-center justify-content-center'>
                                        {{ $row->type == '1' ? 'Simple' : 'Variable' }}</div>
                                    <div
                                        class='col-sm-1 text-center d-flex align-items-center justify-content-center {{ $stock > 0 ? 'text-success' : 'text-danger' }}'>
                                        {{ $stock }}
                                    </div>
                                    <div class='col-sm-2 text-center d-flex gap-2 justify-content-center'>
                                        <a href='{{ route('product.edit', encrypt($row->id)) }}'
                                            class='btn btn-info fs-8 px-2 py-0 text-white d-flex align-items-center gap-1'
                                            style='height: 25px;'><i class='fa-regular fa-pen-to-square'></i>EDIT</a>
                                        <button type='button'
                                            class='btn btn-danger fs-8 px-2 py-0 text-white d-flex align-items-center gap-1'
                                            style='height: 25px;' onclick="openModal('{{ $row->id }}');"><i
                                                class='fa-regular fa-trash-can'></i>DELETE</button>
                                    </div>
                                </div>
                                <?php endforeach;
                                    else: ?>
                                <hr class='m-2 text-body-tertiary opacity-10'>
                                <div class='row fs-7'>
                                    <div class='col-sm-12 text-center'>No Product Found</div>
                                </div>
                                <?php endif; ?>
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
        // let addBtn = document.querySelector(".add-btn");
        // let pageSection = document.querySelector(".page-section");
        // let addSection = document.querySelector(".add-section");

        // addBtn.addEventListener("click", () => {
        //     pageSection.style.display = "none";
        //     addSection.style.display = "block";
        // });
        const appURL = <?= json_encode(url('/')) ?>;

        const searchInput = document.getElementById('search');
        const resultsDiv = document.querySelector('.results');

        searchInput.addEventListener('input', () => {
            const query = searchInput.value != "" ? searchInput.value : '0';
            fetch(`${appURL}/product/search/${encodeURIComponent(query)}`)
                .then(response => response.text())
                .then(data => {
                    resultsDiv.innerHTML = data;
                })
                .catch(error => console.error('Error:', error));
        });

        const sBtn = document.querySelectorAll(".s-btn");

        sBtn.forEach(btn => {
            btn.style.background = "#198754";
            btn.style.color = "#fff";
            btn.addEventListener("click", () => {
                searchInput.value = "";
                sBtn.forEach(button => {
                    button.style.background = "#198754";
                });
                const btnVal = btn.value != "" ? btn.value : '0';
                fetch(`${appURL}/product/search/${btnVal}`)
                    .then(response => response.text())
                    .then(data => {
                        resultsDiv.innerHTML = data;
                    })
                    .catch(error => console.error('Error:', error));

                btn.style.background = "#196d54";
            });
        });
    </script>

@endsection
