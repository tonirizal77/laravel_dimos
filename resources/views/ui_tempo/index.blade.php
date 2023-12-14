@php
    $theme = "ui_tempo"
@endphp
@extends($theme.'.layouts.app')

@section('title')
    <title>Kasir Online - {{ $website->nama }} </title>
@endsection

@section('content')
    @include($theme.'.component.hero')
    <main id="main">
        @include($theme.'.component.about_us')

        @include($theme.'.component.services')

        @include($theme.'.component.features')

        @include($theme.'.component.cta')

        @include($theme.'.component.portofolio')

        @include($theme.'.component.price_service')

        @include($theme.'.component.faq_question')

        @include($theme.'.component.our_team')

        @include($theme.'.component.contact_us')
    </main>
@endsection
