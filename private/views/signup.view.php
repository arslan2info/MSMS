<?php $this->view('includes/header') ?>

<div class="container-fluid">
    <div class="p-4 mx-auto shadow rounded" style="margin-top: 50px; width: 100%; max-width: 340px;">
        <form action="">
            <h2 class="text-center">Fixers Private School</h2>
            <img src="<?= ROOT ?>/assets/logo.png" class="border border-primary d-block mx-auto rounded-circle" style="width:150px;" alt="">
            <h3>Add User</h3>
            <input class="my-2 form-control" type="first_name" name="first_name" placeholder="First Name">
            <input class="my-2 form-control" type="last_name" name="last_name" placeholder="Last Name">
            <input class="my-2 form-control" type="email" name="email" placeholder="Email">
            <select class="my-2 form-control" name="" id="">
                <option value="">--Select a Gender--</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
            <select class="my-2 form-control" name="" id="">
                <option value="">--Select a Rank--</option>
                <option value="student">Student</option>
                <option value="reception">Reception</option>
                <option value="lecturer">Lecturer</option>
                <option value="admin">Admin</option>
                <option value="super_admin">Super Admin</option>
            </select>
            <input class="my-2 form-control" type="password" name="password" placeholder="Password">
            <input class="my-2 form-control" type="password2" name="password2" placeholder="Retype Password">
            <br>
            <button class="btn btn-danger">Cancel</button>
            <button class="btn btn-primary float-end">Add User</button>
        </form>

    </div>
</div>

<?php $this->view('includes/footer') ?>