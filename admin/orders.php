<?php

	/*
	================================================
	== Manage Comments Page
	== You Can Edit | Delete | Approve Comments From Here
	================================================
	*/

	ob_start(); // Output Buffering Start

	session_start();

	$pageTitle = 'ادارة الطلبات ';

	if (isset($_SESSION['Username'])) {

		include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		// Start Manage Page

		if ($do == 'Manage') { // Manage Members Page

			// Select All Users Except Admin 

			$stmt = $con->prepare("SELECT * FROM allorders, items WHERE allorders.order_ItemID = items.Item_ID ORDER BY allorders.order_ID DESC");

			// Execute The Statement

			$stmt->execute();

			// Assign To Variable 

			$comments = $stmt->fetchAll();
			

			if (! empty($comments)) {
				


			?>

			<h1 class="text-center">أدارة  الطلبات  </h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>ID</td>
							<td>المشتري</td>
							<td>الاسرة  </td>
							<td>الكمية  </td>
							<td>تاريخ الطلب    </td>
							<td>سعر الطلب   </td>
							<td> الطبخة المطلوبة   </td>
							<td>حالة الطلب  </td>
							<td>التحكم</td>
						</tr>
						<?php
							foreach($comments as $comment) {
								$getUser = $con->prepare("SELECT * FROM users WHERE UserID = ?");
									$getUser->execute(array($comment['order_PurchasesUserID']));
									$info = $getUser->fetch();		
								$getder = $con->prepare("SELECT * FROM users WHERE UserID = ?");
									$getder->execute(array($comment['order_UserID']));
									$infoord = $getder->fetch();
								?>
								
								
								<tr class='nout-eser'>
									<td><?=$comment['order_ID'] ?> </td>
									<td><?= $info['Username'] ?></td>
									<td ><?= $infoord['Username'] ?></td>
									<td><?=$comment['order_Quantity'] ?></td>
									<td><?=$comment['order_Date'] ?></td>
									<td><?=$comment['order_Price'] ?></td>
									<td><?=$comment['Name'] ?></td>
									<td><?=orderStatus($comment['order_status']) ?></td>
									<td>
										<a href='' class='btn btn-danger confirm'><i class='fa fa-close'></i> الغاء  </a>
										<a href='?do=show&u=<?=$comment['order_ID'] ?>' class='btn btn-info activate '><i class="fa fa-commenting"></i> مشاهدة  </a>
										
									</td>
									
								</tr>
									
							<?php	
							}
						?>
						<tr>
					</table>
				</div>
			</div>

			<?php } else {

				echo '<div class="container">';
					echo '<div class="nice-message">لا يوجد اي طلبات واردة الي الان </div>';
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

		} elseif ($do == 'show') {

			$allItems = getAllFrom('*', 'messages , users ', 'where messages.message_orderID =  ' . $_GET['u'] . ' AND  users.UserID = messages.message_UserID ', '', 'message_ID', 'ASC');
			
		//	print_r($allItems);

			 ?>

			<h1 class='text-center'>المراسلات الواردة  </h1>
			<div class='container'>

			
			<div class="dfg">
						<div class="panel panel-default">
							<div class="panel-body">
								<?php
						if (!empty($allItems)){
								foreach($allItems as $mas) {								?>
								<div class="comment-box <?php 
									
										$getder = $con->prepare("SELECT * FROM allorders WHERE order_ID = ?");
									$getder->execute(array($mas['message_orderID']));
									$infoord = $getder->fetch();
											if($infoord['order_UserID'] == $mas['UserID']) {
												echo 'lift';
											}
											?>">
									<span class="member-n">
										<a href="members.php?do=Edit&amp;userid=<?= $mas['UserID'] ?> "><?= $mas['Username'] ?></a>
									</span>
									<p class="member-c"><?= $mas['message_text'] ?></p>
								</div>
								<?php } }else {
								echo '<div class="container">';
									echo '<div class="nice-message">لا يوجد اي مراسلات هنا </div>';
								echo '</div>';
							
						} ?>
								
													
							</div>
						</div>
					</div>
			
			
			
			
			
			</div>

		<?php } 

		include $tpl . 'footer.php';

	} else {

		header('Location: index.php');

		exit();
	}

	ob_end_flush(); // Release The Output

?>