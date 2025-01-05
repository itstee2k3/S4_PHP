<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Users</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user->id) ?></td>
                        <td><?= htmlspecialchars($user->username) ?></td>
                        <td><?= htmlspecialchars($user->fullname) ?></td>
                        <td>
                            <?php 
                            // Lấy các vai trò của người dùng từ model
                            $roles = $accountModel->getRolesByUserId($user->id);
                            
                            // Kiểm tra nếu có vai trò, sau đó nối các tên vai trò lại thành chuỗi
                            if ($roles) {
                                $roleNames = array_map(function($role) {
                                    return htmlspecialchars($role['role_name'] ?? ''); // Trích xuất tên vai trò và bảo vệ khỏi XSS, trả về chuỗi rỗng nếu 'role_name' không có
                                }, $roles);

                                echo implode(', ', $roleNames); // Nối các tên vai trò lại với nhau bằng dấu phẩy
                            } else {
                                echo "No roles assigned"; // Trường hợp không có vai trò
                            }
                            ?>
                        </td>

                        <td>
                            <a href="/s4_php/account/editPassword/<?php echo $user->id; ?>" class="btn btn-sm btn-primary">Edit Password</a>
                            <a href="/s4_php/account/setRole/<?php echo $user->id; ?>" class="btn btn-sm btn-primary">Set Role</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

