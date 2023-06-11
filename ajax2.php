<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
header('Content-type: application/json');

require_once('google-calendar-api.php');

try {
	// Get event details
	$event = $_POST['event_details'];

	$capi = new GoogleCalendarApi();

	$events = $capi->GetCalenderEvents('primary', $_SESSION['access_token']);
  $str = '<ul>';

  foreach ($events as $event)
  {
    $startDate = "N.A";
    if ($event['start']['date'] != "") {
      $startDate = $event['start']['date'];
    }
     $str = $str.'<li>'."The event is : ".$event['summary']." and it's status is ".$event['status']." Start Date : ".$startDate."</li>";
  }

  $str = $str.'</ul>';

  echo $str;
}

catch(Exception $e) {
	header('Bad Request', true, 400);
    echo json_encode(array( 'error' => 1, 'message' => $e->getMessage() ));
}
?>