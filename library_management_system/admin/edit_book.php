<?php
session_start();
require __DIR__.'/../config/database.php';
require __DIR__.'/../includes/functions.php';
require_admin();

$id = (int)($_GET['id'] ?? 0);
$stmt = $mysqli->prepare("SELECT * FROM books WHERE book_id=?");
$stmt->bind_param('i',$id);
$stmt->execute();
$book = $stmt->get_result()->fetch_assoc();
if(!$book){ header('Location: manage_books.php'); exit; }

$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
  $title=trim($_POST['title']??'');
  $author=trim($_POST['author']??'');
  $category=trim($_POST['category']??'');
  $status=trim($_POST['status']??'Available');
  if($title===''||$author===''||$category===''){ $errors[]='All fields required.'; }
  if(!$errors){
    $stmt=$mysqli->prepare("UPDATE books SET title=?, author=?, category=?, status=? WHERE book_id=?");
    $stmt->bind_param('ssssi',$title,$author,$category,$status,$id);
    if($stmt->execute()){ header('Location: manage_books.php'); exit; }
    else { $errors[]='Update failed.'; }
  }
}

include __DIR__.'/../includes/header.php';
?>
<h3>Edit Book</h3>
<?php if($errors): ?><div class="alert alert-danger"><?php echo e(implode('<br>',$errors)); ?></div><?php endif; ?>
<form method="post" class="needs-validation" novalidate>
  <div class="mb-3"><label class="form-label">Title</label><input class="form-control" name="title" value="<?php echo e($book['title']); ?>" required></div>
  <div class="mb-3"><label class="form-label">Author</label><input class="form-control" name="author" value="<?php echo e($book['author']); ?>" required></div>
  <div class="mb-3"><label class="form-label">Category</label><input class="form-control" name="category" value="<?php echo e($book['category']); ?>" required></div>
  <div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
      <?php foreach(['Available','Borrowed'] as $s): ?>
        <option <?php echo $book['status']===$s?'selected':''; ?>><?php echo e($s); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <button class="btn btn-primary" type="submit">Update</button>
  <a class="btn btn-secondary" href="manage_books.php">Cancel</a>
</form>
<?php include __DIR__.'/../includes/footer.php'; ?>
