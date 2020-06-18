<?php

	/*
	================================================
	== Manage Members Page
	== You Can Add | Edit | Delete Members From Here
	================================================
	*/

	ob_start(); // Output Buffering Start

	session_start();

	$pageTitle = 'Members';

	if (isset($_SESSION['Username'])) {

		include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		// Start Manage Page

		if ($do == 'Manage') { // Manage Members Page

			$query = '';

			if (isset($_GET['page']) && $_GET['page'] == 'Pending') {

				$query = 'AND RegStatus = 0';

			}

			// Select All Users Except Admin 

			$stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query ORDER BY UserID DESC");

			// Execute The Statement

			$stmt->execute();

			// Assign To Variable 

			$rows = $stmt->fetchAll();

			if (! empty($rows)) {

			?>

			<h1 class="text-center">أدارة المستخدمين</h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table manage-members text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td>الصورة</td>
							<td>أسم المستخدم</td>
							<td>الايميل</td>
							<td>الاسم الكامل</td>
							<td>تأريخ الانظمام</td>
							<td>التحكم</td>
						</tr>
						<?php
							foreach($rows as $row) {
								echo "<tr>";
									echo "<td>" . $row['UserID'] . "</td>";
									echo "<td>";
									if (empty($row['avatar'])) {
										echo 'لا يوجد صورة';
									} else {
										echo "<img src='../uploads/avatars/" . $row['avatar'] . "' alt='' />";
									}
									echo "</td>";

									echo "<td><a href='members.php?do=show&userid=" . $row['UserID'] . "'>" . $row['Username'] . "</a></td>";
									echo "<td>" . $row['Email'] . "</td>";
									echo "<td>" . $row['FullName'] . "</td>";
									echo "<td>" . $row['Date'] ."</td>";
									echo "<td>
										<a href='members.php?do=Edit&userid=" . $row['UserID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> تعديل</a>
										<a href='members.php?do=Delete&userid=" . $row['UserID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> حدف </a>";
										if ( $row['RegStatus'] == 0 && $row['Submit'] == 1) {
											echo "<a 
													href='members.php?do=Activate&userid=" . $row['UserID'] . "' 
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
				<a href="members.php?do=Add" class="btn btn-primary">
					<i class="fa fa-plus"></i> أضافة مستخدم 
				</a>
			</div>

			<?php } else {

				echo '<div class="container">';
					echo '<div class="nice-message">لا يوجد اي مستخدم</div>';
					echo '<a href="members.php?do=Add" class="btn btn-primary">
							<i class="fa fa-plus"></i>مستخدم جديد
						</a>';
				echo '</div>';

			} ?>

		<?php 

		} elseif ($do == 'Add') { // Add Page ?>

			<h1 class="text-center">أضافة مستخدم جديد</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
					<!-- Start Username Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">أسم المستخدم</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="ادخل اسم المستخدم" />
						</div>
					</div>
					<!-- End Username Field -->
					<!-- Start Password Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">كلمة المرور</label>
						<div class="col-sm-10 col-md-6">
							<input type="password" name="password" class="password form-control" required="required" autocomplete="new-password" placeholder="ادخل كلمة مرور قوية" />
							<i class="show-pass fa fa-eye fa-2x"></i>
						</div>
					</div>
					<!-- End Password Field -->
					<!-- Start Email Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">البرد</label>
						<div class="col-sm-10 col-md-6">
							<input type="email" name="email" class="form-control" required="required" placeholder="أدخل البريد الالكتروني" />
						</div>
					</div>
					<!-- End Email Field -->
					<!-- Start Full Name Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">الاسم الكامل</label>
						<div class="col-sm-10 col-md-6">
							<input type="text" name="full" class="form-control" required="required" placeholder="ادخل اسم الكامل " />
						</div>
					</div>
					<!-- End Full Name Field -->
					<!-- Start Avatar Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">الصورة المصغرة</label>
						<div class="col-sm-10 col-md-6">
							<input type="file" name="avatar" class="form-control" required="required" />
						</div>
					</div>
					<!-- End Avatar Field -->
					<!-- Start Submit Field -->
					<div class="form-group form-group-lg">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="اضافة مستخدم" class="btn btn-primary btn-lg" />
						</div>
					</div>
					<!-- End Submit Field -->
				</form>
			</div>

		<?php 

		} elseif ($do == 'Insert') {

			// Insert Member Page

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				echo "<h1 class='text-center'>أضافة   مستخدم</h1>";
				echo "<div class='container'>";

				// Upload Variables

				$avatarName = $_FILES['avatar']['name'];
				$avatarSize = $_FILES['avatar']['size'];
				$avatarTmp	= $_FILES['avatar']['tmp_name'];
				$avatarType = $_FILES['avatar']['type'];

				// List Of Allowed File Typed To Upload

				$avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");

				// Get Avatar Extension
				
					$tmp           = explode('.', $avatarName);
				$avatarExtension = strtolower( end($tmp));

				
			

				// Get Variables From The Form

				$user 	= $_POST['username'];
				$pass 	= $_POST['password'];
				$email 	= $_POST['email'];
				$name 	= $_POST['full'];

				$hashPass = sha1($_POST['password']);

				// Validate The Form

				$formErrors = array();

				if (strlen($user) < 4) {
					$formErrors[] = 'يجب ان لا يقل اسم المستخدم عن <strong>4 احرف</strong>';
				}

				if (strlen($user) > 20) {
					$formErrors[] = 'يجب ان لا يزيد اسم المستخدم عن <strong>20 حرف</strong>';
				}

				if (empty($user)) {
					$formErrors[] = ' لا يمكن ان يكون اسم المستخدم<strong>فارغ</strong>';
				}

				if (empty($pass)) {
					$formErrors[] = 'لا يمكن ان تكون كلمة المرور  <strong>فارغ</strong>';
				}

				if (empty($name)) {
					$formErrors[] = 'لا يمكن اي يكون الاسم الكامل <strong>فارغ</strong>';
				}

				if (empty($email)) {
					$formErrors[] = 'لا يمكن ان يكون البريد <strong>فارغ</strong>';
				}

				if (! empty($avatarName) && ! in_array($avatarExtension, $avatarAllowedExtension)) {
					$formErrors[] = 'امتداد الصورة المستخدم غير <strong>متاح</strong>';
				}

				if (empty($avatarName)) {
					$formErrors[] = 'صورة المستخدم يجب  <strong>رفعها</strong>';
				}

				if ($avatarSize > 4194304) {
					$formErrors[] = 'لا يمكن رفع صورة المستخدم اكبر من  <strong>4MB</strong>';
				}

				// Loop Into Errors Array And Echo It

				foreach($formErrors as $error) {
					echo '<div class="alert alert-danger">' . $error . '</div>';
				}

				// Check If There's No Error Proceed The Update Operation

				if (empty($formErrors)) {

					$avatar = rand(0, 10000000000) . '_' . $avatarName;

					move_uploaded_file($avatarTmp, "uploads\avatars\\" . $avatar);

					// Check If User Exist in Database

					$check = checkItem("Username", "users", $user);

					if ($check == 1) {

						$theMsg = '<div class="alert alert-danger">المعدرة هدا المستخدم موجود با الفعل </div>';

						redirectHome($theMsg, 'back');

					} else {

						// Insert Userinfo In Database

						$stmt = $con->prepare("INSERT INTO 
													users(Username, Password, Email, FullName, RegStatus, Date, avatar)
												VALUES(:zuser, :zpass, :zmail, :zname, 1, now(), :zavatar) ");
						$stmt->execute(array(

							'zuser' 	=> $user,
							'zpass' 	=> $hashPass,
							'zmail' 	=> $email,
							'zname' 	=> $name,
							'zavatar'	=> $avatar

						));

						// Echo Success Message

						$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' تمت العملية بنجاح </div>';

						redirectHome($theMsg, 'back');

					}

				}


			} else {

				echo "<div class='container'>";

				$theMsg = '<div class="alert alert-danger">لا يمكن الدخول الي هدة الصفحة بدون ركوست</div>';

				redirectHome($theMsg);

				echo "</div>";

			}

			echo "</div>";

		} elseif ($do == 'Edit') {

			// Check If Get Request userid Is Numeric & Get Its Integer Value

			$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

			// Select All Data Depend On This ID

			$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

			// Execute Query

			$stmt->execute(array($userid));

			// Fetch The Data

			$row = $stmt->fetch();
			
			//print_r($row);

			// The Row Count

			$count = $stmt->rowCount();

			// If There's Such ID Show The Form

			if ($count > 0) { ?>

				<h1 class="text-center">تعديل المستخدم</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Update" method="POST">
						<input type="hidden" name="userid" value="<?php echo $userid ?>" />
						<!-- Start Username Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">اسم المستخدم</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="username" class="form-control" value="<?php echo $row['Username'] ?>" autocomplete="off" required="required" />
							</div>
						</div>
						<!-- End Username Field -->
						<!-- Start Password Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">كلمة المرور</label>
							<div class="col-sm-10 col-md-6">
								<input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>" />
								<input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="كلمة المرور" />
							</div>
						</div>
						<!-- End Password Field -->
						<!-- Start Email Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">البريد</label>
							<div class="col-sm-10 col-md-6">
								<input type="email" name="email" value="<?php echo $row['Email'] ?>" class="form-control" required="required" />
							</div>
						</div>
						<!-- End Email Field -->
						<!-- Start Full Name Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">الاسم الكامل</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="full" value="<?php echo $row['FullName'] ?>" class="form-control" required="required" />
							</div>
						</div>
						<!-- End Full Name Field -->
						<!-- Start Submit Field -->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="حفظ" class="btn btn-primary btn-lg" />
							</div>
						</div>
						<!-- End Submit Field -->
					</form>
				</div>

			<?php

			// If There's No Such ID Show Error Message

			} else {

				echo "<div class='container'>";

				$theMsg = '<div class="alert alert-danger">ان ID غير صحيح</div>';

				redirectHome($theMsg);

				echo "</div>";

			}

		} elseif ($do == 'Update') { // Update Page

			echo "<h1 class='text-center'>رفع المستخدم</h1>";
			echo "<div class='container'>";

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				// Get Variables From The Form

				$id 	= $_POST['userid'];
				$user 	= $_POST['username'];
				$email 	= $_POST['email'];
				$name 	= $_POST['full'];

				// Password Trick

				$pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

				// Validate The Form

				$formErrors = array();

				if (strlen($user) < 4) {
					$formErrors[] = 'لا يمكن ان يقل اسم المستخدم عن <strong>4 احرف</strong>';
				}

				if (strlen($user) > 20) {
					$formErrors[] = 'لا يمكن ان يزيد اسم المستخدم عن <strong>20 حرف</strong>';
				}

				if (empty($user)) {
					$formErrors[] = 'لا يمكن ان يكون اسم المستخدم <strong>فارغ</strong>';
				}

				if (empty($name)) {
					$formErrors[] = 'لا يمكن ان يكون الاسم الكامل  <strong>فارغ</strong>';
				}

				if (empty($email)) {
					$formErrors[] = 'لا يمكن ان يكون الايمل <strong>فارغ</strong>';
				}

				// Loop Into Errors Array And Echo It

				foreach($formErrors as $error) {
					echo '<div class="alert alert-danger">' . $error . '</div>';
				}

				// Check If There's No Error Proceed The Update Operation

				if (empty($formErrors)) {

					$stmt2 = $con->prepare("SELECT 
												*
											FROM 
												users
											WHERE
												Username = ?
											AND 
												UserID != ?");

					$stmt2->execute(array($user, $id));

					$count = $stmt2->rowCount();

					if ($count == 1) {

						$theMsg = '<div class="alert alert-danger">أسم المستخدم هدا موجود با الفعل</div>';

						redirectHome($theMsg, 'back');

					} else { 

						// Update The Database With This Info

						$stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ?, Password = ? WHERE UserID = ?");

						$stmt->execute(array($user, $email, $name, $pass, $id));

						// Echo Success Message

						$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' تمت العملية بنجاح</div>';

						redirectHome($theMsg, 'back');

					}

				}

			} else {

				$theMsg = '<div class="alert alert-danger">لا يمكن الدخول الي هدة الصفحة بدون ركوست</div>';

				redirectHome($theMsg);

			}

			echo "</div>";

		} elseif ($do == 'Delete') { // Delete Member Page

			echo "<h1 class='text-center'>حدف اسم مستخدم</h1>";
			echo "<div class='container'>";

				// Check If Get Request userid Is Numeric & Get The Integer Value Of It

				$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

				// Select All Data Depend On This ID

				$check = checkItem('userid', 'users', $userid);

				// If There's Such ID Show The Form

				if ($check > 0) {

					$stmt = $con->prepare("DELETE FROM users WHERE UserID = :zuser");

					$stmt->bindParam(":zuser", $userid);

					$stmt->execute();

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' تم الحدف بنجاح</div>';

					redirectHome($theMsg, 'back');

				} else {

					$theMsg = '<div class="alert alert-danger">هدا ال ID غير متوفر</div>';

					redirectHome($theMsg);

				}

			echo '</div>';

		} elseif ($do == 'Activate') {

			echo "<h1 class='text-center'> تفعيل المستخدم</h1>";
			echo "<div class='container'>";

				// Check If Get Request userid Is Numeric & Get The Integer Value Of It

				$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

				// Select All Data Depend On This ID

				$check = checkItem('userid', 'users', $userid);

				// If There's Such ID Show The Form

				if ($check > 0) {

					$stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");

					$stmt->execute(array($userid));
					
					
					
					
					
					
				// Set Notifications
			$infor =  'مبروك تم قبولك طلب تحويل الي أسرة منتجة الان يمكن أضافة طبخاتك الخاصة <a href="'.$actual_link.'newad"><span>أضافة طبخة  </span></a>';		
		
				$notifications = $con->prepare("INSERT INTO 

					notifications(notifications_Info, notifications_Type, notifications_Date, notifications_Status, notifications_UserID , notifications_SendID)

					VALUES(:zInfo, :zType, now(), :zStatus, :zUserID, :zSendID)");

				$notifications->execute(array(

					'zInfo' 	=> $infor,
					'zType' 	=> '0',
					'zStatus' 	=> '0',
					'zUserID' 	=> $userid,
					'zSendID'		=> $_SESSION['uid']

				));
		
		
			// end notifications
					
					
					

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' تم تفعيل بنجاح</div>';

					redirectHome($theMsg);
					
					

				} else {

					$theMsg = '<div class="alert alert-danger">هدا ID غير متوفر</div>';

					redirectHome($theMsg);

				}

			echo '</div>';

		} else if ($do == 'show') {
			
			
			echo "<h1 class='text-center'> عرض بيانات المستخدم </h1>";
			echo "<div class='container'>";

				// Check If Get Request userid Is Numeric & Get The Integer Value Of It

				$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

				// Select All Data Depend On This ID

				$check = checkItem('userid', 'users', $userid);

				// If There's Such ID Show The Form

				if ($check > 0) {


					
					$getuserr = $con->prepare("SELECT * FROM users WHERE UserID = ?");
						// Execute Query

						$getuserr->execute(array($userid));

						// Fetch The Data Username

						$getuserrAll = $getuserr->fetch(); ?>
					
					
					<div class="information block">
						<div class="container">
							<div class="panel panel-primary">
								<div class="panel-heading">المعلومات العامة</div>
								<div class="panel-body ">
									<ul class="list-unstyled">
										<li>
											<i class="fa fa-unlock-alt fa-fw"></i>
											<span>اسم المستخدم</span> : <a href="../user.php?user=<?= $getuserrAll['Username'] ?>"> 	<?= $getuserrAll['Username'] ?>				</a></li>
										<li>
											<i class="fa fa-envelope-o fa-fw"></i>
											<span>البريد</span> : <?= $getuserrAll['Email'] ?>					</li>
										<li>
											<i class="fa fa-user fa-fw"></i>
											<span>الاسم الكامل </span> : <?= $getuserrAll['FullName'] ?>					</li>
										<li>
											<i class="fa fa-calendar fa-fw"></i>
											<span>تأريخ الاشتراك</span> : <?= $getuserrAll['Date'] ?>					</li>
										<li>
											<i class="fa fa-map-pin"></i>

											<span>العنوان </span> : <?= $getuserrAll['address'] ?>
										</li> 			
										<li>
											<i class="fa fa-phone"></i>

											<span>الهاتف  </span> : <?= $getuserrAll['TelephoneNumber'] ?>
										</li> 
										<li>
											<i class="fa fa-credit-card"></i>

											<span>رقم الهوية </span> : <?= $getuserrAll['IdentificationNumber'] ?>
										</li> 
										<li>
											<i class="fa fa-institution"></i>

											<span>رقم الحساب البنكي </span> : <?= $getuserrAll['Banknumber'] ?>
										</li> 
										<li>
											<i class="fa fa-map-signs"></i>

											<span>عنوان المدينة </span> : <?= $getuserrAll['userCity'] ?>
										</li> 
										<li>
											<i class="fa fa-hashtag"></i>

											<span>عنوان المحافظة </span> : <?= $getuserrAll['userGovernorate'] ?>
										</li> 
										<li>
											<i class="fa fa-file-zip-o"></i>

											<span>رابط ملف الشهادة </span> : <a target="_blank" href="../uploads/certificatefile/<?= $getuserrAll['Certificatefile'] ?>">تحميل ومشاهدة</a>
										</li> 

										<li >
										<i class="fa fa-circle "></i>    آخر تواجد  :<span id="OnlineUser"><?= checkOnlineUser($getuserrAll['UserID']); ?></span>

										</li>
										<li>
											<i class="fa fa-flag"></i>


											<span>تقديم طلب تحويل</span> : <?php 
											if ($getuserrAll['Submit'] == 0) {
												echo 'لم يقدم بعد ';
											}else {
												echo 'قدم طلب' ;
											}
					
											?>
										</li> 
										<li>
											<i class="fa fa-shield"></i>


											<span>رتبة البائع </span> : <?php 
											setTrustStaus($getuserrAll['TrustStatus']);
					
										?>
										</li> 
									</ul>
									<a href="?do=Edit&userid=<?=$getuserrAll['UserID'] ?>" class="btn btn-default">تعديل المعلومات </a>
								</div>
								<div class="fkssdf">
									<div class="thumbnail item-box"><img class="img-responsive" src="../uploads/avatars/<?php echo !empty($getuserrAll['avatar'])? $getuserrAll['avatar'] :  'avatarbufolt.png' ;?>" alt="">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="my-ads" class="my-ads block">
						<div class="container">
							<div class="panel panel-primary">
								<div class="panel-heading">طبخات خاصة به</div>
								<div class="panel-body">
								<div class="row">
									<?php
									$ghamdan = $getuserrAll['UserID'];
									$myItems = getAllFrom("*", "items", "where Member_ID = $ghamdan", "", "Item_ID");
									foreach ($myItems as $item) {
										
										$emages = 	explode('|', $item['Image']);
									?>
									<div class="col-sm-6 col-md-3">
										<div class="thumbnail item-box">
											<span class="price-tag"><?php echo $item['Price'] ; ?>  ريال</span>
											<img class="img-responsive" src="../uploads/items/<?= $emages[0] ?>" alt="">
											<div class="caption">
												<h3>
													<a href="../items.php?itemid=<?php echo $item['Item_ID']; ?>"><?php echo $item['Name']; ?></a>
												</h3>
												<p><?= $item['Description'] ?></p>
												<div class="date"><?= $item['Add_Date'] ?></div>
											</div>
										</div>
									</div>
									<?php } ?>
										
								</div>			
								</div>
							</div>
						</div>
					</div>	
					

					
					
					
			<?php		
				} else {

					$theMsg = '<div class="alert alert-danger">هدا ID غير متوفر</div>';

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