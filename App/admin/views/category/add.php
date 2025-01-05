<?php include dirname(path: __FILE__, levels: 3) . '/shares/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Add New Category</h1>

    <form method="POST" action="/s4_php/category/store" enctype="multipart/form-data" class="p-4 shadow rounded bg-light" onsubmit="return validateForm();">
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Input name category" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea id="description" name="description" class="form-control" rows="4" placeholder="Input description category" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100">Add Category</button>
    </form>

    <div class="text-center mt-4">
        <a href="/s4_php/admin/categories" class="btn btn-secondary">Return list category</a>
    </div>
</div>
<?php include dirname(path: __FILE__, levels: 3) . '/shares/footer.php'; ?>
