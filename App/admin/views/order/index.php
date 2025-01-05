<?php include 'app/shares/header.php'; ?>

<h1 class="h3 mb-2 text-gray-800">Orders</h1>

<!-- Table for displaying orders -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Orders List</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = 1; // Khởi tạo biến index
                    foreach ($orders as $order): ?>
                    <tr>
                        <td><?= $index++; ?></td>
                        <td><?= htmlspecialchars($order->id) ?></td>
                        <td><?= htmlspecialchars($order->user_id) ?></td>
                        <td><?= htmlspecialchars($order->phone) ?></td>
                        <td><?= htmlspecialchars($order->address) ?></td>
                        <td><?= htmlspecialchars($order->created_at) ?></td>
                        <td>
                            <a href="/s4_php/order/edit/<?= $order->id ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="/s4_php/order/delete/<?= $order->id ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this order?');">Delete</a>

                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'app/shares/footer.php'; ?>
