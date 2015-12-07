
<div id="navigation" class="navbar navbar-default">
    <img src="files/logo_page.png" id="image" alt="logo" >

    <ul class="nav navbar-nav">

        <li><a href="home.php"><i class="fa fa-home fa-2x"></i><br>Home</a></li>
        <?php if(isset($_SESSION['admintrue'])) echo '<li><a href="users.php"><i class="fa fa-cog fa-2x"></i><br>Users</a></li>';?>
        <li><a href="rechnungen.php"><i class="fa fa-balance-scale fa-2x"></i><br>Rechnungen</a></li>
        <li><a href="reisen.php"><i class="fa fa-plane fa-2x"></i><br>Reisen</a></li>
        <li><a href="teilnehmer.php"><i class="fa fa-users fa-2x"></i><br>Teilnehmer</a></li>
        <li><a href="reports.php"><i class="fa fa-table fa-2x"></i><br>Reports</a></li>
        <li><a href="logout.php"><i class="fa fa-close fa-2x"></i><br>Logout</a></li>

    </ul>
</div>

<script type="text/javascript">
    $('.fa-cog').hover(function() {
        $(this).addClass('fa-spin');
    }, function() {
        $(this).removeClass('fa-spin');
    });
</script>