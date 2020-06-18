<?php




	



	/*
	** Check Online UserFunction v1.0
	** Function to Check Online UserIn Database
	** 
	*/

	function checkOnlineUser($userId) {

		global $con;

		$statement = $con->prepare("SELECT OnlineUser FROM users WHERE UserID = $userId");

		$statement->execute();

		$all = $statement->fetchAll();

				
		$temcoast = explode(" ", $all[0][0]);
		$nuwTime = date('Y-m-d H:i:s', time()); 
		$date = $temcoast[0];
		$times = $temcoast[1];
  		$hour = explode(":", $times)[0];
  		$Minutes  = explode(":", $times)[1];
  		$Seconds  = explode(":", $times)[2];
  		$year = explode("-", $date)[0];
  		$month = explode("-", $date)[1];
  		$day = explode("-", $date)[2];
		
		if ($year >= date('Y', time())) {
			if($month >= date('m', time())) { 
				if ($day >= date('d', time())) {
					if ($hour >= date('H', time())) {
						if ($Minutes  + 3 >= date('i', time())) {
							return "متصل الان ";
							
						} else {
							return "قبل دقيقية ";
						}
					}else {
						return "قبل ساعة ";
					}
				} else {
					return 'قبل يوم ';
				}
			} else {
				return "قبل شهر ";
			}
		} else {
			return " قبل سنة  ";
		}
		
			
		
		
		
		
		
		
		
	}




	/*
	** Check evaluation ItemFunction v1.0
	** Function to Check evaluation return 5 star
	** 
	*/


function evaluation($eval) {
	
	if ($eval <= 20 ) {
		echo '<i class=" active fa fa-star "></i>';
		echo '<i class="  fa fa-star "></i>';
		echo '<i class="  fa fa-star "></i>';
		echo '<i class="  fa fa-star "></i>';
		echo '<i class="  fa fa-star "></i>';
		
	}else if ($eval <= 40) {
		echo '<i class=" active fa fa-star "></i>';
		echo '<i class=" active fa fa-star "></i>';
		echo '<i class="  fa fa-star "></i>';
		echo '<i class="  fa fa-star "></i>';
		echo '<i class="  fa fa-star "></i>';
	}else if ($eval <= 60) {
		echo '<i class=" active fa fa-star "></i>';
		echo '<i class=" active fa fa-star "></i>';
		echo '<i class=" active fa fa-star "></i>';
		
		echo '<i class="  fa fa-star "></i>';
		echo '<i class="  fa fa-star "></i>';
	}else if ($eval <= 80) {
		echo '<i class=" active fa fa-star "></i>';
		echo '<i class=" active fa fa-star "></i>';
		echo '<i class=" active fa fa-star "></i>';
		echo '<i class=" active fa fa-star "></i>';
		echo '<i class="  fa fa-star "></i>';
	}else if ($eval > 80) {
		echo '<i class=" active fa fa-star "></i>';
		echo '<i class=" active fa fa-star "></i>';
		echo '<i class=" active fa fa-star "></i>';
		echo '<i class=" active fa fa-star "></i>';
		echo '<i class=" active fa fa-star "></i>';
	}
	
	
}
















	/*
	** Title Function v1.0
	** Title Function That Echo The Page Title In Case The Page
	** Has The Variable $pageTitle And Echo Defult Title For Other Pages
	*/

	function getTitle() {
		global $con;
		$getUser = $con->prepare("SELECT * FROM settings");
		$getUser->execute(array());
		$info = $getUser->fetch();
		

		global $pageTitle;

		if (isset($pageTitle)) {

			echo  $info['name'] . ' | ' . $pageTitle;

		} else {

			echo $info['name'] ;

		}
	}



	/*
	** Slider Function v1.0
	** Slider Function That Set The Slider In Page 
	** Has The Variable $pageSlider And false Not Set The Slider In Page
	*/

	function getSlider() {

		global $pageSlider;

		if (isset($pageSlider)) {

			echo $pageSlider;

		} else {

			echo 'false';

		}
	}

	/*
	** Trust Status Function v1.0
	** TrustStatus Function That Set The Trust In Echo  
	** Has The Variable $TrustStatus 
	*/

	function setTrustStaus($TrustStatus = 0) {

		//global $TrustStatus;

			
			if ($TrustStatus == 0) {
				echo 'مستخدم جديد ';
			}else if ($TrustStatus == 1) {
				echo 'مشتري جاد  ';
			}else if ($TrustStatus == 2) {
				echo 'مشتري VIP  ';
			}else if ($TrustStatus == 3) {
				echo 'أسرة جديدة';
			}else if ($TrustStatus == 4) {
				echo 'أسرة نشطة  ';
			}else if ($TrustStatus == 5) {
				echo 'أسرة مميزة ';
			}else if ($TrustStatus == 6) {
				echo 'أسرة VIP ';
			}
		
	}







	/*
	** Home Redirect Function v3.0
	** This Function Accept Parameters
	** $theMsg = Echo The Message [ Error | Success | Warning ]
	** $url = The Link You Want To Redirect To
	** $seconds = Seconds Before Redirecting
	*/

	function redirectHome($theMsg = "", $url = null, $bakurl = null, $seconds = 3) {

		if ($url === null && $bakurl === null) {

			$url = $actual_link;

			$link = 'الصفحة الرئيسة';

		} else if(!$bakurl == null ){
			
		$url = $bakurl;
		$link = ' ';
		
		} else {

			if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {

				$url = $_SERVER['HTTP_REFERER'];

				$link = 'الصفحة السابقة';

			} else {

				$url = $actual_link;

				$link = 'الصفحة الرئيسة';

			}

		}

		echo $theMsg;

		echo "<div class='alert alert-info'>سيتم تخويلك الي $link خلال  $seconds ثانية.</div>";

		header("refresh:$seconds;url=$url");

		exit();

	}

	/*
	** Page Redirect Function v1.0
	** This Function Accept Parameters
	** $url = The Link You Want To Redirect To
	*/

	function redirectPages() {
		global $actual_link;
	

			if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {

				$url = $_SERVER['HTTP_REFERER'];


			} else {

				$url = $actual_link;


			}
return $url;

	}

	/*
	** Count Number Of Items Function v1.0
	** Function To Count Number Of Items Rows
	** $item = The Item To Count
	** $table = The Table To Choose From
	*/

	function countItems($item, $table) {

		global $con;

		$stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");

		$stmt2->execute();

		return $stmt2->fetchColumn();

	}

	/*
	** Get Latest Records Function v1.0
	** Function To Get Latest Items From Database [ Users, Items, Comments ]
	** $select = Field To Select
	** $table = The Table To Choose From
	** $order = The Desc Ordering
	** $limit = Number Of Records To Get
	*/

	function getLatest($select, $table, $order, $limit = 5) {

		global $con;

		$getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");

		$getStmt->execute();

		$rows = $getStmt->fetchAll();

		return $rows;

	}