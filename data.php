<?php

	
	require("functions.php");
	
	if (!isset($_SESSION["userId"])) {
		
		header("Location: login.php");
		exit();
	}
	
	
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login.php");
		exit();
	}
	
	$variety = "";
	$varietyError = "";
	$location = "";
	$locationError = "";
	$quantity = "";
	$quantityError = "";
	$price = "";
	$priceError = "";
	
	if (isset ($_POST["variety"])) {

		if (empty ($_POST["variety"])) {
			
			$varietyError="Väli on kohustuslik";
		}
	}
	
	if (isset ($_POST["location"])) {

		if (empty ($_POST["location"])) {
			
			$locationError="Väli on kohustuslik";
		}
	}
	
	if (isset ($_POST["quantity"])) {

		if (empty ($_POST["quantity"])) {
			
			$quantityError="Väli on kohustuslik";
		}
	}
	
	if (isset ($_POST["price"])) {

		if (empty ($_POST["price"])) {
			
			$priceError="Kui soovite õunad tasuta ära anda sisestage palun null!";
		}
	}
	
	if ( isset($_POST["variety"]) &&
	     isset($_POST["location"]) &&
		 isset($_POST["quantity"]) &&
		 isset($_POST["price"]) &&
	     !empty($_POST["variety"]) &&
		 !empty($_POST["location"]) &&
		 !empty($_POST["quantity"]) &&
	     !empty($_POST["price"])
	) {
		$variety = cleanInput($_POST["variety"]);
		$location = cleanInput($_POST["location"]);
		$quantity = cleanInput($_POST["quantity"]);
		$price = cleanInput($_POST["price"]);
		
		saveApples($variety, $location, $quantity, $price);
		
		$variety = "";
		$location = "";
		$quantity = "";
		$price = "";	
	}
	
	$list = getApples();
	
?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Õunaturg</title>
		<link type="text/css" rel="stylesheet" href="stylesheet.css" />
	</head>
	
	<body>
		<header>
			<h1>Õunaturg</h1>
		</header>
		
		<div class="wrapper">

			<a href="?logout=1">logi välja</a>
		
			<div class="onOffer boxU">
				
				<p>Hetkel aktiivsed pakkumised</p>
				
				<?php

					
					$html = "<table>";
						
						$html .= "<tr>";
							$html .= "<th>Õunasort</th>";
							$html .= "<th>Asukoht</th>";
							$html .= "<th>Kogus (kg)</th>";
							$html .= "<th>Hinnasoov (€/kg)</th>";
						$html .= "</tr>";
						
						foreach ($list as $p) {
							
							$html .= "<tr>";
								$html .= "<td>".$p->variety."</td>";
								$html .= "<td>".$p->location."</td>";
								$html .= "<td>".$p->quantity."</td>";
								$html .= "<td>".$p->price."</td>";
							$html .= "</tr>";
							
						}
					
					$html .= "</table>";
					
					
					echo $html;

				?>
				
			</div><!--.onOffer-->
			
			<div class="word">
				<p>Kui teilgi leidub õunu mida soovite teistele müüa või tasuta ära anda täitke palun järgnev tabel</p>
			</div><!--.insert-->
			
			<div class="insert boxL">
				
				<form method="POST" >
	
					<label>Õunasort</label><br>
					<input name="variety" type="text" class="formVariety" maxlength="34" value="<?=$variety;?>" > <?php echo $varietyError; ?>
					<br><br>
					
					<label>Asukoht</label><br>
					<input name="location" type="text" class="formLocation" maxlength="60" value="<?=$location;?>"> <?php echo $locationError; ?>
					<br><br>
					
					<label>Kogus kilogrammides</label><br>
					<input name="quantity" type="number" placeholder="0.0" step="0.1" min="0" class="formNumber" value="<?=$quantity;?>" > <?php echo $quantityError; ?>
					<br><br>
					
					<label>Hinnasoov (€/kg)</label><br>
					<input name="price" type="number" placeholder="0.00" step="0.01" min="0" class="formNumber" value="<?=$price;?>" > <?php echo $priceError; ?>
					<br><br>
					
					<input type="submit" value="Sisesta">

				</form>
				
			</div><!--.insertBoxL-->
			
		</div><!--.wrapper-->
		<footer><p>&copy; Rait Keernik</p></footer>
	</body>
</html>