<?php
// logout.php
session_start();

// 세션 변수 삭제
unset($_SESSION['user_id']);

// 세션 자체를 파괴
session_destroy();

// 메인 페이지로 리다이렉트
header('Location: index.php');
exit;
?>