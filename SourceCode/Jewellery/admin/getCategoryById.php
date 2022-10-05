<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: categoryPage.php');
}
include "connect.php";
$errors = [];
$category = array();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $sql = "SELECT * FROM category WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $category = $result->fetch_assoc();
        }
    } catch (Exception $e) {
        echo json_encode($e->getMessage());
    }
}

if (is_array($category) && isset($category['id'])) {
?>
    <h2 class="text-white bg-info p-3 w-100">Update Category Account</h2>
    <div class="input-form p-3">
        <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
        <div class="form-group mb-3">
            <label>Category Title </label>
            <input type="text" value="<?php if (!empty($category['category_name'])) echo $category['category_name']; ?>" class="form-control mt-1" id="category" name="category" placeholder="Enter category">
        </div>
        <input type="hidden" name="updateCategory" value="1">
        <input type="submit" value="Update" name="update_btn" class="btn btn-warning text-white py-2 px-3">
        <?php
        foreach ($errors as $errors) {
            echo '<div class="alert alert-danger mt-2" role="alert">' . $errors . '</div>';
        }
        ?>
    </div>
<?php
}
