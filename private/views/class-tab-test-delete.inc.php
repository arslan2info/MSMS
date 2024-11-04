<div class="card-group justify-content-center">
    <?php if (isset($test_row) && is_object($test_row)): ?>

        <form action="" method="post">
            <h3>Are you sure you want to delete this Test Permanently??!!</h3>

            <?php if (count($errors) > 0): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Errors:</strong>
                    <?php foreach ($errors as $error): ?>
                        <br><?= $error ?>
                    <?php endforeach; ?>
                    <span type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </span>
                </div>
            <?php endif; ?>

            <label>Test Name:</label>
            <input readonly class="form-control" value="<?= get_var('test', $test_row->test) ?>" type="text" name="test" placeholder="Test Title"><br>
            <label>Test Description:</label>
            <textarea readonly name="description" class="form-control" placeholder="Add a description for this test"><?= get_var('description', $test_row->description) ?></textarea>

            <br>

            <input class="btn btn-danger float-end" type="submit" value="Delete">

            <a href="<?= ROOT ?>/single_class/<?= $row->class_id ?>?tab=tests">
                <input class="btn btn-success text-white" type="button" value="Back">
            </a>
        </form>
    <?php else: ?>
        <div class="text-center">
            Sorry, that test was not found! <br><br>
            <a href="<?= ROOT ?>/single_class/<?= $row->class_id ?>?tab=tests">
                <input class="btn btn-success text-white" type="button" value="Back">
            </a>
        </div>
    <?php endif; ?>
</div>