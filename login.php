<?php
// login.php
session_start();

// 임시 사용자 데이터 (실제 DB에서는 이 부분을 대체해야 함)
$valid_users = ['testuser' => '1234', 'admin' => 'password']; // ID => 비밀번호

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = trim($_POST['user_id']);
    $password = $_POST['password'];

    if (isset($valid_users[$user_id]) && $valid_users[$user_id] === $password) {
        // 로그인 성공
        $_SESSION['user_id'] = $user_id;
        header('Location: index.php'); // 메인 페이지로 리다이렉트
        exit;
    } else {
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