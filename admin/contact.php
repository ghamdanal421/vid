<?php

	/*
	================================================
	== Manage Comments Page
	== You Can Edit | Delete | Approve Comments From Here
	================================================
	*/

	ob_start(); // Output Buffering Start

	session_start();

	$pageTitle = 'الرسائل الادارية ';

	if (isset($_SESSION['Username'])) {

		include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		// Start Manage Page

		if ($do == 'Manage') { // Manage Members Page

			// Select All Users Except Admin 

			$stmt = $con->prepare("SELECT contact.* FROM contact ORDER BY contact.ID DESC");

			// Execute The Statement

			$stmt->execute();

			// Assign To Variable 

			$comments = $stmt->fetchAll();
			

			if (! empty($comments)) {
				


			?>

			<h1 class="text-center">أدارة الرسائل الادارية </h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>ID</td>
							<td>المحتوى</td>
							<td>أسم المستخدم </td>
							<td>البريد  </td>
							<td>تاريخ الارسال   </td>
							<td>التحكم</td>
						</tr>
						<?php
							foreach($comments as $comment) {
								
								if ($comment['userIDMass'] == 0){
								
								echo "<tr class='nout-eser'>";
									echo "<td>" . $comment['ID'] . "</td>";
									echo "<td class='colw'>" . $comment['message'] . "</td>";
									echo "<td title='غير مسجل في الموقع '>" . $comment['uesrName'] . "</td>";
									echo "<td>" . $comment['email'] . "</td>";
									echo "<td>" . $comment['massDate'] ."</td>";
									echo "<td>
										<a href='contact.php?do=Delete&comid=" . $comment['ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> حدف </a>";
										
									echo "</td>";
									
								echo "</tr>";
									
								}else {
									$getUser = $con->prepare("SELECT * FROM users WHERE UserID = ?");
									$getUser->execute(array($comment['userIDMass']));
									$info = $getUser->fetch();
									
									echo "<tr>";
									echo "<td>" . $comment['ID'] . "</td>";
									echo "<td class='colw'>" . $comment['message'] . "</td>";
									echo "<td> <a herf='../user.php?user="  . $info['Username'] . "'>".$info['Username']." </a></td>";
									echo "<td>" . $info['Email'] . "</td>";
									echo "<td>" . $comment['massDate'] ."</td>";
									echo "<td>
										<a href='contact.php?do=Delete&comid=" . $comment['ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> حدف </a>";
										if ($comment['approveMass'] == 0) {
											echo "<a href='contact.php?do=Approve&comid="
													 . $comment['ID'] . "&user=".$comment['userIDMass']."
													 
													 '  
													class='btn btn-info activate'>
													<i class='fa fa-share-square-o'></i> رد </a>";
										}
									echo "</td>";
									
								echo "</tr>";
									
								}
							}
						?>
						<tr>
					</table>
				</div>
			</div>

			<?php } else {

				echo '<div class="container">';
					echo '<div class="nice-message">لا يوجد اي رسالة الي الان  </div>';
				echo '</div>';

			} ?>

		<?php 

		}  elseif ($do == 'Delete') { // Delete Page

			echo "<h1 class='text-center'>حدف الرسالة </h1>";

			echo "<div class='container'>";

				// Check If Get Request comid Is Numeric & Get The Integer Value Of It

				$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

				// Select All Data Depend On This ID

				$check = checkItem('ID', 'contact', $comid);

				// If There's Such ID Show The Form

				if ($check > 0) {

					$stmt = $con->prepare("DELETE FROM contact WHERE ID = :zid");

					$stmt->bindParam(":zid", $comid);

					$stmt->execute();

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' تم الحدف بنجاح </div>';

					redirectHome($theMsg, 'back');

				} else {

					$theMsg = '<div class="alert alert-danger">لا يوجد رسالة بهدا الاي دي</div>';

					redirectHome($theMsg);

				}

			echo '</div>';

		} elseif ($do == 'Approve') {

			echo "<h1 class='text-center'>رد على الرسالة </h1>";
			echo "<div class='container'>";

				// Check If Get Request comid Is Numeric & Get The Integer Value Of It

				$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

				// Select All Data Depend On This ID

				$check = checkItem('ID', 'contact', $comid);

				// If There's Such ID Show The Form

				if ($check > 0) {

					
								if ($_SERVER['REQUEST_METHOD'] == 'POST') {
									
									if (isset($_POST['comment'])) {
										
									$getUser = $con->prepare("SELECT * FROM users WHERE UserID = ?");
									$getUser->execute(array($_GET['user']));
									$info = $getUser->fetch();	
										
									$getmegs = $con->prepare("SELECT * FROM contact WHERE ID = ?");
									$getmegs->execute(array($comid));
									$getmass = $getmegs->fetch();
										
									
										
									
										
								$piece = substr($getmass['message']	, 0, 23);

																			//				 Set Notifications
			$infor =  'مرحبا : <a href="user.php?user='. $info['Username'].'">' . $info['Username'] . '</a> رد على رسالتك  : 
			<strong>
			'.$piece.'...
			</strong>
			
			<div class="messg">
			
			'. $_POST['comment'] .'
			</div> <span>رسالة أدارية </span>';		
		
				$notifications = $con->prepare("INSERT INTO 

					notifications(notifications_Info, notifications_Type, notifications_Date, notifications_Status, notifications_UserID , notifications_SendID)

					VALUES(:zInfo, :zType, now(), :zStatus, :zUserID, :zSendID)");

				$notifications->execute(array(

					'zInfo' 	=> $infor,
					'zType' 	=> '0',
					'zStatus' 	=> '0',
					'zUserID' 	=> $_GET['user'],
					'zSendID'		=> $_GET['user']

				));
		
			$theMsg =  $notifications->rowCount() ;
			
										
										
										
									}
									

								}

			
					$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
					?>
					
					
				<div class="container">
					<form class="form-horizontal" action="<?=$actual_link?>" method="POST">
						<input type="hidden" name="comid" value="" />
						<?php
						
						if(isset($theMsg)){
							redirectHome("تم ارسال رسالتك بنجاح $theMsg");
							
						}
						
						?>
						<!-- Start Comment Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">الرسالة </label>
							<div class="col-sm-10 col-md-6">
								<textarea class="form-control" name="comment"></textarea>
							</div>
						</div>
						<!-- End Comment Field -->
						<!-- Start Submit Field -->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="أرسال" class="btn btn-primary btn-sm" />
							</div>
						</div>
						<!-- End Submit Field -->
					</form>
				</div>
					
				<?php
				} else {

					$theMsg = '<div class="alert alert-danger">لا يوجد رسلة بهدا الاي دي </div>';

					redirectHome($theMsg);

				}

			echo '</div>';

		}

		include $tpl . 'footer.php';

	} else {

		header('Location: index.php');

		exit();
	}

	ob_end_flush(); // Release The Output

?>