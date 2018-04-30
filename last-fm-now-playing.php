<?php

/*-------------
Basic cURL Request to the last.fm endpoint

Usage:

<?php displayLastFM(); ?>
--------------*/

function getLastFm() {

    $user     = '** USERNAME **'; // Enter your username here
    $key      = '** API KEYS **'; // Enter your API Key
    $status   = 'Last Played:'; // default to this, if 'Now Playing' is true, the json will reflect this.
    $endpoint = 'https://ws.audioscrobbler.com/2.0/?method=user.getrecenttracks&user=' . $user . '&&limit=2&api_key=' . $key . '&format=json';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); // 0 for indefinite
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); // 10 second attempt before timing out
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));

    $response = curl_exec($ch);
    $lastfm[] = json_decode($response, true);

    curl_close($ch);

    $artwork = $lastfm[0]['recenttracks']['track'][0]['image'][2]['#text'];

    if ( empty( $artwork ) ) {
        $artwork = 'artwork-fallback.png';
    }

    $trackInfo = [
        'name'       => $lastfm[0]['recenttracks']['track'][0]['name'],
        'artist'     => $lastfm[0]['recenttracks']['track'][0]['artist']['#text'],
        'link'       => $lastfm[0]['recenttracks']['track'][0]['url'],
        'albumArt'   => $artwork,
        'status'     => $status
    ];

    if ( !empty($lastfm[0]['recenttracks']['track'][0]['@attr']['nowplaying']) ) {
        $trackInfo['nowPlaying'] = $lastfm[0]['recenttracks']['track'][0]['@attr']['nowplaying'];
        $trackInfo['status'] = 'Now Playing:';
    }

    return displayLastFM($trackInfo);
}

/*-------------
Secondary function to display
the track info on the frontend
--------------*/

function displayLastFM($trackInfo) { ?>

    <section id="now-playing">
        <figure class="lastfm-artwork">
            <a href="<?php echo $trackInfo['link']; ?>" title="See <?php echo $trackInfo['artist'] . ' - ' . $trackInfo['name']; ?> on Last FM">
                <img id="albumart" alt="<?php echo $trackInfo['artist'] . ' - ' . $trackInfo['name']; ?>" src="<?php echo $trackInfo['albumArt']; ?>">
            </a>
        </figure>
        <figcaption class="lastfm-trackinfo">
            <h6><?php echo $trackInfo['status']; ?></h6>
            <p class="title">&#8220;<span class="song-title"><?php echo $trackInfo['name']; ?></span>&#8221;</p>

            <p class="artistname"><span class="artist"><?php echo $trackInfo['artist']; ?></span></p>
        </figcaption>
    </section>
<?php } ?>