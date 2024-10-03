<?php $this->view('includes/header') ?>
<?php $this->view('includes/nav') ?>

<div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px;">
    <?php $this->view('includes/crumbs', ['crumbs' => $crumbs]) ?>

    <?php if ($row): ?>

        <div class="card-group justify-content-center">

            <form action="" method="post">
                <h3>Are you Sure you want to delete?!</h3>

                <input disabled autofocus class="form-control" value="<?= get_var('class', $row[0]->class) ?>" type="text" name="class" placeholder="class Name" id=""><br><br>
                <input type="hidden" name="id" value="<?= get_var('id', $row[0]->id) ?>">
                <input class="btn btn-danger float-end" type="submit" value="Delete">

                <a href="<?= ROOT ?>/classes">
                    <input class="btn btn-success text-white" type="button" value="Cancel">
                </a>
            </form>

        </div>
    <?php else: ?>
        <div style="text-align: center;">

            <h3>The class was not found!</h3>
            <div class="clearfix"></div>
            <br>
            <a href="<?= ROOT ?>/classes">
                <input class="btn btn-danger" type="button" value="Cancel">
            </a>
        </div>
    <?php endif; ?>

</div>

<?php $this->view('includes/footer') ?>