<?php
session_start();
require __DIR__.'/../config/database.php';
require __DIR__.'/../includes/functions.php';
require_admin();

// handle deletion
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $mysqli->prepare("DELETE FROM books WHERE book_id=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    header('Location: manage_books.php');
    exit;
}

include __DIR__.'/../includes/header.php';

$res = $mysqli->query("SELECT * FROM books ORDER BY title");
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Manage Books</h3>
  <a href="add_book.php" class="btn btn-primary">Add Book</a>
</div>
<table class="table table-striped align-middle">
  <thead><tr><th>#</th><th>Title</th><th>Author</th><th>Category</th><th>Status</th><th>Actions</th></tr></thead>
  <tbody>
<?php $i=1; while ($b=$res->fetch_assoc()): ?>
<tr>
  <td><?php echo $i++; ?></td>
  <td><?php echo e($b['title']); ?></td>
  <td><?php echo e($b['author']); ?></td>
  <td><?php echo e($b['category']); ?></td>
  <td><?php echo e($b['status']); ?></td>
  <td>
    <a class="btn btn-sm btn-warning" href="edit_book.php?id=<?php echo (int)$b['book_id']; ?>">Edit</a>
    <a class="btn btn-sm btn-danger" href="manage_books.php?delete=<?php echo (int)$b['book_id']; ?>" onclick="return confirm('Delete book?')">Delete</a>
  </td>
</tr>
<?php endwhile; ?>
  </tbody>
</table>
<?php include __DIR__.'/../includes/footer.php'; ?>
