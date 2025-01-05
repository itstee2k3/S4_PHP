<?php include dirname(path: __FILE__, levels: 3) . '/shares/header.php'; ?>

<div class="container mt-5">
    <div class="card shadow-sm rounded p-4">
        <h1 class="text-center mb-4">Update category</h1>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="/s4_php/category/update" enctype="multipart/form-data" onsubmit="return validateForm();">

            <input type="hidden" name="id" value="<?php echo $category['id']; ?>">

            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea id="description" name="description" class="form-control" rows="4" required><?php echo htmlspecialchars($category['description'], ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="/s4_php/admin/categories" class="btn btn-secondary">Return list category</a>
            </div>
        </form>
    </div>
</div>
<?php include dirname(__FILE__, levels: 3) . '/shares/footer.php'; ?>
