<?php 

function conx(){
    try{
        $conx=new PDO("mysql:host=localhost;dbname=ecommerce","root","");
        }
        catch(PDOException $e)
        {
            echo 'la connexion a échoué'.$e->getMessage();
        }    return $conx;
} 



/*function select_login($conx,$email){
    $req="SELECT * FROM `login` WHERE email=:email";
    $stmt = $conx->prepare($req) ;
    $stmt->execute(array(":email"=> $email)) ;
    return $stmt->fetchColumn();
}*/

class User {
    function insrt_login($conx,$email,$password,$type){
        $req="CALL  insrt_login(:email,:pass,:user_type)";
        $stmt = $conx->prepare($req) ;
        $stmt->execute(array(':email' => $email, ':pass' =>$password,':user_type'=> $type)) ;
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function loginEmailCount($conx,$email) {
        $query = "SELECT COUNT(*) FROM login where email=:email";
        $stmt = $conx->prepare($query);
        $stmt->execute(array(":email" => $email));
        return $stmt->fetchColumn();
    }
    public function fullLoginCount($conx,$email, $password) {
        $query = "CALL  test_login(:email,:log_password)";
        $stmt = $conx->prepare($query);
        $stmt->execute(array(":email" => $email, ":log_password" => $password));
        return $stmt->fetch();
    }
    public function fullLogin($conx,$email, $password) {
        try {
            $query = "SELECT * FROM `login` WHERE email=:email AND `password`=:log_password";
            $statement = $conx->prepare($query);
            $statement->execute(array(":email" => $email, ":log_password" => $password));
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null; 
        }
    }

}
class Client {
    function insrt_client($conx,$nom,$prenom,$tel,$email,$password){
    $req="CALL  insrt_client(:nom,:prenom,:tel,:login_email,:login_password)";
    $stmt = $conx->prepare($req) ;
    $stmt->execute(array(':nom' => $nom, ':prenom' =>$prenom,':tel' => $tel, ':login_email' =>$email,':login_password' => $password)) ;
    return $stmt;
}
    public function getByEmail($conx, $email) {
        try {
            $query = "SELECT * FROM `client` WHERE login_email=:email";
            $statement = $conx->prepare($query);
            $statement->execute(array(":email" => $email));
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null; 
        }
    }
}
class Admin {
    public function getByEmail($conx, $email) {
        try {
            $query = "SELECT * FROM `admin` WHERE login_email=:email";
            $statement = $conx->prepare($query);
            $statement->execute(array(":email" => $email));
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null; 
        }
    }
}
class cart {
    public function insertToCart($conx, $id_client, $id_product, $quantity, $total) {
        try {
            $query = "CALL inserttocart(:id_client, :id_product, :quantity, :total)";
            $stmt = $conx->prepare($query);
            $params = array(
                ':id_client' => $id_client,
                ':id_product' => $id_product,
                ':quantity' => $quantity,
                ':total' => $total,
            );
            $stmt->execute($params);
            return $stmt;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }  
    
    function fetchClientProducts($conx, $clientID) {
        try {
            // Query to select products chosen by the client
            $query = "SELECT p.*,p.id AS prod_id ,p.quantity AS prod_quantity, c.*,c.quantity AS cart_quantity FROM produit p INNER JOIN cart c ON p.id = c.id_product WHERE c.id_client = :clientID";
            $stmt = $conx->prepare($query);
            $stmt->bindParam(':clientID', $clientID, PDO::PARAM_INT);
            $stmt->execute();            
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $products;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }  
    public function deleteAllItemsFromCart($pdo,$idc) {
        try {
            // Prepare the SQL query to delete all items from the cart
            $query = "DELETE FROM cart WHERE id_client =:idc";
        
            // Prepare the statement
            $statement = $pdo->prepare($query);
        
            // Execute the statement
            $statement->execute(array(":idc"=> $idc));
        
            // Return true to indicate successful deletion
            return true;
        } catch (PDOException $e) {
            // If an error occurs during the deletion process, handle it here
            // For example, you can log the error or display a message
            // Return false to indicate failure
            return false;
        }
    }
    
    
    public function deleteProductFromCart($pdo,$idc, $date) {
        try {
            // Prepare the SQL statement to delete the product from the cart
            $stmt = $pdo->prepare("DELETE FROM cart WHERE id_client = :idc AND date = :date ");
            $stmt->execute(array(':idc'=>$idc,':date'=>$date));
            // Check if any rows were affected
            
        } catch (PDOException $e) {
            // Handle any exceptions, such as database errors
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
    public function count_cart( $conx, $idc){
        try {
            $query = "SELECT COUNT(*) FROM `cart` WHERE id_client=:id_client";
            $statement = $conx->prepare($query);
            $statement->execute(array(":id_client" => $idc));
            return $statement->fetchcolumn();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null; 
        }
    }
}
class products{
    function insrt_product($conx,$nom,$prix,$discount,$category,$dateCreation,$quantity,$image_url){
        try {
        $req="CALL  insrt_product(:nom,:prix,:discount,:category,:dateCreation,:quantity,:image_url)";
        $stmt = $conx->prepare($req) ;
        $stmt->execute(array(':nom' => $nom, ':prix' =>$prix,':discount' => $discount, ':category' =>$category,':dateCreation' => $dateCreation,':quantity' => $quantity,':image_url' => $image_url)) ;
        return $stmt;
        } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null; 
        }
    }
    function fetchProducts($conx, $sortBy, $sortOrder) {
        try {
            $query = "SELECT * FROM produit";
            if($sortBy!==null){
                if ($sortOrder !== null) {
                   $query .= " ORDER BY $sortBy $sortOrder";
                }else $query .= " ORDER BY $sortBy ASC";
            }
            $stmt = $conx->prepare($query);
            $stmt->execute();            
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $products;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
    function searchAndSortProducts($conn, $searchval, $category_nom , $minprix, $maxprix, $sortBy, $sortOrder) {
        try {
            $query = "SELECT * FROM produit WHERE nom = :searchval";
    
            if ($category_nom !== null) {
                $query .= " AND category = :category_nom";
            }
            if ($minprix !== null) {
                $query .= " AND prix >= :minprix";
            }
            if ($maxprix !== null) {
                $query .= " AND prix <= :maxprix";
            }
            if($sortOrder!==null){
                if ($sortBy !== null) {
                   $query .= " ORDER BY $sortBy $sortOrder";
                }
            }else $query .= " ORDER BY $sortBy ASC";
            
    
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':searchval', $searchval);
    
            if ($category_nom !== null) {
                $stmt->bindValue(':category_nom', $category_nom);
            }
            if ($minprix !== null) {
                $stmt->bindValue(':minprix', $minprix);
            }
            if ($maxprix !== null) {
                $stmt->bindValue(':maxprix', $maxprix);
            }
    
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $products;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
    

// Function to fetch product details from the database
function getProductById($pdo,$product_id) {


    try {

        $stmt = $pdo->prepare('SELECT * FROM produit WHERE id = :product_id');

        // Bind parameter
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Fetch product details as an associative array
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        return $product;
    } catch (PDOException $e) {
        // Handle database connection error
        echo "Error: " . $e->getMessage();
            return null;
    }
}

// Function to fetch product images from the database
function getProductImages($product_id) {
    // Connect to your database
    $pdo = new PDO('mysql:host=localhost;dbname=ecommerce', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare SQL statement to fetch images for the given product ID
    $stmt = $pdo->prepare('SELECT img_url FROM produit WHERE id = :product_id');
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch all image paths as an array
    $images = $stmt->fetchAll(PDO::FETCH_COLUMN);

    return $images;

}
    // Function to fetch product details by ID
    function fetchProductById($pdo, $product_id) {
        try {
            // Prepare SQL statement to fetch product details by ID
            $stmt = $pdo->prepare('SELECT * FROM produit WHERE id = :product_id');
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();
    
            // Fetch product details as an associative array
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $product;
        } catch (PDOException $e) {
            // Handle database connection error
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
    function deleteProduct($pdo,$product_id){
        try {
            // Prepare SQL statement to fetch product details by ID
            $stmt = $pdo->prepare('DELETE FROM produit WHERE `id` = :product_id');
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();
            return$stmt;
        } catch (PDOException $e) {
            // Handle database connection error
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
    function updateProduct($pdo, $product_id, $nom, $prix, $discount, $category, $quantity, $image_url) {
        try {
            $stmt = $pdo->prepare('UPDATE `produit` SET
                `nom` = :nom,
                `prix` = :prix,
                `discount` = :discount,
                `category` = :category,
                `quantity` = :quantity,
                `image_url` = :image_url
                WHERE `id` = :product_id');
            
            $params = array(
                ':nom' => $nom,
                ':prix' => $prix,
                ':discount' => $discount,
                ':category' => $category,
                ':quantity' => $quantity,
                ':image_url' => $image_url,
                ':product_id' => $product_id
            );
    
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            // Handle database connection error
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
    function getProductDetails($pdo,$product_id) {

    try {
       
        // Prepare SQL statement
        $stmt = $pdo->prepare('SELECT * FROM produit WHERE id = :product_id');

        // Bind parameter
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Fetch product details as an associative array
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        return $product;
    } catch (PDOException $e) {
        // Handle database connection error
        echo "Error: " . $e->getMessage();
            return null;
    }
}
    
    
}
class category{
    function fetch_name($pdo){
        try {
        $stmt = $pdo->prepare('SELECT nom FROM category');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
}
class command{
    public function deleteCommandFromCart($pdo,$idc, $date) {
        try {
            // Prepare the SQL statement to delete the product from the cart
            $stmt = $pdo->prepare("DELETE FROM commandelist WHERE date = :date AND id_client = :idc");
            $stmt->execute(array(':date'=>$date,':idc'=>$idc));
            // Check if any rows were affected
            
        } catch (PDOException $e) {
            // Handle any exceptions, such as database errors
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function insertToCommand($conx, $id_client, $id_product, $quantity, $total) {
        try {
            $query = "CALL inserttocommandelist(:id_client, :id_product, :quantity, :total)";
            $stmt = $conx->prepare($query);
            $stmt->execute( array(
                ':id_client' => $id_client,
                ':id_product' => $id_product,
                ':quantity' => $quantity,
                ':total' => $total,
            ));
            return $stmt;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
    public function count_commandelist( $conx){
        try {
            $query = "SELECT COUNT(*) FROM `commandelist` ";
            $statement = $conx->prepare($query);
            $statement->execute();
            return $statement->fetchcolumn();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null; 
        }
    }
    public function fetchCommandelist( $conx){
        try {
            $query = "SELECT p.*,p.quantity AS prod_quantity, c.*,c.quantity AS cart_quantity FROM produit p INNER JOIN `commandelist` c ON p.id = c.id_product";
            $statement = $conx->prepare($query);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null; 
        }
    }
}


?>