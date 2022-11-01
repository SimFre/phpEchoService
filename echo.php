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
$data->contentExtension = "dat";
$data->contentType = "application/octet-stream";

$p = $_SERVER['PATH_INFO'] ?? "unknown";
$output = "";
switch($p) {
    case "/xml":
        $data->contentExtension = "xml";
        $data->contentType = "text/xml";
        $xml = '<root>';
        $xml .= generate_xml_from_array($data, "root", 0);
        $xml .= '</root>';
        $doc = new DOMDocument('1.0', 'utf-8');
        $doc->preserveWhiteSpace = false;
        $doc->formatOutput = true;
        $doc->loadXML($xml);
        $output = $doc->saveXML();
        break;

    case "/plain":
        $data->contentExtension = "txt";
        $data->contentType = "text/plain";
        $output = print_r($data, true);
        break;

    case "/json":
    default:
        $data->contentExtension = "json";
        $data->contentType = "application/json";
        $output = json_encode($data, JSON_PRETTY_PRINT);
        break;
}



function generate_xml_from_array($array, $node_name, $depth = 0)
{
    $xml = '';
    if (is_array($array) || is_object($array)) {
        foreach ($array as $key=>$value) {
            if (is_numeric($key)) {
                $key = $node_name;
            }
            $content = generate_xml_from_array($value, $node_name, $depth +1);
            if ($depth == 0) {
                $xml .= '<' . $key . '>' . $content . '</'.$key.'>';
            } else {
                $xml .= '<data key="' . $key . '">' . $content . '</data>';
            }
        }
    } else {
        $xml = htmlspecialchars($array, ENT_QUOTES);
    }
    return $xml;
}

header("Content-type: " . $data->contentType);
echo $output . PHP_EOL;
error_log($output . PHP_EOL);

$ymd = date("YmdHis");
@mkdir("output");
@file_put_contents("output/echo_".$ymd.".".$data->contentExtension, $output);
