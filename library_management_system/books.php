<?php
session_start();
require __DIR__.'/config/database.php';
require __DIR__.'/includes/functions.php';

$search = trim($_GET['q'] ?? '');
$sql = "SELECT * FROM books";
$params = [];
if ($search !== '') {
    $sql .= " WHERE title LIKE ? OR author LIKE ? OR category LIKE ?";
}
$sql .= " ORDER BY title ASC";

$stmt = $mysqli->prepare($sql);
if ($search !== '') {
    $like = "%$search%";
    $stmt->bind_param('sss', $like, $like, $like);
}
$stmt->execute();
$res = $stmt->get_result();

include __DIR__.'/includes/header.php';
?>
<h3>Books</h3>
<form class="row g-2 mb-3" method="get">
  <div class="col-md-10">
    <input class="form-control" type="search" name="q" placeholder="Search by title, author, category" value="<?php echo e($search); ?>">
  </div>
  <div class="col-md-2 d-grid">
    <button class="btn btn-primary" type="submit">Search</button>
  </div>
</form>

<table class="table table-bordered table-striped align-middle">
  <thead><tr><th>Title</th><th>Author</th><th>Category</th><th>Status</th><th>Action</th></tr></thead>
  <tbody>
<?php while ($b = $res->fetch_assoc()): ?>
<tr>
  <td><?php echo e($b['title']); ?></td>
  <td><?php echo e($b['author']); ?></td>
  <td><?php echo e($b['category']); ?></td>
  <td><?php echo e($b['status']); ?></td>
  <td>
    <?php if (is_logged_in() && $b['status'] === 'Available'): ?>
      <form method="post" action="borrow.php" class="d-inline">
        <input type="hidden" name="book_id" value="<?php echo (int)$b['book_id']; ?>">
        <button class="btn btn-sm btn-success" type="submit">Borrow</button>
      </form>
    <?php else: ?>
      <button class="btn btn-sm btn-secondary" disabled>Borrow</button>
    <?php endif; ?>
  </td>
</tr>
<?php endwhile; ?>
  </tbody>
</table>
<?php include __DIR__.'/includes/footer.php'; ?>
