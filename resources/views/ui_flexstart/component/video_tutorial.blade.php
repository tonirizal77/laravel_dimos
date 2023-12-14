@php
    $theme = "ui_flexstart";
@endphp

@section('css-x')
    <link href="{{ asset($theme.'/assets/vendor/player/plyr.css')}}" rel="stylesheet">
@endsection

<!-- ======= Video-Us Section ======= -->
<section id="video-present" class="video-present bg-sec">
    <div class="container" data-aos="fade-up">
        <header class="section-header">
            <h2>Video Tutorials</h2>
            <p>Watching Our Video Tutorial</p>
        </header>

        <div class="row content">
            <div class="col-lg-8 p-1" data-aos="fade-right">
                <!-- Box Video-->
                <div id="box-video" class="col-lg-12" data-aos="fade-right">

                    {{-- <div class="plyr__video-embed" id="player">
                        <iframe
                            src="https://www.youtube.com/embed/bTqVqk7FSmY?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1"
                            allowfullscreen
                            allowtransparency
                            allow="autoplay"
                        ></iframe>
                    </div> --}}

                    {{-- <div class="plyr__video-embed" id="player" data-plyr-provider="youtube" data-plyr-embed-id="bTqVqk7FSmY"></div> --}}

                    <video id="player" class="js-player" crossorigin controls playsinline data-poster="{{asset($theme.'/assets/img/blog/blog-1.jpg')}}">

                        <!-- Video files -->
                        {{-- <source src="{{url('/video/Godzilla vs. Kong (2021).mp4')}}" type="video/mp4" size="576" /> --}}
                        {{-- <source src="{{url('/video/Godzilla vs. Kong (2021).mp4')}}" type="video/mp4" size="720" /> --}}
                        <source src="{{url('/video/Godzilla vs. Kong (2021).mp4')}}" type="video/mp4" size="1080" />

                        <!-- Caption files -->
                        <track kind="Captions" label="Indonesia" srclang="id" src="{{ url('/video/Godzilla vs. Kong (2021).srt')}}" default />
                        <track kind="Captions" label="Indo" srclang="id" src="{{ url('/video/Godzilla vs. Kong (2021).vtt')}}" />

                        <!-- Fallback for browsers that don't support the <video> element -->
                        <a href="{{url('/video/Godzilla vs. Kong (2021).mp4')}}" download>Download</a>
                    </video>
                </div>
                <!-- Box Title -->
                <div id="title-movie" class="col-lg-12 p-1">
                    Ariana Grande, Billie Ellish, Maroon 5, Ava Max, Charlie Puth, Bebe Rexha, Anne-Marie | Pop
                    Hits 2019
                </div>
                <!-- Description -->
                <div class="col-lg-12 d-flex flex-wrap justify-content-between desc-movie">
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
                    @for ($x=1; $x<10; $x++)
                        <li id="1" data-src="/movie/Captain-Marvel-2019.mp4" data-vbtype="video"
                            data-type="video/mp4" data-size="['576','720','1080']">
                            <div class="col-sm-5">
                                <div class="img-video">
                                    <img src="{{ asset('ui_users/assets/img/blog-1.jpg')}}" alt="">
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="desc-video">
                                    <div class="title">Top Songs 2020 Top 40 Populer Songs Playlist 2020</div>
                                    <div class="subTitle">Sub Title Video</div>
                                    <div class="watched">358 rb x ditonton</div>
                                    <div class="date">Tanggal : 12 Des 2020</div>
                                </div>
                            </div>
                        </li>
                    @endfor
                </ul>
            </div>
        </div>
    </div>
</section><!-- End Why-Us Section -->

@section('js-x')
    <script src="{{ asset($theme.'/assets/vendor/player/plyr.js')}}" crossorigin="anonymous"></script>
    <script>
        // Video
        $(document).ready(function () {
            const player = new Plyr('#player', {
                controls: [
                    'play-large', // The large play button in the center
                    'restart', // Restart playback
                    'rewind', // Rewind by the seek time (default 10 seconds)
                    'play', // Play/pause playback
                    'fast-forward', // Fast forward by the seek time (default 10 seconds)
                    'progress', // The progress bar and scrubber for playback and buffering
                    'current-time', // The current time of playback
                    'duration', // The full duration of the media
                    'mute', // Toggle mute
                    'volume', // Volume control
                    'captions', // Toggle captions
                    'settings', // Settings menu
                    'pip', // Picture-in-picture (currently Safari only)
                    'airplay', // Airplay (currently Safari only)
                    'download', // Show a download button with a link to either the current source or a custom URL you specify in your options
                    'fullscreen', // Toggle fullscreen

                ],
                i18n: {
                    restart: 'Restart',
                    rewind: 'Rewind {seektime} secs',
                    play: 'Play',
                    pause: 'Pause',
                    fastForward: 'Forward {seektime} secs',
                    seek: 'Seek',
                    played: 'Played',
                    buffered: 'Buffered',
                    currentTime: 'Current time',
                    duration: 'Duration',
                    volume: 'Volume',
                    mute: 'Mute',
                    unmute: 'Unmute',
                    enableCaptions: 'Enable captions',
                    disableCaptions: 'Disable captions',
                    enterFullscreen: 'Enter fullscreen',
                    exitFullscreen: 'Exit fullscreen',
                    frameTitle: 'Player for {title}',
                    captions: 'Captions',
                    settings: 'Settings',
                    speed: 'Speed',
                    normal: 'Normal',
                    quality: 'Quality',
                    loop: 'Loop',
                    start: 'Start',
                    end: 'End',
                    all: 'All',
                    reset: 'Reset',
                    disabled: 'Disabled',
                    advertisement: 'Ad',
                },
            });
        })
    </script>
@endsection
