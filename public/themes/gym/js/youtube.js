var players = [];
function onYouTubeIframeAPIReady() {
    $('.youtube-slide').each(function (index, youtubeSlide) {
        var index = $(youtubeSlide).data('index');
        var id = $(youtubeSlide).data('id');
        var properties = {
            height: '100%',
            width: '100%',
            videoId: id,
            events: {
                onStateChange: onPlayerStateChange
            },
            playerVars: {
                playlist: id,
                loop: 1,
                showinfo: 0,
                controls: 0,
                disablekb: 1,
                iv_load_policy: 3,
                rel: 0
            }
        };
        if (index == 1) {
            properties.events.onReady = onPlayerReady;
            _YOUTUBE_PATCH = true;
        }
        players[index] = new YT.Player('youtube-slide-' + index, properties);
    });
}

function onPlayerReady(event) {
    players[1].playVideo().mute();
}

function onPlayerStateChange(event) {
    if (event.data == YT.PlayerState.PLAYING) {
        $('#mute-ctrl').addClass('show');
    }
}
