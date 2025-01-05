    
    <?php
    require_once('app/controllers/CartController.php');
    require_once('app/controllers/FavoriteController.php');
    class DefaultController
    {
        protected $cartController;
        protected $favoriteController;

        public function __construct()
        {
            $this->cartController = new CartController();
            $this->favoriteController = new FavoriteController();
        }

        public function index()
        {
            // include_once dirname(__FILE__) . '/../../account/login.php';
        }

        public function shares()
        {
            // Lấy số lượng sản phẩm trong giỏ hàng và yêu thích
            $cartCount = $this->cartController->getCartCount();
            $favoriteCount = $this->favoriteController->getFavoriteCount();

            // Truyền dữ liệu vào view
            include 'app/views/shares/header.php';  // Gọi header.php
        }
    }