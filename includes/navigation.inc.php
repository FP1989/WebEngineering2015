<nav class="navbar">
    <div class="container-fluid">
        <!--        <div class="navbar-header">-->
        <!--        <a href="home.php" class="pull-left"><img src="files/logo_pagetry.png" id="image" alt="logo"></a>-->
        <!--        </div>-->
        <div id="navbar-in">
            <ul class="nav navbar-nav">
                <a href="home.php" class="pull-left"><img src="files/logo_home.png" id="image" alt="logo"></a>
                <li><a href="home.php"><i class="fa fa-home fa-2x"></i><br>Home</a></li>
                <?php if(isset($_SESSION['admintrue'])) echo '<li><a href="users.php"><span style="color:#ff000e;font-weight:bold;"><i class="fa fa-cog fa-2x"></i><br>Users</span></a></li>';?>
                <li><a href="rechnungen.php"><i class="fa fa-balance-scale fa-2x"></i><br>Rechnungen</a></li>
                <li><a href="reisen.php"><i class="fa fa-plane fa-2x"></i><br>Reisen</a></li>
                <li><a href="teilnehmer.php"><i class="fa fa-users fa-2x"></i><br>Teilnehmer</a></li>
                <li><a href="beguenstigter.php"><i class="fa fa-user fa-2x"></i><br>Begünstigter</a></li>
                <li><a href="reservationen.php"><i class="fa fa-credit-card fa-2x"></i><br/>Reservationen</a></li>
                <li><a href="reports.php"><i class="fa fa-table fa-2x"></i><br>Reports</a></li>
                <li><a href="logout.php"><i class="fa fa-close fa-2x"></i><br>Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<script type="text/javascript">
    $('.fa-cog').hover(function() {
        $(this).addClass('fa-spin');
    }, function() {
        $(this).removeClass('fa-spin');
    });

    $('.fa-close').hover(function() {
        $(this).addClass('fa-spin');
    }, function() {
        $(this).removeClass('fa-spin');
    });
</script>