<?php
// PHP 코드를 여기에 추가할 수 있습니다.
// 1. 데이터베이스 연결 (실제 서버에서는 필요)
// 2. 리뷰 데이터 불러오기 (fetch)
// 3. 폼 제출 처리 및 리뷰 저장 (insert)

// (예시) 더미 리뷰 데이터 배열
$reviews = [
    [
        'id' => 3, 
        'product' => 'Multi-Peptide + HA Serum', 
        'user' => '김**민', 
        'rating' => 5, 
        'date' => '2025.10.28', 
        'content' => '이 세럼은 정말 놀라워요. 피부결이 눈에 띄게 개선되었고, 끈적임 없이 흡수됩니다. 재구매 의사 100%!',
        'image' => 'https://placehold.co/100x100/f7f9fc/333?text=Review+Img'
    ],
    [
        'id' => 2, 
        'product' => 'Niacinamide 10% + Zinc 1%', 
        'user' => '박**수', 
        'rating' => 4, 
        'date' => '2025.10.25', 
        'content' => '사용 후 트러블이 줄어들었어요. 다만 처음에는 약간 따가움이 있었습니다. 적응 기간이 필요해요.',
        'image' => 'https://placehold.co/100x100/f7f9fc/333?text=Review+Img'
    ],
    [
        'id' => 1, 
        'product' => 'Lactic Acid 10% + HA', 
        'user' => '이**영', 
        'rating' => 5, 
        'date' => '2025.10.20', 
        'content' => '각질 제거 효과가 뛰어나요. 다음 날 화장이 정말 잘 먹습니다.',
        'image' => null
    ],
];

