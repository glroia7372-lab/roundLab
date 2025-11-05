<?php
// PHP 시작 - 세션을 시작하여 장바구니 정보를 유지합니다.
session_start();

// 장바구니 아이템 추가 후 리다이렉션을 위한 함수 (선택 사항이지만 사용자 경험을 위해 권장)
function redirectToShop() {
    // 장바구니 처리가 완료된 후 상품 목록 페이지로 돌아가기
    header("Location: shop.php");
    exit();
}

// ⚠️ 실제 데이터베이스 연결 대신 하드코딩된 상품 데이터입니다.
// price 값은 숫자(int)로 유지하여 계산에 사용합니다.
$productData = [
    101 => ['name' => 'Multi-Peptide + HA Serum', 'price' => 38000, 'priceKr' => '38,000 KRW', 'image' => 'https://placehold.co/300x450/f7f9fc/333?text=Multi+Serum'],
    102 => ['name' => 'Niacinamide 10% + Zinc 1%', 'price' => 17500, 'priceKr' => '17,500 KRW', 'image' => 'https://placehold.co/300x450/f7f9fc/333?text=Niacinamide'],
    103 => ['name' => 'Lactic Acid 10% + HA', 'price' => 18500, 'priceKr' => '18,500 KRW', 'image' => 'https://placehold.co/300x450/f7f9fc/333?text=Lactic+Acid'],
    104 => ['name' => 'Hyaluronic Acid 2% + B5', 'price' => 16000, 'priceKr' => '16,000 KRW', 'image' => 'https://placehold.co/300x450/f7f9fc/333?text=HA+B5'],
    105 => ['name' => '"Buffet" + Copper Peptides 1%', 'price' => 38500, 'priceKr' => '38,500 KRW', 'image' => 'https://placehold.co/300x450/f7f9fc/333?text=Copper+Peptide'],
    106 => ['name' => 'Caffeine Solution 5% + EGCG', 'price' => 17000, 'priceKr' => '17,000 KRW', 'image' => 'https://placehold.co/300x450/f7f9fc/333?text=Caffeine'],
    107 => ['name' => 'Glycolipid Cream Cleanser', 'price' => 21000, 'priceKr' => '21,000 KRW', 'image' => 'https://placehold.co/300x450/f7f9fc/333?text=Cleanser'],
    108 => ['name' => '100% Niacinamide Powder', 'price' => 21000, 'priceKr' => '21,000 KRW', 'image' => 'https://placehold.co/300x450/f7f9fc/333?text=Powder'],
    109 => ['name' => 'Squalane Cleanser', 'price' => 22000, 'priceKr' => '22,000 KRW', 'image' => 'https://placehold.co/300x450/f7f9fc/333?text=Squalane'],
];

// --- 정렬 로직 (PHP에서 처리) ---
$currentSort = $_GET['sort'] ?? 'default';
$sortedProducts = $productData;

switch ($currentSort) {
    case 'name-asc':
        usort($sortedProducts, fn($a, $b) => strcmp($a['name'], $b['name']));
        break;
    case 'price-asc':
        usort($sortedProducts, fn($a, $b) => $a['price'] - $b['price']);
        break;
    case 'default':
        // 키(ID)를 기준으로 정렬
        ksort($sortedProducts);
        $sortedProducts = $productData;
        break;
}

