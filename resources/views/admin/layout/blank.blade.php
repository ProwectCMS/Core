<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>@yield('title', $pageTitle ?? 'Admin') :: ProwectCMS</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @stack('metas')

        @include('prowectcms::admin.partial.styles')
        @stack('styles')
    </head>
    <body class="layout-light side-menu overlayScroll"> {{-- TODO: configurable light/dark-mode --}}
        <main class="main-content">
            @yield('content')
        </main>

        {{-- PageLoader :: Loading Overlay --}}
        <div id="overlayer">
            <span class="loader-overlay">
                <div class="atbd-spin-dots spin-lg">
                   <span class="spin-dot badge-dot dot-primary"></span>
                   <span class="spin-dot badge-dot dot-primary"></span>
                   <span class="spin-dot badge-dot dot-primary"></span>
                   <span class="spin-dot badge-dot dot-primary"></span>
                </div>
            </span>
        </div>

        @include('prowectcms::admin.partial.scripts')
        @stack('scripts')
    </body>
</html>