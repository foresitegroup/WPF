<?php
header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename=event.ics');

$output = "BEGIN:VCALENDAR\r\n";
$output .= "VERSION:2.0\r\n";
$output .= "BEGIN:VEVENT\r\n";
$output .= "DTSTAMP:".date("Ymd\THis\Z", time())."\r\n";
$output .= "UID:".uniqid()."\r\n";
$output .= "DTSTART:";
if (isset($_POST['date_start'])) $output .= $_POST['date_start'];
$output .= "\r\n";
$output .= "DTEND:";
if (isset($_POST['date_end'])) $output .= $_POST['date_end'];
$output .= "\r\n";
$output .= "SUMMARY:";
if (isset($_POST['summary'])) $output .= preg_replace('/([\,;])/','\\\$1', $_POST['summary']);
$output .= "\r\n";
$output .= "DESCRIPTION:";
if (isset($_POST['description'])) $output .= preg_replace('/([\,;])/','\\\$1', $_POST['description']);
$output .= "\r\n";
$output .= "LOCATION:";
if (isset($_POST['location'])) $output .= preg_replace('/([\,;])/','\\\$1', $_POST['location']);
$output .= "\r\n";
$output .= "END:VEVENT\r\n";
$output .= "END:VCALENDAR\r\n";

echo $output;
?>