<?php
// register.php
session_start();

// 💡 임시 사용자 저장소: 세션에 사용자 정보 배열을 저장합니다.
// 로그인 페이지와 연동되어 사용자 정보를 저장하는 임시 DB 역할을 합니다.
if (!isset($_SESSION['valid_users'])) {
    // 세션 초기화: 'testuser'/'1234' 기본 계정을 해시하여 넣어둡니다.
    $_SESSION['valid_users'] = [
        'testuser' => password_hash('1234', PASSWORD_DEFAULT)
    ];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_user_id = trim($_POST['new_user_id']);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($new_user_id) || empty($new_password) || empty($confirm_password)) {
        $error = "모든 필드를 입력해야 합니다.";
    } elseif ($new_password !== $confirm_password) {
        $error = "비밀번호가 일치하지 않습니다.";
    } elseif (isset($_SESSION['valid_users'][$new_user_id])) {
        // 아이디 중복 검사 (임시)
        $error = "이미 존재하는 아이디입니다.";
    } else {
        // 🔑 1. 비밀번호 해싱 (보안 강화)
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        // 💾 2. 세션에 사용자 정보 저장 (임시 DB 저장 역할)
        $_SESSION['valid_users'][$new_user_id] = $hashed_password;

        $success = "회원가입이 완료되었습니다! 이제 로그인할 수 있습니다.";
    }
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원가입 - ROUND LAB</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100..900&display=swap" rel="stylesheet">
    <style>
        /* CSS 디자인 코드 */
        body { font-family: 'Noto Sans KR', sans-serif; background-color: #f7f9fc; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .register-container { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 350px; text-align: center; }
        .logo { font-size: 1.5rem; font-weight: 800; color: #333; margin-bottom: 2rem; }
        h2 { margin-bottom: 1.5rem; }
        input[type="text"], input[type="password"] { width: 100%; padding: 0.8rem; margin-bottom: 1rem; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; padding: 0.8rem; background-color: #5b9bd5; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 1rem; font-weight: 600; transition: background-color 0.3s; }
        button:hover { background-color: #4a8ac2; }
        .error { color: #e74c3c; margin-top: 1rem; font-size: 0.9rem; }
        .success { color: #2ecc71; margin-top: 1rem; font-size: 1rem; font-weight: 600; }
        .links a { display: block; margin-top: 1rem; color: #5b9bd5; text-decoration: none; font-size: 0.9rem; }
        .links a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="logo">ROUND LAB</div>
        <h2>회원가입</h2>
        
        <?php if (isset($success)): ?>
            <p class="success"><?php echo $success; ?></p>
            <div class="links"><a href="login.php">로그인하러 가기</a></div>
        <?php else: ?>
            <form method="POST" action="register.php">
                <input type="text" name="new_user_id" placeholder="아이디" required>
                <input type="password" name="new_password" placeholder="비밀번호" required>
                <input type="password" name="confirm_password" placeholder="비밀번호 확인" required>
                <button type="submit">가입하기</button>
            </form>
            
            <?php if (isset($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            
            <div class="links"><a href="index.php">메인 페이지로 돌아가기</a></div>
        <?php endif; ?>
    </div>
</body>
</html>