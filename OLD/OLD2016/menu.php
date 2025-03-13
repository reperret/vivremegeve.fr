
		
        		<nav class="w-nav-menu menu-ham" role="navigation">
			<a class="w-nav-link nav-link" href="index.php">Accueil</a>	
            <a class="w-nav-link nav-link" href="actualites.php">Actualites</a>		
			<a class="w-nav-link nav-link" href="adhererPre.php">Adhérer</a>
			<a class="w-nav-link nav-link" href="contact.php">Contact</a>
		<?php	if (!isset($_SESSION['login'])) 
		{?>
			<a class="w-nav-link nav-link" href="compteclient.php">Compte client</a>
		<?php 
		}
		else
		{?>
			<a class="w-nav-link nav-link" href="compteclient.php">Mon compte</a>
		<?php 
		}
		?>
		</nav>