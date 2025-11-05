<?php
// login.php
session_start();

// 💡 수정: 회원가입 시 register.php에서 세션에 저장한 
// 사용자 정보 (아이디 => 해시된 비밀번호)를 가져옵니다.
// 세션에 정보가 없으면 빈 배열을 사용합니다.
$valid_users = isset($_SESSION['valid_users']) ? $_SESSION['valid_users'] : [];

// ⭐ 테스트를 위한 기본 계정 설정 (세션이 비어있을 경우에만 추가)
// 실제 DB를 사용할 때는 이 로직을 제거해야 합니다.
if (empty($valid_users) || !isset($valid_users['testuser'])) {
    // 'testuser'/'1234' 계정이 없으면 임시로 추가합니다.
    $valid_users['testuser'] = password_hash('1234', PASSWORD_DEFAULT);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 입력값 앞뒤 공백 제거
    $user_id = trim($_POST['user_id']);
    $password = $_POST['password'];

    // 1. 아이디 존재 여부 확인
    if (isset($valid_users[$user_id])) {
        $hashed_password = $valid_users[$user_id];
        
        // 2. 입력된 비밀번호와 저장된 해시 값을 안전하게 비교
        if (password_verify($password, $hashed_password)) {
            // 로그인 성공
            $_SESSION['user_id'] = $user_id;
            
            // 리다이렉션 전에 반드시 exit; 호출
            header('Location: index.php'); 
            exit;
        } else {
            // 비밀번호 불일치
            $error = "아이디 또는 비밀번호가 올바르지 않습니다.";
        }
    } else {
        // 아이디 없음
        $error = "아이디 또는 비밀번호가 올바르지 않습니다.";
    }
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인 - ROUND LAB</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100..900&display=swap" rel="stylesheet">
    <style>
        /* CSS 코드는 변경 없음 */
        body { font-family: 'Noto Sans KR', sans-serif; background-color: #f7f9fc; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-container { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 350px; text-align: center; }
        .logo { font-size: 1.5rem; font-weight: 800; color: #333; margin-bottom: 2rem; }
        input[type="text"], input[type="password"] { width: 100%; padding: 0.8rem; margin-bottom: 1rem; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; padding: 0.8rem; background-color: #5b9bd5; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 1rem; font-weight: 600; transition: background-color 0.3s; }
        button:hover { background-color: #4a8ac2; }
        .error { color: #e74c3c; margin-top: 1rem; font-size: 0.9rem; }
        .links a { display: block; margin-top: 1rem; color: #5b9bd5; text-decoration: none; font-size: 0.9rem; }
        .links a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">ROUND LAB</div>
        <h2>로그인</h2>
        <form method="POST" action="login.php">
            <input type="text" name="user_id" placeholder="아이디" required>
            <input type="password" name="password" placeholder="비밀번호" required>
            <button type="submit">로그인</button>
        </form>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <div class="links">
            <a href="register.php">회원가입</a>
            <a href="index.php">메인 페이지로 돌아가기</a>
        </div>
    </div>
</body>
</html>