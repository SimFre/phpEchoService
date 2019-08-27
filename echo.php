<?php
error_reporting(E_ALL);

// Collect data
$data = new stdClass();
$data->post = $_POST;
$data->get = $_GET;
$data->cookie = $_COOKIE;
$data->files = $_FILES;
$data->server = $_SERVER;
$data->headers = getallheaders();
$data->input = file_get_contents("php://input");
$data->contentMode = null;
$data->contentType = null;

$p = $_SERVER['PATH_INFO'] ?? "unknown";
switch($p) {
    case "/xml":
        $data->contentMode = "xml";
        $data->contentType = "text/xml";
    break;
    
    case "/plain":
        $data->contentMode = "plain";
        $data->contentType = "text/plain";
    break;
    
    case "/json":
    default:
        $data->contentMode = "json";
        $data->contentType = "text/json";
    break;
}

//$contentMode = "plain";
//$contentType = "text/plain";
//if (!empty($data->headers['Accept'])) {
//    $accept = $data->headers['Accept'];
//    if (substr_count($accept, "text/json")) {
///        $contentMode = "json";
///        $contentType = "text/json";
//    } elseif (substr_count($accept, "application/json")) {
//        $contentMode = "json";
//        $contentType = "application/json";
//    //} elseif (substr_count($accept, "application/xml")) {
//    //    $contentMode = "xml";
//    //    $contentType = "application/xml";
//    //} elseif (substr_count($accept, "text/xml")) {
//    //    $contentMode = "xml";
//    //    $contentType = "text/xml";
//    }
//}

//$serverHeaders = array();
//foreach ($_SERVER as $key => $value) {
//    if (strpos($key, 'HTTP_') === 0) {
//        $chunks = explode('_', $key);
//        $value = end($chunks);
//        $i = count($chunks);
//        if ($i == 1) {
//            $serverHeaders[$value] = "_n/a_";
//        } else {
//            unset($chunks[$i-1]);
//            $key = implode("_", $chunks);
//            $serverHeaders[$key] = $value;
//        }
//    }
//}

//$serverHeadersTxt = "";
//foreach ($_SERVER as $key => $value) {
//    if (strpos($key, 'HTTP_') === 0) {
//        $chunks = explode('_', $key);
//        $header = '';
//        for ($i = 1; $y = sizeof($chunks) - 1, $i < $y; $i++) {
//            $header .= ucfirst(strtolower($chunks[$i])).'-';
//        }
//        $header .= ucfirst(strtolower($chunks[$i])).': '.$value;
//        error_log($header);
//    }
//}

//error_log("Content-type: $contentType");
//error_log("X-Content-mode: $contentMode");

$json = json_encode($data, JSON_PRETTY_PRINT);

// Set output header

switch ($data->contentMode) {
    case "plain":
        header("Content-type: text/plain");
        echo "\n=== POST ===\n";
        print_r($data->post);

        echo "\n=== GET ===\n";
        print_r($data->get);

        echo "\n=== COOKIE ===\n";
        print_r($data->cookie);

        echo "\n=== FILES ===\n";
        print_r($data->files);

        echo "\n=== SERVER ===\n";
        print_r($data->server);

        echo "\n=== HEADERS ===\n";
        print_r($data->headers);

        echo "\n=== INPUT ===\n";
        var_dump($data->input);
    break;

    case "json":
    default:
        header("Content-type: text/json");
        echo $json;
    break;
    
    //case "xml":
    //$array = array('hello' => 'world', 'good' => 'morning');
    //$xml = simplexml_load_string('<'.'?xml version='1.0' encoding="utf-8"?'..'><echo />');
    //foreach ($array as $k=>$v) {
    //    $xml->addChild($k, $v);
    //}
    //break;



}

error_log($json);
echo PHP_EOL;
