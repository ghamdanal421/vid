<?php

//		$description = $con->prepare("SELECT * FROM settings");
//		$description->execute(array());
//		$infodescription = $description->fetch();
//		if (isset($_SESSION['user'])){
//			$getUser = $con->prepare("SELECT * FROM users WHERE Username = ?");
//			$getUser->execute(array($_SESSION['user']));
//			$info = $getUser->fetch();
//		
//		}

?>
<!DOCTYPE html>
<html lang="ar">
	<head>
		<meta charset="UTF-8" />
		<!-- Chrome, Firefox OS and Opera -->
		<meta content='#0b5f31' name='theme-color'/>
		<!-- Windows Phone -->
		<meta content='#0b5f31' name='msapplication-navbutton-color'/>
		<title><?php getTitle() ?></title>
		<meta property="og:description" content="<?= $infodescription['description_meta']?>">
		<link rel="stylesheet" href="<?php echo $css ?>font-awesome.min.css" />
		<link rel="stylesheet" href="<?php echo $css ?>normalize.css" />
		<link rel="stylesheet" href="<?php echo $css ?>NotoArabic.css" />
		<link rel="stylesheet" href="<?php echo $css ?>jquery.bxslider.css" />
		<link rel="stylesheet" href="<?php echo $css ?>style.css" />
		<link rel="shortcut icon" href="<?=$actual_link?>icon.png" />
        <meta content="width=device-width, initial-scale=1" name="viewport">
         <!--[if lt IE 9]>
            <script src="<?php echo $js ?>html5shiv.js"></script>
        <![endif]-->
	</head>
	<body>

  <!-- Start Navigation Bar -->
		<header>
			<div class="container">
			<div class="logo">
				<h1><b>ibr</b>anime</h1>
				<p>  أبراهيم انمي والفلام</p>
			</div>
			<form method="get">
				<input type="search" name="search" placeholder="البحث ..." />
				<button><i class="fa fa-search"></i></button>
			</form>
			<div class="login">
				<button> <i class="fa fa-sign-in"></i>  تسجيل  / اشتراك </button>
			</div>
			</div>
		</header>
        <nav class="navbar">
                <div class="navbar-link">
					<div class="container">
                    <ul class="links">
                        <li class="active"><a href="#"> الرئسية</a></li>
                        <li><a  href="#" data-value="ser">الانمي</a></li>
                        <li><a href="#" data-value="test">أفلام</a></li>
                        <li><a href="#" data-value="port">الأخبار</a></li>
                      <li><a href="?" data-value="cont">الحائط</a></li> 
                    </ul>
				</div>
                </div>			
                <div class="clearfix"></div>
        </nav>
      <!-- End Navigation Bar -->
		
		<!-- Start 	asidebar -->
		
		<!-- End 	asidebar -->

		
		</aside>