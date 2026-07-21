<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Admin | @yield('title', 'Dashboard')</title>
    <!--begin::Accessibility Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <!--end::Accessibility Meta Tags-->
    <!--begin::Primary Meta Tags-->
    <meta name="title" content="Admin | @yield('title')" />
    <meta name="author" content="ColorlibHQ" />
    <meta name="description"
        content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS. Fully accessible with WCAG 2.1 AA compliance." />
    <meta name="keywords"
        content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard, accessible admin panel, WCAG compliant" />
    <!--end::Primary Meta Tags-->
    <!--begin::Accessibility Features-->
    <!-- Skip links will be dynamically added by accessibility.js -->
    <meta name="supported-color-schemes" content="light dark" />
    <link rel="preload" href="{{ asset('adminlte/dist/css/adminlte.css') }}" as="style" />
    <link rel="icon" href="{{ asset('images/favicon.png') }}">
    <!--end::Accessibility Features-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous" media="print"
        onload="this.media='all'" />
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
        crossorigin="anonymous" />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        crossorigin="anonymous" />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!-- apexcharts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
        integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous" />
    <!-- jsvectormap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
        integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4=" crossorigin="anonymous" />
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/toast.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.5/dist/sweetalert2.min.css">
    <!--end::Required Plugin(AdminLTE)-->

    @yield('css')
    <style>
        .s-btn:hover {
            background: #196d54 !important;
        }

        .delete-modal {
            height: 100vh;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background: #000000cc;
            z-index: 2000;
            display: grid;
            place-items: center;
            display: none;
        }

        .delete-modal-dialog {
            height: auto;
            width: 325px;
            background: #fff;
            opacity: 0;
            transition: .8s;
        }

        .list-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            line-height: 1rem;
            letter-spacing: 0.05em;
        }

        /* .list-badge:before {
            content: '';
            display: inline-block;
            width: 0.5rem;
            height: 0.5rem;
            border-radius: 9999px;
            margin-right: 0.5rem;
            color: inherit;
        } */

        .list-badge.active {
            background-color: #0f9b1866;
            color: #1b6e02;
        }

        .list-badge.inactive {
            background-color: #ff000047;
            color: #c52a2a;
        }

        .list-badge.processing {
            background-color: #FFF3CD;
            color: #856404;
        }

        .list-badge.shipped {
            background-color: #CCE5FF;
            color: #004085;
        }

        .list-badge.delivered {
            background-color: #D4EDDA;
            color: #155724;
        }

        .list-badge.cancelled {
            background-color: #F8D7DA;
            color: #721C24;
        }

        .sub-nav-item {
            padding-left: 1rem;
            font-size: 0.9rem;
        }
    </style>
