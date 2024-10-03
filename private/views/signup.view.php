<?php $this->view('includes/header') ?>

<div class="container-fluid">
    <div class="p-4 mx-auto shadow rounded" style="margin-top: 50px; width: 100%; max-width: 340px;">
        <form action="" method="post">
            <h2 class="text-center">Fixers Private School</h2>
            <img src="<?= ROOT ?>/assets/logo.png" class="border border-primary d-block mx-auto rounded-circle" style="width:150px;" alt="">
            <h3>Add User</h3>

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

            <input class="my-2 form-control" value="<?= get_var('first_name') ?>" type="first_name" name="first_name" placeholder="First Name">
            <input class="my-2 form-control" value="<?= get_var('last_name') ?>" type="last_name" name="last_name" placeholder="Last Name">
            <input class="my-2 form-control" value="<?= get_var('email') ?>" type="email" name="email" placeholder="Email">

            <select class="my-2 form-control" name="gender" id="">
                <option <?= get_select('gender', '') ?> value="">--Select a Gender--</option>
                <option <?= get_select('gender', 'male') ?> value="male">Male</option>
                <option <?= get_select('gender', 'female') ?> value="female">Female</option>
            </select>

            <?php if ($mode == 'students') : ?>
                <input class="my-2 form-control" readonly="true" type="text" value="student" name="rank" id="">
            <?php else : ?>
                <select class="my-2 form-control" name="rank" id="">
                    <option <?= get_select('rank', '') ?> value="">--Select a Rank--</option>
                    <option <?= get_select('rank', 'student') ?> value="student">Student</option>
                    <option <?= get_select('rank', 'reception') ?> value="reception">Reception</option>
                    <option <?= get_select('rank', 'lecturer') ?> value="lecturer">Lecturer</option>
                    <option <?= get_select('rank', 'admin') ?> value="admin">Admin</option>
                    <?php if (!Auth::getRank() == "super_admin"): ?>
                        <option <?= get_select('rank', 'super_admin') ?> value="super_admin">Super Admin</option>
                    <?php endif; ?>
                </select>
            <?php endif; ?>

            <input class="my-2 form-control" value="<?= get_var('password') ?>" type="password" name="password" placeholder="Password">
            <input class="my-2 form-control" value="<?= get_var('password2') ?>" type="password" name="password2" placeholder="Retype Password">
            <br>
            <button class="btn btn-primary float-end">Add User</button>

            <?php if ($mode == 'students'): ?>
                <a href="<?= ROOT ?>/students" ?>
                    <button type="button" class="btn btn-danger">Cancel</button>
                </a>
            <?php else: ?>
                <a href="<?= ROOT ?>/users" ?>
                    <button type="button" class="btn btn-danger">Cancel</button>
                </a>
            <?php endif; ?>
        </form>

    </div>
</div>

<?php $this->view('includes/footer') ?>