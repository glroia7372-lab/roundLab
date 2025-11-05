<?php
// 세션 시작: 장바구니 데이터를 저장하고 접근하기 위해 필수입니다.
session_start();

// 장바구니 배열 초기화: 세션에 'cart' 배열이 없으면 새로 생성합니다.
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$total_price = 0;
$notification_message = '';

// =======================================================
// 1. 장바구니 추가 (Add to Cart) 로직
// =======================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
    $name = filter_input(INPUT_POST, 'product_name', FILTER_SANITIZE_SPECIAL_CHARS);
    $price = filter_input(INPUT_POST, 'product_price', FILTER_VALIDATE_INT);
    $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
    $image = filter_input(INPUT_POST, 'product_image', FILTER_SANITIZE_URL);

    if ($id && $name && $price && $quantity > 0) {
        if (isset($_SESSION['cart'][$id])) {
            // 이미 있는 상품이면 수량 증가
            $_SESSION['cart'][$id]['quantity'] += $quantity;
        } else {
            // 새로운 상품이면 추가
            $_SESSION['cart'][$id] = [
                'id' => $id,
                'name' => $name,
                'price' => $price,
                'quantity' => $quantity,
                'image' => $image,
            ];
        }

        // shop.php로 리다이렉션하여 POST 재전송을 방지하고 알림 표시 (shop.php에서 이 세션을 사용)
        $_SESSION['cart_add_success'] = "✅ " . htmlspecialchars($name) . " 상품을 장바구니에 담았습니다.";
        header('Location: shop.php');
        exit();
    }
}

// =======================================================
// 2. 장바구니 수정 (Update Quantity) 로직
// =======================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
    $id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
    $new_quantity = filter_input(INPUT_POST, 'new_quantity', FILTER_VALIDATE_INT);

    if ($id && isset($_SESSION['cart'][$id])) {
        if ($new_quantity > 0) {
            // 수량 업데이트
            $_SESSION['cart'][$id]['quantity'] = $new_quantity;
            $notification_message = "수량이 성공적으로 업데이트되었습니다.";
        } else {
            // 수량이 0 이하면 상품 제거
            unset($_SESSION['cart'][$id]);
            $notification_message = "상품이 장바구니에서 제거되었습니다.";
        }
    }
}

// =======================================================
// 3. 장바구니 삭제 (Remove Item) 로직
// =======================================================
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['remove_item'])) {
    $id_to_remove = filter_input(INPUT_GET, 'remove_item', FILTER_VALIDATE_INT);
    
    if ($id_to_remove && isset($_SESSION['cart'][$id_to_remove])) {
        unset($_SESSION['cart'][$id_to_remove]);
        $notification_message = "상품이 장바구니에서 제거되었습니다.";
        
        // GET 요청 후 새로고침 시 중복 제거 방지를 위해 리다이렉션
        header('Location: cart.php');
        exit();
    }
}

// =======================================================
// 4. 총액 계산 로직
// =======================================================
foreach ($_SESSION['cart'] as $item) {
    // 상품 가격 * 수량으로 총액 계산
    $total_price += ($item['price'] * $item['quantity']);
}