// ⚠️ 장바구니 추가 알림을 위한 세션 변수 처리
$cart_notification_message = null;
if (isset($_SESSION['cart_add_success'])) {
    $cart_notification_message = $_SESSION['cart_add_success'];
    unset($_SESSION['cart_add_success']); // 알림을 한 번 표시했으면 제거
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>라운드랩 | 전체 상품</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* 글로벌 설정 및 초기화 */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Noto Sans KR', sans-serif; color: #333; line-height: 1.5; min-width: 320px; background-color: #ffffff; }
        a { text-decoration: none; color: inherit; }
        .container { max-width: 1400px; padding: 0 40px; margin: 0 auto; }

        
        .hero-banner {
            width: 100%; height: 250px; background-color: #f7f9fc;
            background-image: url('https://placehold.co/1400x250/f0f4f8/333?text=ROUNDLAB+Banner');
            background-size: cover; background-position: center;
            display: flex; align-items: center; justify-content: center;
            color: #333; text-align: center; font-size: 28px; font-weight: 600;
            padding-top: 70px; /* 헤더 높이만큼 여백 */
        }

        /* 2. 상품 카탈로그 및 장바구니 폼 관련 CSS */
        .product-catalog { padding-top: 50px; }
        .catalog-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; padding: 0 10px; }
        .catalog-header h1 { font-size: 28px; font-weight: 600; }
        .control-link { font-size: 14px; cursor: pointer; position: relative; padding: 5px 10px; border-radius: 4px; transition: background-color 0.2s; }
        .control-link:hover { background-color: #f0f0f0; }
        
        /* 드롭다운 메뉴 스타일 */
        .dropdown { position: absolute; top: 100%; right: 0; background-color: white; border: 1px solid #ddd; box-shadow: 0 4px 12px rgba(0,0,0,0.08); z-index: 10; min-width: 150px; border-radius: 6px; padding: 5px 0; display: none; }
        .dropdown.active { display: block; }
        .dropdown-item { padding: 10px 15px; cursor: pointer; font-size: 14px; display: block; }
        .dropdown-item:hover { background-color: #f7f9fc; color: #000; }
        
        /* 상품 그리드 */
        .products-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 40px 20px; }
        .product-card { text-align: center; transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1); border-radius: 8px; padding: 10px; cursor: pointer; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1); background-color: #fff; }
        .product-image-container { position: relative; margin-bottom: 15px; border-radius: 6px; overflow: hidden; }
        .product-image-container img { width: 100%; height: auto; display: block; border-radius: 6px; transition: transform 0.4s ease-out; }
        .product-card:hover .product-image-container img { transform: scale(1.03); }
        
        /* 장바구니 폼 스타일 */
        .cart-form { position: absolute; bottom: 10px; right: 10px; z-index: 5; background: none; border: none; padding: 0; margin: 0; line-height: 0; }
        .add-btn {
            background: rgba(255, 255, 255, 0.8); border: 1px solid #ddd;
            width: 36px; height: 36px; line-height: 32px; border-radius: 50%;
            font-size: 20px; font-weight: 500; cursor: pointer;
            transition: all 0.2s; color: #333; opacity: 0; padding: 0;
            display: flex; align-items: center; justify-content: center;
        }
        .product-card:hover .add-btn { opacity: 1; }
        .add-btn:hover { background: #000; color: #fff; border-color: #000; }

        .product-name { font-size: 16px; font-weight: 600; margin-bottom: 3px; color: #222; }
        .product-price { font-size: 14px; color: #666; font-weight: 400; }
        .load-more-btn { display: block; margin: 50px auto 100px; padding: 12px 30px; background: none; border: 1px solid #ccc; cursor: pointer; font-size: 16px; font-weight: 500; border-radius: 4px; transition: background-color 0.3s; }
        .load-more-btn:hover { background-color: #f7f9fc; }
        
        /* 장바구니 알림 */
        #cart-notification {
            position: fixed; top: 20px; left: 50%;
            transform: translateX(-50%) translateY(-100px);
            background-color: #000; color: #fff;
            padding: 12px 25px; border-radius: 30px;
            font-size: 15px; font-weight: 500; z-index: 10000;
            opacity: 0; transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
            pointer-events: none; box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        #cart-notification.visible { opacity: 1; transform: translateX(-50%) translateY(0); }

        /* 푸터 영역 (반응형 포함) */
        .main-footer { background-color: #f7f9fc; padding: 40px 0 20px; font-size: 14px; }
        .footer-grid { display: flex; justify-content: space-between; gap: 20px; padding-bottom: 40px; border-bottom: 1px solid #ddd; }
        .footer-grid strong { display: block; margin-bottom: 15px; font-weight: 700; text-transform: uppercase; font-size: 16px; }
        .footer-grid p > a { display: block; margin-bottom: 8px; font-size: 14px; color: #666; }
        .copyright { text-align: center; font-size: 10px; color: #999; padding-top: 20px; }
        
        @media (max-width: 1024px) { .products-grid { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 768px) { .products-grid { grid-template-columns: repeat(2, 1fr); gap: 20px 15px; } }
        @media (max-width: 480px) { .products-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
    <div id="cart-notification" class="<?= $cart_notification_message ? 'visible' : '' ?>">
        <?= $cart_notification_message ?? '✅ 장바구니에 추가되었습니다.' ?>
    </div>

    <section class="hero-banner">
        ROUND LAB - 전체 상품
    </section>

    <main class="product-catalog container">

        <div class="catalog-header">
            <div class="filter-controls">
                <span id="filter-link" class="control-link">Filter by +</span>
            </div>
            <h1>Skincare</h1>
            <div class="sort-controls">
                <span id="sort-link" class="control-link">Sort by +
                    <div id="sort-dropdown" class="dropdown">
                        <a href="?sort=name-asc" class="dropdown-item">이름 순 (A-Z)</a>
                        <a href="?sort=price-asc" class="dropdown-item">가격 순 (낮은 가격)</a>
                        <a href="?sort=default" class="dropdown-item">기본 정렬</a>
                    </div>
                </span>
            </div>
        </div>

        <div id="products-grid" class="products-grid">
            <?php foreach ($sortedProducts as $id => $product): ?>
                <div class="product-card">
                    <div class="product-image-container">
                        <img src="<?= $product['image'] ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                        
                        <form action="cart.php" method="POST" class="cart-form">
                            <input type="hidden" name="add_to_cart" value="1">
                            <input type="hidden" name="product_id" value="<?= $id ?>">
                            <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['name']) ?>">
                            <input type="hidden" name="product_price" value="<?= $product['price'] ?>">
                            <input type="hidden" name="quantity" value="1">
                            <input type="hidden" name="product_image" value="<?= $product['image'] ?>">
                            
                            <button type="submit" class="add-btn" data-product-name="<?= htmlspecialchars($product['name']) ?>">
                                <i class="fas fa-plus"></i>
                            </button>
                        </form>
                    </div>
                    <p class="product-name"><?= htmlspecialchars($product['name']) ?></p>
                    <p class="product-price"><?= $product['priceKr'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <button class="load-more-btn">Load more</button>
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

    <script>
        // 📌 정렬 드롭다운 토글 기능 (JavaScript는 여전히 필요)
        const sortLink = document.getElementById('sort-link');
        const sortDropdown = document.getElementById('sort-dropdown');
        
        sortLink.addEventListener('click', (e) => {
            e.stopPropagation();
            sortDropdown.classList.toggle('active');
        });

        document.addEventListener('click', () => {
            sortDropdown.classList.remove('active');
        });

        // 햄버거 메뉴 토글 기능
        const menuToggle = document.querySelector('.menu-toggle');
        const navMenu = document.querySelector('.nav');

        if (menuToggle && navMenu) {
            menuToggle.addEventListener('click', () => {
                navMenu.classList.toggle('active'); 
                menuToggle.classList.toggle('active');
            });
        }
    </script>
</body>
</html>