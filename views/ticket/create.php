<link rel="stylesheet" href="<?php echo ROOT_PATH; ?>assets/css/create.css">  

<div class="container">
    <h4 class="mb-3">Complete your ticket</h4>
    <hr class="mb-4">
    
    <div class="row">
        <div class="col-md-8 order-md-1">
            <form method="POST"  action="<?php $_SERVER['PHP_SELF']; ?>">
                
                <div class="mb-3">
                    <label for="department">Department</label>
                    <select class="custom-select d-block w-100" id="country">
                        <option>Choose...</option>
                    </select>
                </div>

                <div class="mb-3 form-group required">
                    <label class="control-label" for="subject">Subject</label>
                    <input type="text" class="form-control" id="subject" placeholder="Your subject goes here.." required="">
                </div>

                <div class="mb-3 form-group required">
                    <label class="control-label" for="email">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="you@example.com" required="">
                </div>
                
                <div class="mb-3 form-group required">
                   <label class="control-label" for="message">Message</label>
                   <textarea class="form-control" id="message" placeholder="Your message goes here.." required=""></textarea>
                </div>
                
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Submit your ticket</button>
                <hr class="mb-4">
                
                <h6> All fields marked with <span style="color:red">*</span> are required! </h6>
                
            </form>
        </div>
    </div>

</div>