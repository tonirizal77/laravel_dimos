@php
    function rupiah($angka){
        // $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        $hasil_rupiah = number_format($angka,0,',',',');
        return $hasil_rupiah;
    };
@endphp

@extends('ui_users.layouts.main')

@section('title')
<title>Kasir Online - {{ $website->nama }} </title>
@endsection

@section('css-x')
<link rel="stylesheet" href="{{ asset('ui_admin/plugins/fontawesome-free/css/all.min.css') }}">
@endsection

@section('content')
<!-- ======= Hero Section ======= -->
<section id="hero">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-ride="carousel">

        <div class="carousel-inner" role="listbox">

            <!-- Slide 1 -->
            <div class="carousel-item clipShadow active">
                <div class="carousel-img">
                    <img src="{{asset('ui_users/assets/img/slide/slide-6.jpg')}}" alt="">
                </div>

                <div class="carousel-container">
                    <div class="carousel-content animate__animated animate__fadeInUp">
                        <h2>Welcome to <span class="stroke">{{ $website->nama }}</span></h2>
                        <p>merupakan penyedia sarana layanan Aplikasi Kasir Online yang berbasis Web dan Android
                            yang dirancang khusus untuk pelaku bisnis yang bergerak dalam Bidang Distribusi Barang
                            Perdagangan yang dapat lebih cepat memproses transaksi pemesanan, transaksi penjualan,
                            pengiriman barang, pengiriman informasi produk, promo produk, dan lain-lainnya kepada pelanggannya.</p>
                        <div class="text-right">
                            <a href="{{url('#about-us')}}" class="btn-get-started">Read More</a>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item clipShadow">
                <div class="carousel-img">
                    <img src="{{asset('ui_users/assets/img/slide/slide-6.jpg')}}" alt="">
                </div>
                <div class="carousel-container">
                    <div class="carousel-content animate__animated animate__fadeInUp">
                        <h2>Welcome to <span class="stroke">{{ $website->nama }}</span></h2>
                        <p>
                            Tingkatkan Profit Bisnis Anda dengan cepat, efektif
                            dan tanpa batas dengan jangkauan yang lebih luas.
                        </p>
                        <p>
                            Mengelola Transaksi Penjualan, Pembelian, Stock Barang dan Keuangan Bisnis
                            Anda dalam satu Aplikasi. Monitor Bisnis Anda kapan saja dan dimana saja.</p>
                        <div class="text-right">
                            <a href="{{url('#about-us')}}" class="btn-get-started">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <a class="carousel-control-prev" href="#heroCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon icofont-simple-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>

        <a class="carousel-control-next" href="#heroCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon icofont-simple-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>

        <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

    </div>
</section><!-- End Hero -->

