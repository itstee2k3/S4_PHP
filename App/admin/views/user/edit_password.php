<?php include dirname(path: __FILE__, levels: 3) . '/shares/header.php'; ?>


<div class="container mt-5">
    <div class="card shadow-sm rounded p-4">
        <h1 class="text-center mb-4">Edit Password</h1>

        <form method="POST" action="/s4_php/account/updatePassword">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user->id); ?>">

            <div class="mb-3">
                <label for="password" class="form-label">New Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="/s4_php/admin/users" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include dirname(__FILE__, levels: 3) . '/shares/footer.php'; ?>
