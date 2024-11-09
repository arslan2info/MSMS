<?php $this->view('includes/header') ?>
<?php $this->view('includes/nav') ?>

<div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px;">
    <?php $this->view('includes/crumbs', ['crumbs' => $crumbs]) ?>
    <?php if ($row && !($row->disabled && Auth::access('student'))): ?>

        <div class="row">
            <center>
                <h4><?= esc(ucwords($row->test)) ?></h4>
                <h5>From: <?= esc(ucwords($row->class->class)) ?></h5>
            </center>
            <table class="table table-hover table-striped table-bordered">
                <tr>
                    <th> Created By: </th>
                    <td> <?= esc($row->user->first_name) ?> <?= esc($row->user->last_name) ?> </td>

                    <th> Date Created: </th>
                    <td> <?= esc(get_date($row->date)) ?> </td>

                </tr>

                <?php $active = $row->disabled == 1 ? "No" : "Yes" ?>
                <tr>
                    <td><b>Class:</b> <?= $row->class->class ?></td>
                    <td colspan="5"><b>Test Description:</b><br><?= esc($row->description) ?></td>
                </tr>
            </table>
        </div>
        <!-- <hr> -->
        <div>

            <?php
            switch ($page_tab) {
                case 'view':
                    # code...
                    include(views_path('take-test-tab-view'));
                    break;


                default:
                    # code...
                    break;
            }
            ?>
        </div>
    <?php else: ?>
        <center>
            <h4>That Test was not found!</h4>
        </center>
    <?php endif; ?>
</div>

<?php $this->view('includes/footer') ?>