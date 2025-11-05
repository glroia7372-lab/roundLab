<?php
// logout.php
session_start();

// 1. 모든 세션 변수 해제
$_SESSION = array();

// 2. 세션 쿠키 파괴
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 3. 세션 자체를 파괴
session_destroy();

// 4. 메인 페이지로 리다이렉트
header('Location: index.php');
exit;
?>