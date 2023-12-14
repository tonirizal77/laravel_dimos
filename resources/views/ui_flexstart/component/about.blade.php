<section id="about" class="about">
    <div class="container" data-aos="fade-up">
        <div class="row gx-0">

            <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
                <div class="content">
                    <h3>About Us</h3>
                    <h2>{{$website->nama}} - Simple Distribution Management Online System</h2>
                    <p>
                        <b> {{$website->nama}}</b> merupakan penyedia sarana layanan <b>Aplikasi Kasir Online yang berbasis Web dan Android</b>
                        yang dirancang khusus untuk pelaku bisnis yang bergerak dalam Bidang Distribusi Barang Perdagangan yang dapat
                        lebih cepat memproses transaksi pemesanan, transaksi penjualan, pengiriman barang, pengiriman informasi
                        produk, promo produk, dan lain-lainnya kepada pelanggannya.
                    </p>
                    {{-- <div class="text-center text-lg-start">
                        <a href="" class="btn-read-more d-inline-flex align-items-center justify-content-center align-self-center">
                        <span>Read More</span>
                        <i class="bi bi-arrow-right"></i>
                        </a>
                    </div> --}}
                </div>
            </div>

            <div class="col-lg-6 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="400">
                <img src="{{asset($theme.'/assets/img/warehouse.jpg')}}" class="img-fluid" alt="">
            </div>

        </div>
    </div>
</section><!-- End About Section -->
