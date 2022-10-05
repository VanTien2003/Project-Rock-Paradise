<?php 
  $conn = new mysqli("localhost", "root", "vertrigo", null);
  if($conn->connect_error) {
    die("Connection Failed: " .$conn->connect_error);
  }

  $sql = "CREATE DATABASE IF NOT EXISTS TermProject1";
  $result = $conn->query($sql);
  if($result) {
    echo "Database created Successfully!!!";
  } else {
    die("Error creating database: ". $conn->error);
  }
  $conn->select_db("TermProject1");

  // Table structure for table account
  $sql = "CREATE TABLE IF NOT EXISTS account (
    id int AUTO_INCREMENT PRIMARY KEY,
    role varchar(30) NOT NULL,
    fullname varchar(50) NOT NULL,
    email varchar(100) NOT NULL UNIQUE,
    password varchar(50) NOT NULL,
    phone varchar(11) NOT NULL,
    address varchar(200) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    code INT NOT NULL DEFAULT 0,
    status varchar(20) NOT NULL DEFAULT 'verified'
  )";

  $result = $conn->query($sql);
  if($result) {
    echo "Table account created successfully!!!";
  } else {
    die("Error Creating Table account! ".$conn->error);
  }

  // Table structure for table brand
  $sql = "CREATE TABLE IF NOT EXISTS brand (
    id int AUTO_INCREMENT PRIMARY KEY,
    brand_name varchar(50) NOT NULL
  )";

  $result = $conn->query($sql);
  if($result) {
    echo "Table brand created successfully!!!";
  } else {
    die("Error Creating Table brand! ".$conn->error);
  }

  // Table structure for table category
  $sql = "CREATE TABLE IF NOT EXISTS category (
    id int AUTO_INCREMENT PRIMARY KEY,
    category_name varchar(50) NOT NULL
  )";

  $result = $conn->query($sql);
  if($result) {
    echo "Table category created successfully!!!";
  } else {
    die("Error Creating Table category! ".$conn->error);
  }

  // Table structure for table feedback
  $sql = "CREATE TABLE IF NOT EXISTS comments (
    id int AUTO_INCREMENT PRIMARY KEY,
    account_id INT NOT NULL,
    product_id INT NOT NULL,
    content varchar(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status TINYINT(1) DEFAULT 0
  )";

  $result = $conn->query($sql);
  if($result) {
    echo "Table comments created successfully!!!";
  } else {
    die("Error Creating Table comments! ".$conn->error);
  }

  // Table structure for table gemstone
  $sql = "CREATE TABLE IF NOT EXISTS gemstone (
    id int AUTO_INCREMENT PRIMARY KEY,
    gemstone_name varchar(50) NOT NULL
  )";

  $result = $conn->query($sql);
  if($result) {
    echo "Table gemstone created successfully!!!";
  } else {
    die("Error Creating Table gemstone! ".$conn->error);
  }

  // Table structure for table product_order
  $sql = "CREATE TABLE IF NOT EXISTS product_order (
    id int AUTO_INCREMENT PRIMARY KEY,
    account_id int NOT NULL,
    orderMethod_id int NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status TINYINT NOT NULL DEFAULT 1,
    FOREIGN KEY (account_id) REFERENCES account(id)
  )";

  $result = $conn->query($sql);
  if($result) {
    echo "Table product_order created successfully!!!";
  } else {
    die("Error Creating Table product_order! ".$conn->error);
  }

  // Table structure for table product
  $sql = "CREATE TABLE IF NOT EXISTS product (
    id int AUTO_INCREMENT PRIMARY KEY,
    avatar varchar(255),
    name varchar(100) NOT NULL,
    description varchar(255) NOT NULL,
    price float NOT NULL,
    sold varchar(30),
    sale varchar(100),
    category_id int NOT NULL,
    brand_id int NOT NULL,
    gemstone_id int NOT NULL,
    FOREIGN KEY (brand_id) REFERENCES brand(id),
    FOREIGN KEY (gemstone_id) REFERENCES gemstone(id),
    FOREIGN KEY (category_id) REFERENCES category(id)
)";

  $result = $conn->query($sql);
  if($result) {
    echo "Table product created successfully!!!";
  } else {
    die("Error Creating Table product! ".$conn->error);
  }

  // Table structure for table order_detail
  $sql = "CREATE TABLE IF NOT EXISTS order_detail (
    id int AUTO_INCREMENT PRIMARY KEY,
    order_id int NOT NULL,
    product_id int NOT NULL,
    price float NOT NULL,
    quantity int NOT NULL,
    FOREIGN KEY (product_id) REFERENCES product(id),
    FOREIGN KEY (order_id) REFERENCES product_order(id)
  )";

  $result = $conn->query($sql);
  if($result) {
    echo "Table order_detail created successfully!!!";
  } else {
    die("Error Creating Table order_detail! ".$conn->error);
  }

  // Table structure for table gallery
  $sql = "CREATE TABLE IF NOT EXISTS gallery (
    id int AUTO_INCREMENT PRIMARY KEY,
    product_id int NOT NULL,
    image varchar(255) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES product(id)
  )";

  $result = $conn->query($sql);
  if($result) {
    echo "Table gallery created successfully!!!";
  } else {
    die("Error Creating Table gallery! ".$conn->error);
  }

  // Table structure for table contact
  $sql = "CREATE TABLE IF NOT EXISTS contact(
    id int AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    phone VARCHAR(11) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(50) NOT NULL,
    message VARCHAR(255) NOT NULL
  )";

  $result = $conn->query($sql);
  if($result) {
    echo "Table contact created successfully!!!";
  } else {
    die("Error Creating table contact! ".$conn->error);
  }


  // Insert Table Brand
  // $sql = "INSERT INTO `brand` (`id`, `brand_name`) VALUES
  // (1, 'Swarovski'),
  // (2, 'Tiffany'),
  // (3, 'Pandora'),
  // (4, 'Saga'),
  // (5, 'Sokolov'),
  // (6, 'BvLgari'),
  // (7, 'Cartier'),
  // (8, 'Other')";

  // $result = $conn->query($sql);
  // if($result) {
  //   echo "Insert table brand successfullly!!!";
  // } else {
  //   die("Error Insert table brand! ".$conn->error);
  // }
  
  // // Insert Table Category
  // $sql = "INSERT INTO `category` (`id`, `category_name`) VALUES
  // (1, 'Pendant '),
  // (2, 'Necklace'),
  // (3, 'Bangle'),
  // (4, 'Rings'),
  // (5, 'Leather Belt'),
  // (6, 'Errings'),
  // (7, 'crown'),
  // (8, 'keyring')";

  // $result = $conn->query($sql);
  // if($result) {
  //   echo "Insert table category successfullly!!!";
  // } else {
  //   die("Error Insert table category! ".$conn->error);
  // }

  // // Insert Table Category
  // $sql = "INSERT INTO `gemstone` (`id`, `gemstone_name`) VALUES
  // (1, 'Rhodium plated'),
  // (2, 'aventurine '),
  // (3, 'Diamond'),
  // (4, 'Amethyst'),
  // (5, 'Crystal Quartz'),
  // (6, 'Rose Quartz'),
  // (7, 'Lapis'),
  // (8, 'Labradorite')";

  // $result = $conn->query($sql);
  // if($result) {
  //   echo "Insert table gemstone successfullly!!!";
  // } else {
  //   die("Error Insert table gemstone! ".$conn->error);
  // }

  // Insert Table Category
  // $sql = "INSERT INTO gallery (product_id, image) VALUES
  // (1, '/images/product/sunshine-ring--pink--rhodium-plated-swarovski-5642966.png'),
  // (1, '/images/product/sunshine-ring--pink--rhodium-plated-swarovski-5642966 (1).png'),
  // (2, '/images/product/constella-cocktail-ring--princess-cut--white--rhodium-plated-swarovski-5638529.png'),
  // (2, '/images/product/constella-cocktail-ring--princess-cut--white--rhodium-plated-swarovski-5638529 (1).png'),
  // (2, '/images/product/constella-cocktail-ring--princess-cut--white--rhodium-plated-swarovski-5638529 (2).png'),
  // (2, '/images/product/constella-cocktail-ring--princess-cut--white--rhodium-plated-swarovski-5638529 (3).png'),
  // (3, '/images/product/Screenshot 2022-08-31 171919.png'),
  // (4, '/images/product/04AF3460E010416DA17561B094BB.jpg'),
  // (4, '/images/product/219F78B5DC525C576404BC2F25DE.jpg'),
  // (4, '/images/product/BCD7486C0240F2B39BA5F66EF324.jpg'),
  // (4, '/images/product/50B5BE65E2BA31D9C85AD98A8E0C.jpg'),
  // (5, '/images/product/1360054.png'),
  // (5, '/images/product/1360055.png'),
  // (5, '/images/product/1364610.png'),
  // (5, '/images/product/1341089.png'),
  // (6, '/images/product/IMG_E8773_900x.png'),
  // (6, '/images/product/IMG_E8773_900x (1).png'),
  // (6, '/images/product/IMG_E8771_900x.png'),
  // (6, '/images/product/IMG_E8770_900x.png'),
  // (7, '/images/product/KEYCHAINS.TUMBLED_900x.png'),
  // (7, '/images/product/tumbled-tiger-eye-silver-toned-key-chain-natural-crystal-tiger-eye-stone-keychain-rk45b1b-3_900x_67e95927-209a-4c8c-b2e6-aff0333b9a69_900x.jpg'),
  // (7, '/images/product/tumbled-crystal-quartz-silver-toned-key-chain-natural-crystal-quartz-stone-keychain-rk45b2b-01-1_900x_371860d4-d54a-46aa-bcdf-aa67010167a8_900x.png'),
  // (7, '/images/product/tumbled-rose-quartz-silver-toned-key-chain-natural-crystal-rose-quartz-stone-keychain-rk45b6b-1_900x_d23c3561-5851-483b-b524-2e61087b0bdd_900x.png'),
  // (7, '/images/product/keychain-tumbled-citrine-silver-toned-key-chain-natural-crystal-citrine-stone-keychain-rk45b5b-02-1_900x_c809e5f1-249f-40e3-9e95-4a51a2091620_900x.png'),
  // (8, '/images/product/IMG_E6303_55047c3d-3eea-4d0e-86fa-51286acaebe2_900x.png'),
  // (8, '/images/product/IMG_E6303_55047c3d-3eea-4d0e-86fa-51286acaebe2_900x (1).png'),
  // (8, '/images/product/IMG_E6309-001_900x.png'),
  // (8, '/images/product/IMG_E6313_ede17bc4-a149-4012-a126-c6f7ca98ae01_900x.png'),
  // (9, '/images/product/crown-princess-crown-gold-and-silver-crowns-with-5-or-7-stone-accents-22_900x.png'),
  // (9, '/images/product/crown-princess-crown-gold-and-silver-crowns-with-5-or-7-stone-accents-19_900x.png'),
  // (9, '/images/product/crown-princess-crown-gold-and-silver-crowns-with-5-or-7-stone-accents-24_900x.png'),
  // (9, '/images/product/crown-princess-crown-gold-and-silver-crowns-with-5-or-7-stone-accents-32_900x.png'),
  // (10, '/images/product/IMG_7152_900x.png'),
  // (10, '/images/product/IMG_7132_900x.png'),
  // (10, '/images/product/IMG_7135_900x.png'),
  // (10, '/images/product/IMG_7138_900x.png'),
  // (10, '/images/product/IMG_7146_900x.png'),
  // (11, '/images/product/IMG_7098_900x.png'),
  // (11, '/images/product/IMG_7092_900x.png'),
  // (11, '/images/product/IMG_7097_900x.png'),
  // (11, '/images/product/IMG_7101_900x.png'),
  // (11, '/images/product/IMG_7108_900x.png')";

  // $result = $conn->query($sql);
  // if($result) {
  //   echo "Insert table gallery successfullly!!!";
  // } else {
  //   die("Error Insert table gallery! ".$conn->error);
  // }
  

?>
