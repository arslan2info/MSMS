<?php $this->view('includes/header') ?>

<div class="container-fluid">
    <div class="p-4 mx-auto shadow rounded" style="margin-top: 50px; width: 100%; max-width: 340px;">
        <form action="">
            <h2 class="text-center">Fixers Private School</h2>
            <img src="<?= ROOT ?>/assets/logo.png" class="border border-primary d-block mx-auto rounded-circle" style="width:150px;" alt="">
            <h3>Login</h3>
            <input class="my-2 form-control" type="email" name="email" placeholder="Email" autofocus>
            <input class="my-2 form-control" type="password" name="password" placeholder="Password">
            <br>
            <button class="btn btn-primary">Login</button>
        </form>

    </div>
</div>

<?php $this->view('includes/footer') ?>