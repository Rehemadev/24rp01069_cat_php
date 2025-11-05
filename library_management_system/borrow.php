<?php
session_start();
require __DIR__.'/config/database.php';
require __DIR__.'/includes/functions.php';
require_login();

$book_id = (int)($_POST['book_id'] ?? 0);
if ($book_id <= 0) { header('Location: books.php'); exit; }

$mysqli->begin_transaction();
try {
    // Check availability
    $stmt = $mysqli->prepare("SELECT status FROM books WHERE book_id=? FOR UPDATE");
    $stmt->bind_param('i', $book_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $book = $res->fetch_assoc();
    if (!$book || $book['status'] !== 'Available') {
        throw new Exception('Book unavailable.');
    }

    // Insert borrow record
    $stmt = $mysqli->prepare("INSERT INTO borrowed_books (student_id, book_id, borrow_date) VALUES (?, ?, NOW())");
    $stmt->bind_param('si', $_SESSION['user']['student_id'], $book_id);
    if (!$stmt->execute()) throw new Exception('Borrow failed.');

    // Update book status
    $stmt = $mysqli->prepare("UPDATE books SET status='Borrowed' WHERE book_id=?");
    $stmt->bind_param('i', $book_id);
    if (!$stmt->execute()) throw new Exception('Status update failed.');

    $mysqli->commit();
    header('Location: dashboard.php');
} catch (Exception $e) {
    $mysqli->rollback();
    $_SESSION['flash'] = 'Error: '.$e->getMessage();
    header('Location: books.php');
}
exit;
