<?php
error_reporting(-1);
include_once 'telemetry_settings.php';
require 'idObfuscation.php';

$download_speed = ($_POST['download_speed']);
$upload_speed = ($_POST['upload_speed']);
$ping = ($_POST['ping']);
$jitter = ($_POST['jitter']);
$client_ip = ($_POST['client_ip']);
$isp_name = ($_POST['isp_name']);
$latitude = ($_POST['latitude']);
$longitude = ($_POST['longitude']);
$user_agent = ($_SERVER['HTTP_USER_AGENT']);
$resolution = ($_POST['resolution']);
$dpi = ($_POST['dpi']);
$internet_type = 'wifi';
$battery_level = ($_POST['battery']);
$perfomance = ($_POST['perfomance']);

if ($redact_ip_addresses) {
    $ip = '0.0.0.0';
    $ipv4_regex = '/(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)/';
    $ipv6_regex = '/(([0-9a-fA-F]{1,4}:){7,7}[0-9a-fA-F]{1,4}|([0-9a-fA-F]{1,4}:){1,7}:|([0-9a-fA-F]{1,4}:){1,6}:[0-9a-fA-F]{1,4}|([0-9a-fA-F]{1,4}:){1,5}(:[0-9a-fA-F]{1,4}){1,2}|([0-9a-fA-F]{1,4}:){1,4}(:[0-9a-fA-F]{1,4}){1,3}|([0-9a-fA-F]{1,4}:){1,3}(:[0-9a-fA-F]{1,4}){1,4}|([0-9a-fA-F]{1,4}:){1,2}(:[0-9a-fA-F]{1,4}){1,5}|[0-9a-fA-F]{1,4}:((:[0-9a-fA-F]{1,4}){1,6})|:((:[0-9a-fA-F]{1,4}){1,7}|:)|fe80:(:[0-9a-fA-F]{0,4}){0,4}%[0-9a-zA-Z]{1,}|::(ffff(:0{1,4}){0,1}:){0,1}((25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])\.){3,3}(25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])|([0-9a-fA-F]{1,4}:){1,4}:((25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])\.){3,3}(25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9]))/';
    $hostname_regex = '/"hostname":"([^\\\\"]|\\\\")*"/';
    $ispinfo = preg_replace($ipv4_regex, '0.0.0.0', $ispinfo);
    $ispinfo = preg_replace($ipv6_regex, '0.0.0.0', $ispinfo);
    $ispinfo = preg_replace($hostname_regex, '"hostname":"REDACTED"', $ispinfo);
    $log = preg_replace($ipv4_regex, '0.0.0.0', $log);
    $log = preg_replace($ipv6_regex, '0.0.0.0', $log);
    $log = preg_replace($hostname_regex, '"hostname":"REDACTED"', $log);
}

header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0, s-maxage=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

    $conn = new mysqli($MySql_hostname, $MySql_username, $MySql_password, $MySql_databasename) or die('1');
    $sql = "INSERT INTO speedtest_users (download_speed,upload_speed,ping,jitter,client_ip,isp_name,latitude,longitude,user_agent,resolution,dpi,internet_type,battery_level,perfomance) VALUES ('{$download_speed}','{$upload_speed}','{$ping}','{$jitter}','{$client_ip}','{$isp_name}','{$latitude}','{$longitude}','{$user_agent}','{$resolution}','{$dpi}','{$internet_type}','{$battery_level}','{$perfomance}')";
    mysqli_query($conn, $sql) or die($conn->error);
    $id = $conn->insert_id;
    echo 'id '.($enable_id_obfuscation ? obfuscateId($id) : $id);
    $conn->close() or die('6');
?>
