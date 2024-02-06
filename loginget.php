<?php
$message = '';

$db = new PDO('mysql:host=localhost;dbname=user_data', 'root', '');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['login'])) {
    $id = $_GET['id'];
    $password = $_GET['password'];

    $stmt = $db->prepare("SELECT * FROM user WHERE id = ?");
    $stmt->execute(array($id));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $message = "로그인 성공!";
    } else {
        $message = "ID 또는 비밀번호가 잘못되었습니다.";
    }
}
?>

<!-- 로그인 양식 -->
<form method="get">
    ID: <input type="text" name="id" required>
    Password: <input type="password" name="password" required> <!-- 여기를 수정했습니다 -->
    <input type="submit" name="login" value="Login">
    <button type="button" onclick="window.location.href='register.php';">회원가입</button>
</form>

<?php if ($message != ''): ?>
<script type="text/javascript">
alert('<?php echo $message; ?>');
</script>
<?php endif; ?>
