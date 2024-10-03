<?php $this->view('includes/header') ?>

<div class="container-fluid">
    <form action="" method="post">
        <div class="p-4 mx-auto shadow rounded" style="margin-top: 50px; width: 100%; max-width: 340px;">
            <h2 class="text-center">Fixers Private School</h2>
            <img src="<?= ROOT ?>/assets/logo.png" class="border border-primary d-block mx-auto rounded-circle" style="width:150px;" alt="">
            <h3>Login</h3>

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

            <input class="my-2 form-control" value="<?= get_var('email') ?>" type="email" name="email" placeholder="Email" autofocus>
            <input class="my-2 form-control" value="<?= get_var('password') ?>" type="password" name="password" placeholder="Password">
            <br>
            <button class="btn btn-primary">Login</button>

        </div>
    </form>
</div>

<?php $this->view('includes/footer') ?>