<?php
$image = get_image($row->image, $row->gender);
?>
<div class="card m-2 shadow-sm" style="max-width: 12rem; min-width: 12rem">
    <!-- <div class="card-header">User Profile</div> -->
    <img class="rounded-circle card-img-top w-75 h-75 d-block mx-auto mt-1" src="<?= $image ?>" style="width: 12rem; height: 12rem;" alt="Card image cap">
    <div class="card-body">
        <center>
            <h5 class="card-title"><?= $row->first_name ?> <?= $row->last_name ?></h5>
            <p class="card-text"><?= get_rank($row->rank) ?></p>
        </center>
        <a href="<?= ROOT ?>/profile/<?= $row->user_id ?>" class="btn btn-primary">Profile</a>

        <?php if (isset($_GET['select'])): ?>
            <button name="selected" value="<?= $row->user_id ?>" class="float-end btn btn-danger">Select</button>
        <?php endif; ?>
    </div>
</div>