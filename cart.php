<?php
session_start();

// 📌 [추가된 로직] 삭제 요청 처리 로직
if (isset($_GET['remove_id'])) {
    $remove_id = (int)$_GET['remove_id'];
    if (isset($_SESSION['cart'])) {
        // 해당 ID를 가진 항목을 필터링하여 제외
        $_SESSION['cart'] = array_filter($_SESSION['cart'], function($item) use ($remove_id) {
            return $item['id'] !== $remove_id;
        });
        // 키(key) 인덱스 재정렬 (선택 사항)
        $_SESSION['cart'] = array_values($_SESSION['cart']); 
    }
    // 삭제 후 GET 파라미터가 남지 않도록 리다이렉션
    header('Location: cart.php');
    exit;
}

// 📌 더미 장바구니 데이터 초기화 (테스트용)
// 실제 환경에서는 데이터베이스나 Ajax 요청을 통해 데이터를 가져와야 합니다.
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $_SESSION['cart'] = [
        ['id' => 1, 'name' => '1025 독도 토너 대용량 500ML', 'price' => 26000, 'qty' => 2, 'image' => '토너_대.png'],
        ['id' => 2, 'name' => '자작나무 수분 선크림 50ML', 'price' => 26000, 'qty' => 1, 'image' => '토너.png'],
        ['id' => 3, 'name' => '1025 독도 크림 80ml', 'price' => 25600, 'qty' => 3, 'image' => '크림.png'],
    ];
}

// 📌 쇼핑카트 총합 계산 함수
function calculate_cart_total($cart) {
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['qty'];
    }
    return $total;
}

