<?php

class Product
{

    public $id;
    public $name;
    public $price;
    public $added_by;
    // Get all the products
    public static function getAll($conn)
    {
        $sql = "SELECT *
                FROM product
                ORDER BY id";

        $results = $conn->query($sql);

        return $results->fetchAll(PDO::FETCH_ASSOC);
    }

    //Get a page of products
    public static function getPage($conn, $limit, $offset)
    {
        $sql = "SELECT *
                FROM product
                ORDER BY id
                LIMIT :limit
                OFFSET :offset";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get a single product by id
    public static function getByID($conn, $id)
    {
        $sql = "SELECT *
                FROM product
                WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Product');

        if ($stmt->execute()) {

            return $stmt->fetch();
        }
    }

    public static function getByCategory($conn, $category_id) {

        $sql = "SELECT product.*
                FROM product 
                INNER JOIN product_category  
                ON product.id = product_category.product_id
                WHERE product_category.category_id = :category_id";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get a single product by ID with its category
    public static function getWithCategories($conn, $id)
    {
        $sql = "SELECT product.*, category.name AS category_name
                FROM product 
                LEFT JOIN product_category 
                ON product.id = product_category.product_id 
                LEFT JOIN category 
                ON product_category.category_id = category.id
                WHERE product.id = :id ";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // get a product's category
    public function getCategories($conn)
    {
        $sql = "SELECT category.*
                FROM category
                JOIN product_category
                ON category.id = product_category.category_id
                WHERE product_id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Set the product category
    public function setCategory($conn, $id)
    {
        if ($id) {
            $sql = "INSERT IGNORE INTO product_category (product_id, category_id)
                    VALUES ({$this->id}, :category_id)";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':category_id', $id, PDO::PARAM_INT);
            $stmt->execute();
        }
    }

    // Update the product category
    public function updateCategory($conn, $newCategoryId)
    {

        $sql = "UPDATE product_category
                    SET category_id = :category_id
                    WHERE product_id = :product_id";


        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':category_id', $newCategoryId, PDO::PARAM_INT);
        $stmt->bindValue(':product_id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();

    }

    // Update a single product
    public function update($conn)
    {

        $sql = "UPDATE product
                SET name = :pname,
                    price = :price
                WHERE id = :id";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':pname', $this->name, PDO::PARAM_STR);
        $stmt->bindValue(':price', $this->price, PDO::PARAM_STR);

        return $stmt->execute();

    }

    // Delete a single product
    public function delete($conn)
    {
        $sql = "DELETE FROM product
                WHERE id = :id";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Add a new product
    public function create($conn)
    {

        $sql = "INSERT INTO product (name, price, added_by)
                VALUES (:name, :price, :added_by)";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindValue(':price', $this->price, PDO::PARAM_STR);
        $stmt->bindValue(':added_by', $_SESSION['username'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            $this->id = $conn->lastInsertId();
            return true;
        }

    }


}