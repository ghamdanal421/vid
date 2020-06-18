<?php

	/*
	================================================
	== Manage Comments Page
	== You Can Edit | Delete | Approve Comments From Here
	================================================
	*/

	ob_start(); // Output Buffering Start

	session_start();

	$pageTitle = 'Comments';

	if (isset($_SESSION['Username'])) {

		include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		// Start Manage Page

		if ($do == 'Manage') { // Manage Members Page

			// Select All Users Except Admin 

			$stmt = $con->prepare("SELECT 
										comments.*, items.Name AS Item_Name, users.Username AS Member  
									FROM 
										comments
									INNER JOIN 
										items 
									ON 
										items.Item_ID = comments.item_id
									INNER JOIN 
										users 
									ON 
										users.UserID = comments.user_id
									ORDER BY 
										c_id DESC");

			// Execute The Statement

			$stmt->execute();

			// Assign To Variable 

			$comments = $stmt->fetchAll();

			if (! empty($comments)) {

			?>

			<h1 class="text-center">أدارة التعليقات </h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>ID</td>
							<td>التعليق</td>
							<td>التقيم</td>
							<td>أسم الدبخة</td>
							<td>أسم المستخدم </td>
							<td>ـاريخ الاضافة </td>
							<td>التحكم</td>
						</tr>
						<?php
							foreach($comments as $comment) {
								echo "<tr>";
									echo "<td>" . $comment['c_id'] . "</td>";
									echo "<td>" ;
								if ($comment['added']== "1") {
									echo '<i class="fa fa-thumbs-up"></i>';
								}else {
									echo '<i class="fa fa-thumbs-down"></i>';
								}
								echo "</td>";
									echo "<td>" . $comment['comment'] . "</td>";
									echo "<td>" . $comment['Item_Name'] . "</td>";
									echo "<td>" . $comment['Member'] . "</td>";
									echo "<td>" . $comment['comment_date'] ."</td>";
									echo "<td>
										<a href='comments.php?do=Edit&comid=" . $comment['c_id'] . "' class='btn btn-success'><i class='fa fa-edit'></i> تحرير</a>
										<a href='comments.php?do=Delete&comid=" . $comment['c_id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> حدف </a>";
										if ($comment['status'] == 0) {
											echo "<a href='comments.php?do=Approve&comid="
													 . $comment['c_id'] . "' 
													class='btn btn-info activate'>
													<i class='fa fa-check'></i> تفعيل</a>";
										}
									echo "</td>";
								echo "</tr>";
							}
						?>
						<tr>
					</table>
				</div>
			</div>

			<?php } else {

				echo '<div class="container">';
					echo '<div class="nice-message">لا يوجد اي تعليق </div>';
				echo '</div>';

			} ?>

		<?php 

		} elseif ($do == 'Edit') {

			// Check If Get Request comid Is Numeric & Get Its Integer Value

			$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

			// Select All Data Depend On This ID

			$stmt = $con->prepare("SELECT * FROM comments WHERE c_id = ?");

			// Execute Query

			$stmt->execute(array($comid));

			// Fetch The Data

			$row = $stmt->fetch();

			// The Row Count

			$count = $stmt->rowCount();

			// If There's Such ID Show The Form

			if ($count > 0) { ?>

				<h1 class="text-center">Edit Comment</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Update" method="POST">
						<input type="hidden" name="comid" value="<?php echo $comid ?>" />
						<!-- Start Comment Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Comment</label>
							<div class="col-sm-10 col-md-6">
								<textarea class="form-control" name="comment"><?php echo $row['comment'] ?></textarea>
							</div>
						</div>
						<!-- End Comment Field -->
						<!-- Start Submit Field -->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Save" class="btn btn-primary btn-sm" />
							</div>
						</div>
						<!-- End Submit Field -->
					</form>
				</div>

			<?php

			// If There's No Such ID Show Error Message

			} else {

				echo "<div class='container'>";

				$theMsg = '<div class="alert alert-danger">الا يوجد اي تعليق بهدا الاي دي</div>';

				redirectHome($theMsg);

				echo "</div>";

			}

		} elseif ($do == 'Update') { // Update Page

			echo "<h1 class='text-center'>رفع التعليق</h1>";
			echo "<div class='container'>";

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				// Get Variables From The Form

				$comid 		= $_POST['comid'];
				$comment 	= $_POST['comment'];

				// Update The Database With This Info

				$stmt = $con->prepare("UPDATE comments SET comment = ? WHERE c_id = ?");

				$stmt->execute(array($comment, $comid));

				// Echo Success Message

				$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' تم تعديل </div>';

				redirectHome($theMsg, 'back');

			} else {

				$theMsg = '<div class="alert alert-danger">لا يمدكن الدخول الي هدة الصفحة بدون ركوست</div>';

				redirectHome($theMsg);

			}

			echo "</div>";

		} elseif ($do == 'Delete') { // Delete Page

			echo "<h1 class='text-center'>حدف تعليق</h1>";

			echo "<div class='container'>";

				// Check If Get Request comid Is Numeric & Get The Integer Value Of It

				$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

				// Select All Data Depend On This ID

				$check = checkItem('c_id', 'comments', $comid);

				// If There's Such ID Show The Form

				if ($check > 0) {

					$stmt = $con->prepare("DELETE FROM comments WHERE c_id = :zid");

					$stmt->bindParam(":zid", $comid);

					$stmt->execute();

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' تم حدف </div>';

					redirectHome($theMsg, 'back');

				} else {

					$theMsg = '<div class="alert alert-danger">لا يوجد اي دي بهدا الرقم</div>';

					redirectHome($theMsg);

				}

			echo '</div>';

		} elseif ($do == 'Approve') {

			echo "<h1 class='text-center'>تفعيل التعليق</h1>";
			echo "<div class='container'>";

				// Check If Get Request comid Is Numeric & Get The Integer Value Of It

				$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

				// Select All Data Depend On This ID

				$check = checkItem('c_id', 'comments', $comid);

				// If There's Such ID Show The Form

				if ($check > 0) {

					$stmt = $con->prepare("UPDATE comments SET status = 1 WHERE c_id = ?");

					$stmt->execute(array($comid));

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' تم تفعيل</div>';

					redirectHome($theMsg, 'back');

				} else {

					$theMsg = '<div class="alert alert-danger">لا يوجد اي تعليق بهدا الاي دي</div>';

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