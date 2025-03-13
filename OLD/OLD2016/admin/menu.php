
    <div id="menu">
        <div class="pure-menu">
            <a class="pure-menu-heading" href="#"> <img src="../images/logoMail.jpg" width="100px"></a>

            <ul class="pure-menu-list">
            
            <?php if($profilAdmin=="0") { ?>
                            <li class="pure-menu-item"><a href="index.php" class="pure-menu-link">Listing</a></li>
                <li class="pure-menu-item"><a href="gestionActualites.php" class="pure-menu-link">Actualités</a></li>
				<li class="pure-menu-item"><a href="gestionFlash.php" class="pure-menu-link">Flash Info</a></li>
                <li class="pure-menu-item"><a href="export.php" class="pure-menu-link">Export</a></li>
            
           <?php } ?>
           
           <?php if($profilAdmin=="1") { ?>
            
   				<li class="pure-menu-item"><a href="index.php" class="pure-menu-link">Listing</a></li>
                <li class="pure-menu-item"><a href="export.php" class="pure-menu-link">Export</a></li>
           <?php } ?>
           
           <?php if($profilAdmin=="2") { ?>
                <li class="pure-menu-item"><a href="export.php" class="pure-menu-link">Export</a></li>
           <?php } ?>

                
				<li class="pure-menu-item"><a href="deconnexion.php" class="pure-menu-link">Deconnexion</a></li>
            </ul>
        </div>
    </div>