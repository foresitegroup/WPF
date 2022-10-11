<?php
header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename=event.ics');

$output = "BEGIN:VCALENDAR\r\n";
$output .= "VERSION:2.0\r\n";
$output .= "BEGIN:VEVENT\r\n";
$output .= "DTSTAMP:".date("Ymd\THis\Z", time())."\r\n";
$output .= "UID:".uniqid()."\r\n";
$output .= "DTSTART:".$_POST['date_start']."\r\n";
$output .= "DTEND:".$_POST['date_end']."\r\n";
$output .= "SUMMARY:".preg_replace('/([\,;])/','\\\$1', $_POST['summary'])."\r\n";
$output .= "DESCRIPTION:".preg_replace('/([\,;])/','\\\$1', $_POST['description'])."\r\n";
$output .= "LOCATION:".preg_replace('/([\,;])/','\\\$1', $_POST['location'])."\r\n";
$output .= "END:VEVENT\r\n";
$output .= "END:VCALENDAR\r\n";

echo $output;
?>