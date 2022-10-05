<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('location: listProduct.php');
}
include "connect.php";
$errors = [];
$product = array();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $sql = "SELECT * FROM product WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
        }
    } catch (Exception $e) {
        echo json_encode($e->getMessage());
    }
}

$sql = "SELECT * FROM category";
$result = $conn->query($sql);
$categorys = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categorys[] = $row;
    }
}

$sql = "SELECT * FROM brand";
$result = $conn->query($sql);
$brands = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $brands[] = $row;
    }
}

$sql = "SELECT * FROM gemstone";
$result = $conn->query($sql);
$gemstones = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $gemstones[] = $row;
    }
}

if (is_array($product) && isset($product['id'])) {
?>
    <h2 class="text-white bg-info p-3 w-100">Update Product</h2>
    <input type="hidden" name="id" value="<?php if(!empty($product['id'])) echo $product['id']; ?>">
    <div class="input-form p-3">
        <div class="form-group mb-3">
            <label>Name </label>
            <input type="text" value="<?php if (!empty($product['name'])) echo $product['name']; ?>" class="form-control mt-1" id="name" name="name" placeholder="Enter name" readonly>
        </div>
        <div class="form-group mb-3">
            <label>Description </label>
            <textarea name="description" class="form-control mt-1" id="description" rows="5" placeholder="Enter description" required><?php if (!empty($product['description'])) echo $product['description']; ?></textarea>
        </div>
        <div class="form-group mb-3">
            <label>Price($) </label>
            <input type="number" value="<?php if (!empty($product['price'])) echo $product['price']; ?>" class="form-control mt-1" id="price" name="price" placeholder="Enter price" min="0" step=".01" required>
        </div>
        <div class="form-group mb-3">
            <label>Category</label>
            <select name="category" id="category_id" class="form-control mt-1" required>
                <?php
                foreach ($categorys as $category) {
                    $selected = ($category['id'] == $product['category_id']) ? 'selected' : '';
                    echo "<option {$selected} value='$category[id]'>$category[category_name] </option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group mb-3">
            <label>Brand</label>
            <select name="brand" id="brand_id" class="form-control mt-1" required>
                <?php
                foreach ($brands as $brand) {
                    $selected = ($brand['id'] == $product['brand_id']) ? 'selected' : '';
                    echo "<option {$selected} value='$brand[id]'>$brand[brand_name] </option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group mb-3">
            <label>Gemstone</label>
            <select name="gemstone" id="gemstone_id" class="form-control mt-1" required>
                <?php
                foreach ($gemstones as $gemstone) {
                    $selected = ($gemstone['id'] == $product['gemstone_id']) ? 'selected' : '';
                    echo "<option {$selected} value='$gemstone[id]'>$gemstone[gemstone_name] </option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group mb-3">
            <label>Avatar </label><br>
            <input type="file" class="mt-1" name="avatar"> <br>
            <img class="mt-2" src="<?php if(!empty($product['avatar'])): echo $product['avatar']; else: echo '../public/images/avatar/imageDefault.jpg'; endif; ?>" alt="imageDefault" width="110" height="110">
        </div>

        <input type="hidden" name="updateProduct" value="1">
        <input type="submit" value="Update" name="update_btn" class="btn btn-success text-white py-2 px-3">
        <div class="error-wrap">
            <?php
            foreach ($errors as $errors) {
                echo '<div class="alert alert-danger mt-2" role="alert">' . $errors . '</div>';
            }
            ?>
        </div>
    </div>
<?php
}
