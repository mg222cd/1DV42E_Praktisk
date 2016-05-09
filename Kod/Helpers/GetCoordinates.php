<?php
if ( ! isset($_SESSION)) {
   session_start();
}
echo json_encode(['data' => ['lat' => $_SESSION['lat'], 'lng' => $_SESSION['lng']]], JSON_FORCE_OBJECT);