<div class="card-group justify-content-center">

    <table class="table table-striped table-hover">
        <tr>
            <th></th>
            <th>Test Name</th>
            <th>Created by</th>
            <th>Date</th>
            <th>

            </th>
        </tr>
        <?php if (isset($rows) && $rows): ?>
            <?php foreach ($rows as $row): ?>
                <tr>
                    <td>
                        <a href="<?= ROOT ?>/test/<?= esc($row->class_id) ?>">
                            <button class="btn btm-sm btn-primary"> <i class="fa fa-chevron-right"></i></button>
                        </a>
                    </td>
                    <td><?= $row->class ?></td>
                    <td><?= $row->user->first_name ?> <?= $row->user->last_name ?></td>
                    <td><?= get_date($row->date) ?></td>
                    <td>
                        <?php if (Auth::access('lecturer')): ?>
                            <a href="<?= ROOT ?>/tests/edit/<?= $row->id ?>">
                                <button class="btn-sm btn btn-info text-white"><i class="fa fa-edit"></i></button>
                            </a>
                            <a href="<?= ROOT ?>/tests/delete/<?= $row->id ?>">
                                <button class="btn-sm btn btn-danger"><i class="fa fa-trash-alt"></i></button>
                            </a>
                        <?php endif; ?>

                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">
                    <center>No tests were found at this time</center>
                </td>
            </tr>
        <?php endif; ?>
    </table>

</div>