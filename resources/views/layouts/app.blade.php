<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('inc.headerstyles')
        @include('inc.styles')
    </head>
    <body>
        <div class="main-wrapper">
            @if ($page_name == 'Dashboard')
            @include('inc.preloader')
            @endif
            @include('inc.header')
            @include('inc.sidebar')
            <div class="page-wrapper">
                <div class="content container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
        @include('inc.scripts')
        @yield('scripts')
    </body>
</html>