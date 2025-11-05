<?php
// header.php

// ⭐ 1. 세션 시작 및 상태 확인 (다른 파일에서 호출될 경우를 대비하여 한 번 더 확인)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// 로그인 상태 변수 정의
$is_logged_in = isset($_SESSION['user_id']);
?>

<head>
    <link rel="stylesheet" href="header.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<header> 
    <div class="header-container">
        <div class="logo">
            <a href="./">ROUND LAB</a>
        </div>
        
        <ul class="nav">
            <li><a href="shop.php">SHOP</a></li>
            <li><a href="review.php">REVIEW</a></li> 
            <li><a href="brand.php">BRAND</a></li>
            <li><a href="center.php">C/S CENTER</a></li>
        </ul>
        <div class="header-icons">
            <button class="menu-toggle icon-btn" aria-label="메뉴 열기">
                <i class="fas fa-bars"></i>
            </button>
            
            <button class="icon-btn" title="검색"><i class="fas fa-search"></i></button> 
            
            <?php if ($is_logged_in): ?>
                <a href="mypage.php" class="icon-btn login-mypage-link" title="마이페이지">
                    <i class="fas fa-user"></i>
                </a>
                <a href="logout.php" class="icon-btn logout-btn" title="로그아웃">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            <?php else: ?>
                <a href="login.php" class="icon-btn login-mypage-link" title="로그인">
                    <i class="fas fa-user"></i>
                </a>
                <a href="register.php" class="icon-btn register-link" title="회원가입">
                    <i class="fas fa-user-plus"></i> </a>
            <?php endif; ?>

            <a href="cart.php" class="icon-btn" title="장바구니"><i class="fas fa-shopping-cart"></i></a>
        </div>
    </div>
</header>