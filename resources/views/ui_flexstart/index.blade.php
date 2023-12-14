@php
    $theme = "ui_flexstart";
@endphp

@extends($theme.'.layouts.app')

@section('title')
    <title>Kasir Online - {{ $website->nama }} </title>
@endsection

@section('content')
    <!-- ======= Hero Section ======= -->
    @include($theme.'.component.hero')
    <main id="main">
        <!-- ======= About Section ======= -->
        @include($theme.'.component.about')

        <!-- ======= Values Section ======= -->
        @include($theme.'.component.values')

        <!-- ======= Video Section ======= -->
        @include($theme.'.component.video_tutorial')

        <!-- ======= Counts Section ======= -->
        @include($theme.'.component.count')

        <!-- ======= Features Section ======= -->
        @include($theme.'.component.features')

        <!-- ======= Services Section ======= -->
        {{-- @include($theme.'.component.services') --}}

        <!-- ======= Pricing Section ======= -->
        @include($theme.'.component.pricing')

        <!-- ======= F.A.Q Section ======= -->
        @include($theme.'.component.faq')

        <!-- ======= Portfolio Section ======= -->
        {{-- @include($theme.'.component.portfolio') --}}

        <!-- ======= Testimonials Section ======= -->
        {{-- @include($theme.'.component.testimonials') --}}

        <!-- ======= Team Section ======= -->
        {{-- @include($theme.'.component.team') --}}

        <!-- ======= Clients Section ======= -->
        {{-- @include($theme.'.component.clients') --}}

        <!-- ======= Recent Blog Posts Section ======= -->
        {{-- @include($theme.'.component.blog-posts') --}}

        <!-- ======= Contact Section ======= -->
        {{-- @include($theme.'.component.contact') --}}

    </main><!-- End #main -->
@endsection
