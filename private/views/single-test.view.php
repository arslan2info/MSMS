<?php $this->view('includes/header') ?>
<?php $this->view('includes/nav') ?>

<div class="container-fluid p-4 shadow mx-auto" style="max-width: 1000px;">
    <?php $this->view('includes/crumbs', ['crumbs' => $crumbs]) ?>
    <?php if ($row): ?>

        <div class="row">
            <center>
                <h4><?= esc(ucwords($row->test)) ?></h4>
            </center>
            <table class="table table-hover table-striped table-bordered">
                <tr>
                    <th> Created By: </th>
                    <td> <?= esc($row->user->first_name) ?> <?= esc($row->user->last_name) ?> </td>

                    <th> Date Created: </th>
                    <td> <?= esc(get_date($row->date)) ?> </td>
                    <td>
                        <a href="<?= ROOT ?>/single_class/<?= $row->class_id ?>?tab=tests">
                            <button class="btn btn-primary"><i class="fa fa-plus"></i>Create Question</button>
                        </a>
                    </td>
                </tr>

                <?php $active = $row->disabled == 1 ? "No" : "Yes" ?>
                <tr>
                    <td><b>Active:</b> <?= $active ?></td>
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
                    include(views_path('test-tab-view'));
                    break;
                case 'add-question':
                    # code...
                    include(views_path('test-tab-add-question'));
                    break;
                case 'edit-question':
                    # code...
                    include(views_path('test-tab-edit-question'));
                    break;
                case 'delete-question':
                    # code...
                    include(views_path('test-tab-delete-question'));
                    break;
                case 'edit':
                    # code...
                    include(views_path('test-tab-edit'));
                    break;
                case 'delete':
                    # code...
                    include(views_path('test-tab-delete'));
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