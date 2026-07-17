<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="#" class="brand-link">
            <!--begin::Brand Image-->
            <img src="{{ asset('adminlte/dist/assets/img/nexora-logo2.svg') }}" alt="Nexora Logo"
                class="brand-image opacity-75 shadow" />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            {{-- <span class="brand-text fw-light">Admin</span> --}}
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation"
                aria-label="Main navigation" data-accordion="false" id="navigation">
                {{-- ---:: Dashboard ::--- --}}
                <li class="nav-item border-bottom mb-3">
                    <a href="{{ route('dashboard') }}" class="nav-link @yield('dactive')">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                {{-- ---:: Category ::--- --}}
                <li class="nav-item @yield('catmenuopen')">
                    <a href="#" class="nav-link @yield('cactive')">
                        <i class="nav-icon bi bi-grid"></i>
                        <p>Category</p>
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item sub-nav-item">
                            <a href="{{ route('category.add') }}" class="nav-link @yield('acatactive')">
                                <i class="nav-icon bi bi-plus-square"></i>
                                <p>Add Category</p>
                            </a>
                        </li>
                        <li class="nav-item sub-nav-item">
                            <a href="{{ route('admin.category') }}" class="nav-link @yield('catlactive')">
                                <i class="nav-icon bi-list-task"></i>
                                <p>Category List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- ---:: Sub Category ::--- --}}
                <li class="nav-item @yield('scatmenuopen')">
                    <a href="#" class="nav-link @yield('scactive')">
                        <i class="nav-icon bi bi-diagram-3"></i>
                        <p>Sub Category</p>
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item sub-nav-item">
                            <a href="{{ route('subcategory.add') }}" class="nav-link @yield('sacatactive')">
                                <i class="nav-icon bi bi-plus-square"></i>
                                <p>Add Sub Category</p>
                            </a>
                        </li>
                        <li class="nav-item sub-nav-item">
                            <a href="{{ route('admin.subcategory') }}" class="nav-link @yield('scatlactive')">
                                <i class="nav-icon bi-list-task"></i>
                                <p>Sub Category List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- ---:: Product ::--- --}}
                <li class="nav-item @yield('pmenuopen')">
                    <a href="#" class="nav-link @yield('pactive')">
                        <i class="nav-icon bi bi-box-seam"></i>
                        <p>
                            Product
                        </p>
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item sub-nav-item @yield('addpmenuopen')">
                            <a href="#" class="nav-link @yield('addpactive')">
                                <i class="nav-icon bi bi-plus-square"></i>
                                <p>
                                    Add Product
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item sub-nav-item">
                                    <a href="{{ route('admin.simple-product') }}" class="nav-link @yield('smpactive')">
                                        <i class="nav-icon bi bi-node-plus"></i>
                                        <p>Simple Product</p>
                                    </a>
                                </li>
                                <li class="nav-item sub-nav-item">
                                    <a href="{{ route('admin.variable-product') }}" class="nav-link @yield('varactive')">
                                        <i class="nav-icon bi bi-node-plus"></i>
                                        <p>Variable Product</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item sub-nav-item">
                            <a href="{{ route('admin.product') }}" class="nav-link @yield('plactive')">
                                <i class="nav-icon bi-list-task"></i>
                                <p>Product List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- ---:: Coupon ::--- --}}
                <li class="nav-item @yield('dismenuopen')">
                    <a href="#" class="nav-link @yield('discactive')">
                        <i class="nav-icon bi bi-ticket-perforated"></i>
                        <p>Coupon</p>
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item sub-nav-item">
                            <a href="{{ route('discount.add') }}" class="nav-link @yield('disaddactive')">
                                <i class="nav-icon bi bi-plus-square"></i>
                                <p>Add Coupon</p>
                            </a>
                        </li>
                        <li class="nav-item sub-nav-item">
                            <a href="{{ route('admin.discount') }}" class="nav-link @yield('dislactive')">
                                <i class="nav-icon bi-list-task"></i>
                                <p>Coupon List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- ---:: Order ::--- --}}
                <li class="nav-item">
                    <a href="{{ route('admin.order') }}" class="nav-link @yield('oactive')">
                        <i class="nav-icon bi bi-cart3"></i>
                        <p>Order</p>
                    </a>
                </li>
                {{-- ---:: Customer ::--- --}}
                <li class="nav-item">
                    <a href="{{ route('admin.user') }}" class="nav-link @yield('uactive')">
                        <i class="nav-icon bi bi-person"></i>
                        <p>Customer</p>
                    </a>
                </li>
                {{-- ---:: Setting ::--- --}}
                <li class="nav-item">
                    <a href="{{ route('admin.setting') }}" class="nav-link @yield('sactive')">
                        <i class="nav-icon bi bi-gear"></i>
                        <p>Setting</p>
                    </a>
                </li>
            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