<main id="main">

    <!-- === Top Item Section === -->
    <section id="top-item" class="top-item">
        <div class="container">

            <div class="row justify-content-between">
                <div id="box-items-1" class="col-md-6 col-lg-4 d-flex align-items-stretch mb-3 mb-lg-0"
                    data-aos="fade-up">
                    <div class="box-item">
                        <div class="icon d-flex"><i class="bx bxl-dribbble"></i>Info Product Promo dan lainnya</div>
                        <p class="description">
                            Seluruh informasi promo produk dan bonus dari distributor dan toko akan tampil disini.
                        </p>
                        <div class="date-news"><i class="fas fa-calendar-check"></i> Kam, 12-06-2020</div>
                    </div>
                </div>

                <div id="box-items-2" class="col-md-6 col-lg-4 d-flex align-items-stretch mb-3 mb-lg-0"
                    data-aos="fade-up" data-aos-delay="100">
                    <div class="box-item">
                        <div class="icon d-flex"><i class="bx bxl-deviantart"></i>Update Information</div>
                        <p class="description">Seluruh informasi aktivitas toko dan customernya akan tampil disini.</p>
                        <div class="date-news"><i class="fas fa-calendar-check"></i> Kam, 12-06-2020</div>
                    </div>
                </div>

                <div id="box-items-3" class="col-md-6 col-lg-4 d-flex align-items-stretch mb-3 mb-lg-0"
                    data-aos="fade-up" data-aos-delay="200">
                    <div class="box-item">
                        <div class="icon d-flex"><i class="bx bxl-flickr"></i>Breaking News</div>
                        <p class="description">
                            Seluruh informasi berita terbaru akan tampil disini.
                        </p>
                        <div class="date-news"><i class="fas fa-calendar-check"></i> Kam, 12-06-2020</div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Icon Boxes Section -->

    <!-- ======= About Us Section ======= -->
    <section id="about-us" class="about-us section-bg">
        <div class="container" data-aos="fade-up">
            <div class="style left">
                <div class="title-box">
                    <div class="bg-box">
                        <p class="title">About Us</p>
                    </div>
                </div>

                <div class="row content">
                    <div class="col-lg-12 mb-2" data-aos="fade-right">
                        <p>
                            <span class="title-dimos">{{ $website->nama }}</span>
                            merupakan penyedia sarana layanan Aplikasi Kasir Online yang berbasis Web dan Android
                            yang dirancang khusus untuk pelaku bisnis yang bergerak dalam Bidang Distribusi Barang
                            Perdagangan yang dapat lebih cepat memproses transaksi pemesanan, transaksi penjualan,
                            pengiriman barang, pengiriman informasi produk, promo produk, dan lain-lainnya kepada pelanggannya.
                        </p>
                    </div>
                    <div class="col-lg-12 box-content mb-3" data-aos="fade-left">
                        <div class="col-lg-7 align-self-center d-flex" data-aos="fade-right">

                            <div class="col-lg-6 align-self-center" data-aos="fade-left"
                                style="display: inline-grid; z-index: 1;">
                                <div class="img-circle">
                                    <img class="" src="{{ asset('ui_users/assets/img/about.jpg') }}" alt="about-us">
                                </div>
                            </div>
                            <div class="col-lg-6 align-self-center img-about ml-auto" data-aos="fade-right">
                                <div class="img-about-1" data-aos="fade-right"></div>
                                <div class="img-about-2" data-aos="fade-right"></div>
                                <div class="img-about-3" data-aos="fade-right"></div>
                                <div class="img-about-4" data-aos="fade-right"></div>
                            </div>

                        </div>

                        <ul class="col-lg-5 align-self-center" data-aos="fade-left">
                            <li data-aos="fade-left">
                                <div class="about-title">Jalur Target Customer Terarah</div>
                                <div class="about-desc">Dengan mendapatkan target yang
                                    terarah akan mengoptimalkan penjualan dan menghemat biaya pengeluaran.</div>
                            </li>
                            <li data-aos="fade-left">
                                <div class="about-title">Proses Order lebih Cepat dan Mudah</div>
                                <div class="about-desc">Customer dengan mudah melakukan proses order setiap saat.
                                </div>
                            </li>
                            <li data-aos="fade-left">
                                <div class="about-title">Respon Order yang Cepat</div>
                                <div class="about-desc">Untuk mengoptimalkan penjualan dibutuhkan respon yang cepat
                                    atas
                                    pemesanan barang dari Customer.</div>
                            </li>
                            <li data-aos="fade-left">
                                <div class="about-title">Simple dan Praktis</div>
                                <div class="about-desc">Dengan menggunakan aplikasi {{ $website->nama }}, segala pekerjaan menjadi
                                    mudah dan cepat untuk dilakukan.</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </section><!-- End About Us Section -->

    <!-- ======= Services Section ======= -->
    <section id="services" class="services section-bg">
        <div class="container" data-aos="fade-up">
            <div class="style right">

                <div class="title-box" data-aos="fade-left">
                    <div class="bg-box">
                        <p class="title">Services</p>
                    </div>
                </div>

                <div class="row m-2" data-aos="fade-down">
                    <div class="col-lg-6 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
                        <div class="box-service">
                            <div class="icon-service">
                                <img src="{{asset('ui_users/assets/img/icon-biru.png')}}" alt="">
                            </div>
                            <div class="title">Kunci Data Pelanggan dan relationship (Relationship Customer Lock)</div>
                            <div class="desc">
                                Hubungan / relationship dengan pelanggan sangatlah penting
                                dalam menjalankan bisnis usaha apapun jenisnya.
                                <span style="font-weight: bold">{{ $website->nama }}</span> akan mengelola dan mengunci data customer
                                dengan baik.
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="200">
                        <div class="box-service">
                            <div class="icon-service">
                                <img src="{{asset('ui_users/assets/img/icon-kuning.png')}}" alt="">
                            </div>
                            <div class="title">Kelola Hutang & Piutang secara cepat dan akurat</div>
                            <div class="desc">
                                Semua kebutuhan pencatatan hutang & piutang yang
                                dibutuhkan oleh bisnis Anda, sudah tersedia dalam
                                aplikasi {{ $website->nama }}. Mulai dari pencatatan, pembayaran
                                hutang, penagihan piutang dan juga notifikasi untuk
                                semua hal yang terkait didalamnya agar informasi dapat
                                diproses dengan cepat.
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="300">
                        <div class="box-service">
                            <div class="icon-service">
                                <img src="{{asset('ui_users/assets/img/icon-hijau.png')}}" alt="">
                            </div>
                            <div class="title">Kelola stok secara realtime dengan cepat dan efisien</div>
                            <div class="desc">
                                Bisnis distribusi barang membutuhkan fasilitas stok
                                super komplit, {{ $website->nama }} menyediakan semua fitur untuk
                                pengelolaan stok tersaji secara realtime sehingga Anda
                                tidak perlu lagi melakukan penghitungan manual stok
                                yang Anda miliki. Jadi, berapa banyak waktu yang
                                terpakai jika harus menghitung ribuan stok yang Anda
                                miliki?
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
                        <div class="box-service">
                            <div class="icon-service">
                                <img src="{{asset('ui_users/assets/img/icon-hijau-tua.png')}}" alt="">
                            </div>
                            <div class="title">Laporan Transaksi dapat dibuat dalam hitungan detik</div>
                            <div class="desc">
                                Semua pengusaha butuh laporan yang akurat dan cepat,
                                tapi bagaimana caranya bisa tersedia dalam hitungan
                                detik? seperti rekap penjualan, pembelian, pencapaian
                                target salesmen dan lainnya, bersama {{ $website->nama }} semua
                                laporan tersebut dapat tersaji otomatis dalam hitungan
                                detik. Jadi kamu bisa menghemat tenaga, biaya dan
                                waktu berharga anda.
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section><!-- End Services Section -->

    <!-- ======= Feature Section ======= -->
    <section id="feature" class="features section-bg d-none">
        <div class="container">
            <div class="style left">

                <div class="title-box" data-aos="fade-left" data-aos-delay="100">
                    <div class="bg-box">
                        <p class="title">Features</p>
                    </div>
                </div>

                <div class="row" data-aos="fade-right" data-aos-delay="200">
                    <div class="col-lg-12 d-flex justify-content-center">
                        <ul id="feature-filters">
                            <li data-filter="*" class="filter-active">Sales</li>
                            <li data-filter=".filter-app">Purchase</li>
                            <li data-filter=".filter-card">Inventory</li>
                            <li data-filter=".filter-web">Accounting</li>
                        </ul>
                    </div>
                </div>

                <div class="row content" data-aos="fade-up" data-aos-delay="300">
                    <div class="col-lg-12 d-flex flex-wrap feature-item filter-app">
                        <div class="col-lg-5" data-aos="fade-left" data-aos-delay="200">
                            <div class="tab-title">
                                Aplikasi Kasir Online yang dirancang khusus
                                untuk Pelaku Bisnis Distribusi Barang
                                Perdagangan dan diakses dari semua platform (Android & Website).
                            </div>
                            <div class="tab-desc">
                                Lakukan penjualan dengan lebih mudah, cepat,
                                efektif dan tingkatkan produktivitas tim
                                penjualan Anda dengan Distributor
                                Management Online System berbasis Web dan
                                Seluler (Mobile Apps).
                            </div>
                            <p class="sub-title">
                                Sistem Manajemen Penjualan
                            </p>
                            <ul>
                                <li class="circle active"><i class="circle"></i>Manajemen Customer</li>
                                <li class="circle"><i class="circle"></i>Manajemen Pemesan Produk</li>
                                <li class="circle"><i class="circle"></i>Manajemen Harga Bertingkat</li>
                                <li class="circle"><i class="circle"></i>Manajemen Harga Promo</li>
                                <li class="circle"><i class="circle"></i>Manajemen Pengembalian Produk</li>
                                <li class="circle"><i class="circle"></i>Manajemen Pengiriman Produk</li>
                            </ul>
                        </div>

                        <div class="col-lg-7" id="detail-feature" data-aos="fade-right" data-aos-delay="300">
                            <div class="title-detail">Manajemen Customer</div>
                            <ul class="col-lg-12 col-md-12 d-flex flex-wrap">
                                <li class="col-lg-6">
                                    <p class="title">Optimal Penagihan Piutang</p>
                                    <p class="desc">Optimalkan penagihan piutang
                                        customer malalui pembayaran
                                        tagihan yang tepat waktu dengan
                                        bantuan proses otomatis.</p>
                                </li>
                                <li class="col-lg-6">
                                    <p class="title">Optimalkan Penjualan</p>
                                    <p class="desc">Minimalkan proses manual yang
                                        membuang waktu dan fokus pada
                                        peningkatan konversi penjualan.</p>
                                </li>
                                <li class="col-lg-6">
                                    <p class="title">Analisis Produk Terjual</p>
                                    <p class="desc">Menganalisa produk terjual mana
                                        yang paling banyak dan sedikit
                                        terjual agar dapat di optimalkan
                                        dalam pemasaran dan pemesanan
                                        barang kembali (re-stock).</p>
                                </li>
                                <li class="col-lg-6">
                                    <p class="title">Tingkatkan Akurasi</p>
                                    <p class="desc">Hitung komisi penjualan secara
                                        akurat berdasarkan target penjualan
                                        yang dicapai oleh setiap salesperson.</p>
                                </li>

                            </ul>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section><!-- End Feature Section -->

    <!-- ======= Cta Section ======= -->
    <section id="cta" class="cta d-none">
        <div class="container d-flex flex-wrap">
            <div class="col-lg-12" data-aos="zoom-in">
                <div class="title" data-aos="fade-up">Hot Promo</div>
                <div class="col-lg-12 text-center content">
                    <div class="desc col-lg-10" data-aos="fade-down">
                        Ayo bergabung sekarang juga dan dapatkan hot promo pada periode ini, berlaku hingga : Agustus
                        2020
                    </div>
                    <div class="disc align-self-center" data-aos="fade-left">50%</div>
                </div>
            </div>

            <div class="col-lg-12 cta-btn-container text-center ">
                <div class="cta-btn-order p-2" data-aos="fade-right">
                    <div class="btn-in">
                        <a href="{{url('#price')}}" class="btn-txt">Order Now!</a>
                    </div>
                </div>
                <div class="cta-time-over d-flex p-2" data-aos="fade-left">
                    <div class="time-promo">
                        <div class="btn-in">
                            <a href="{{url('#price')}}" class="promo-txt">01 Days</a>
                        </div>
                    </div>
                    <div class="time-promo">
                        <div class="btn-in">
                            <a href="{{url('#price')}}" class="promo-txt">01 Hours</a>
                        </div>
                    </div>
                    <div class="time-promo">
                        <div class="btn-in">
                            <a href="{{url('#price')}}" class="promo-txt">01 Min</a>
                        </div>
                    </div>
                    <div class="time-promo">
                        <div class="btn-in">
                            <a href="{{url('#price')}}" class="promo-txt">01 Sec</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Cta Section -->

    <!-- ======= Why-Us Section ======= -->
    <section id="why-us" class="why-us section-bg">
        <div class="container" data-aos="fade-up">
            <div class="style right">

                <div class="title-box" data-aos="fade-left">
                    <div class="bg-box">
                        <p class="title">Why Choose Me</p>
                    </div>
                </div>

                <div class="row content">
                    <div id="box-video" class="col-lg-7" data-aos="fade-right">
                        <img src="{{asset('ui_users/assets/img/blog-6.jpg')}}" alt="">
                        <a href="https://youtu.be/52_Rh5-O7n8" class="venobox play-btn mb-4"
                            data-vbtype="video" data-autoplay="true">
                        </a>
                    </div>
                    <div class="col-lg-5 list-why" data-aos="fade-left">
                        <ul>
                            <li>
                                <div class="col-lg-3 right-point grad-blue">
                                    <img class="iconx" src="{{asset('ui_users/assets/img/ic-target.png')}}"
                                        alt="target">
                                </div>
                                <div class="col-lg-9 col-list">
                                    <div class="title">Fasilitas Khusus</div>
                                    <div class="desc">Untuk pelaku bisnis distribusi barang perdagangan.</div>
                                </div>
                            </li>
                            <li>
                                <div class="col-lg-3 right-point grad-h1">
                                    <img class="iconx" src="{{asset('ui_users/assets/img/ic-people-gr.png')}}"
                                        alt="target">
                                </div>
                                <div class="col-lg-9 col-list">
                                    <div class="title">Relationship Lock System</div>
                                    <div class="desc">Dapat menjaga hubungan/relationship pembeli dan penjual
                                        dengan Relationship Lock System.
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="col-lg-3 right-point grad-yellow">
                                    <img class="iconx" src="{{asset('ui_users/assets/img/ic-people.png')}}" alt="target">
                                </div>
                                <div class="col-lg-9 col-list">
                                    <div class="title">Management Stock</div>
                                    <div class="desc">
                                        Pengontrolan Stock menggunakan multi satuan, multi harga, diskon item dan
                                        diskon tambahan, dll.
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="col-lg-3 right-point grad-h2">
                                    <img class="iconx" src="{{asset('ui_users/assets/img/ic-medali.png')}}"
                                        alt="target">
                                </div>
                                <div class="col-lg-9 col-list">
                                    <div class="title">Cepat dan Mudah digunakan</div>
                                    <div class="desc">Cepat melakukan proses transaksi dan mudah digunakan bagi seluruh
                                        pengguna (user’s)
                                    </div>
                                </div>
                            </li>
                        </ul>

                    </div>
                </div>

            </div>
        </div>
    </section><!-- End Why-Us Section -->

    <!-- ======= Video-Us Section ======= -->
    <section id="video-present" class="video-present section-bg d-none">
        <div class="container" data-aos="fade-up">
            <div class="style flat">

                <div class="title-box" data-aos="fade-left">
                    <div class="bg-box">
                        <p class="title">Video Presentation</p>
                    </div>
                </div>

                <div class="row content">
                    <div class="col-lg-8 p-1" data-aos="fade-right">

                        <div id="box-video" class="col-lg-12 p-1" data-aos="fade-right">
                            {{-- <div class="plyr__video-embed" id="player">
                                <iframe
                                  src="https://www.youtube.com/embed/bTqVqk7FSmY?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1"
                                  allowfullscreen
                                  allowtransparency
                                  allow="autoplay"
                                ></iframe>
                            </div> --}}
                            {{-- <div class="plyr__video-embed" id="player" data-plyr-provider="youtube" data-plyr-embed-id="bTqVqk7FSmY"></div> --}}

                            {{-- <video id="player" crossorigin controls playsinline data-poster="{{asset('ui_users/assets/img/blog-6.jpg')}}"> --}}
                                <!-- Video files -->
                                {{-- <source src="{{url('/video/Nonton Eragon (2006).mp4')}}" type="video/mp4" size="576" /> --}}
                                {{-- <source src="{{url('/video/Nonton Eragon (2006).mp4')}}" type="video/mp4" size="720" /> --}}
                                {{-- <source src="{{url('/video/Nonton Eragon (2006).mp4')}}" type="video/mp4" size="1080" /> --}}

                                <!-- Caption files -->
                                {{-- <track kind="captions" label="Indonesia" srclang="id"
                                    src="{{url('/video/Captain-Marvel-2019.vtt')}}" default /> --}}

                                <!-- Fallback for browsers that don't support the <video> element -->
                                {{-- <a href="{{url('/video/Nonton Eragon (2006).mp4')}}" download>Download</a> --}}
                            {{-- </video> --}}
                        </div>

                        <div id="title-movie" class="col-lg-12 p-1">
                            Ariana Grande, Billie Ellish, Maroon 5, Ava Max, Charlie Puth, Bebe Rexha, Anne-Marie | Pop
                            Hits 2019
                        </div>

                        <div class="col-lg-12 p-1 d-flex flex-wrap justify-content-between desc-movie">
                            <div id="ditonton" class="col-lg-6 p-0 mb-2 d-flex">6.53.1361 x ditonton, 14 Okt 2019</div>
                            <div class="col-lg-6 p-0 mb-2 d-flex justify-content-between social-movie">
                                <button id="likeMovie">
                                    <i class="mr-3 icofont-thumbs-up"><span>450&nbsp;Rb</span></i>
                                </button>
                                <button id="unlikeMovie">
                                    <i class="mr-3 icofont-thumbs-down"><span>125&nbsp;Rb</span></i>
                                </button>
                                <button id="shareMovie">
                                    <i class="icofont-share-boxed"><span>&nbsp;Bagikan</span></i>
                                </button>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-4 list-video" data-aos="fade-left">
                        <ul>
                            <li id="1" data-src="/movie/Captain-Marvel-2019.mp4" data-vbtype="video"
                                data-type="video/mp4" data-size="['576','720','1080']">
                                <div class="img-video">
                                    <img src="{{asset('ui_users/assets/img/blog-1.jpg')}}" alt="">
                                </div>
                                <div class="desc-video">
                                    <div class="title block-with-text">Top Songs 2020 Top 40 Populer Songs Playlist 2020
                                    </div>
                                    <div class="subTitle">Sub Title Video</div>
                                    <div class="watched">358 rb x ditonton</div>
                                    <div class="date">Tanggal : 12 Des 2020</div>
                                </div>
                            </li>
                            <li id="2" data-src="" data-vbtype="video"
                                data-type="video/mp4" data-size="['576','720','1080']">
                                <div class="img-video">
                                    <img src="{{asset('ui_users/assets/img/blog-2.jpg')}}" alt="">
                                </div>
                                <div class="desc-video">
                                    <div class="title block-with-text">
                                        Ariana Grande, Billie Ellish, Maroon 5, Ava Max,
                                        Charlie Puth, Bebe Rexha, Anne-Marie | Pop Hits 2019
                                    </div>
                                    <div class="subTitle">Sub Title Video</div>
                                    <div class="watched">358 rb x ditonton</div>
                                    <div class="date">Tanggal : 12 Des 2020</div>
                                </div>
                            </li>
                            <li id="3" data-src="" data-vbtype="video"
                                data-type="video/mp4" data-size="['576','720','1080']">
                                <div class="img-video">
                                    <img src="{{asset('ui_users/assets/img/blog-3.jpg')}}" alt="">
                                </div>
                                <div class="desc-video">
                                    <div class="title block-with-text">
                                        Top Songs 2020 Top 40 Populer Songs Playlist 2020
                                    </div>
                                    <div class="subTitle">Sub Title Video</div>
                                    <div class="watched">358 rb x ditonton</div>
                                    <div class="date">Tanggal : 12 Des 2020</div>
                                </div>
                            </li>
                            <li id="4" data-src="" data-vbtype="video"
                                data-type="video/mp4" data-size="['576','720','1080']">
                                <div class="img-video">
                                    <img src="{{asset('ui_users/assets/img/blog-4.jpg')}}" alt="">
                                </div>
                                <div class="desc-video">
                                    <div class="title block-with-text">
                                        Top Songs 2020 Top 40 Populer Songs Playlist 2020
                                    </div>
                                    <div class="subTitle">Sub Title Video</div>
                                    <div class="watched">358 rb x ditonton</div>
                                    <div class="date">Tanggal : 12 Des 2020</div>
                                </div>
                            </li>
                            <li id="5" data-src="" data-vbtype="video"
                                data-type="video/mp4" data-size="['576','720','1080']">
                                <div class="img-video">
                                    <img src="{{asset('ui_users/assets/img/blog-5.jpg')}}" alt="">
                                </div>
                                <div class="desc-video">
                                    <div class="title block-with-text">
                                        Top Songs 2020 Top 40 Populer Songs Playlist 2020
                                    </div>
                                    <div class="subTitle">Sub Title Video</div>
                                    <div class="watched">358 rb x ditonton</div>
                                    <div class="date">Tanggal : 12 Des 2020</div>
                                </div>
                            </li>
                            <li id="6" data-src="" data-vbtype="video"
                                data-type="video/mp4" data-size="['576','720','1080']">
                                <div class="img-video">
                                    <img src="{{asset('ui_users/assets/img/blog-6.jpg')}}" alt="">
                                </div>
                                <div class="desc-video">
                                    <div class="title block-with-text">
                                        Top Songs 2020 Top 40 Populer Songs Playlist 2020
                                    </div>
                                    <div class="subTitle">Sub Title Video</div>
                                    <div class="watched">358 rb x ditonton</div>
                                    <div class="date">Tanggal : 12 Des 2020</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        {{-- </div> --}}
    </section><!-- End Why-Us Section -->

    <!-- ======= Portfolio Section ======= -->
    <section id="portfolio" class="portfolio d-none">
        <div class="container">
            <div class="style right" data-aos="fade-up">

                <div class="title-box" data-aos="fade-up">
                    <div class="bg-box">
                        <p class="title">Portofolio</p>
                    </div>
                </div>

                <div class="row" data-aos="fade-up">
                    <div class="col-lg-12 d-flex justify-content-center">
                        <ul id="portfolio-flters">
                            <li data-filter="*" class="filter-active">All</li>
                            <li data-filter=".filter-app">App</li>
                            <li data-filter=".filter-card">Card</li>
                            <li data-filter=".filter-web">Web</li>
                        </ul>
                    </div>
                </div>

                <div class="row portfolio-container" data-aos="fade-up">

                    <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                        <img src="{{asset('ui_users/assets/img/portfolio/portfolio-1.jpg')}}" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>App 1</h4>
                            <p>App</p>
                            <a href="{{asset('ui_users/assets/img/portfolio/portfolio-1.jpg')}}"
                                data-gall="portfolioGallery" class="venobox preview-link" title="App 1"><i
                                    class="bx bx-plus"></i></a>
                            <a href="portfolio-details.html" class="details-link" title="More Details"><i
                                    class="bx bx-link"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-web">
                        <img src="{{asset('ui_users/assets/img/portfolio/portfolio-2.jpg')}}" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>Web 3</h4>
                            <p>Web</p>
                            <a href="{{asset('ui_users/assets/img/portfolio/portfolio-2.jpg')}}"
                                data-gall="portfolioGallery" class="venobox preview-link" title="Web 3"><i
                                    class="bx bx-plus"></i></a>
                            <a href="portfolio-details.html" class="details-link" title="More Details"><i
                                    class="bx bx-link"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                        <img src="{{asset('ui_users/assets/img/portfolio/portfolio-3.jpg')}}" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>App 2</h4>
                            <p>App</p>
                            <a href="{{asset('ui_users/assets/img/portfolio/portfolio-3.jpg')}}"
                                data-gall="portfolioGallery" class="venobox preview-link" title="App 2"><i
                                    class="bx bx-plus"></i></a>
                            <a href="portfolio-details.html" class="details-link" title="More Details"><i
                                    class="bx bx-link"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                        <img src="{{asset('ui_users/assets/img/portfolio/portfolio-4.jpg')}}" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>Card 2</h4>
                            <p>Card</p>
                            <a href="{{asset('ui_users/assets/img/portfolio/portfolio-4.jpg')}}"
                                data-gall="portfolioGallery" class="venobox preview-link" title="Card 2"><i
                                    class="bx bx-plus"></i></a>
                            <a href="portfolio-details.html" class="details-link" title="More Details"><i
                                    class="bx bx-link"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-web">
                        <img src="{{asset('ui_users/assets/img/portfolio/portfolio-5.jpg')}}" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>Web 2</h4>
                            <p>Web</p>
                            <a href="{{asset('ui_users/assets/img/portfolio/portfolio-5.jpg')}}"
                                data-gall="portfolioGallery" class="venobox preview-link" title="Web 2"><i
                                    class="bx bx-plus"></i></a>
                            <a href="portfolio-details.html" class="details-link" title="More Details"><i
                                    class="bx bx-link"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                        <img src="{{asset('ui_users/assets/img/portfolio/portfolio-6.jpg')}}" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>App 3</h4>
                            <p>App</p>
                            <a href="{{asset('ui_users/assets/img/portfolio/portfolio-6.jpg')}}"
                                data-gall="portfolioGallery" class="venobox preview-link" title="App 3"><i
                                    class="bx bx-plus"></i></a>
                            <a href="portfolio-details.html" class="details-link" title="More Details"><i
                                    class="bx bx-link"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                        <img src="{{asset('ui_users/assets/img/portfolio/portfolio-7.jpg')}}" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>Card 1</h4>
                            <p>Card</p>
                            <a href="{{asset('ui_users/assets/img/portfolio/portfolio-7.jpg')}}"
                                data-gall="portfolioGallery" class="venobox preview-link" title="Card 1"><i
                                    class="bx bx-plus"></i></a>
                            <a href="portfolio-details.html" class="details-link" title="More Details"><i
                                    class="bx bx-link"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                        <img src="{{asset('ui_users/assets/img/portfolio/portfolio-8.jpg')}}" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>Card 3</h4>
                            <p>Card</p>
                            <a href="{{asset('ui_users/assets/img/portfolio/portfolio-8.jpg')}}"
                                data-gall="portfolioGallery" class="venobox preview-link" title="Card 3"><i
                                    class="bx bx-plus"></i></a>
                            <a href="portfolio-details.html" class="details-link" title="More Details"><i
                                    class="bx bx-link"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-web">
                        <img src="{{asset('ui_users/assets/img/portfolio/portfolio-9.jpg')}}" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>Web 3</h4>
                            <p>Web</p>
                            <a href="{{asset('ui_users/assets/img/portfolio/portfolio-9.jpg')}}"
                                data-gall="portfolioGallery" class="venobox preview-link" title="Web 3"><i
                                    class="bx bx-plus"></i></a>
                            <a href="portfolio-details.html" class="details-link" title="More Details"><i
                                    class="bx bx-link"></i></a>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section><!-- End Portfolio Section -->

    <!-- ======= Our Clients Section ======= -->
    <section id="clients" class="clients d-none">
        <div class="container" data-aos="fade-up">
            <div class="style left">

                <div class="title-box" data-aos="fade-down">
                    <div class="bg-box">
                        <p class="title">Clients</p>
                    </div>
                </div>

                <div class="row no-gutters clients-wrap clearfix" data-aos="fade-up">

                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="client-logo">
                            <img src="{{asset('ui_users/assets/img/clients/client-1.png')}}" class="img-fluid" alt="">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="client-logo">
                            <img src="{{asset('ui_users/assets/img/clients/client-2.png')}}" class="img-fluid" alt="">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="client-logo">
                            <img src="{{asset('ui_users/assets/img/clients/client-3.png')}}" class="img-fluid" alt="">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="client-logo">
                            <img src="{{asset('ui_users/assets/img/clients/client-4.png')}}" class="img-fluid" alt="">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="client-logo">
                            <img src="{{asset('ui_users/assets/img/clients/client-5.png')}}" class="img-fluid" alt="">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="client-logo">
                            <img src="{{asset('ui_users/assets/img/clients/client-6.png')}}" class="img-fluid" alt="">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="client-logo">
                            <img src="{{asset('ui_users/assets/img/clients/client-7.png')}}" class="img-fluid" alt="">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="client-logo">
                            <img src="{{asset('ui_users/assets/img/clients/client-8.png')}}" class="img-fluid" alt="">
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>
    <!-- End Our Clients Section -->

    <!-- ======= Paket List Section ======= -->
    <section id="price-list" class="price-list section-bg">
        <div class="container" data-aos="fade-up">
            <div class="style left">

                <div class="title-box" data-aos="fade-left">
                    <div class="bg-box">
                        <p class="title">Price List</p>
                    </div>
                </div>

                <div class="row m-2" data-aos="fade-down" id="box-paket">
                    @php
                        $effect = ["","zoom-in","fade-up-right","fade-up-left","fade-down-left"]
                    @endphp
                    @for ($i = 1; $i < count($paket); $i++)
                        <div class="box-price col-xs-12 col-sm-12 col-md-6" data-aos="{{ $effect[$i] }}" data-aos-delay="{{100*$i}}">
                            <div class="box-price-list {{ $paket[$i]->warna_body }}">
                                <div class="tipe">{{$paket[$i]->name}}</div>
                                <div class="header">
                                    <div class="icon-price-list col-lg-4 p-0">
                                        <img src="{{ asset('custom/gambar/'.$paket[$i]->gambar) }}" alt="{{ 'Paket-'.$paket[$i]->name }}">
                                    </div>
                                    <div class="title col-lg-8">
                                        {{$paket[$i]->keterangan}}
                                    </div>
                                </div>
                                <div class="desc ml-3 mr-3">
                                    <div class="row">
                                        <ul>
                                            <li>Akses ke semua platform (Android dan Website)</li>
                                            <li>Transaksi Offline dan Online</li>
                                            <li>Multiple Outlet, Multiple Satuan & Harga</li>
                                            <li>Penjualan & Pembelian (Tunai, Kredit)</li>
                                            <li>Otorisasi Hak Akses & Multi User</li>
                                            <li>Seluruh Laporan Transaksi.</li>
                                            <li>dan lain-lain.</li>
                                        </ul>
                                    </div>
                                    <div class="row pl-4 mb-3">
                                        <p class="text-bold">Fasilitas :</p>
                                        @php
                                            $fasilitas = explode(",", $paket[$i]->max_features);
                                        @endphp
                                        <ol  style="padding-inline-start: 20px">
                                            <li>Max. Product : {{ $fasilitas[0] }} Product</li>
                                            <li>Max. Outlet/Toko : {{ $fasilitas[1] }} Outlet</li>
                                            <li>Max. Trx.Sale : {{ $fasilitas[2] }} Trx/bulan</li>
                                        </ol>
                                    </div>
                                </div>
                                <div class="footer">
                                    <div class="box-harga">
                                        <span class="fc">Rp.</span><span class="harga1">{{($paket[$i]->biaya/1000)}}</span>
                                        <span class="box-harga2">
                                            <div class="harga2">000</div>
                                            <div class="tenor">Bulan</div>
                                        </span>
                                    </div>


                                </div>
                            </div>
                        </div>
                    @endfor

                    @auth
                    @else
                        <div class="row p-4">
                            <div class="col-lg-8">
                                Aplikasi Kasir berbasis cloud yang diakses melalui semua platform
                                (Android dan Website) yang membawa bisnis Anda Go-Online.
                                Rasakan operasional yang jauh lebih mudah, jangkauan yang semakin
                                luas dan pertumbuhan bisnis yang semakin pesat.
                            </div>
                            <div class="col-lg-4 text-center align-self-center">
                                <a href="{{ route('register', ['tp' => 'free']) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-address-book"></i> Coba Gratis Sekarang!
                                </a>
                            </div>
                        </div>
                    @endauth

                </div>
            </div>
        </div>
    </section><!-- End price-list Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="d-none">
        <div class="container" data-aos="fade-up">

            <div class="style right">

                <div class="title-box" data-aos="fade-down">
                    <div class="bg-box">
                        <p class="title">Contact Us</p>
                    </div>
                </div>

                <div class="content contact row mt-1 d-flex justify-content-center" data-aos="fade-right"
                    data-aos-delay="100">

                    <div class="col-lg-5">
                        <div class="info">
                            <div class="address">
                                <i class="icofont-google-map"></i>
                                <h4>Location:</h4>
                                <p>{{ $website->alamat }}</p>
                            </div>

                            <div class="email">
                                <i class="icofont-envelope"></i>
                                <h4>Email:</h4>
                                <p>{{ $website->email }}</p>
                            </div>

                            <div class="phone">
                                <i class="icofont-phone"></i>
                                <h4>Call:</h4>
                                <p>{{ $website->telp }}</p>
                            </div>

                        </div>

                    </div>

                    <div class="col-lg-6 mt-5 mt-lg-0" data-aos="fade-left" data-aos-delay="100">

                        <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <input type="text" name="name" class="form-control" id="name"
                                        placeholder="Your Name" data-rule="minlen:4"
                                        data-msg="Please enter at least 4 chars" />
                                    <div class="validate"></div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <input type="email" class="form-control" name="email" id="email"
                                        placeholder="Your Email" data-rule="email"
                                        data-msg="Please enter a valid email" />
                                    <div class="validate"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="subject" id="subject"
                                    placeholder="Subject" data-rule="minlen:4"
                                    data-msg="Please enter at least 8 chars of subject" />
                                <div class="validate"></div>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="message" rows="5" data-rule="required"
                                    data-msg="Please write something for us" placeholder="Message"></textarea>
                                <div class="validate"></div>
                            </div>
                            <div class="mb-3">
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <div class="sent-message">Your message has been sent. Thank you!</div>
                            </div>
                            <div class="text-center"><button type="submit">Send Message</button></div>
                        </form>

                    </div>

                </div>

            </div>

        </div>
    </section><!-- End Contact Section -->

</main><!-- End #main -->
@endsection

@section('js-x')
<script>
    // Video
    $(document).ready(function () {
        const player = new Plyr('#player');
    })
</script>
@endsection
