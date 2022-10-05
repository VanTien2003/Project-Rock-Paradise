<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: comments.php');
}
include "connect.php";
$errors = [];
$comments = array();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $sql = "SELECT comments.id, account.fullname, account.email, account.phone, comments.content, comments.created_at, comments.status  FROM account INNER JOIN comments on account.id = comments.account_id INNER JOIN product on comments.product_id = product.id WHERE comments.id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $comments = $result->fetch_assoc();
        } else {
            echo "Error: " .$conn->error;
        }
    } catch (Exception $e) {
        echo json_encode($e->getMessage());
    }
}

if (is_array($comments) && count($comments) > 0 && isset($comments['id'])) {
?>
    <h2 class="text-white bg-info p-3 w-100">Update Status </h2>
    <div class="input-form p-3">
        <input type="hidden" name="id" value="<?php echo $comments['id']; ?>">
        <div class="form-group mb-3">
            <label>Status </label>
            <input type="number" min="0" max="1" value="<?=$comments['status']; ?>" class="form-control mt-1" id="status" name="status" placeholder="Enter status">
        </div>
        <input type="hidden" name="updateStatus" value="1">
        <input type="submit" value="Update" name="update_btn" class="btn btn-warning text-white py-2 px-3">
        <?php
        foreach ($errors as $errors) {
            echo '<div class="alert alert-danger mt-2" role="alert">' . $errors . '</div>';
        }
        ?>
    </div>
<?php
}
