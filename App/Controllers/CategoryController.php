<?php
// Require SessionHelper and other necessary files
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');
class CategoryController
{
    private $categoryModel;
    private $db;
    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
    }
    public function list()
    {
        $categories = $this->categoryModel->getCategories();
        include 'app/views/category/list.php';
    }

    // Show form to create a new category
    public function create()
    {
        include 'app/admin/views/category/add.php';
    }

    // Handle form submission to create category
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            if ($this->categoryModel->createCategory($name, $description)) {
                header('Location: /s4_php/admin/categories');
                exit;
            } else {
                echo "Error creating category.";
            }
        }
    }

    // Show form to edit a category
    public function edit($id)
    {
        $category = $this->categoryModel->getCategoryById($id);
        if ($category) {
            include 'app/admin/views/category/edit.php';
        } else {
            echo "Category not found.";
        }
    }

    // Handle form submission to update category
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            if ($this->categoryModel->updateCategory($id, $name, $description)) {
                header('Location: /s4_php/admin/categories');
                exit;
            } else {
                echo "Error updating category.";
            }
        }
    }

    // Delete a category
    public function delete($id)
    {
        if ($this->categoryModel->deleteCategory($id)) {
            header('Location: /s4_php/admin/categories');
            exit;
        } else {
            echo "Error deleting category.";
        }
    }


}
