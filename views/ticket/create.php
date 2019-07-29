<link rel="stylesheet" href="<?php echo ROOT_PATH; ?>assets/css/create.css">  

<div class="container">
    <h4 class="mb-3">Complete your ticket</h4>
    
    <div class="row">
        <div class="col-md-8 order-md-1">
            <form method="POST">
                <hr class="mb-4">
                <div class="mb-3">
                    <label for="department">Department</label>
                    <select class="custom-select d-block w-100" name="department" id="department">
                        <?php foreach($viewmodel['departments'] as $department) : ?>
                            <option value="<?= $department['id'] ?>"><?= $department['name'] ?></option>
                        <?php endforeach; ?> 
                    </select>
                </div>

                <div class="mb-3 form-group required">
                    <label class="control-label" for="subject">Subject</label>
                    <input type="text" class="form-control" name="subject" id="subject" placeholder="Your subject goes here.." required="">
                </div>

                <div class="mb-3 form-group required">
                    <label class="control-label" for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="you@example.com" required="">
                </div>
                
                <div class="mb-3 form-group required">
                   <label class="control-label" for="message">Message</label>
                   <textarea class="form-control" id="message" name="message" placeholder="Your message goes here.." required=""></textarea>
                </div>
                
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" name="submit" value="submit" type="submit">Submit your ticket</button>
                <hr class="mb-4">
                
                <h6> All fields marked with <span style="color:red">*</span> are required! </h6>
                
            </form>
        </div>
    </div>

</div>