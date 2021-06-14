<?php
//include ('../sql.php');

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


$query = mysqli_query($mysqli, 'SELECT ARTISTID, ARTISTNAME, ARTISTPHOTO FROM artists WHERE ARTISTPHOTO = ""');

while($row = $query->fetch_assoc()) {
    $options = array(
        'http' => array(
            'header' => "Authorization: Bearer $accestoken\r\n",
            'method' => 'GET'
        )
    );
    $context = stream_context_create($options);
    $contents = file_get_contents('https://api.spotify.com/v1/search?q=' . urlencode($row['ARTISTNAME']) . '&type=artist', false, $context);


    $contents = utf8_encode($contents);
    $results = json_decode($contents, true);
    if (count($results['artists']['items']) > 0) {
        $photourl = $results['artists']['items'][0]['images'][0]['url'];
        mysqli_query($mysqli, "UPDATE artists SET ARTISTPHOTO = '" . $photourl . "' WHERE ARTISTID = '" . $row['ARTISTID'] . "'");
        //echo $row['ARTISTNAME'] . ' - ' . $photourl . '<br>';
    } else {
        $photourl = "assets/images/users/avatar-generic.png";
        mysqli_query($mysqli, "UPDATE artists SET ARTISTPHOTO = '" . $photourl . "' WHERE ARTISTID = '" . $row['ARTISTID'] . "'");
        //echo $row['ARTISTNAME'] . ' - ' . $photourl . '<br>';
    }
}
?>
