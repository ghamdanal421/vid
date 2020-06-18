<?php

	/*
	** Get All Function v2.0
	** Function To Get All Records From Any Database Table
	*/

	function getAllFrom($field, $table, $where = NULL, $and = NULL, $orderfield, $ordering = "DESC") {

		global $con;

		$getAll = $con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering");

		$getAll->execute();

		$all = $getAll->fetchAll();

		return $all;

	}




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
	** order Status Function v1.0
	** orderStatus Function That Set The status In Echo  
	** Has The Variable $TrustStatus 
	*/

	function orderStatus($orderStatus = 0) {


			
			if ($orderStatus == 0) {
				echo '<samp class="exchange"><i class="fa fa-exchange"></i> بانتظار  الموافقة </samp>';
			}else if ($orderStatus == 1) {
				echo '<samp class="circle"><i class="fa fa-fw fa-info-circle"></i>  قيد التنفيذ  </samp>';
			}else if ($orderStatus == 2) {
				echo '<samp class="truck"><i class="fa fa-truck"></i>  بانتظار الاستلام </samp>';
			}else if ($orderStatus == 3) {
				echo '<samp class="check"><i class="fa fa-check"></i> تم الاستلام';
			}else if ($orderStatus == 4) {
				echo '<samp class="times"><i class="fa fa-times-circle-o"></i> طلب ملغي  </samp>';
			}
		
	}





	/*
	** Trust Status Function v1.0
	** TrustStatus Function That Set The Trust In Echo  
	** Has The Variable $TrustStatus 
	*/

	function setTrustStaus($TrustStatus = 0) {

		global $TrustStatus;

			
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
	** Title Function v1.0
	** Title Function That Echo The Page Title In Case The Page
	** Has The Variable $pageTitle And Echo Defult Title For Other Pages
	*/

	function getTitle() {

		global $pageTitle;

		if (isset($pageTitle)) {

			echo $pageTitle;

		} else {

			echo 'Default';

		}
	}

	/*
	** Home Redirect Function v2.0
	** This Function Accept Parameters
	** $theMsg = Echo The Message [ Error | Success | Warning ]
	** $url = The Link You Want To Redirect To
	** $seconds = Seconds Before Redirecting
	*/

	function redirectHome($theMsg, $url = null, $seconds = 3) {

		if ($url === null) {

			$url = 'index.php';

			$link = 'Homepage';

		} else {

			if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {

				$url = $_SERVER['HTTP_REFERER'];

				$link = 'الصفحة السابقية';

			} else {

				$url = 'index.php';

				$link = 'Homepage';

			}

		}

		echo $theMsg;

		echo "<div class='alert alert-info'>سوف يتم تحويلك الي $link خلال $seconds ثواني.</div>";

		header("refresh:$seconds;url=$url");

		exit();

	}

	/*
	** Check Items Function v1.0
	** Function to Check Item In Database [ Function Accept Parameters ]
	** $select = The Item To Select [ Example: user, item, category ]
	** $from = The Table To Select From [ Example: users, items, categories ]
	** $value = The Value Of Select [ Example: ghamdan, Box, Electronics ]
	*/

	function checkItem($select, $from, $value) {

		global $con;

		$statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");

		$statement->execute(array($value));

		$count = $statement->rowCount();

		return $count;

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