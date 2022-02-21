<!DOCTYPE html>

<html lang="en">

@include('layouts/landing/head')

<body>
    @include('layouts/landing/sidebar')
    <div class="wrapper d-flex flex-column min-vh-100 bg-light">
        @include('layouts/landing/header')
        <div class="body flex-grow-1 px-3">
            <div class="container-lg">
                @yield('content')
            </div>
        </div>
        @include('layouts/landing/footer')
    </div>
    @include('layouts/landing/footer-script')

</body>

</html>
