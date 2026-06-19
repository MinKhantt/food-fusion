<?php
session_start();
unset($_SESSION['lockout_time']);
unset($_SESSION['login_attempts']);
session_regenerate_id(true);
header('Content-Type: application/json');
echo json_encode(['success' => true]);
exit();
?>