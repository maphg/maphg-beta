<?php
include_once 'php/layout.php';
include 'php/conexion.php';
$layout = new Layout();
?>

<!DOCTYPE html>
<html>
    <head>
        <?php echo $layout->styles(); ?>
        <link rel="stylesheet" href="css/all.css">
        <link rel="stylesheet" href="DataTables/datatables.css">
        <link rel="stylesheet" href="css/test.css">
    </head>
    <body>
        <div id="wrapper" class="wrapper">

            <div id="aside" class="sidebar">
                <ul class="nav">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Experience</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Bio</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>

                <!-- <div>
                        some extra text
                </div> -->
            </div><!-- /Aside -->

            <div id="content" class="content">
                <a class='button'></a>
                <h1>Flexbox Off-Canvas Side Menu</h1>
                <h2>Easy to use</h2>
            </div><!-- /Content -->

        </div>
    </body>
    <?php echo $layout->scripts(); ?>
    <script>
        $(document).ready(function () {
            $('.button').on('click', function () {
                $('.sidebar').toggleClass('isClosed');
                $('.sidebar ul.nav').toggleClass('isClosed');
            });
        });

    </script>
</html>
