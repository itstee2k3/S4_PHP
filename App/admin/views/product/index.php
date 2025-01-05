<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Products</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        <a href="/s4_php/product/add" class="btn btn-sm btn-success">Add New Product</a>

    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Category</th>      
                        <th>Actions</th>                  
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Category</th>  
                        <th>Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product->id) ?></td>
                        <td><?= htmlspecialchars($product->name) ?></td>
                        <td><?= htmlspecialchars($product->description) ?></td>
                        <td><?= htmlspecialchars($product->price) ?></td>
                        <td>
                            <img src="/s4_php/public/images/<?= htmlspecialchars($product->image) ?>" alt="Product Image" width="50">
                        </td>
                        <td><?= htmlspecialchars($product->category_name) ?></td>
                        <td>
                            <a href="/s4_php/product/edit/<?php echo $product->id; ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="/s4_php/product/delete/<?php echo $product->id ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

