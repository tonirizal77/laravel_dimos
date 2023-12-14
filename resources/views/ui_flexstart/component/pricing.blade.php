<section id="pricing" class="pricing">
    <div class="container" data-aos="fade-up">
        <header class="section-header">
            <h2>Pricing</h2>
            <p>Check Our Pricing</p>
        </header>

        <div class="row gy-4" data-aos="fade-left">
            @php
                $gambar      = ["","pricing-free.png","pricing-starter.png","pricing-business.png","pricing-ultimate.png"];
                $warna_title = ["","#07d5c0","#65c600","#ff901c","#ff0071"];
                $warna_bg    = ["","bg-primary","bg-dark","bg-danger","bg-info"];
            @endphp

            @for ($i = 1; $i < count($paket); $i++)
                <div class="col-lg-3 col-md-6 col-sm-12" data-aos="zoom-in" data-aos-delay="{{100*$i}}">
                    <div class="box">
                        @if ($i == 3)
                            <span class="featured">Featured</span>
                        @endif
                        <div class="row justify-content-center">
                            {{-- <div class="col-lg-5 col-md-12 col-sm-12 mb-2">
                                <img style="border-radius:20px" class="img-fluid bg-gradient {{$warna_bg[$i]}}"
                                    src="{{asset('custom/gambar/'.$paket[$i]->gambar)}}"
                                    alt="{{'Paket-'.$paket[$i]->name}}">
                            </div> --}}
                            <div class="col-md-4 col-lg-12 mb-2">
                                <img style="border-radius:20px" class="img-fluid"
                                    src="{{asset($theme.'/assets/img/'.$gambar[$i])}}"
                                    alt="{{'Paket-'.$paket[$i]->name}}">
                            </div>
                            <div class="col-md-4 col-lg-12">
                                <h3 style="color: {{$warna_title[$i]}}">Paket {{$paket[$i]->name}}</h3>
                                <div class="price">
                                    <sup>Rp</sup>{{($paket[$i]->biaya/1000)}}<span>ribu/bln</span>
                                </div>
                                <div class="title">{{$paket[$i]->keterangan}}</div>
                            </div>
                        </div>

                        @php
                            $fasilitas = explode(",", $paket[$i]->max_features);
                        @endphp

                        <div class="row">
                            <div class="col-sm-12">
                                <p style="font-size: 14px">Ketentuan :</p>
                                <ol class="text-start" style="padding-inline-start: 20px">
                                    <li>Max. Product : {{ $fasilitas[0] }} Product</li>
                                    <li>Max. Outlet/Toko : {{ $fasilitas[1] }} Outlet</li>
                                    <li>Max. Trx.Sale : {{ $fasilitas[2] }} Trx/bulan</li>
                                </ol>
                            </div>
                        </div>
                        {{-- <a href="#" class="btn-buy">Join Now!</a> --}}
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section><!-- End Pricing Section -->
