<form action="" method="post" class="form mx-auto" style="width: 100%; max-width: 400px;">
    <h4>Add Lacturer</h4>

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

    <input value="<?= get_var('name') ?>" autofocus class="form-control" type="text" name="name" id="" placeholder="Lecturer Name">
    <br>
    <a href="<?= ROOT ?>/single_class/<?= $row->class_id ?>?tab=lecturers">
        <button type="button" class="btn btn-danger ">Cancel</button>
    </a>
    <button class="btn btn-primary float-end" name="search">Search</button>
    <div class="clearfix"></div>
</form>
<br>
<div class="card-group justify-content-center">
    <form action="" method="post">

        <?php if (isset($results) && $results): ?>

            <?php foreach ($results as $row): ?>
                <?php include(views_path('user')) ?>
            <?php endforeach; ?>

        <?php else: ?>

            <?php if (count($_POST) > 0): ?>
                <hr>
                <center>
                    <h4>No results found yet</h4>
                </center>
            <?php endif; ?>

        <?php endif; ?>
    </form>
</div>