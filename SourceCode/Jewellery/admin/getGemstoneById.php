<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: gemstonePage.php');
}
include "connect.php";
$errors = [];
$gemstone = array();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $sql = "SELECT * FROM gemstone WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $gemstone = $result->fetch_assoc();
        }
    } catch (Exception $e) {
        echo json_encode($e->getMessage());
    }
}

if (is_array($gemstone) && isset($gemstone['id'])) {
?>
    <h2 class="text-white bg-info p-3 w-100">Update Gemstone Account</h2>
    <div class="input-form p-3">
        <input type="hidden" name="id" value="<?php echo $gemstone['id']; ?>">
        <div class="form-group mb-3">
            <label>Gemstone Title </label>
            <input type="text" value="<?php if (!empty($gemstone['gemstone_name'])) echo $gemstone['gemstone_name']; ?>" class="form-control mt-1" id="gemstone" name="gemstone" placeholder="Enter gemstone">
        </div>
        <input type="hidden" name="updategemstone" value="1">
        <input type="submit" value="Update" name="update_btn" class="btn btn-warning text-white py-2 px-3">
        <?php
        foreach ($errors as $errors) {
            echo '<div class="alert alert-danger mt-2" role="alert">' . $errors . '</div>';
        }
        ?>
    </div>
<?php
}
