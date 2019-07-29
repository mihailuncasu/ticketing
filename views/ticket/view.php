<link rel="stylesheet" href="<?php echo ROOT_PATH; ?>assets/css/view.css">  

<div class="container">
    
    <div class="row">
        <!-- ALL REPLIES FOR THIS TICKET -->
        <div class="col-md-6 mb-4 myColumn">
            <h4 class="mb-3">Ticket replies</h4>
            <hr class="mb-4">
            <div class="mb-3 form-group">
                <?php
                foreach ($viewmodel['messages'] as $reply) :
                    $class = $reply['iAuthor'] ? 'success' : 'warning';
                    $author = $reply['iAuthor'] ? 'by the author of the ticket' : 'by a guest user';
                    ?>
                    <div class="myReply alert-<?= $class ?>">
                        <h10><?= $reply['message'] ?></h10>
                        <hr class="mb-4">
                        Posted by <?= $author ?> on date <?= $reply['date'] ?> 
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- TICKET DATA -->
        <div class="col-md-6 order-md-1">
            <h4 class="mb-3">Ticket with reference NO. <?= $viewmodel['ticket']['reference'] ?> </h4>
            <hr class="mb-4">
            <div class="mb-3">
                <label for="department">Department</label>
                <input type="text" class="form-control" name="department" value="<?= $viewmodel['ticket']['department']['name'] ?>" readonly="">
            </div>

            <div class="mb-3 form-group">
                <label class="control-label" for="subject">Subject</label>
                <input type="text" class="form-control" name="subject" value="<?= $viewmodel['ticket']['subject'] ?>" readonly="">
            </div>

            <div class="mb-3 form-group">
                <label class="control-label" for="email">Email</label>
                <input type="email" class="form-control" name="email" value="<?= $viewmodel['ticket']['email'] ?>" readonly="">
            </div>

            <hr class="mb-4">
            <!-- REPLY FORM -->
            <form method="POST">
                <div class="mb-3 form-group">
                    <input type="hidden" value="<?= $viewmodel['ticket']['reference'] ?>" name="reference">
                    <label class="control-label" for="message">Submit a new reply as </label>
                    <?php
                    if ($_SESSION['iAuthor']) {
                        echo 'the author of the ticket.';
                    } else {
                        echo 'a guest user.';
                    }
                    ?>
                    <textarea class="form-control" id="message" name="message" placeholder="Your reply goes here.." required=""></textarea>
                    <button class="btn btn-primary btn-lg btn-block" name="submit" value="submit" type="submit">Submit your reply</button>
                </div>
            </form>
        </div>
    </div>
</div>