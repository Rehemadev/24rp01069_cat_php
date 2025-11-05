<?php
session_start();
require __DIR__.'/config/database.php';
require __DIR__.'/includes/functions.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $errors[] = 'Email and password are required.';
    } else {
        $stmt = $mysqli->prepare("SELECT id, username, email, password, role, student_id FROM users WHERE email=?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id'=>$user['id'],
                'username'=>$user['username'],
                'email'=>$user['email'],
                'role'=>$user['role'],
                'student_id'=>$user['student_id']
            ];
            header('Location: dashboard.php');
            exit;
        } else {
            $errors[] = 'Invalid credentials.';
        }
    }
}
include __DIR__.'/includes/header.php';
?>
<h3>Login</h3>
<?php if (!empty($_SESSION['flash'])): ?>
  <div class="alert alert-success"><?php echo e($_SESSION['flash']); unset($_SESSION['flash']); ?></div>
<?php endif; ?>
<?php if ($errors): ?>
<div class="alert alert-danger"><?php echo e(implode('<br>', $errors)); ?></div>
<?php endif; ?>
<form method="post" class="needs-validation" novalidate>
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password" name="password" class="form-control" required>
  </div>
  <button class="btn btn-primary" type="submit">Login</button>
</form>
<?php include __DIR__.'/includes/footer.php'; ?>
