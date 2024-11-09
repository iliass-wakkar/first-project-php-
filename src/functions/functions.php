<?php

function conx()
{
    try {
        $conx = new PDO("mysql:host=sql102.infinityfree.com;dbname=if0_37676924_Basic_E_commerce", "if0_37676924", "vkamjoVooWCsbOG");
        // Set the PDO error mode to exception
        $conx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'La connexion a échoué: ' . $e->getMessage();
    }
    return $conx;
}


class User
{
    function insrt_login($conx, $email, $password, $type)
    {
        $query = "INSERT INTO login (email, password, user_type)
                  SELECT :email, :pass, :user_type
                  FROM DUAL
                  WHERE NOT EXISTS (SELECT 1 FROM login WHERE email = :email)";
        $stmt = $conx->prepare($query);
        $stmt->execute(array(':email' => $email, ':pass' => $password, ':user_type' => $type));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function loginEmailCount($conx, $email)
    {
        $query = "SELECT COUNT(*) FROM login WHERE email=:email";
        $stmt = $conx->prepare($query);
        $stmt->execute(array(":email" => $email));
        return $stmt->fetchColumn();
    }

    public function fullLoginCount($conx, $email, $password)
    {
        $query = "SELECT 1 FROM login WHERE email = :email AND password = :log_password";
        $stmt = $conx->prepare($query);
        $stmt->execute(array(":email" => $email, ":log_password" => $password));
        return $stmt->fetch();
    }

    public function fullLogin($conx, $email, $password)
    {
        try {
            $query = "SELECT * FROM login WHERE email=:email AND password=:log_password";
            $statement = $conx->prepare($query);
            $statement->execute(array(":email" => $email, ":log_password" => $password));
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
}


class Client
{
    function insrt_client($conx, $nom, $prenom, $tel, $email, $password)
    {
        $query = "INSERT INTO client (nom, prenom, tel, login_email, login_password)
                  SELECT :nom, :prenom, :tel, :login_email, :login_password
                  FROM DUAL
                  WHERE NOT EXISTS (SELECT 1 FROM client WHERE login_email = :login_email)";
        $stmt = $conx->prepare($query);
        $stmt->execute(array(':nom' => $nom, ':prenom' => $prenom, ':tel' => $tel, ':login_email' => $email, ':login_password' => $password));
        return $stmt;
    }

    public function getByEmail($conx, $email)
    {
        try {
            $query = "SELECT * FROM client WHERE login_email=:email";
            $statement = $conx->prepare($query);
            $statement->execute(array(":email" => $email));
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
}


class Admin
{
    public function getByEmail($conx, $email)
    {
        try {
            $query = "SELECT * FROM admin WHERE login_email=:email";
            $statement = $conx->prepare($query);
            $statement->execute(array(":email" => $email));
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
}


class cart
{
    public function insertToCart($conx, $id_client, $id_product, $quantity, $total)
    {
        try {
            $query = "INSERT INTO cart (id_client, id_product, quantity, total, date)
                      VALUES (:id_client, :id_product, :quantity, :total, CURRENT_TIMESTAMP)";
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

    function fetchClientProducts($conx, $clientID)
    {
        try {
            $query = "SELECT p.*, p.id AS prod_id, p.quantity AS prod_quantity, c.*, c.quantity AS cart_quantity 
                      FROM produit p INNER JOIN cart c ON p.id = c.id_product 
                      WHERE c.id_client = :clientID";
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

    public function deleteAllItemsFromCart($pdo, $idc)
    {
        try {
            $query = "DELETE FROM cart WHERE id_client = :idc";
            $statement = $pdo->prepare($query);
            $statement->execute(array(":idc" => $idc));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deleteProductFromCart($pdo, $idc, $date)
    {
        try {
            $stmt = $pdo->prepare("DELETE FROM cart WHERE id_client = :idc AND date = :date");
            $stmt->execute(array(':idc' => $idc, ':date' => $date));
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function count_cart($conx, $idc)
    {
        try {
            $query = "SELECT COUNT(*) FROM cart WHERE id_client=:id_client";
            $statement = $conx->prepare($query);
            $statement->execute(array(":id_client" => $idc));
            return $statement->fetchColumn();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
}


class products
{
    function insrt_product($conx, $nom, $prix, $discount, $category, $dateCreation, $quantity, $image_url)
    {
        try {
            $query = "INSERT INTO produit (nom, prix, discount, category, dateCreation, quantity, image_url) 
                      VALUES (:nom, :prix, :discount, :category, :dateCreation, :quantity, :image_url)";
            $stmt = $conx->prepare($query);
            $stmt->execute(array(
                ':nom' => $nom,
                ':prix' => $prix,
                ':discount' => $discount,
                ':category' => $category,
                ':dateCreation' => $dateCreation,
                ':quantity' => $quantity,
                ':image_url' => $image_url
            ));
            return $stmt;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    function fetchProductById($conx, $id)
    {
        try {
            $query = "SELECT * FROM produit WHERE id = :id";
            $stmt = $conx->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $products = $stmt->fetch(PDO::FETCH_ASSOC);
            return $products;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    function fetchProducts($conx, $sortBy, $sortOrder)
    {
        try {
            $query = "SELECT * FROM produit";
            if ($sortBy !== null) {
                if ($sortOrder !== null) {
                    $query .= " ORDER BY $sortBy $sortOrder";
                } else {
                    $query .= " ORDER BY $sortBy ASC";
                }
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

    function searchAndSortProducts($conn, $searchval, $category_nom, $minprix, $maxprix, $sortBy, $sortOrder)
    {
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
            if ($sortOrder !== null) {
                if ($sortBy !== null) {
                    $query .= " ORDER BY $sortBy $sortOrder";
                }
            } else {
                $query .= " ORDER BY $sortBy ASC";
            }

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
}


class category
{
    function fetchAllCategories($conx)
    {
        try {
            $query = "SELECT * FROM category";
            $stmt = $conx->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    // function fetch_name($conx, $name)
    // {
    //     try {
    //         $query = "SELECT * FROM produit WHERE nom = :name";
    //         $stmt = $conx->prepare($query);
    //         $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    //         $stmt->execute();
    //         $products = $stmt->fetch(PDO::FETCH_ASSOC);
    //         return $products;
    //     } catch (Exception $e) {
    //         echo "Error: " . $e->getMessage();
    //         return null;
    //     }
    // }
}

?>