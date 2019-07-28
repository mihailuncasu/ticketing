<html>
    <head>
        <title><?= APP_TITLE ?></title>
        <link href="" rel="stylesheet" type="text/css" >
        <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>assets/css/.css">
        <script src="" type="text/javascript" ></script>
        <script src="<?= ROOT_PATH ?>/assets/js/.js"></script>
    </head>
    
    <body>
        <nav class="navbar navbar-default">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="<?= ROOT_URL ?>home">Home</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">

            <div class="row">
                <?php Messages::display(); ?>
                <?php require($view); ?>
            </div>

        </div><!-- /.container -->
    </body>
</html>

