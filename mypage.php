<?php
// mypage.php
session_start();

// ⭐ 1. 접근 보호: 로그인하지 않았으면 로그인 페이지로 리다이렉션
if (!isset($_SESSION['user_id'])) {
header('Location: login.php');
exit;
}

// 로그인된 사용자의 ID를 가져옵니다. (DB 연결 후 실제 사용자 정보를 가져와야 함)
$user_id = $_SESSION['user_id']; 
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>마이페이지 - ROUND LAB</title>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100..900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<link rel="stylesheet" href="style.css"> 

<style>
/* 마이페이지 전용 스타일 */
body { font-family: 'Noto Sans KR', sans-serif; background-color: #f7f9fc; margin: 0; padding: 0; }
.mypage-container { max-width: 1200px; margin: 80px auto 50px auto; padding: 20px; background-color: white; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
h1 { font-size: 2.2rem; font-weight: 700; color: #333; margin-bottom: 30px; border-bottom: 2px solid #5b9bd5; padding-bottom: 10px; display: inline-block; }

.user-info-box { background-color: #f0f4f8; padding: 25px; border-radius: 8px; margin-bottom: 30px; display: flex; align-items: center; justify-content: space-between; }
.user-greeting { font-size: 1.2rem; color: #333; }
.user-id-highlight { font-weight: 700; color: #5b9bd5; margin-left: 5px; }

.mypage-nav { display: flex; flex-direction: column; width: 250px; min-height: 400px; margin-right: 30px; background-color: #ffffff; border-right: 1px solid #eee; padding-top: 10px; }
.mypage-nav a { padding: 15px 20px; text-decoration: none; color: #555; font-weight: 500; border-left: 3px solid transparent; transition: all 0.2s; }
.mypage-nav a:hover, .mypage-nav a.active { background-color: #eaf1f7; color: #5b9bd5; border-left-color: #5b9bd5; font-weight: 600; }

.mypage-content-area { flex-grow: 1; padding: 20px; }
.mypage-grid { display: flex; }

.summary-card-grid { display: flex; gap: 20px; margin-bottom: 40px; }
.summary-card { flex: 1; padding: 25px; border: 1px solid #ddd; border-radius: 8px; text-align: center; background: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
.summary-card p { margin: 0; font-size: 0.9rem; color: #777; }
.summary-card strong { display: block; font-size: 1.8rem; color: #333; margin-top: 5px; }
.summary-card.highlight strong { color: #e74c3c; } 

.section-title { font-size: 1.5rem; color: #333; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 20px; }
</style>
</head>

<body>
<?php include 'header.php'; // 헤더 포함 (가장 먼저 실행되는 PHP는 header.php) ?>

<div class="mypage-container">
<h1>마이페이지</h1>

<div class="user-info-box">
<p class="user-greeting">
반갑습니다, <span class="user-id-highlight"><?php echo htmlspecialchars($user_id); ?></span>님!
</p>
</div>

 <div class="mypage-grid">
 <div class="mypage-nav">
  <a href="mypage.php" class="active"><i class="fas fa-home"></i> 메인</a>
  <a href="#"><i class="fas fa-box"></i> 주문/배송 조회</a>
  <a href="#"><i class="fas fa-receipt"></i> 취소/반품/교환</a>
  <a href="#"><i class="fas fa-user-circle"></i> 회원 정보 수정</a>
  <a href="#"><i class="fas fa-ticket-alt"></i> 쿠폰 / 적립금</a>
 </div>

 <div class="mypage-content-area">
  
  <h2 class="section-title">요약 정보</h2>
  
  <div class="summary-card-grid">
  <div class="summary-card">
   <p>총 주문 금액 (3개월)</p>
   <strong>0원</strong>
  </div>
  <div class="summary-card">
   <p>쿠폰</p>
   <strong class="highlight">3개</strong>
  </div>
  <div class="summary-card">
   <p>적립금</p>
   <strong>1,500원</strong>
  </div>
  <div class="summary-card">
   <p>배송 중</p>
   <strong>0건</strong>
  </div>
  </div>

 <h2 class="section-title">최근 주문 내역</h2>
 <p style="color: #999;">최근 3개월간 주문 내역이 없습니다.</p>

 </div>
 </div>

 </div>
 
 <?php // include 'footer.php'; ?>
</body>
</html>