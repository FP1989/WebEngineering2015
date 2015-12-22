<nav class="navbar">
    <div class="container-fluid">
        <div id="navbar-in">
            <ul class="nav navbar-nav">
                <a href="home.php" class="pull-left"><img src="files/logo_home.png" id="image" alt="logo"></a>
                <li><a href="home.php"><i class="fa fa-home fa-2x verschwinden"></i><br>Home</a></li>
                <?php if(isset($_SESSION['admintrue'])) echo '<li><a href="users.php"><i class="fa fa-cog fa-2x verschwinden"></i><br>Users</span></a></li>';?>
                <li><a href="rechnungen.php"><i class="fa fa-calculator fa-2x verschwinden"></i><br>Rechnungen</a></li>
                <li><a href="reisen.php"><i class="fa fa-plane fa-2x verschwinden"></i><br>Reisen</a></li>
                <li><a href="teilnehmer.php"><i class="fa fa-users fa-2x verschwinden"></i><br>Teilnehmer</a></li>
                <li><a href="beguenstigter.php"><i class="fa fa-user fa-2x verschwinden"></i><br>Begünstigter</a></li>
                <li><a href="reservationen.php"><i class="fa fa-credit-card fa-2x verschwinden"></i><br/>Reservationen</a></li>
                <li><a href="reports.php"><i class="fa fa-table fa-2x verschwinden"></i><br>Reports</a></li>
                <li><a href="logout.php"><i class="fa fa-power-off fa-2x verschwinden"></i><br>Logout</a></li>
            </ul>
        </div>
    </div>
</nav>