</head>
<!--end::Head-->
<!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
    @include('sweetalert::alert')
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <!--begin::Header-->
        @include('layout.header')
        <!--end::Header-->
        <!--begin::Sidebar-->
        @include('layout.sidebar')
        <!--end::Sidebar-->
        <!--begin::App Main-->

        @yield('content')

        <!--end::App Main-->
        <!--begin::Footer-->
        @include('layout.footer')
        <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <!-- apexcharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
        integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
        crossorigin="anonymous"></script>
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous">
    </script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)-->
    <!--begin::Required Plugin(Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.5/dist/sweetalert2.min.js"></script>
    <script src="{{ asset('toast/toast.js') }}"></script>
    <!--end::Required Plugin(Bootstrap 5)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script>
    <!--end::Required Plugin(AdminLTE)-->
    <!--begin::OverlayScrollbars Configure-->
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
        const Default = {
            scrollbarTheme: 'os-theme-light',
            scrollbarAutoHide: 'leave',
            scrollbarClickScroll: true,
        };
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);

            // Disable OverlayScrollbars on mobile devices to prevent touch interference
            const isMobile = window.innerWidth <= 992;

            if (
                sidebarWrapper &&
                OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined &&
                !isMobile
            ) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script>
    <!--end::OverlayScrollbars Configure--><!--begin::Color Mode Toggle (#6010)-->
    <script>
        (() => {
            'use strict';

            const STORAGE_KEY = 'lte-theme';

            const getStoredTheme = () => localStorage.getItem(STORAGE_KEY);
            const setStoredTheme = (theme) => localStorage.setItem(STORAGE_KEY, theme);

            const prefersDark = () => globalThis.matchMedia('(prefers-color-scheme: dark)').matches;

            const getPreferredTheme = () => {
                const stored = getStoredTheme();
                if (stored) return stored;
                return prefersDark() ? 'dark' : 'light';
            };

            const setTheme = (theme) => {
                const resolved = theme === 'auto' ? (prefersDark() ? 'dark' : 'light') : theme;
                document.documentElement.setAttribute('data-bs-theme', resolved);
            };

            setTheme(getPreferredTheme());

            const showActiveTheme = (theme) => {
                // Highlight the active dropdown option
                document.querySelectorAll('[data-bs-theme-value]').forEach((el) => {
                    el.classList.remove('active');
                    el.setAttribute('aria-pressed', 'false');
                    const check = el.querySelector('.bi-check-lg');
                    if (check) check.classList.add('d-none');
                });
                const active = document.querySelector(`[data-bs-theme-value="${theme}"]`);
                if (active) {
                    active.classList.add('active');
                    active.setAttribute('aria-pressed', 'true');
                    const check = active.querySelector('.bi-check-lg');
                    if (check) check.classList.remove('d-none');
                }
                // Sync the topbar trigger icon
                document.querySelectorAll('[data-lte-theme-icon]').forEach((icon) => {
                    icon.classList.toggle('d-none', icon.dataset.lteThemeIcon !== theme);
                });
            };

            globalThis.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                const stored = getStoredTheme();
                if (!stored || stored === 'auto') setTheme(getPreferredTheme());
            });

            document.addEventListener('DOMContentLoaded', () => {
                showActiveTheme(getPreferredTheme());
                document.querySelectorAll('[data-bs-theme-value]').forEach((toggle) => {
                    toggle.addEventListener('click', () => {
                        const theme = toggle.getAttribute('data-bs-theme-value');
                        setStoredTheme(theme);
                        setTheme(theme);
                        showActiveTheme(theme);
                    });
                });
            });
        })();
    </script>
    <!--end::Color Mode Toggle-->

    <script>
        let modal = document.querySelector(".delete-modal");
        let modalBox = document.querySelector(".delete-modal-dialog");
        let delClose = document.querySelector(".del-close");
        let delImage = document.querySelector("#modal-id");

        function openModal(val) {
            delImage.value = val;
            modal.style.display = "grid";
            modalBox.style.opacity = "1";
        }
        if (delClose) {
            delClose.addEventListener("click", () => {
                modal.style.display = "none";
                modalBox.style.opacity = "0";
            });
        }
        if (modal) {
            modal.addEventListener("click", () => {
                modal.style.display = "none";
                modalBox.style.opacity = "0";
            });
        }
    </script>

    <!--end::OverlayScrollbars Configure-->
    <!-- OPTIONAL SCRIPTS -->
    <!-- sortablejs -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js" crossorigin="anonymous"></script>
    <!-- sortablejs -->
    <!--begin::Bootstrap Tooltips-->
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipTriggerList.forEach((tooltipTriggerEl) => {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });
    </script>
    <!--end::Bootstrap Tooltips-->
    <!-- <script>
        new Sortable(document.querySelector('.connectedSortable'), {
            group: 'shared',
            handle: '.card-header',
        });

        const cardHeaders = document.querySelectorAll('.connectedSortable .card-header');
        cardHeaders.forEach((cardHeader) => {
            cardHeader.style.cursor = 'move';
        });
    </script> -->

    @yield('script')
    <!--end::Script-->
</body>
<!--end::Body-->

</html>
