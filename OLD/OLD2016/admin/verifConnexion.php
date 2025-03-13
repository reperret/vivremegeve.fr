<?php
if (isset($_POST['connexion']) && $_POST['connexion'] == 'Connexion') 
{
	if ((isset($_POST['login']) && !empty($_POST['login'])) && (isset($_POST['pass']) && !empty($_POST['pass']))) 
	{
	
		$reqSelect = $dbh->prepare('SELECT count(*) AS nbre FROM administrateur WHERE login=? AND pass_md5=?');
		$reqSelect->bindParam(1, $login);
		$reqSelect->bindParam(2, $passmd5);
		$login = $_POST['login'];
		$passmd5 = md5($_POST['pass']);
		
		$reqSelect->execute();
		$lignes=$reqSelect->fetchAll(PDO::FETCH_OBJ);

	
	foreach ($lignes as $colonne)
	{
		if ($colonne->nbre == 1) 
		{
			session_start();
			$_SESSION['login'] = $_POST['login'];
			header('Location: index.php');
			exit();
		}
		elseif ($colonne->nbre == 0) 
		{
			$erreur = 'Compte non reconnu.';
		}
		else 
		{
			$erreur = 'Une erreur fatale est intervenue. Veuillez contacter votre webmaster';
		}
	}	
	$reqSelect->closeCursor();

		
	}
	else 
	{
		$erreur = 'Veuillez remplir tous les champs demandés';
	}
}
?>