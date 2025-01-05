<?php
class AccountModel
{
    private $conn;
    private $table_name = "accounts";
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function getAccountByUsername($username)
    {
        $query = "SELECT * FROM accounts WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    function save($username, $fullname, $password, $role_id = 1)
    {
        try {
            // Bắt đầu transaction để đảm bảo tính toàn vẹn dữ liệu
            $this->conn->beginTransaction();
    
            // Thêm tài khoản vào bảng accounts
            $query = "INSERT INTO " . $this->table_name . " (username, fullname, password) VALUES (:username, :fullname, :password)";
            $stmt = $this->conn->prepare($query);
    
            // Gán dữ liệu vào câu lệnh
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':fullname', $fullname);
            $stmt->bindParam(':password', $password);
    
            // Thực thi câu lệnh
            if ($stmt->execute()) {
                // Lấy ID của user vừa được tạo
                $user_id = $this->conn->lastInsertId();
    
                // Thêm vào bảng user_roles
                $role_query = "INSERT INTO user_roles (user_id, role_id) VALUES (:user_id, :role_id)";
                $role_stmt = $this->conn->prepare($role_query);
    
                $role_stmt->bindParam(':user_id', $user_id);
                $role_stmt->bindParam(':role_id', $role_id);
    
                // Thực thi câu lệnh thêm role
                if ($role_stmt->execute()) {
                    // Hoàn tất transaction
                    $this->conn->commit();
                    return true;
                }
            }
    
            // Rollback nếu có lỗi
            $this->conn->rollBack();
            return false;
        } catch (Exception $e) {
            // Rollback nếu có ngoại lệ
            $this->conn->rollBack();
            error_log("Error saving user: " . $e->getMessage());
            return false;
        }
    }
    

    public function getRolesByUserId($user_id)
    {
        $sql = "SELECT r.role_name 
                FROM user_roles ur 
                JOIN roles r ON ur.role_id = r.id 
                WHERE ur.user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getAllUsers()
    {
        try {
            $query = "SELECT * FROM " . $this->table_name;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            error_log("Error fetching all users: " . $e->getMessage());
            return [];
        }
    }

    public function updatePassword($id, $password)
    {
        $query = "UPDATE accounts SET password = :password WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getAllRoles()
    {
        $query = "SELECT * FROM roles";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function updateUserRole($userId, $roleId)
    {
        $query = "UPDATE user_roles SET role_id = :role_id WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':role_id', $roleId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getUserById($id)
    {
        $query = "
            SELECT a.id, a.username, a.fullname, a.password, r.role_name
            FROM accounts a
            JOIN user_roles ur ON a.id = ur.user_id
            JOIN roles r ON ur.role_id = r.id
            WHERE a.id = :id
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        // Lấy kết quả và trả về dữ liệu
        return $stmt->fetch(PDO::FETCH_OBJ);
    }    
}
