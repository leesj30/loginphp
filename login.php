<?php
$message = ''; // 메시지를 저장할 변수

// 데이터베이스 연결 설정
$db = new PDO('mysql:host=localhost;dbname=user_data', 'root', '');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    // 폼에서 제출된 데이터 받기
    $id = $_POST['id'];
    $password = $_POST['password'];

    // 사용자 정보 조회 쿼리
    $stmt = $db->prepare("SELECT * FROM user WHERE id = ?");
    $stmt->execute(array($id));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // 비밀번호 검증 성공
        $_SESSION['user_id'] = $user['id'];
        $message = "로그인 성공!";
    } else {
        // 로그인 실패
        $message = "ID 또는 비밀번호가 잘못되었습니다.";
    }
}
?>

<!-- 로그인 양식 -->
<form method="post">
    ID: <input type="text" name="id" required>
    Password: <input type="password" name="password" required>
    <input type="submit" name="login" value="Login">
    <!-- 회원가입 페이지로 이동하는 버튼 추가 -->
    <button type="button" onclick="window.location.href='register.php';">회원가입</button>
</form>

<?php if ($message != ''): ?>
<script type="text/javascript">
alert('<?php echo $message; ?>');
</script>
<?php endif; ?>
