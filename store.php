<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if($_GET['key'] == 'random_key') {
  $data = json_decode(file_get_contents('php://input'), true);
  if($_GET['method'] == 'add') {
    $handle= fopen("shows.json", "r") or die("Unable to open file!");
    $raw = fread($handle, filesize("shows.json"));
    fclose($handle);

    $json = json_decode($raw, true);
    $data['id'] = sizeof($json);
    array_push($json, $data);

    $handle = fopen("shows.json", "w") or die ("Unable to open file!");
    fwrite($handle, json_encode($json));
    fclose($handle);

    echo json_encode($json);
  }
  else if($_GET['method'] == 'read') {
    $handle= fopen("shows.json", "r") or die("Unable to open file!");
    $raw = fread($handle, filesize("shows.json"));
    fclose($handle);
    echo $raw;
  }
  else if($_GET['method'] == 'delete') {
    $handle= fopen("shows.json", "r") or die("Unable to open file!");
    $raw = fread($handle, filesize("shows.json"));
    fclose($handle);

    $json = json_decode($raw, true);
    foreach($json as $key=>$entry) {
      if($entry['id'] == $data['id']) {
        unset($json[$key]);
        break;
      }
    }

    $json = array_values($json);

    //reset ids by index
    foreach($json as $key=>$entry) {
      $json[$key]['id'] = $key;
    }

    $handle = fopen("shows.json", "w") or die ("Unable to open file!");
    fwrite($handle, json_encode($json));
    fclose($handle);

    echo json_encode($json);
  }
  else if ($_GET['method'] == 'update') {
    $handle= fopen("shows.json", "r") or die("Unable to open file!");
    $raw = fread($handle, filesize("shows.json"));
    fclose($handle);

    $json = json_decode($raw, true);
    foreach($json as $key=>$entry) {
      if($entry['id'] == $data['id']) {
        $data['id'] = $key;
        $json[$key] = $data;
        break;
      }
    }

    $json = array_values($json);

    $handle = fopen("shows.json", "w") or die ("Unable to open file!");
    fwrite($handle, json_encode($json));
    fclose($handle);

    echo json_encode($json);
  }
}
?>
