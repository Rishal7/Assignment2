<?php

class User
{
    public $id;
    public $username;
    public $email;
    public $phone;
    public $password;

    public function register($conn)
    {
        $sql = "INSERT INTO user (username,email,phone,password)
                VALUES (:username,:email,:phone,:password)";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':username', $this->username, PDO::PARAM_STR);
        $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindValue(':phone', $this->phone, PDO::PARAM_STR);
        $stmt->bindValue(':password', $this->password, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $this->id = $conn->lastInsertId();
            return true;
        }
    }

    public function update($conn)
    {

        $sql = "UPDATE user
                SET username = :username,
                    email = :email,
                    phone = :phone,
                    password = :password
                WHERE id = :id";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':username', $this->username, PDO::PARAM_STR);
        $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindValue(':phone', $this->phone, PDO::PARAM_STR);
        $stmt->bindValue(':password', $this->password, PDO::PARAM_STR);

        return $stmt->execute();

    }

    // Delete a user from the database
    public function delete($conn)
    {
        $sql = "DELETE FROM user
                WHERE id = :id";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public static function authenticate($conn, $username, $password)
    {
        $sql = "SELECT *
                FROM user
                WHERE username = :username";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'USER');

        $stmt->execute();

        if ($user = $stmt->fetch()) {

            return password_verify($password, $user->password);
        }
        else {
            echo "user not registered";
        }
    }

    public static function getUserByUsername($conn, $username)
    {
        $sql = "SELECT * FROM user WHERE username = :username";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
        $stmt->execute();

        return $stmt->fetch();
    }

    public static function getUserByID($conn, $userID)
    {
        $sql = "SELECT * FROM user WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $userID, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
        $stmt->execute();

        return $stmt->fetch();
    }

    // public static function updateUserDetails($conn, $userID, $newUsername, $newEmail, $newPhone)
    // {
    //     $sql = "UPDATE user SET username = :username, email = :email, phone_number = :phone WHERE id = :id";

    //     $stmt = $conn->prepare($sql);
    //     $stmt->bindValue(':username', $newUsername, PDO::PARAM_STR);
    //     $stmt->bindValue(':email', $newEmail, PDO::PARAM_STR);
    //     $stmt->bindValue(':phone', $newPhone, PDO::PARAM_STR);
    //     $stmt->bindValue(':id', $userID, PDO::PARAM_INT);

    //     return $stmt->execute();
    // }
}