<?php include __DIR__.'/includes/header.php'; ?>
<div class="p-5 mb-4 bg-white rounded-3 border">
  <div class="container-fluid py-5">
    <h1 class="display-6 fw-bold">Welcome to the Library</h1>
    <p class="col-md-8 fs-5">Register, browse books, and borrow online. Admins manage catalog and availability.</p>
    <a class="btn btn-primary btn-lg" href="books.php">Browse Books</a>
  </div>
</div>
<div class="row g-3">
  <div class="col-md-4">
    <div class="card card-hover">
      <div class="card-body">
        <h5 class="card-title">Register</h5>
        <p class="card-text">Create your student account.</p>
        <a href="register.php" class="btn btn-outline-primary">Get started</a>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card card-hover">
      <div class="card-body">
        <h5 class="card-title">Login</h5>
        <p class="card-text">Access your dashboard and borrowed books.</p>
        <a href="login.php" class="btn btn-outline-primary">Sign in</a>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card card-hover">
      <div class="card-body">
        <h5 class="card-title">Books</h5>
        <p class="card-text">Search and filter available books.</p>
        <a href="books.php" class="btn btn-outline-primary">View catalog</a>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__.'/includes/footer.php'; ?>
