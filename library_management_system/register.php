<?php
session_start();
require __DIR__.'/config/database.php';
require __DIR__.'/includes/functions.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $student_id = trim($_POST['student_id'] ?? '');

    if ($username === '' || $email === '' || $password === '' || $student_id === '') {
        $errors[] = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email.';
    }

    if (!$errors) {
        $stmt = $mysqli->prepare("SELECT id FROM users WHERE email=? OR username=?");
        $stmt->bind_param('ss', $email, $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors[] = 'Username or email already exists.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $role = 'student';
            $stmt = $mysqli->prepare("INSERT INTO users (username,email,password,role,student_id) VALUES (?,?,?,?,?)");
            $stmt->bind_param('sssss', $username, $email, $hash, $role, $student_id);
            if ($stmt->execute()) {
                $_SESSION['flash'] = 'Registration successful. Please login.';
                header('Location: login.php');
                exit;
            } else {
                $errors[] = 'Registration failed.';
            }
        }
    }
}
include __DIR__.'/includes/header.php';
?>
<h3>Register</h3>
<?php if ($errors): ?>
<div class="alert alert-danger"><?php echo e(implode('<br>', $errors)); ?></div>
<?php endif; ?>
<form method="post" class="needs-validation" novalidate>
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Username</label>
      <input type="text" name="username" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Student ID</label>
      <input type="text" name="student_id" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" minlength="6" required>
    </div>
  </div>
  <div class="mt-3">
    <button class="btn btn-primary" type="submit">Create account</button>
  </div>
</form>
<?php include __DIR__.'/includes/footer.php'; ?>
