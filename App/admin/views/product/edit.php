<?php include dirname(path: __FILE__, levels: 3) . '/shares/header.php'; ?>


<div class="container mt-5">
    <div class="card shadow-sm rounded p-4">
        <h1 class="text-center mb-4">Sửa sản phẩm</h1>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="/s4_php/product/update" enctype="multipart/form-data" onsubmit="return validateForm();">
            <input type="hidden" name="id" value="<?php echo $product->id; ?>">

            <div class="mb-3">
                <label for="name" class="form-label">Tên sản phẩm:</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Mô tả:</label>
                <textarea id="description" name="description" class="form-control" rows="4" required><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Giá:</label>
                <input type="number" id="price" name="price" class="form-control" step="0.01" value="<?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Danh mục:</label>
                <select id="category_id" name="category_id" class="form-select" required>
                    <option value="">Chọn danh mục</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category->id; ?>" <?php echo $category->id == $product->category_id ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Hình ảnh:</label>
                <input type="file" id="image" name="image" class="form-control">
                <input type="hidden" name="existing_image" value="<?php echo $product->image; ?>">
                <?php if ($product->image): ?>
                    <div class="mt-2">
                        <img src="/s4_php/public/images/<?php echo $product->image; ?>" alt="product Image" class="img-thumbnail" style="max-width: 150px;">
                    </div>
                <?php endif; ?>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                <a href="/s4_php/product/list" class="btn btn-secondary">Quay lại danh sách sản phẩm</a>
            </div>
        </form>
    </div>
</div>
<?php include dirname(__FILE__, levels: 3) . '/shares/footer.php'; ?>
