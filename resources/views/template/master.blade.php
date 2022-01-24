<!DOCTYPE html>
<html lang="en">
@include('template.header')
<body>
    <div id="fh5co-wrapper">
    <div id="fh5co-page">
    @include('template.navbar')

    @yield('main-content')

    @include('template.footer')
</body>
</html>