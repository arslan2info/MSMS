<?php
$quest_type = "Subjective";
if (isset($_GET["type"]) && $_GET["type"] == "objective") {
    $quest_type = "Objective";
} else
if (isset($_GET["type"]) && $_GET["type"] == "multiple") {
    $quest_type = "Multiple Choice";
}
?>
<center>
    <h5>Add <?= $quest_type ?> Question</h5>
</center>

<form method="post" enctype="multipart/form-data">

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

    <label>Question:</label>
    <textarea autofocus class="form-control" name="question" placeholder="Type your question here"><?= get_var('question') ?></textarea>
    <div class="input-group mb-3 pt-3">
        <label class="input-group-text" for="inputGroupFile01">Comment (Optional)</label>
        <input type="text" name="comment" value="<?= get_var('comment') ?>" class="form-control" placeholder="Comment">
    </div>
    <div class="input-group mb-3">
        <label class="input-group-text" for="inputGroupFile01"><i class="fa fa-image"></i>Image (Optional)</label>
        <input type="file" name="image" class="form-control" id="inputGroupFile01">
    </div>

    <?php if (isset($_GET["type"]) && $_GET["type"] == "objective") : ?>
        <div class="input-group mb-3">
            <label class="input-group-text" for="inputGroupFile01">Answer</label>
            <input type="text" value="<?= get_var('correct_answer') ?>" name="correct_answer" class="form-control" id="inputGroupFile01" placeholder="Enter the correct answer here">
        </div>
    <?php endif; ?>

    <a href="<?= ROOT ?>/single_test/<?= $row->test_id ?>">
        <button type="button" class="btn btn-primary"><i class="fa fa-chevron-left"></i>Back</button>
    </a>
    <button class="btn btn-danger float-end">Save Question</button>
    <div></div>
</form>