$cart_items = $_SESSION['cart'];
$total_amount = calculate_cart_total($cart_items);
$shipping_fee = $total_amount >= 50000 ? 0 : 3000; // 5만원 이상 무료 배송 가정
$final_total = $total_amount + $shipping_fee;
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ROUND LAB - 쇼핑카트</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* index.php의 기본 설정 및 헤더 스타일을 여기에 복사하여 사용 */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Noto Sans KR', sans-serif; color: #333; line-height: 1.6; background-color: #f7f9fc; overflow-x: hidden; }
        a { text-decoration: none; color: inherit; }

        /* --- Header (index.php와 동일하게 유지) --- */
        header { background: white; padding: 1rem 5%; position: sticky; top: 0; z-index: 1000; box-shadow: 0 1px 5px rgba(0,0,0,0.05); }
        .header-container { max-width: 1400px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; height: 50px; }
        .logo { font-family: 'Montserrat', sans-serif; font-size: 1.2rem; font-weight: 800; color: #333; letter-spacing: 0.5px; }
        .menu-toggle { display: none; background: none; border: none; cursor: pointer; font-size: 1.05rem; color: #666; transition: color 0.3s; z-index: 1001; margin-left: 1rem; }
        .nav { display: flex; gap: 2.2rem; list-style: none; margin: 0; }
        .nav a { font-size: 0.95rem; font-weight: 600; color: #666; transition: color 0.3s; }
        .nav a:hover { color: #333; }
        .header-icons { display: flex; gap: 1.0rem; align-items: center; }
        .icon-btn { background: none; border: none; cursor: pointer; font-size: 1.05rem; color: #666; transition: color 0.3s; }
        .icon-btn:hover { color: #333; }

        /* --- Cart Page Layout --- */
        .cart-section {
            max-width: 1200px;
            margin: 3rem auto;
            padding: 0 3%;
            display: flex;
            gap: 2rem; 
            align-items: flex-start; 
        }

        .cart-list-container {
            flex: 2; 
            min-width: 60%;
        }

        .cart-summary-container {
            flex: 1; 
            min-width: 300px;
            position: sticky; 
            top: 70px;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 2rem;
            text-align: left;
        }

        /* --- Cart Item Styling --- */
        .cart-item {
            display: flex;
            align-items: center;
            background: white;
            padding: 1rem;
            border-radius: 15px;
            margin-bottom: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: box-shadow 0.3s;
        }
        .cart-item:hover {
             box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .item-image {
            width: 80px;
            height: 80px;
            background-color: #f7f9fc;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1.5rem;
            overflow: hidden;
        }
        .item-image img {
            width: 60%;
            height: auto;
            object-fit: contain;
        }

        .item-details {
            flex-grow: 1;
        }

        .item-name {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.3rem;
        }

        .item-price {
            font-size: 0.9rem;
            color: #777;
        }

        .item-quantity {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-right: 2rem;
        }

        .item-quantity button {
            width: 30px;
            height: 30px;
            border: 1px solid #ddd;
            background: #fff;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            color: #5b9bd5;
            transition: background 0.2s;
        }
        .item-quantity button:hover {
            background: #eef7fc;
        }

        .item-quantity input {
            width: 40px;
            text-align: center;
            border: 1px solid #ddd;
            padding: 0.3rem 0;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 500;
        }
        
        .item-total {
            font-size: 1.1rem;
            font-weight: 700;
            color: #333;
            width: 100px;
            text-align: right;
        }

        /* 📌 수정된 CSS: <a> 태그로 변경된 삭제 버튼 스타일 */
        .remove-item-btn {
            background: none; 
            border: none;     
            color: #ccc;
            font-size: 1.1rem;
            margin-left: 1.5rem;
            cursor: pointer;
            transition: color 0.3s;
            display: flex; /* 아이콘 중앙 정렬을 위해 flex 사용 */
            align-items: center;
            justify-content: center;
            padding: 0.5rem; /* 클릭 영역 확보 */
        }
        .remove-item-btn:hover {
            color: #e74c3c;
        }

        /* --- Cart Summary Styling --- */
        .cart-summary {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border: 1px solid #eee;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            font-size: 1rem;
            color: #555;
        }
        .summary-row.total {
            border-top: 1px solid #eee;
            margin-top: 1rem;
            padding-top: 1rem;
            font-size: 1.3rem;
            font-weight: 700;
            color: #333;
        }

        .order-btn {
            width: 100%;
            padding: 1rem;
            background: #5b9bd5;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            margin-top: 1.5rem;
            transition: background 0.3s;
        }
        .order-btn:hover {
            background: #4a8dc1;
        }

        /* --- 반응형 (RWD) for Cart --- */
        @media (max-width: 992px) {
            .cart-section {
                flex-direction: column; 
                gap: 1.5rem;
            }
            .cart-list-container, .cart-summary-container {
                min-width: 100%;
                width: 100%;
            }
            .cart-summary-container {
                position: static; 
                order: 1; 
            }
            .cart-list-container {
                order: 2;
            }
            
            /* index.php의 반응형 스타일 복사 */
            .menu-toggle { display: block; }
            .nav { display: none; flex-direction: column; position: absolute; top: 66px; left: 0; width: 100%; background-color: white; box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1); padding: 0 5%; z-index: 999; }
            .header-icons { order: 3; margin-left: auto; }
            .logo { order: 1; }
        }

        @media (max-width: 768px) {
             .page-title { font-size: 2rem; margin-bottom: 1.5rem; }
             .cart-item { flex-wrap: wrap; padding: 0.8rem; }
             .item-image { width: 60px; height: 60px; margin-right: 1rem; }
             .item-details { width: 100%; order: 1; margin-bottom: 0.5rem; }
             .item-quantity { order: 3; margin-top: 0.5rem; }
             .item-total { order: 2; width: auto; font-size: 1rem; margin-left: auto; }
             .remove-item-btn { order: 4; margin-left: 1rem; }
             
             .item-name { font-size: 0.9rem; }
             
             /* --- Footer RWD (위치 오류 방지) --- */
             .footer-container { grid-template-columns: 1fr; gap: 1.5rem; }
        }

        /* --- Footer 스타일 --- */
        footer { background-color: #f0f0f0; padding: 3rem 5%; border-top: 1px solid #e0e0e0; }
        .footer-container { max-width: 1400px; margin: 0 auto; display: grid; grid-template-columns: 1.5fr 1fr 1.5fr; gap: 2rem; }
        .footer-section { display: flex; flex-direction: column; align-items: flex-start; }
        .footer-section h4 { font-weight: 700; margin-bottom: 1rem; font-size: 1rem; color: #333; }
        .footer-section p, .footer-section a { 
            font-size: 0.8rem; 
            color: #777; 
            line-height: 1.5; 
            margin-bottom: 0.4rem; 
            display: block; /* 텍스트를 한 줄씩 표시 */
        }
        .footer-section a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">ROUND LAB</div>
            <ul class="nav">
                <li><a href="index.php#shop">SHOP</a></li>
                <li><a href="index.php#review">REVIEW</a></li>
                <li><a href="index.php#brand">BRAND</a></li>
                <li><a href="index.php#center">C/S CENTER</a></li>
            </ul>
            <div class="header-icons">
                <button class="menu-toggle icon-btn" aria-label="메뉴 열기">
                    <i class="fas fa-bars"></i>
                </button>
                <button class="icon-btn"><i class="fas fa-search"></i></button>
                <a href="login.php" class="icon-btn" title="로그인/마이페이지"><i class="fas fa-user"></i></a>
                <a href="cart.php" class="icon-btn" title="쇼핑카트"><i class="fas fa-shopping-cart"></i></a>
            </div>
        </div>
    </header>

    <section class="cart-section">
        <div class="cart-list-container">
            <h2 class="page-title">쇼핑카트</h2>

            <?php if (empty($cart_items)): ?>
                <p style="text-align: center; padding: 3rem; background: white; border-radius: 15px;">장바구니에 담긴 상품이 없습니다. 🛍️</p>
            <?php else: ?>
                <?php foreach ($cart_items as $item): 
                    $subtotal = $item['price'] * $item['qty'];
                ?>
                    <div class="cart-item">
                        <div class="item-image">
                            <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        </div>
                        <div class="item-details">
                            <p class="item-name"><?php echo htmlspecialchars($item['name']); ?></p>
                            <p class="item-price"><?php echo number_format($item['price']); ?>원</p>
                        </div>
                        <div class="item-quantity">
                            <button>-</button>
                            <input type="number" value="<?php echo $item['qty']; ?>" min="1" readonly>
                            <button>+</button>
                        </div>
                        <div class="item-total">
                            <?php echo number_format($subtotal); ?>원
                        </div>
                        <a href="cart.php?remove_id=<?php echo htmlspecialchars($item['id']); ?>" 
                           class="remove-item-btn" 
                           title="삭제"
                           onclick="return confirm('이 상품을 장바구니에서 삭제하시겠습니까?');">
                           <i class="fas fa-times"></i>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="cart-summary-container">
            <div class="cart-summary">
                <h4>결제 예정 금액</h4>
                <div class="summary-row">
                    <span>총 상품 금액</span>
                    <span id="subtotal"><?php echo number_format($total_amount); ?>원</span>
                </div>
                <div class="summary-row">
                    <span>배송비</span>
                    <span id="shipping-fee"><?php echo number_format($shipping_fee); ?>원</span>
                </div>
                <div class="summary-row total">
                    <span>총 결제 금액</span>
                    <span id="final-total"><?php echo number_format($final_total); ?>원</span>
                </div>
                <button class="order-btn">전체 상품 주문하기</button>
            </div>
        </div>
    </section>
    
    <footer>
        <div class="footer-container">
             <div class="footer-section">
                <h4>ROUND LAB</h4>
                <p>070-7717-0675</p>
                <p>평일 오전 10시 ~ 오후 4시 (점심시간 오후 12시 ~ 1시)</p>
            </div>
            <div class="footer-section">
                <h4>COMPANY</h4>
                <a href="#">공지사항</a>
                <a href="#">이용약관</a>
                <a href="#">개인정보처리방침</a>
            </div>
            <div class="footer-section">
                <h4>COMPANY</h4>
                <p>대표이사: 김라운드</p>
                <p>사업자등록번호: 123-45-67890</p>
                <p>통신판매업신고: 제2024-서울-0000호</p>
            </div>
        </div>
    </footer>

    <script>
        // 📌 햄버거 메뉴 토글 기능 (index.php에서 복사)
        const menuToggle = document.querySelector('.menu-toggle');
        const nav = document.querySelector('.nav');

        if (menuToggle) {
             menuToggle.addEventListener('click', function() {
                nav.classList.toggle('open');
                const icon = menuToggle.querySelector('i');
                if (nav.classList.contains('open')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-times');
                    menuToggle.setAttribute('aria-label', '메뉴 닫기');
                } else {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                    menuToggle.setAttribute('aria-label', '메뉴 열기');
                }
            });
        }
       
        // 📌 장바구니 수량/삭제 기능 관련 JS는 제거 (PHP에서 처리)
        document.querySelectorAll('.item-quantity button').forEach(button => {
            button.addEventListener('click', function() {
                alert('수량 변경 기능은 서버와의 통신이 필요합니다.');
            });
        });
    </script>
</body>
</html>