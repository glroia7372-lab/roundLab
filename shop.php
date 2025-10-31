<?php
// PHP로 제품 데이터를 정의합니다. (데이터베이스에서 가져오는 것을 시뮬레이션)
$products = [
    ['name' => 'Multi-Peptide + HA Serum', 'price' => '38,000 KRW', 'image' => 'serum_multi.png'],
    ['name' => 'Niacinamide 10% + Zinc 1%', 'price' => '17,500 KRW', 'image' => 'serum_niacinamide.png'],
    ['name' => 'Lactic Acid 10% + HA', 'price' => '18,500 KRW', 'image' => 'serum_lactic.png'],
    ['name' => 'Hyaluronic Acid 2% + B5', 'price' => '16,000 KRW', 'image' => 'serum_hyaluronic.png'],
    ['name' => '"Buffet" + Copper Peptides 1%', 'price' => '38,500 KRW', 'image' => 'serum_copper.png'],
    ['name' => 'Caffeine Solution 5% + EGCG', 'price' => '17,000 KRW', 'image' => 'serum_caffeine.png'],
    ['name' => 'Glycolipid Cream Cleanser', 'price' => '21,000 KRW', 'image' => 'cleanser_glyco.png'],
    ['name' => '100% Niacinamide Powder', 'price' => '21,000 KRW', 'image' => 'powder_niacinamide.png'],
    // 더 많은 상품 데이터를 여기에 추가할 수 있습니다.
];
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>라운드랩 | 전체 상품</title>
    <link rel="stylesheet" href="style.css"> 

    <style>
        /* 글로벌 설정 및 초기화 */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: Arial, sans-serif;
    color: #333;
    line-height: 1.5;
    min-width: 320px; /* 모바일 최소 너비 */
}

a {
    text-decoration: none;
    color: inherit;
}

/* 중앙 정렬 컨테이너 */
.container {
    max-width: 1400px;
    padding: 0 40px;
    margin: 0 auto;
}

/* === 1. 헤더 및 네비게이션 === */

.main-header {
    border-bottom: 1px solid #eee;
}

.main-nav {
    display: flex;
    justify-content: center;
    padding: 15px 0;
    gap: 30px;
    font-size: 14px;
    text-transform: uppercase;
}

.nav-item.active {
    font-weight: bold;
    border-bottom: 2px solid #000;
    padding-bottom: 3px;
}

/* === 2. Hero 배너 === */

.hero-banner {
    width: 100%;
    height: 250px; /* 이미지 높이 설정 */
    background-color: #f7f9fc; 
    /* 실제 이미지를 여기에 설정하세요 */
    background-image: url('banner_bg.jpg'); 
    background-size: cover;
    background-position: center;
}

/* === 3. 상품 카탈로그 및 필터 영역 === */

.product-catalog {
    padding-top: 50px;
}

.catalog-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 40px;
    padding: 0 10px;
    text-align: center;
}

.catalog-header h1 {
    font-size: 24px;
    font-weight: 500;
}

.control-link {
    font-size: 14px;
    cursor: pointer;
}

/* --- 상품 그리드 (핵심 레이아웃) --- */

.products-grid {
    display: grid;
    /* 기본 4열 그리드 구현 */
    grid-template-columns: repeat(4, 1fr);
    gap: 30px 20px;
}

.product-card {
    text-align: center;
    margin-bottom: 20px;
}

.product-image-container {
    position: relative;
    margin-bottom: 10px;
}

.product-image-container img {
    width: 100%;
    height: auto;
    display: block;
}

.add-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
}

.product-name {
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 5px;
}

.product-price {
    font-size: 12px;
    color: #666;
}

.load-more-btn {
    display: block;
    margin: 50px auto 100px;
    padding: 10px 20px;
    background: none;
    border: 1px solid #ccc;
    cursor: pointer;
    font-size: 14px;
}

/* === 4. 푸터 영역 === */

.main-footer {
    background-color: #f7f9fc;
    padding: 40px 0 20px;
    font-size: 14px;
}

.footer-grid {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    padding-bottom: 40px;
    border-bottom: 1px solid #ddd;
}

.footer-grid strong {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
    text-transform: uppercase;
}

.copyright {
    text-align: center;
    font-size: 10px;
    color: #999;
    padding-top: 20px;
}

/* === 반응형 미디어 쿼리 === */

@media (max-width: 1024px) {
    /* 태블릿: 3열 또는 2열로 변경 */
    .products-grid {
        grid-template-columns: repeat(3, 1fr); 
    }
}

@media (max-width: 768px) {
    .container {
        padding: 0 20px; /* 모바일에서 패딩 줄임 */
    }
    /* 모바일: 2열로 변경 */
    .products-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px 10px;
    }
    .footer-grid {
        flex-wrap: wrap; /* 푸터 항목을 여러 줄로 배치 */
    }
    .footer-grid > div {
        width: 45%; /* 2열로 표시 */
        margin-bottom: 20px;
    }
}

@media (max-width: 480px) {
    /* 아주 작은 모바일: 1열로 변경 */
    .products-grid {
        grid-template-columns: 1fr;
    }
    .main-nav {
        flex-wrap: wrap;
        gap: 15px;
    }
}
    </style>
</head>
<body>

    <section class="hero-banner">
        </section>

    <main class="product-catalog container">
        
        <div class="catalog-header">
            <div class="filter-controls">
                <span class="control-link">Filter by +</span>
            </div>
            <h1>All Skincare</h1>
            <div class="sort-controls">
                <span class="control-link">Sort by +</span>
            </div>
        </div>

        <div class="products-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <div class="product-image-container">
                        <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                        <button class="add-btn">+</button>
                    </div>
                    <p class="product-name"><?= htmlspecialchars($product['name']) ?></p>
                    <p class="product-price"><?= htmlspecialchars($product['price']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <button class="load-more-btn">Load more</button>
    </main>

    <footer class="main-footer">
        <div class="footer-grid container">
            <div><strong>Company</strong><p>About Us<br>CSR<br>Commitment</p></div>
            <div><strong>Customer Care</strong><p>FAQ<br>Shipping & Returns<br>Contact Us</p></div>
            <div><strong>Sign In</strong><p>Track Order<br>Store Locator<br>Gift Card</p></div>
            <div><strong>News Letter</strong><p>Email Address</p></div>
            <div><strong>Social</strong><p>Instagram<br>YouTube<br>Facebook</p></div>
        </div>
        <p class="copyright">Terms & Conditions | Privacy Policy | Cookies | ISO BEAUTY Group Inc. 2022 All rights reserved.</p>
    </footer>

</body>
</html>