<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: listUser.php');
}
include "connect.php";
$errors = [];
$user = array();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $sql = "SELECT * FROM account WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
        }
    } catch (Exception $e) {
        echo json_encode($e->getMessage());
    }
}

if (is_array($user) && isset($user['id'])) {
?>
    <h2 class="text-white bg-info p-3 w-100">Update User Account</h2>
    <div class="input-form p-3">
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        <div class="form-group mb-3">
            <label>Fullname </label>
            <input type="text" value="<?php if (!empty($user['fullname'])) echo $user['fullname']; ?>" class="form-control mt-1" id="fullname" name="fullname" placeholder="Enter fullname" readonly>
        </div>
        <div class="form-group mb-3">
            <label>Email </label>
            <input type="email" value="<?php if (!empty($user['email'])) echo $user['email']; ?>" class="form-control mt-1" id="email" name="email" placeholder="Enter email" readonly>
        </div>
        <div class="form-group mb-3">
            <label>Phone Number </label>
            <input type="text" value="<?php if (!empty($user['phone'])) echo $user['phone']; ?>" pattern="[0-9]{10,11}" class="form-control mt-1" id="phone" name="phone" placeholder="Enter phone " required>
        </div>
        <div class="form-group mb-3">
            <label>Address</label>
            <input type="text" value="<?php if (!empty($user['address'])) echo $user['address']; ?>" class="form-control mt-1" id="address" name="address" placeholder="Enter address" required>
        </div>
        <div class="form-group mb-3">
            <label>New Password </label>
            <input type="password" class="form-control mt-1" id="new_password" name="password" placeholder="Enter new_password">
        </div>
        <div class="form-group mb-3">
            <label>Confirm New Password </label>
            <input type="password" class="form-control mt-1" id="new_password_confirm" name="password_confirm" placeholder="Confirm new password ">
        </div>
        <input type="hidden" name="updateUser" value="1">
        <input type="submit" value="Update" name="update_btn" class="btn btn-warning text-white py-2 px-3">
        <?php
        foreach ($errors as $errors) {
            echo '<div class="alert alert-danger mt-2" role="alert">' . $errors . '</div>';
        }
        ?>
    </div>
    <script>
        $('#new_password_confirm').on('keyup', function(e) {
            if ($('#new_password').val() != $('#new_password_confirm').val()) {
                $('#new_password_confirm').addClass('is-invalid');
            } else {
                $('#new_password_confirm').removeClass('is-invalid');
            }
        });
    </script>
<?php
}
