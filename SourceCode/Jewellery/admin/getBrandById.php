<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: brandPage.php');
}
include "connect.php";
$errors = [];
$brand = array();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $sql = "SELECT * FROM brand WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $brand = $result->fetch_assoc();
        }
    } catch (Exception $e) {
        echo json_encode($e->getMessage());
    }
}

if (is_array($brand) && isset($brand['id'])) {
?>
    <h2 class="text-white bg-info p-3 w-100">Update Brand Account</h2>
    <div class="input-form p-3">
        <input type="hidden" name="id" value="<?php echo $brand['id']; ?>">
        <div class="form-group mb-3">
            <label>Brand Title </label>
            <input type="text" value="<?php if (!empty($brand['brand_name'])) echo $brand['brand_name']; ?>" class="form-control mt-1" id="brand" name="brand" placeholder="Enter brand">
        </div>
        <input type="hidden" name="updateBrand" value="1">
        <input type="submit" value="Update" name="update_btn" class="btn btn-warning text-white py-2 px-3">
        <?php
        foreach ($errors as $errors) {
            echo '<div class="alert alert-danger mt-2" role="alert">' . $errors . '</div>';
        }
        ?>
    </div>
<?php
}
