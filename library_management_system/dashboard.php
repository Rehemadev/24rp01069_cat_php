<?php
session_start();
require __DIR__.'/config/database.php';
require __DIR__.'/includes/functions.php';
require_login();

include __DIR__.'/includes/header.php';

$user = $_SESSION['user'];
?>
<h3 class="mb-3">Dashboard</h3>
<div class="mb-3">Hello, <strong><?php echo e($user['username']); ?></strong> (<?php echo e($user['role']); ?>)</div>

<?php if (is_admin()): ?>
<div class="alert alert-info">Admin panel: <a href="admin/manage_books.php">Manage books</a></div>
<?php endif; ?>

<h5>Your borrowed books</h5>
<table class="table table-striped align-middle">
  <thead><tr><th>#</th><th>Title</th><th>Author</th><th>Borrowed</th><th>Return</th></tr></thead>
  <tbody>
<?php
$stmt = $mysqli->prepare("
SELECT b.title, b.author, bb.borrow_date, bb.return_date
FROM borrowed_books bb
JOIN books b ON b.book_id = bb.book_id
WHERE bb.student_id = ?
ORDER BY bb.borrow_date DESC
");
$stmt->bind_param('s', $user['student_id']);
$stmt->execute();
$res = $stmt->get_result();
$i=1;
while ($row = $res->fetch_assoc()): ?>
<tr>
  <td><?php echo $i++; ?></td>
  <td><?php echo e($row['title']); ?></td>
  <td><?php echo e($row['author']); ?></td>
  <td><?php echo e($row['borrow_date']); ?></td>
  <td><?php echo e($row['return_date'] ?: '-'); ?></td>
</tr>
<?php endwhile; ?>
  </tbody>
</table>
<?php include __DIR__.'/includes/footer.php'; ?>
