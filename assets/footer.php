<?php 

if (basename($_SERVER['PHP_SELF']) == 'index.php') {

    ?>


    <!-- SCRIPTS -->
    <!-- JQuery -->
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="js/mdb.min.js"></script>
    <!-- TOASTR JS -->
    <script type="text/javascript" src="js/toastr.min.js"></script>
     <!-- MAIN JS -->
    <script type="text/javascript" src="js/main.js"></script>


    <?php


} else {

?>

        <!-- SCRIPTS -->
        <!-- JQuery -->
        <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
        <!-- Bootstrap tooltips -->
        <script type="text/javascript" src="../js/popper.min.js"></script>
        <!-- Bootstrap core JavaScript -->
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <!-- MDB core JavaScript -->
        <script type="text/javascript" src="../js/mdb.min.js"></script>
        <!-- TOASTR JS -->
        <script type="text/javascript" src="../js/toastr.min.js"></script>
        <!-- MAIN JS -->
        <script type="text/javascript" src="../js/main.js"></script>


<?php

}

?>

        <script type="text/javascript">
        $(document).ready(function(){
        
            <?php
            // toastr output & session reset
            if(isset($_SESSION['toastr'])){
                echo 'toastr.'.$_SESSION['toastr']['type'].'("'.$_SESSION['toastr']['message'].'", "'.$_SESSION['toastr']['title'].'")';
                unset($_SESSION['toastr']);
            } 
            ?>          
        });
    </script> 
    </body>

    </html>