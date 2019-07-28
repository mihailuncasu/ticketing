<html>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?= APP_TITLE ?></title>
        <!-- ASSETS -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" >
        <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>assets/css/main.css">        
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </head>

    <body>
        <!-- HEADER --> 
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a class="navbar-brand" href="#"><?= strtoupper(APP_TITLE) ?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= ROOT_URL ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= ROOT_URL ?>ticket/create">Create ticket</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= ROOT_URL ?>ticket/view">View tickets</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- MAIN CONTENT -->
        <div class="container myContainer">
            <div class="row">
                <?php Messages::display(); ?>
                <?php require($view); ?>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="spacer"></div>
        <footer class="container-fluid">
            <p class="float-right"><a href="#">Back to top</a></p>
            <p>&copy; <?= APP_TITLE ?> Inc. &middot; <a href="">Privacy</a> &middot; <a href="#">Terms</a></p>
        </footer>

    </body>   
</html>

