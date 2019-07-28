<link rel="stylesheet" href="<?php echo ROOT_PATH; ?>assets/css/viewtickets.css">  
<div id="confirmBox"></div>
<h2>View all tickets</h2>
<table class="table table-hover myTable">
    <!-- HEAD -->
    <thead>
        <tr>
            <th style="width:15%">Subject</th>
            <th style="width:20%">Department</th>
            <th style="width:15%">Status</th>
            <th style="width:20%">Email</th>
            <th style="width:15%">Submission date</th>
            <th style="width:15%">Actions</th>
        </tr>
    </thead>
    <!-- BODY -->
    <tbody>
        <!-- FILTERS ROW -->

        <tr class="table-primary">
            <td>
                <input type="text" class="form-control" name="subject" id="subject">
            </td>
            <td>
                <select class="custom-select d-block w-100" name="department" id="department">
                    <option value="-1">All</option>
                    <?php foreach ($viewmodel['departments'] as $department) : ?>
                        <option value="<?= $department['id'] ?>"><?= $department['name'] ?></option>
                    <?php endforeach; ?> 
                </select>
            </td>
            <td>
                <select class="custom-select d-block w-100" name="status" id="status">
                    <option value="-1">All</option>
                    <option value="1">Open</option>
                    <option value="0">Closed</option>
                </select>
            </td>
            <td>
                <input type="text" class="form-control" name="email" id="email">
            </td>
            <td>
                <select class="custom-select d-block w-100" name="date" id="date">
                    <option value="0">Asc</option>
                    <option value="1">Desc</option>
                </select>
            </td>
            <td></td>
        </tr>


        <!-- TICKET ROWS -->
        <?php foreach ($viewmodel['tickets'] as $ticket): ?>
            <?php
            $statusCss = $ticket['status'] ? 'active' : 'warning';
            $statusToggledCss = $ticket['status'] ? 'warning' : 'success';
            $statusRow = $ticket['status'] ? 'Open' : 'Closed';
            $statusToggledRow = $ticket['status'] ? 'Close' : 'Open';
            $departmentsId = array_column($viewmodel['departments'], 'id');
            $key = array_search($ticket['id_department'], $departmentsId);
            $reference = str_replace('-', '_', $ticket['reference']);
            ?>
        <tr class="table-<?= $statusCss; ?>">
            <td>
                <?= $ticket['subject'] ?>
            </td>
            <td>
                <?= $viewmodel['departments'][$key]['name'] ?>
            </td>
            <td>
                <?= $statusRow ?>
            </td>
            <td>
                <?= $ticket['email'] ?>
            </td>
            <td>
                <?= $ticket['date'] ?>
            </td>
            <td>
                <div class="btn-group">
                    <button type="button" onclick="actionConfirm(<?= $ticket['id'] ?>)" id="toggle" value="toggle" class="btn btn-<?= $statusToggledCss ?> btn-sm"><?= $statusToggledRow ?></button>
                    <button type="button" onclick="actionConfirm(<?= $ticket['id'] ?>)" id="delete" value="delete" class="btn btn-danger btn-sm">Delete</button>
                    <a href="<?= ROOT_URL ?>ticket/view/<?= $reference ?>" id="view" value="view" class="btn btn-primary btn-sm">View</a>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>

</tbody>
</table>

<script type="text/javascript" src="<?php echo ROOT_PATH; ?>assets/js/popup.js"></script>