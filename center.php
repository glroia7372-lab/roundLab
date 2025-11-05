<?php
// PHP 코드를 여기에 추가할 수 있습니다.
// (예시) FAQ 데이터 배열
$faqs = [
    ['q' => '배송은 얼마나 걸리나요?', 'a' => '결제 완료 후 평균 2~3 영업일 이내에 출고됩니다. (주말, 공휴일 제외)'],
    ['q' => '주문을 취소하고 싶어요.', 'a' => '상품이 "배송 준비 중" 단계 이전일 경우에만 취소가 가능하며, [마이페이지 > 주문내역]에서 직접 취소 요청하실 수 있습니다.'],
    ['q' => '회원 등급별 혜택이 궁금합니다.', 'a' => '각 등급별 할인율 및 적립금 혜택은 [BRAND > 멤버십] 페이지에서 상세히 확인하실 수 있습니다.'],
    ['q' => '제품 교환/반품은 어떻게 하나요?', 'a' => '제품 수령 후 7일 이내에 C/S 센터를 통해 접수해 주시면 절차를 안내해 드립니다.'],
];

// PHP: 1:1 문의 제출 처리 (간단한 예시)
$inquiry_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_inquiry'])) {
    $name = htmlspecialchars($_POST['inquiry_name']);
    $email = htmlspecialchars($_POST['inquiry_email']);
    $type = htmlspecialchars($_POST['inquiry_type']);
    $content = htmlspecialchars($_POST['inquiry_content']);
    
    // 실제 구현에서는 이 데이터를 데이터베이스나 이메일 시스템으로 전송합니다.
    $inquiry_message = "문의가 성공적으로 접수되었습니다. 빠른 시간 내에 답변드리겠습니다. (문의 유형: $type)";
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>라운드랩 | C/S 센터</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* 🚨 shop.php, review.php와 동일한 디자인 유지를 위해 CSS를 대부분 복사합니다. */

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
        /* 💥 header.php를 위한 CSS (이전 논의된 내용) 💥 */
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

        /* === C/S Center 페이지 전용 스타일 === */
        
        .hero-banner {
            width: 100%;
            height: 250px;
            background-color: #f7f9fc;
            background-image: url('https://placehold.co/1400x250/f0f4f8/333?text=CUSTOMER+SUPPORT');
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
        
        .cs-section {
            padding: 50px 0 80px;
        }

        .cs-section h2 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 25px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            margin-top: 40px;
        }
        .cs-section h2:first-child {
             margin-top: 0;
        }
        
        /* --- Contact Info --- */
        .contact-info {
            display: flex;
            justify-content: space-around;
            padding: 20px 0;
            border-bottom: 1px solid #eee;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .contact-item {
            padding: 20px;
        }

        .contact-item i {
            font-size: 32px;
            color: #333;
            margin-bottom: 15px;
        }

        .contact-item strong {
            display: block;
            font-size: 18px;
            margin-bottom: 5px;
        }
        
        .contact-item p {
            font-size: 15px;
            color: #666;
        }

        /* --- FAQ Accordion --- */
        .faq-item {
            border-bottom: 1px solid #eee;
        }
        
        .faq-question {
            padding: 15px 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.2s;
        }
        
        .faq-question:hover {
            background-color: #f9f9f9;
        }
        
        .faq-question i {
            transition: transform 0.3s;
        }
        
        .faq-question.active i {
            transform: rotate(180deg);
        }

        .faq-answer {
            padding: 0 10px 15px 10px;
            font-size: 15px;
            color: #555;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease-out, padding 0.4s ease-out;
            background-color: #fcfcfc;
        }
        
        .faq-answer.active {
            max-height: 200px; /* 충분한 높이 설정 */
            padding: 15px 10px 20px 10px;
        }
        
        /* --- Inquiry Form (shop.php의 폼 디자인 재사용) --- */
        .inquiry-form label {
            display: block;
            font-size: 15px;
            font-weight: 600;
            margin-top: 15px;
            margin-bottom: 5px;
        }
        
        .inquiry-form select, .inquiry-form textarea, .inquiry-form input[type="text"], .inquiry-form input[type="email"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 15px;
        }
        
        .inquiry-form textarea {
            resize: vertical;
            min-height: 150px;
        }

        .inquiry-form button[type="submit"] {
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
        .inquiry-form button[type="submit"]:hover {
            background-color: #000;
        }
        
        /* --- 푸터 영역 (디자인 유지) --- */
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
        
        /* --- 반응형 미디어 쿼리 --- */
        @media (max-width: 768px) {
            .contact-info {
                flex-direction: column;
                border-bottom: none;
            }
            .contact-item {
                border-bottom: 1px solid #eee;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>

<section class="hero-banner">
    CUSTOMER SERVICE CENTER
</section>

<main class="cs-section container">
    
    <h2><i class="fas fa-headset"></i> 고객 지원 정보</h2>
    <div class="contact-info">
        <div class="contact-item">
            <i class="fas fa-phone-alt"></i>
            <strong>전화 문의</strong>
            <p>1588-XXXX (유료)</p>
            <p>평일 09:00 ~ 18:00 (점심 12:00 ~ 13:00)</p>
        </div>
        <div class="contact-item">
            <i class="fas fa-comment-dots"></i>
            <strong>카카오톡 상담</strong>
            <p>라운드랩 공식 채널</p>
            <p>평일 09:00 ~ 18:00</p>
        </div>
        <div class="contact-item">
            <i class="fas fa-envelope"></i>
            <strong>이메일 문의</strong>
            <p>cs@roundlab.com</p>
            <p>24시간 접수 가능</p>
        </div>
    </div>

    <h2><i class="fas fa-question-circle"></i> 자주 묻는 질문 (FAQ)</h2>
    <div class="faq-list">
        <?php foreach ($faqs as $index => $faq): ?>
            <div class="faq-item">
                <div class="faq-question" data-index="<?= $index ?>">
                    Q. <?= $faq['q'] ?>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer" id="faq-answer-<?= $index ?>">
                    <p><?= nl2br($faq['a']) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <h2 id="inquiry-form-area"><i class="fas fa-paper-plane"></i> 1:1 문의하기</h2>
    
    <?php if ($inquiry_message): ?>
        <div style="background-color: #e6ffed; color: #007d3f; padding: 15px; border: 1px solid #c8f5d7; border-radius: 4px; margin-bottom: 20px; text-align: center;">
            <?= $inquiry_message ?>
        </div>
    <?php endif; ?>

    <form class="inquiry-form" method="POST" action="center.php#inquiry-form-area">
        <label for="inquiry_name">이름</label>
        <input type="text" id="inquiry_name" name="inquiry_name" required>

        <label for="inquiry_email">이메일 주소</label>
        <input type="email" id="inquiry_email" name="inquiry_email" required>
        
        <label for="inquiry_type">문의 유형</label>
        <select id="inquiry_type" name="inquiry_type" required>
            <option value="배송">배송 문의</option>
            <option value="반품/교환">반품/교환 문의</option>
            <option value="제품">제품 문의</option>
            <option value="기타">기타 문의</option>
        </select>

        <label for="inquiry_content">문의 내용</label>
        <textarea id="inquiry_content" name="inquiry_content" required></textarea>

        <button type="submit" name="submit_inquiry">문의 제출</button>
    </form>

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
    // 1. FAQ 아코디언 기능 구현
    document.querySelectorAll('.faq-question').forEach(question => {
        question.addEventListener('click', () => {
            const answer = document.getElementById(`faq-answer-${question.dataset.index}`);
            
            // 현재 열려있는 다른 답변 닫기
            document.querySelectorAll('.faq-question.active').forEach(activeQ => {
                if (activeQ !== question) {
                    activeQ.classList.remove('active');
                    document.getElementById(`faq-answer-${activeQ.dataset.index}`).classList.remove('active');
                }
            });

            // 클릭된 답변 토글
            question.classList.toggle('active');
            answer.classList.toggle('active');
        });
    });

    // 2. 햄버거 메뉴 토글 기능 (반응형 대응)
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