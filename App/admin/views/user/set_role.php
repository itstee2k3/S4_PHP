<?php include dirname(__FILE__, 3) . '/shares/header.php'; ?>

<div class="container mt-5">
    <div class="card shadow-sm rounded p-4">
        <h1 class="text-center mb-4">Set Role</h1>

        <form method="POST" action="/s4_php/account/updateRole">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user->id); ?>">

            <div class="mb-3">
                <label for="role_id" class="form-label">Role:</label>
                <select id="role_id" name="role_id[]" class="form-control" multiple required>
                    <?php foreach ($roles as $role): ?>
                        <option value="<?php echo $role->id; ?>" 
                                <?php echo in_array($role->id, array_column($user_roles, 'role_id')) ? 'selected' : ''; ?>>
                            <?php echo $role->role_name; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="/s4_php/admin/users" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include dirname(__FILE__, 3) . '/shares/footer.php'; ?>
