<link rel="stylesheet" href="<?php echo ROOT_PATH; ?>assets/css/viewtickets.css">  
<div id="confirmBox"></div>

<div class="container">
    <h4 class="mb-3">View all tickets</h4>
    <div class="table-responsive">
        <table class="table table-hover myTable">
            <!-- HEAD -->
            <thead>
                <tr>
                    <th style="max-width:18%">Subject</th>
                    <th style="width:20%">Department</th>
                    <th style="width:15%">Status</th>
                    <th style="width:20%">Email</th>
                    <th style="width:12%">Date</th>
                    <th style="width:15%">Actions</th>
                </tr>
            </thead>
            <!-- BODY -->
            <tbody>
                <!-- FILTERS ROW -->
                <tr class="table-primary">
            <form method="POST" id="filters">
                <td>
                    <?php 
                        $subject = '';
                        if (isset($viewmodel['filters']) && isset($viewmodel['filters']['subject'])) {
                            $subject = $viewmodel['filters']['subject'];
                        }
                    ?>
                    <input type="text" class="form-control" name="subject" id="subject" value="<?= $subject ?>">
                </td>
                <td>
                    <select class="custom-select d-block w-100" name="department" id="department">
                        <?php foreach ($viewmodel['departments'] as $department) : ?>
                            <?php
                            $option = '';
                            if (isset($viewmodel['filters']) && isset($viewmodel['filters']['department'])) {
                                if ($department['id'] == $viewmodel['filters']['department']) {
                                    $option = 'selected';
                                }
                            }
                            ?>
                            <option value="<?= $department['id'] ?>" <?= $option ?>><?= $department['name'] ?></option>
                        <?php endforeach; ?> 
                    </select>
                </td>
                <td>
                    <select class="custom-select d-block w-100" name="status" id="status">
                        <?php foreach ($viewmodel['statuses'] as $status) : ?>
                            <?php
                            $option = '';
                            if (isset($viewmodel['filters']) && isset($viewmodel['filters']['status'])) {
                                if ($status['value'] == $viewmodel['filters']['status']) {
                                    $option = 'selected';
                                }
                            }
                            ?>
                            <option value="<?= $status['value'] ?>" <?= $option ?>><?= $status['name'] ?></option>
                        <?php endforeach; ?> 
                    </select>
                </td>
                <td>
                    <?php 
                        $email = '';
                        if (isset($viewmodel['filters']) && isset($viewmodel['filters']['email'])) {
                            $email = $viewmodel['filters']['email'];
                        }
                    ?>
                    <input type="text" class="form-control" name="email" id="email" value="<?= $email ?>">
                </td>
                <td>
                    <select class="custom-select d-block w-100" name="date" id="date">
                        <?php
                        $asc = '';
                        $desc = '';
                        if (isset($viewmodel['filters']) && isset($viewmodel['filters']['date'])) {
                            if ($viewmodel['filters']['date']) {
                                $desc = 'selected';
                            } else {
                                $asc = 'selected';
                            }
                        }
                        ?>
                        <option value="0" <?= $asc ?>>Asc &uarr;</option>
                        <option value="1" <?= $desc ?>>Desc &darr;</option>
                    </select>
                </td>
                <td>
                    <div class="btn-group">
                        <button type="submit" value="submit" name="filter" class="form-control btn btn-primary btn-sm">Apply filters</button>
                        <button type="submit" value="reset" name="filter" class="form-control btn btn-success btn-sm">Reset filters</button>
                    </div>
                </td>
            </form>
            </tr>

            <!-- TICKET ROWS -->
            <?php foreach ($viewmodel['tickets'] as $ticket): ?>
                <?php
                $statusCss = $ticket['status'] ? 'success' : 'warning';
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
                            <a href="<?= ROOT_URL ?>ticket/view/<?= $reference ?>" id="view" value="view" class="btn btn-primary btn-sm">View</a>
                            <button type="button" onclick="confirmDelete(<?= $ticket['id'] ?>)" class="btn btn-danger btn-sm">Delete</button>
                            <button type="button" onclick="confirmToggle(<?= $ticket['id'] ?>, '<?= $statusToggledRow ?>')" class="btn btn-<?= $statusToggledCss ?> btn-sm"><?= $statusToggledRow ?> ticket</button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript" src="<?php echo ROOT_PATH; ?>assets/js/popup.js"></script>