// PHP 종료 후 HTML 출력 시작
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>라운드랩 | 장바구니</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* 글로벌 설정 및 초기화 (shop.php와 동일하게 유지) */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Noto Sans KR', sans-serif; color: #333; line-height: 1.5; min-width: 320px; background-color: #ffffff; }
        a { text-decoration: none; color: inherit; }
        .container { max-width: 1200px; padding: 0 40px; margin: 0 auto; } /* 장바구니는 조금 좁은 컨테이너 사용 */

        /* 1. Header (shop.php와 동일) */
        header { position: fixed; top: 0; width: 100%; background-color: #fff; z-index: 1000; box-shadow: 0 1px 5px rgba(0,0,0,0.1); padding: 10px 5%; }
        .header-container { max-width: 1400px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; height: 50px; }
        .logo a { font-family: 'Montserrat', sans-serif; font-size: 1.2rem; font-weight: 800; color: #333; letter-spacing: 0.5px; }
        .nav { display: flex; list-style: none; gap: 2.2rem; }
        .nav a { font-size: 0.95rem; font-weight: 600; color: #666; transition: color 0.3s; }
        .nav a:hover { color: #333; }
        .header-icons { display: flex; gap: 1.0rem; align-items: center; }
        .icon-btn { background: none; border: none; cursor: pointer; font-size: 1.05rem; color: #666; transition: color 0.3s; }
        .icon-btn:hover { color: #333; }
        .menu-toggle { display: none; }
        
        /* 2. Main Content (장바구니 전용) */
        .cart-main { padding-top: 120px; padding-bottom: 80px; } /* 헤더 높이 감안 */
        .cart-main h1 { font-size: 2.2rem; font-weight: 700; margin-bottom: 40px; text-align: center; }
        
        /* 장바구니 테이블 스타일 */
        .cart-table-container { margin-bottom: 40px; }
        .cart-table { width: 100%; border-collapse: collapse; text-align: left; font-size: 15px; }
        .cart-table th, .cart-table td { padding: 15px 10px; border-bottom: 1px solid #eee; }
        .cart-table th { font-weight: 600; color: #555; border-top: 2px solid #333; }
        .cart-table tr:last-child td { border-bottom: none; }

        /* 상품 정보 열 */
        .product-info { display: flex; align-items: center; gap: 15px; }
        .product-info img { width: 80px; height: auto; border-radius: 4px; border: 1px solid #f0f0f0; }
        .product-name a { font-weight: 500; }
        
        /* 수량 입력 */
        .quantity-form { display: flex; align-items: center; }
        .quantity-form input[type="number"] { width: 60px; padding: 5px; text-align: center; border: 1px solid #ccc; border-radius: 4px; margin-right: 10px; }
        .quantity-form button { padding: 5px 10px; background-color: #f7f7f7; border: 1px solid #ddd; border-radius: 4px; cursor: pointer; transition: background-color 0.2s; font-size: 14px; }
        .quantity-form button:hover { background-color: #eee; }

        /* 가격 정보 */
        .cart-price { font-weight: 600; color: #333; }
        .cart-remove a { color: #aaa; font-size: 1.1rem; transition: color 0.2s; }
        .cart-remove a:hover { color: #e74c3c; }

        /* 총액 섹션 */
        .cart-summary { 
            display: flex; 
            justify-content: flex-end; 
            margin-top: 30px;
            border-top: 2px solid #333;
            padding-top: 20px;
        }
        .summary-box { width: 100%; max-width: 400px; padding: 20px; background-color: #f9f9f9; border-radius: 8px; }
        .summary-line { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 16px; }
        .summary-total { font-size: 1.4rem; font-weight: 700; color: #000; margin-top: 15px; border-top: 1px dashed #ddd; padding-top: 15px; }
        
        /* 버튼 그룹 */
        .cart-actions { display: flex; justify-content: space-between; margin-top: 40px; }
        .continue-shopping { padding: 12px 25px; background: none; border: 1px solid #ccc; border-radius: 4px; cursor: pointer; font-size: 16px; transition: background-color 0.2s; }
        .continue-shopping:hover { background-color: #f0f0f0; }
        .checkout-btn { padding: 12px 30px; background-color: #000; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: 500; transition: opacity 0.2s; }
        .checkout-btn:hover { opacity: 0.8; }
        
        /* 빈 장바구니 */
        .empty-cart { text-align: center; padding: 80px 0; border: 1px solid #eee; border-radius: 8px; background-color: #fcfcfc; }
        .empty-cart p { font-size: 1.2rem; color: #777; margin-bottom: 20px; }
        
        /* 알림 메시지 */
        .notification {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 16px;
        }

        /* 3. Footer (shop.php와 동일) */
        .main-footer { background-color: #f7f9fc; padding: 40px 0 20px; font-size: 14px; margin-top: 50px; }
        .footer-grid { display: flex; justify-content: space-between; gap: 20px; padding-bottom: 40px; border-bottom: 1px solid #ddd; }
        .footer-grid strong { display: block; margin-bottom: 15px; font-weight: 700; text-transform: uppercase; font-size: 16px; }
        .copyright { text-align: center; font-size: 10px; color: #999; padding-top: 20px; }
    </style>
</head>
<body>

    <header>
        <div class="header-container">
            <div class="logo"><a href="index.php">ROUND LAB</a></div>
            <ul class="nav">
                <li><a href="shop.php">SHOP</a></li>
                <li><a href="index.php#review">REVIEW</a></li>
                <li><a href="index.php#brand">BRAND</a></li>
                <li><a href="index.php#center">C/S CENTER</a></li>
            </ul>
            <div class="header-icons">
                <button class="menu-toggle icon-btn" aria-label="메뉴 열기"><i class="fas fa-bars"></i></button>
                <button class="icon-btn"><i class="fas fa-search"></i></button>
                <a href="login.php" class="icon-btn" title="로그인/마이페이지"><i class="fas fa-user"></i></a>
                <a href="cart.php" class="icon-btn" title="쇼핑카트"><i class="fas fa-shopping-cart"></i></a>
            </div>
        </div>
    </header>

    <main class="cart-main container">
        <h1>쇼핑 카트</h1>

        <?php if (!empty($notification_message)): ?>
            <div class="notification"><?= $notification_message ?></div>
        <?php endif; ?>

        <?php if (empty($_SESSION['cart'])): ?>
            <div class="empty-cart">
                <p>장바구니가 비어 있습니다. 😢</p>
                <a href="shop.php" class="continue-shopping">상품 보러 가기</a>
            </div>
        <?php else: ?>
            <div class="cart-table-container">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th style="width: 40%;">상품</th>
                            <th style="width: 15%;" class="hide-mobile">가격</th>
                            <th style="width: 20%;">수량</th>
                            <th style="width: 15%;">총액</th>
                            <th style="width: 10%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart'] as $item): ?>
                            <tr>
                                <td>
                                    <div class="product-info">
                                        <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                                        <span class="product-name"><a href="#"><?= htmlspecialchars($item['name']) ?></a></span>
                                    </div>
                                </td>
                                <td class="hide-mobile">
                                    <?= number_format($item['price']) ?> KRW
                                </td>
                                <td>
                                    <form action="cart.php" method="POST" class="quantity-form">
                                        <input type="hidden" name="update_cart" value="1">
                                        <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                        <input type="number" name="new_quantity" value="<?= $item['quantity'] ?>" min="1">
                                        <button type="submit">수정</button>
                                    </form>
                                </td>
                                <td class="cart-price">
                                    <?= number_format($item['price'] * $item['quantity']) ?> KRW
                                </td>
                                <td class="cart-remove">
                                    <a href="cart.php?remove_item=<?= $item['id'] ?>" title="장바구니에서 제거"><i class="fas fa-times"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="cart-summary">
                <div class="summary-box">
                    <div class="summary-line">
                        <span>상품 합계</span>
                        <span><?= number_format($total_price) ?> KRW</span>
                    </div>
                    <div class="summary-line">
                        <span>배송비</span>
                        <span>0 KRW</span> </div>
                    <div class="summary-total">
                        <span>총 결제 금액</span>
                        <span><?= number_format($total_price) ?> KRW</span>
                    </div>
                </div>
            </div>

            <div class="cart-actions">
                <a href="shop.php" class="continue-shopping">쇼핑 계속하기</a>
                <button class="checkout-btn">결제하기</button>
            </div>
        <?php endif; ?>
    </main>

    <footer class="main-footer">
        <div class="footer-grid container">
            <div><strong>Company</strong><p><a href="#">About Us</a><a href="#">CSR</a><a href="#">Commitment</a></p></div>
            <div><strong>Customer Care</strong><p><a href="#">FAQ</a><a href="#">Shipping & Returns</a><a href="#">Contact Us</a></p></div>
            <div><strong>Sign In</strong><p><a href="#">Track Order</a><a href="#">Store Locator</a><a href="#">Gift Card</a></p></div>
            <div><strong>News Letter</strong><p><a href="#">Email Address</a></p></div>
            <div><strong>Social</strong><p><a href="#">Instagram</a><a href="#">YouTube</a><a href="#">Facebook</a></p></div>
        </div>
        <p class="copyright">Terms & Conditions | Privacy Policy | Cookies | ISO BEAUTY Group Inc. 2022 All rights reserved.</p>
    </footer>
</body>
</html>