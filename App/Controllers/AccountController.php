<?php
require_once('app/config/database.php');
require_once('app/models/AccountModel.php');

class AccountController
{
    private $accountModel;

    private $db;
    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
    }
    function register()
    {
        include_once 'app/views/account/register.php';
    }
    public function login()
    {
        include_once 'app/views/account/login.php';
    }
    function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $fullName = $_POST['fullname'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmpassword'] ?? '';
            $errors = [];

            if (empty($username)) {
                $errors['username'] = "Vui long nhap userName!";
            }
            if (empty($fullName)) {
                $errors['fullname'] = "Vui long nhap fullName!";
            }
            if (empty($password)) {
                $errors['password'] = "Vui long nhap password!";
            }
            if ($password != $confirmPassword) {
                $errors['confirmPass'] = "Mat khau va xac nhan chua dung";
            }
            
            //kiểm tra username đã được đăng ký chưa?
            $account = $this->accountModel->getAccountByUsername($username);
            if ($account) {
                $errors['account'] = "Tai khoan nay da co nguoi dang ky!";
            }
            
            if (count($errors) > 0) {
                include_once 'app/views/account/register.php';
            } else {
                $password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
                $result = $this->accountModel->save($username, $fullName, $password);
                if ($result) {
                    header('Location: /s4_php/account/login');
                    exit;
                } else {
                    echo "Có lỗi xảy ra khi lưu tài khoản.";
                }
            }
        }
    }

    function logout()
    {
        session_unset();
        session_destroy();
        // unset($_SESSION['username']);
        // unset($_SESSION['user_role']);
        // unset($_SESSION['user_id']);
        // Xóa cookie nếu tồn tại
        setcookie(session_name(), '', time() - 3600, '/');

        setcookie('user', '', time() - 3600, '/', '', false, true);
        setcookie('login_time', '', time() - 3600, '/', '', false, true);
        header('Location: /s4_php/product/');
    }

    public function checkLogin()
    {
        // Kiểm tra xem liệu form đã được submit
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $rememberMe = isset($_POST['remember_me']);

            if (empty($username) || empty($password)) {
                echo "Vui lòng nhập đầy đủ thông tin đăng nhập.";
                return;
            }

            $account = $this->accountModel->getAccountByUserName($username);
            if ($account) {
                $pwd_hashed = $account->password;
                //check mat khau
                if (password_verify($password, $pwd_hashed)) {
                    session_start();
                    $_SESSION['user_id'] = $account->id;
                    $_SESSION['username'] = $account->username;
                    $_SESSION['user_roles'] = $this->accountModel->getRolesByUserId($account->id);

                    if ($rememberMe) {
                        setcookie('user', $account->username, time() + (1 * 60), '/', '', false, true);
                        setcookie('login_time', time(), time() + (1 * 60), '/', '', false, true);
                    }

                    if (in_array('Admin', haystack: $_SESSION['user_roles'])) {
                        header('Location: /s4_php/admin/dashboard');
                    } else {
                        header('Location: /s4_php/product/');
                    }
                    //header('Location: /s4_php/product/');
                    // var_dump($_SESSION['user_roles']);

                    exit;
                } else {
                    echo "Password incorrect.";
                }
            } else {
                echo "Bao loi khong tim thay tai khoan";
            }
        }
    }

    public function autoLogin()
    {
        if (isset($_COOKIE['user']) && isset($_COOKIE['login_time'])) {
            $current_time = time();
            $login_time = $_COOKIE['login_time'];

            // Kiểm tra thời gian hiệu lực
            if (($current_time - $login_time) <= (1 * 60)) {
                $username = $_COOKIE['user'];
                $account = $this->accountModel->getAccountByUserName($username);

                if ($account) {
                    // session_start();
                    $_SESSION['user_id'] = $account->id;
                    $_SESSION['username'] = $account->username;
                    $_SESSION['user_roles'] = $this->accountModel->getRolesByUserId($account->id);

                    // Làm mới thời gian cookie
                    setcookie('login_time', $current_time, $current_time + (1 * 60), '/', '', false, true);

                    return true;
                }
            }

            // Nếu cookie hết hạn hoặc không hợp lệ
            $this->logout();
        }

        return false;
    }


    // Hiển thị form chỉnh sửa mật khẩu
    public function editPassword($id)
    {
        $user = $this->accountModel->getUserById($id);
        if ($user) {
            include 'app/admin/views/user/edit_password.php';
        } else {
            echo "User not found.";
        }
    }

    // Xử lý cập nhật mật khẩu
    public function updatePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            $password = $_POST['password'] ?? '';
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            if ($this->accountModel->updatePassword($id, $hashedPassword)) {
                header('Location: /s4_php/admin/users');
                exit;
            } else {
                echo "Error updating password.";
            }
        }
    }

    // Hiển thị form thiết lập vai trò
    public function setRole($id)
    {
        $user = $this->accountModel->getUserById($id);
        $roles = $this->accountModel->getAllRoles(); // Lấy danh sách vai trò
        $user_roles = $this->accountModel->getRolesByUserId($id); // Lấy vai trò của người dùng

        if ($user) {
            include 'app/admin/views/user/set_role.php';
        } else {
            echo "User not found.";
        }
    }

    // Xử lý cập nhật vai trò
    public function updateRole()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'] ?? '';
            $roleId = $_POST['role_id'] ?? '';

            if ($this->accountModel->updateUserRole($userId, $roleId)) {
                header('Location: /s4_php/admin/users');
                exit;
            } else {
                echo "Error updating role.";
            }
        }
    }
}