// PHP: 리뷰 제출 처리 (간단한 예시)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    $product = htmlspecialchars($_POST['review_product']);
    $rating = (int)$_POST['review_rating'];
    $content = htmlspecialchars($_POST['review_content']);
    
    // 실제 구현에서는 이 데이터를 데이터베이스에 저장합니다.
    $message = "리뷰가 성공적으로 제출되었습니다. (상품: $product, 평점: $rating)";
    // 실제로는 여기에 데이터베이스 저장 후 리다이렉션이 필요합니다.
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>라운드랩 | 고객 리뷰</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* shop.php의 기본 설정 및 CSS를 여기에 모두 복사하여 사용해야 합니다.
           (이전에 논의된 header.php를 위한 CSS 포함) 
           
           🚨 주의: shop.php의 <style> 전체 내용을 여기에 붙여 넣어야 디자인이 유지됩니다. 🚨
           
           ------------------------------------------------------------------ */

        /* 글로벌 설정 및 초기화 */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', Arial, sans-serif;
            color: #333;
            line-height: 1.5;
            min-width: 320px;
            background-color: #ffffff;
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

        /* ========================================================= */
        /* 💥 header.php를 위한 CSS (shop.php에서 가져옴) 💥 */
        /* ========================================================= */
        
        header {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: #fff;
            z-index: 1000;
            box-shadow: 0 1px 5px rgba(0,0,0,0.1);
            padding: 10px 5%;
        }
        
        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 50px;
        }

        .logo a {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.2rem;
            font-weight: 800;
            color: #333;
            letter-spacing: 0.5px;
        }
        
        .nav {
            display: flex;
            list-style: none;
            gap: 2.2rem;
        }
        
        .nav a {
            font-size: 0.95rem;
            font-weight: 600;
            color: #666;
            transition: color 0.3s;
        }
        .nav a:hover {
            color: #333;
        }

        .header-icons {
            display: flex;
            gap: 1.0rem;
            align-items: center;
        }
        
        .icon-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.05rem;
            color: #666;
            transition: color 0.3s;
        }
        .icon-btn:hover {
            color: #333;
        }
        
        .menu-toggle {
             display: none;
        }
        
        /* ------------------------------------------------------------------ */

        /* === Review 페이지 전용 스타일 === */
        
        /* Hero Banner 높이를 헤더 때문에 조정 (shop.php와 동일) */
        .hero-banner {
            width: 100%;
            height: 250px;
            background-color: #f7f9fc;
            background-image: url('https://placehold.co/1400x250/f0f4f8/333?text=CUSTOMER+REVIEWS');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
            text-align: center;
            font-size: 28px;
            font-weight: 600;
            padding-top: 70px; /* 헤더 높이만큼 여백 */
        }
        
        .review-section {
            padding: 50px 0 80px;
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }
        
        .review-header h1 {
            font-size: 28px;
            font-weight: 600;
        }

        /* --- 리뷰 작성 버튼 --- */
        .write-btn {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 15px;
            transition: background-color 0.3s;
        }
        .write-btn:hover {
            background-color: #000;
        }

        /* --- 리뷰 카드 목록 --- */
        .review-list {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .review-card {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.03);
            display: flex;
            gap: 20px;
        }

        .review-meta {
            width: 150px; /* 메타 정보 고정 폭 */
            text-align: center;
            flex-shrink: 0;
        }
        .review-meta img {
            width: 80px;
            height: 80px;
            border-radius: 4px;
            object-fit: cover;
            margin-bottom: 10px;
            border: 1px solid #ddd;
        }
        .review-meta p {
            font-size: 13px;
            color: #999;
        }
        .review-meta strong {
            display: block;
            font-size: 15px;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }
        
        /* --- 평점 별 표시 --- */
        .rating {
            color: gold;
            margin-bottom: 5px;
        }
        .rating .far {
            color: #ccc;
        }

        .review-content-area {
            flex-grow: 1;
        }
        .review-content-area h3 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        .review-content-area .review-user-info {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
        }
        .review-content-area p {
            font-size: 15px;
        }
        
        /* --- 리뷰 작성 폼 스타일 (shop.php 디자인 기반) --- */
        .review-form-container {
            border-top: 2px solid #333;
            padding-top: 40px;
            margin-top: 50px;
        }
        
        .review-form-container h2 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 25px;
        }

        .review-form label {
            display: block;
            font-size: 15px;
            font-weight: 600;
            margin-top: 15px;
            margin-bottom: 5px;
        }
        
        .review-form select, .review-form textarea, .review-form input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 15px;
        }
        
        .review-form textarea {
            resize: vertical;
            min-height: 150px;
        }

        .review-form button[type="submit"] {
            margin-top: 25px;
            width: 100%;
            background-color: #333;
            color: #fff;
            padding: 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s;
        }
        .review-form button[type="submit"]:hover {
            background-color: #000;
        }
        
        /* --- 푸터 영역 (shop.php와 동일) --- */
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
            margin-bottom: 15px;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 16px;
        }

        .footer-grid p > a {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #666;
        }
        
        .footer-grid p > a:hover {
            text-decoration: underline;
        }

        .copyright {
            text-align: center;
            font-size: 10px;
            color: #999;
            padding-top: 20px;
        }
        /* --- 반응형 미디어 쿼리 (shop.php와 동일) --- */
        @media (max-width: 768px) {
            .review-card {
                flex-direction: column;
                text-align: center;
            }
            .review-meta {
                width: 100%;
            }
            .review-content-area h3, .review-content-area p {
                text-align: left;
            }
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>

<section class="hero-banner">
    CUSTOMER REVIEWS
</section>

<main class="review-section container">
    
    <?php if (isset($message)): ?>
        <div style="background-color: #e6ffed; color: #007d3f; padding: 15px; border: 1px solid #c8f5d7; border-radius: 4px; margin-bottom: 20px; text-align: center;">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <div class="review-header">
        <h1>Recent Reviews (<?= count($reviews) ?>)</h1>
        <button class="write-btn" onclick="document.getElementById('review-form-area').scrollIntoView({ behavior: 'smooth' });">리뷰 작성</button>
    </div>

    <div class="review-list">
        <?php foreach ($reviews as $review): ?>
            <div class="review-card">
                <div class="review-meta">
                    <img src="<?= $review['image'] ?? 'https://placehold.co/100x100/f7f9fc/666?text=No+Image' ?>" alt="Review Image">
                    <div class="rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fa-star <?= ($i <= $review['rating']) ? 'fas' : 'far' ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <strong><?= $review['user'] ?></strong>
                    <p><?= $review['date'] ?></p>
                </div>
                <div class="review-content-area">
                    <h3>[<?= $review['product'] ?>] 제품 리뷰</h3>
                    <div class="review-user-info">
                        평점: <?= $review['rating'] ?>점
                    </div>
                    <p><?= nl2br($review['content']) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <div id="review-form-area" class="review-form-container">
        <h2>리뷰 작성하기</h2>
        <form class="review-form" method="POST" action="review.php">
            <label for="review_product">상품 선택</label>
            <select id="review_product" name="review_product" required>
                <option value="">상품을 선택하세요</option>
                <option value="Multi-Peptide + HA Serum">Multi-Peptide + HA Serum</option>
                <option value="Niacinamide 10% + Zinc 1%">Niacinamide 10% + Zinc 1%</option>
                <option value="Lactic Acid 10% + HA">Lactic Acid 10% + HA</option>
                </select>

            <label for="review_rating">평점 (1-5)</label>
            <select id="review_rating" name="review_rating" required>
                <option value="5">5점 - 최고예요</option>
                <option value="4">4점 - 좋아요</option>
                <option value="3">3점 - 보통이에요</option>
                <option value="2">2점 - 별로예요</option>
                <option value="1">1점 - 최악이에요</option>
            </select>

            <label for="review_content">리뷰 내용</label>
            <textarea id="review_content" name="review_content" required></textarea>

            <button type="submit" name="submit_review">리뷰 제출</button>
        </form>
    </div>

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
    // shop.php에서 사용한 햄버거 메뉴 토글 기능 (만약 필요하다면)
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