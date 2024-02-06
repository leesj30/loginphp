<?php
// 데이터베이스 연결 설정
$db = new PDO('mysql:host=localhost;dbname=user_data', 'root', '');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['register'])) {
    $id = $_GET['id'];
    $password = password_hash($_GET['password'], PASSWORD_DEFAULT);

    $checkStmt = $db->prepare("SELECT * FROM user WHERE id = ?");
    $checkStmt->execute(array($id));
    $user = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo "<script>alert('이미 존재하는 ID입니다.');</script>";
    } else {
        $stmt = $db->prepare("INSERT INTO user (id, password) VALUES (?, ?)");
        if ($stmt->execute(array($id, $password))) {
            echo "<script>alert('회원가입이 완료되었습니다.'); window.location = 'login.php';</script>";
            exit();
        }
    }
}
?>

<!-- 회원가입 양식 -->
<form method="get">
    ID: <input type="text" name="id" required>
    Password: <input type="password" name="password" required> 
    <input type="submit" name="register" value="Register">
</form>

