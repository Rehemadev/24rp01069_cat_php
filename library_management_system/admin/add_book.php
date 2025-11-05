<?php
session_start();
require __DIR__.'/../config/database.php';
require __DIR__.'/../includes/functions.php';
require_admin();

$errors=[];
if ($_SERVER['REQUEST_METHOD']==='POST') {
  $title=trim($_POST['title']??'');
  $author=trim($_POST['author']??'');
  $category=trim($_POST['category']??'');
  $status='Available';
  if($title===''||$author===''||$category===''){ $errors[]='All fields required.'; }
  if(!$errors){
    $stmt=$mysqli->prepare("INSERT INTO books (title,author,category,status) VALUES (?,?,?,?)");
    $stmt->bind_param('ssss',$title,$author,$category,$status);
    if($stmt->execute()){ header('Location: manage_books.php'); exit; }
    else { $errors[]='Insert failed.'; }
  }
}
include __DIR__.'/../includes/header.php';
?>
<h3>Add Book</h3>
<?php if($errors): ?><div class="alert alert-danger"><?php echo e(implode('<br>',$errors)); ?></div><?php endif; ?>
<form method="post" class="needs-validation" novalidate>
  <div class="mb-3"><label class="form-label">Title</label><input class="form-control" name="title" required></div>
  <div class="mb-3"><label class="form-label">Author</label><input class="form-control" name="author" required></div>
  <div class="mb-3"><label class="form-label">Category</label><input class="form-control" name="category" required></div>
  <button class="btn btn-primary" type="submit">Save</button>
  <a class="btn btn-secondary" href="manage_books.php">Cancel</a>
</form>
<?php include __DIR__.'/../includes/footer.php'; ?>
