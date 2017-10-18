<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 27.07.2017
 * Time: 19:04
 */

$localHomeLocation = '/project/HAW/Semesterplan/index.php';

echo ('
    <div id="navbar">
        <ul>
            <li class="navbarDrop">
                <p><a class="navLink" href="'.$localHomeLocation.'">Home</a></p>
            </li>
            '.$logoutButton.'
        </ul>
        <script type="text/javascript">
            $("#navLoginP").click(function() {
                $("#navLogin").toggleClass("ShowMenueOnClick");
                $("#navLogin>ul").toggleClass("ShowMenue");
            });
            $("#navLogin>ul").click(function() {
                $("#navLogin").addClass("ShowMenueOnClick");
                $("#navLogin>ul").addClass("ShowMenue");
            });
            $(".headline").click(function() {
                $(".headline>li").toggleClass("ShowMenue");
            });
        </script>

    </div>');
?>