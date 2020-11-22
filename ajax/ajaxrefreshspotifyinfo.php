<?php
if (!isset($_GET['artistid'])) {
    echo "No artist id supplied";
    die;
}
include ('../modules/sql.php');

$url = 'https://accounts.spotify.com/api/token';
$data = array('grant_type' => 'client_credentials');

// use key 'http' even if you send the request to https://...
$key = "Basic " . base64_encode("9df449a6b96b42b193bf61949876b854:d735dc62265f47f5810bf6c7af623b0f");

$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n" .
            "Authorization: $key\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) { /* Handle error */ }

$json = json_decode($result, true);
$accestoken = $json['access_token'];


$query = mysqli_query($mysqli, 'SELECT * FROM artists WHERE ARTISTID = ' . $_GET['artistid'] . ' LIMIT 0, 1');

while($row = $query->fetch_assoc()) {
    $options = array(
        'http' => array(
            'header' => "Authorization: Bearer $accestoken\r\n",
            'method' => 'GET'
        )
    );
    $context = stream_context_create($options);
    $spotifyartistid = $row['SPOTIFYID'];

    if ($spotifyartistid == "") {
        $contents = file_get_contents('https://api.spotify.com/v1/search?q=' . urlencode($row['ARTISTNAME']) . '&type=artist', false, $context);

        $contents = utf8_encode($contents);
        $results = json_decode($contents, true);

        if (count($results['artists']['items']) > 0) {
            $spotifyartistid = $results['artists']['items'][0]['id'];
            mysqli_query($mysqli, "UPDATE artists SET SPOTIFYID = '" . $spotifyartistid . "' WHERE ARTISTID = '" . $_GET['artistid'] . "'");
        }
    }


    $contents = file_get_contents('https://api.spotify.com/v1/artists/' . $spotifyartistid, false, $context);

    $contents = utf8_encode($contents);
    $results = json_decode($contents, true);
    if (count($results) > 0) {
        $followers = $results['followers']['total'];
        $genres = implode(", ", $results['genres']);
        $popularity = $results['popularity'];
        $photo = $results['images'][0]['url'];

        mysqli_query($mysqli, "UPDATE artists SET SPOTIFYGENRES = '" . $genres . "', SPOTIFYPOPULARITY = '" . $popularity . "', SPOTIFYFOLLOWERS = '" . $followers . "', ARTISTPHOTO = '" . $photo . "', SPOTIFYLASTUPDATED = NOW() WHERE ARTISTID = '" . $_GET['artistid'] . "'");
        echo "FIELDS UPDATED";

    } else {
        echo "NO RESULTS FOUND";
    }

    $contents = file_get_contents('https://api.spotify.com/v1/artists/' . $spotifyartistid . '/related-artists', false, $context);

    $contents = utf8_encode($contents);
    $results = json_decode($contents, true);

    $relatedartists = "";

    if (count($results['artists']) > 0) {
        for ($i=0; $i<count($results['artists']); $i++) {
            $relatedartists .= $results['artists'][$i]['name'];
            if ($i<(count($results['artists'])-1)) {
                $relatedartists .= ', ';
            }
        }
        mysqli_query($mysqli, "UPDATE artists SET SPOTIFYRELATEDARTISTS = '" . $relatedartists . "' WHERE ARTISTID = '" . $_GET['artistid'] . "'");
        echo ", RELATED ARTISTS UPDATED";
    }
}
?>
<?php
