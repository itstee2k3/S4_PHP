<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Categories</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        <a href="/s4_php/category/create" class="btn btn-sm btn-success">Add New Category</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Description</th>    
                        <th>Actions</th>                  
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?= htmlspecialchars($category->id) ?></td>
                        <td><?= htmlspecialchars($category->name) ?></td>
                        <td><?= htmlspecialchars($category->description) ?></td>
                        <td>
                            <a href="/s4_php/category/edit/<?php echo $category->id; ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="/s4_php/category/delete/<?php echo $category->id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

