<?php

	ob_start(); // Output Buffering Start

	session_start();

	if (isset($_SESSION['Username'])) {

		$pageTitle = 'لوحة تحكم';

		include 'init.php';

		/* Start Dashboard Page */

		$numUsers = 6; // Number Of Latest Users

		$latestUsers = getLatest("*", "users", "UserID", $numUsers); // Latest Users Array

		$numItems = 6; // Number Of Latest Items

		$latestItems = getLatest("*", 'items', 'Item_ID', $numItems); // Latest Items Array

		$numComments = 4;
		$numContact = 4;

		?>

		<div class="home-stats">
			<div class="container text-center">
				<h1>لوحة التحكم</h1>
				<div class="row">
					<div class="col-md-2">
						<div class="stat st-members">
							<i class="fa fa-users"></i>
							<div class="info">
								عدد المستخدمين
								<span>
									<a href="members.php"><?php echo countItems('UserID', 'users') ?></a>
								</span>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="stat st-pending">
							<i class="fa fa-user-plus"></i>
							<div class="info">
								المستخدمين قيد التفعيل 
								<span>
									<a href="members.php?do=Manage&page=Pending">
										<?php 
			
									
								$statement = $con->prepare("SELECT RegStatus, Submit  FROM users WHERE Submit = 1 AND RegStatus = ?");

								$statement->execute(array(0));

								$count = $statement->rowCount();

								echo $count;
			
			
			 ?>
										
										
										
									</a>
								</span>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="stat st-items">
							<i class="fa fa-tag"></i>
							<div class="info">
								عدد الوجبات 
								<span>
									<a href="items.php"><?php echo countItems('Item_ID', 'items') ?></a>
								</span>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="stat st-comments">
							<i class="fa fa-comments"></i>
							<div class="info">
								عدد التعليقات
								<span>
									<a href="comments.php"><?php echo countItems('c_id', 'comments') ?></a>
								</span>
							</div>
						</div>
					</div>					
					<div class="col-md-2">
						<div class="stat st-contact">
							<i class="fa fa-bullhorn"></i>
							<div class="info">
								الرسائل الادارية
								<span>
									<a href="contact.php"><?php echo countItems('ID', 'contact') ?></a>
								</span>
							</div>
						</div>
					</div>					
					<div class="col-md-2">
						<div class="stat st-cart">
							<i class="fa fa-bar-chart-o"></i>
							<div class="info">
								 الرصيد الكلي 
								<span>
									<a href="comments.php"><?php echo 0 ?> ريال </a>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="latest">
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="fa fa-users"></i> 
								اخر <?php echo $numUsers ?> مستخدمين مسجلين 
								<span class="toggle-info pull-right">
									<i class="fa fa-plus fa-lg"></i>
								</span>
							</div>
							<div class="panel-body">
								<ul class="list-unstyled latest-users">
								<?php
									if (! empty($latestUsers)) {
										foreach ($latestUsers as $user) {
											echo '<li>';
												echo $user['Username'];
												echo '<a href="members.php?do=Edit&userid=' . $user['UserID'] . '">';
													echo '<span class="btn btn-success pull-right">';
														echo '<i class="fa fa-edit"></i> تعديل';
														if ($user['RegStatus'] == 0 && $user['Submit'] == 1) {
															echo "<a 
																	href='members.php?do=Activate&userid=" . $user['UserID'] . "' 
																	class='btn btn-info pull-right activate'>
																	<i class='fa fa-check'></i> تفعيل</a>";
														}
													echo '</span>';
												echo '</a>';
											echo '</li>';
										}
									} else {
										echo 'لا يوجد اي مستخدم الي الان';
									}
								?>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="fa fa-tag"></i> اخر  <?php echo $numItems ?> وجبات مضافة 
								<span class="toggle-info pull-right">
									<i class="fa fa-plus fa-lg"></i>
								</span>
							</div>
							<div class="panel-body">
								<ul class="list-unstyled latest-users">
									<?php
										if (! empty($latestItems)) {
											foreach ($latestItems as $item) {
												echo '<li>';
													echo $item['Name'];
													echo '<a href="items.php?do=Edit&itemid=' . $item['Item_ID'] . '">';
														echo '<span class="btn btn-success pull-right">';
															echo '<i class="fa fa-edit"></i> تحرير';
															if ($item['Approve'] == 0) {
																echo "<a 
																		href='items.php?do=Approve&itemid=" . $item['Item_ID'] . "' 
																		class='btn btn-info pull-right activate'>
																		<i class='fa fa-check'></i> تفعيل</a>";
															}
														echo '</span>';
													echo '</a>';
												echo '</li>';
											}
										} else {
											echo 'لا يوجد اي وجبات مضافة الي الان';
										}
									?>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<!-- Start Latest Comments -->
				<div class="row">
					<div class="col-sm-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="fa fa-comments-o"></i> 
								أخر  <?php echo $numComments ?> تعليقات  
								<span class="toggle-info pull-right">
									<i class="fa fa-plus fa-lg"></i>
								</span>
							</div>
							<div class="panel-body">
								<?php
									$stmt = $con->prepare("SELECT 
																comments.*, users.Username AS Member  
															FROM 
																comments
															INNER JOIN 
																users 
															ON 
																users.UserID = comments.user_id
															ORDER BY 
																c_id DESC
															LIMIT $numComments");

									$stmt->execute();
									$comments = $stmt->fetchAll();

									if (! empty($comments)) {
										foreach ($comments as $comment) {
											echo '<div class="comment-box">';
												echo '<span class="member-n">
													<a href="members.php?do=Edit&userid=' . $comment['user_id'] . '">
														' . $comment['Member'] . '</a></span>';
												echo '<p class="member-c">' . $comment['comment'] . '</p>';
											echo '</div>';
										}
									} else {
										echo 'لا يوجد اي تعليق الي الان';
									}
								?>
							</div>
						</div>
					</div>
						<div class="col-sm-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="fa fa-comments-o"></i> 
								أخر  <?php echo $numContact ?> رسائل   
								<span class="toggle-info pull-right">
									<i class="fa fa-plus fa-lg"></i>
								</span>
							</div>
							<div class="panel-body">
								<?php
									$stmt = $con->prepare("SELECT contact.*, users.Username AS Member, users.UserID AS MemberUserID FROM contact INNER JOIN users ON users.UserID = contact.userIDMass or contact.userIDMass = 0 ORDER BY ID DESC LIMIT $numContact");

									$stmt->execute();
									$Contact = $stmt->fetchAll();
			
									

									if (! empty($Contact)) {
										foreach ($Contact as $mas) {
											
											
											
											echo '<div class="comment-box">';
												echo '<span class="member-n">
													<a href="members.php?do=Edit&userid= ">' ;
											if ($mas['userIDMass'] == 0) {
												echo $mas['uesrName'];
											} else if ($mas['userIDMass'] == $mas['MemberUserID']) {
												echo $mas['Member']; }
											
											echo  '</a></span>';
												echo '<p class="member-c">' . $mas['message'] . '</p>';
											echo '</div>';
										}
									} else {
										echo 'لا يوجد اي رسالة جديدة ';
									}
								?>
							</div>
						</div>
					</div>
				</div>
				<!-- End Latest Comments -->
			</div>
		</div>

		<?php

		/* End Dashboard Page */

		include $tpl . 'footer.php';

	} else {

		header('Location: index.php');

		exit();
	}

	ob_end_flush(); // Release The Output

?>