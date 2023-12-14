// // Video
// $(document).ready(function () {
//     const player = new Plyr('#player', {
/*option
    player.source = {
        type: 'video',
        title: 'Example title',
        sources: [
            {
            src: '/path/to/movie.mp4',
            type: 'video/mp4',
            size: 720,
            },
            {
            src: '/path/to/movie.webm',
            type: 'video/webm',
            size: 1080,
            },
        ],
        poster: '/path/to/poster.jpg',
        previewThumbnails: {
            src: '/path/to/thumbnails.vtt',
        },
        tracks: [
            {
            kind: 'captions',
            label: 'English',
            srclang: 'en',
            src: '/path/to/captions.en.vtt',
            default: true,
            },
            {
            kind: 'captions',
            label: 'French',
            srclang: 'fr',
            src: '/path/to/captions.fr.vtt',
            },
        ],
        };
    */
// });

// });

$(document).ready(function () {
    var vids = plyr.setup();
    $(".plyr__video-embed").each(function () {

        var $t = $(this),
            $cont = $t.closest(".video-play-container"),
            h = parseInt($cont.css("max-height")),
            w = parseInt($cont.css("max-width")),
            ratio = h / w,
            percent = ratio * 100,
            origH = $t.innerHeight(),
            origW = $t.innerWidth(),
            oldRatio = origH / origW,
            oldPercent = oldRatio * 100,
            diff = (percent - oldPercent) / 2;

        $t.css("padding-bottom", function () {
                return (percent - diff) + "%";
            })
            .css("padding-top", function () {
                return diff + "%";
            });

    });

});
