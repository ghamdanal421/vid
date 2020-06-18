<?php

	/*
	================================================
	== Items Page
	================================================
	*/

	ob_start(); // Output Buffering Start

	session_start();

	$pageTitle = 'Items';

	if (isset($_SESSION['Username'])) {

		include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		if ($do == 'Manage') {


			$stmt = $con->prepare("SELECT 
										items.*, 
										categories.Name AS category_name, 
										users.Username 
									FROM 
										items
									INNER JOIN 
										categories 
									ON 
										categories.ID = items.Cat_ID 
									INNER JOIN 
										users 
									ON 
										users.UserID = items.Member_ID
									ORDER BY 
										Item_ID DESC");

			// Execute The Statement

			$stmt->execute();

			// Assign To Variable 

			$items = $stmt->fetchAll();

			if (! empty($items)) {

			?>

			<h1 class="text-center">لوحة تحكم في الاوجبات  </h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td>أسم الوجبة</td>
							<td>وصف الوجبة</td>
							<td>السعر</td>
							<td>تاريخ الاضافة </td>
							<td>القسم </td>
							<td>أسم المضيف</td>
							<td>التحكم</td>
						</tr>
						<?php
							foreach($items as $item) {
								echo "<tr>";
									echo "<td>" . $item['Item_ID'] . "</td>";
									echo "<td>" . $item['Name'] . "</td>";
									echo "<td class='max-wte'>" . $item['Description'] . "</td>";
									echo "<td>" . $item['Price'] . "</td>";
									echo "<td>" . $item['Add_Date'] ."</td>";
									echo "<td>" . $item['category_name'] ."</td>";
									echo "<td>" . $item['Username'] ."</td>";
									echo "<td>
										<a href='items.php?do=Edit&itemid=" . $item['Item_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> تعديل</a>
										<a href='items.php?do=Delete&itemid=" . $item['Item_ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> حدف </a>";
										if ($item['Approve'] == 0) {
											echo "<a 
													href='items.php?do=Approve&itemid=" . $item['Item_ID'] . "' 
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
					echo '<div class="nice-message">لا يوجد اي وجبة </div>';
					echo '';
				echo '</div>';

			} ?>

		<?php 

		} elseif ($do == 'Add') { ?>

			<h1 class="text-center">أضافة وجبة جديدة</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=Insert" method="POST">
					<!-- Start Name Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">الاسم </label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="name" 
								class="form-control" 
								required="required"  
								placeholder="أدخل الاسم الجديد" />
						</div>
					</div>
					<!-- End Name Field -->
					<!-- Start Description Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">وصف الوجبة</label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="description" 
								class="form-control" 
								required="required"  
								placeholder="ادخل وصف الطبخة" />
						</div>
					</div>
					<!-- End Description Field -->
					<!-- Start Price Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">السعر</label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="number" 
								name="price" 
								class="form-control" 
								required="required" 
								placeholder="ادخل السعر رقم" />
						</div>
					</div>
					<!-- End Price Field -->
					<!-- Start Members Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">اسم المستخدم</label>
						<div class="col-sm-10 col-md-6">
							<select name="member">
								<option value="0">...</option>
								<?php
									$allMembers = getAllFrom("*", "users", "", "", "UserID");
									foreach ($allMembers as $user) {
										echo "<option value='" . $user['UserID'] . "'>" . $user['Username'] . "</option>";
									}
								?>
							</select>
						</div>
					</div>
					<!-- End Members Field -->
					<!-- Start Categories Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">القسم </label>
						<div class="col-sm-10 col-md-6">
							<select name="category">
								<option value="0">...</option>
								<?php
									$allCats = getAllFrom("*", "categories", "where parent = 0", "", "ID");
									foreach ($allCats as $cat) {
										echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
										$childCats = getAllFrom("*", "categories", "where parent = {$cat['ID']}", "", "ID");
										foreach ($childCats as $child) {
											echo "<option value='" . $child['ID'] . "'>--- " . $child['Name'] . "</option>";
										}
									}
								?>
							</select>
					</div>
					</div>
					<!-- End Categories Field -->
					<!-- Start Tags Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">الوسوم</label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="tags" 
								class="form-control" 
								placeholder="ادخل اسم التجات وفصل بينهم با  (,)" />
						</div>
					</div>
					<!-- End Tags Field -->
					<!-- Start Submit Field -->
					<div class="form-group form-group-lg">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="أضافة " class="btn btn-primary btn-sm" />
						</div>
					</div>
					<!-- End Submit Field -->
				</form>
			</div>

			<?php

		} elseif ($do == 'Insert') {

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				echo "<h1 class='text-center'>أضافة الوجبة</h1>";
				echo "<div class='container'>";

				// Get Variables From The Form

				$name		= $_POST['name'];
				$desc 		= $_POST['description'];
				$price 		= $_POST['price'];
				$ingredients 	= $_POST['ingredients'];
				$status 	= $_POST['status'];
				$member 	= $_POST['member'];
				$cat 		= $_POST['category'];
				$tags 		= $_POST['tags'];

				// Validate The Form

				$formErrors = array();

				if (empty($name)) {
					$formErrors[] = 'لا يمكن ان يكون الاسم الوجبة<strong>فارغ</strong>';
				}

				if (empty($desc)) {
					$formErrors[] = 'لا يمكن ان كون وصف الوجبة  <strong>فارغ</strong>';
				}

				if (empty($price)) {
					$formErrors[] = 'لا يمكن ان يكون سعر الوجبة <strong>فارغ</strong>';
				}

				if (empty($ingredients)) {
					$formErrors[] = 'لا يمكن ان يكون مكونات الوجبة <strong>فارغ</strong>';
				}

				if ($status == 0) {
					$formErrors[] = 'لا يمكن ان تكون الحالة غير <strong>مفعلة</strong>';
				}

				if ($member == 0) {
					$formErrors[] = 'يجب تحديد  <strong>أسم مستخدم</strong>';
				}

				if ($cat == 0) {
					$formErrors[] = 'يجب تحديد <strong>القسم</strong>';
				}

				// Loop Into Errors Array And Echo It

				foreach($formErrors as $error) {
					echo '<div class="alert alert-danger">' . $error . '</div>';
				}

				// Check If There's No Error Proceed The Update Operation

				if (empty($formErrors)) {

					// Insert Userinfo In Database

					$stmt = $con->prepare("INSERT INTO 

						items(Name, Description, Price, ingredients, Status, Add_Date, Cat_ID, Member_ID, tags)

						VALUES(:zname, :zdesc, :zprice, :zingredients, :zstatus, now(), :zcat, :zmember, :ztags)");

					$stmt->execute(array(

						'zname' 	=> $name,
						'zdesc' 	=> $desc,
						'zprice' 	=> $price,
						'zingredients' 	=> $ingredients,
						'zstatus' 	=> $status,
						'zcat'		=> $cat,
						'zmember'	=> $member,
						'ztags'		=> $tags

					));

					// Echo Success Message

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' تم بنجاح </div>';

					redirectHome($theMsg, 'back');

				}

			} else {

				echo "<div class='container'>";

				$theMsg = '<div class="alert alert-danger">لا يمكن الدخول الي هدة الصفحة بدون ركوست/div>';

				redirectHome($theMsg);

				echo "</div>";

			}

			echo "</div>";

		} elseif ($do == 'Edit') {

			// Check If Get Request item Is Numeric & Get Its Integer Value

			$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

			// Select All Data Depend On This ID

			$stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ?");

			// Execute Query

			$stmt->execute(array($itemid));

			// Fetch The Data

			$item = $stmt->fetch();

			// The Row Count

			$count = $stmt->rowCount();

			// If There's Such ID Show The Form

			if ($count > 0) { ?>

				<h1 class="text-center">تحرير الطبخة</h1>
				<div class="container">

					<form class="form-horizontal" action="?do=Update" method="POST">

						<input type="hidden" name="itemid" value="<?php echo $itemid ?>" />
						<!-- Start Name Field -->
						<div class="form-group form-group-lg">
							<a  class="btn btn-primary " href="../items.php?itemid=<?= $itemid ?>">مشاهدة الطبخة</a>

							<label class="col-sm-2 control-label">الاسم</label>
							<div class="col-sm-10 col-md-6">
								<input 
									type="text" 
									name="name" 
									class="form-control" 
									required="required"  
									placeholder="أسم الطبخة"
									value="<?php echo $item['Name'] ?>" />
							</div>
						</div>
						<!-- End Name Field -->
						<!-- Start Description Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">الوصف </label>
							<div class="col-sm-10 col-md-6">
								<input 
									type="text" 
									name="description" 
									class="form-control" 
									required="required"  
									placeholder="اضف وصف للطبخة"
									value="<?php echo $item['Description'] ?>" />
							</div>
						</div>
						<!-- End Description Field -->
						<!-- Start Price Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">السعر</label>
							<div class="col-sm-10 col-md-6">
								<input 
									type="number"
									name="price" 
									class="form-control" 
									required="required" 
									placeholder="أدخل سعر الطبخة"
									value="<?php echo $item['Price'] ?>" />
							</div>
						</div>
						<!-- End Price Field -->
						<!-- Start ingredients Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">المكونات</label>
							<div class="col-sm-10 col-md-6">
								<input 
									type="text" 
									name="ingredients" 
									class="form-control" 
									required="required" 
									placeholder="أدخل مكونات الطبخة"
									value="<?php echo $item['ingredients'] ?>" />
							</div>
						</div>
						<!-- End ingredients Field -->
						<!-- Start Members Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">اسم المستخدم</label>
							<div class="col-sm-10 col-md-6">
								<select name="member">
									<?php
										$allMembers = getAllFrom("*", "users", "", "", "UserID");
										foreach ($allMembers as $user) {
											echo "<option value='" . $user['UserID'] . "'"; 
											if ($item['Member_ID'] == $user['UserID']) { echo 'selected'; } 
											echo ">" . $user['Username'] . "</option>";
										}
									?>
								</select>
							</div>
						</div>
						<!-- End Members Field -->
						<!-- Start Categories Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">القسم</label>
							<div class="col-sm-10 col-md-6">
								<select name="category">
									<?php
										$allCats = getAllFrom("*", "categories", "where parent = 0", "", "ID");
										foreach ($allCats as $cat) {
											echo "<option value='" . $cat['ID'] . "'";
											if ($item['Cat_ID'] == $cat['ID']) { echo ' selected'; }
											echo ">" . $cat['Name'] . "</option>";
											$childCats = getAllFrom("*", "categories", "where parent = {$cat['ID']}", "", "ID");
											foreach ($childCats as $child) {
												echo "<option value='" . $child['ID'] . "'";
												if ($item['Cat_ID'] == $child['ID']) { echo ' selected'; }
												echo ">--- " . $child['Name'] . "</option>";
											}
										}
									?>
								</select>
							</div>
						</div>
						<!-- End Categories Field -->
						<!-- Start Tags Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">الوسوم</label>
							<div class="col-sm-10 col-md-6">
								<input 
									type="text" 
									name="tags" 
									class="form-control" 
									placeholder="ادخل الوسوم وفصلهن با (,)" 
									value="<?php echo $item['tags'] ?>" />
							</div>
						</div>
						<!-- End Tags Field -->
						<!-- Start Submit Field -->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="حفظ التعديلات" class="btn btn-primary btn-sm" />
							</div>
						</div>
						<!-- End Submit Field -->
					</form>

					<?php

					// Select All Users Except Admin 

					$stmt = $con->prepare("SELECT 
												comments.*, users.Username AS Member  
											FROM 
												comments
											INNER JOIN 
												users 
											ON 
												users.UserID = comments.user_id
											WHERE item_id = ?");

					// Execute The Statement

					$stmt->execute(array($itemid));

					// Assign To Variable 

					$rows = $stmt->fetchAll();

					if (! empty($rows)) {
						
					?>
					<h1 class="text-center">ادارة [ <?php echo $item['Name'] ?> ] التعليقات</h1>
					<div class="table-responsive">
						<table class="main-table text-center table table-bordered">
							<tr>
								<td>التعليق</td>
								<td>أسم المستخدم</td>
								<td>تأريخ الاضافة</td>
								<td>التحكم</td>
							</tr>
							<?php
								foreach($rows as $row) {
									echo "<tr>";
										echo "<td>" . $row['comment'] . "</td>";
										echo "<td>" . $row['Member'] . "</td>";
										echo "<td >" . $row['comment_date'] ."</td>";
										echo "<td>
											<a href='comments.php?do=Edit&comid=" . $row['c_id'] . "' class='btn btn-success'><i class='fa fa-edit'></i> تحرير</a>
											<a href='comments.php?do=Delete&comid=" . $row['c_id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> حدف </a>";
											if ($row['status'] == 0) {
												echo "<a href='comments.php?do=Approve&comid="
														 . $row['c_id'] . "' 
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
					<?php } ?>
				</div>

			<?php

			// If There's No Such ID Show Error Message

			} else {

				echo "<div class='container'>";

				$theMsg = '<div class="alert alert-danger">هدا ال ID غير صحيح</div>';

				redirectHome($theMsg);

				echo "</div>";

			}			

		} elseif ($do == 'Update') {

			echo "<h1 class='text-center'>تعديل الوجبة</h1>";
			echo "<div class='container'>";

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				// Get Variables From The Form

				$id 		= $_POST['itemid'];
				$name 		= $_POST['name'];
				$desc 		= $_POST['description'];
				$price 		= $_POST['price'];
				$ingredients	= $_POST['ingredients'];
				$cat 		= $_POST['category'];
				$member 	= $_POST['member'];
				$tags 		= $_POST['tags'];

				// Validate The Form

				$formErrors = array();

				if (empty($name)) {
					$formErrors[] = 'لا يمكن ان يكون الاسم الوجبة<strong>فارغ</strong>';
				}

				if (empty($desc)) {
					$formErrors[] = 'لا يمكن ان كون وصف الوجبة  <strong>فارغ</strong>';
				}

				if (empty($price)) {
					$formErrors[] = 'لا يمكن ان يكون سعر الوجبة <strong>فارغ</strong>';
				}

				if (empty($ingredients)) {
					$formErrors[] = 'لا يمكن ان يكون مكونات الوجبة <strong>فارغ</strong>';
				}

				

				if ($member == 0) {
					$formErrors[] = 'يجب تحديد  <strong>أسم مستخدم</strong>';
				}

				if ($cat == 0) {
					$formErrors[] = 'يجب تحديد <strong>القسم</strong>';
				}


				// Loop Into Errors Array And Echo It

				foreach($formErrors as $error) {
					echo '<div class="alert alert-danger">' . $error . '</div>';
				}

				// Check If There's No Error Proceed The Update Operation

				if (empty($formErrors)) {

					// Update The Database With This Info

					$stmt = $con->prepare("UPDATE 
												items 
											SET 
												Name = ?, 
												Description = ?, 
												Price = ?, 
												ingredients = ?,
												Cat_ID = ?,
												Member_ID = ?,
												tags = ?
											WHERE 
												Item_ID = ?");

					$stmt->execute(array($name, $desc, $price, $ingredients, $cat, $member, $tags, $id));

					// Echo Success Message

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' تم بنجاح </div>';

					redirectHome($theMsg, 'back');

				}

			} else {

				$theMsg = '<div class="alert alert-danger">لا يمكن الدخول الي هدة الصفحة بدون ركوست</div>';

				redirectHome($theMsg);

			}

			echo "</div>";

		} elseif ($do == 'Delete') {

			echo "<h1 class='text-center'>حدف الوجبة</h1>";
			echo "<div class='container'>";

				// Check If Get Request Item ID Is Numeric & Get The Integer Value Of It

				$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

				// Select All Data Depend On This ID

				$check = checkItem('Item_ID', 'items', $itemid);

				// If There's Such ID Show The Form

				if ($check > 0) {

					$stmt = $con->prepare("DELETE FROM items WHERE Item_ID = :zid");

					$stmt->bindParam(":zid", $itemid);

					$stmt->execute();

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' تم الحدف </div>';

					redirectHome($theMsg, 'back');

				} else {

					$theMsg = '<div class="alert alert-danger">هدا ال ID غير صحيح</div>';

					redirectHome($theMsg);

				}

			echo '</div>';

		} elseif ($do == 'Approve') {

			echo "<h1 class='text-center'>تفعيل الوجبة</h1>";
			echo "<div class='container'>";

				// Check If Get Request Item ID Is Numeric & Get The Integer Value Of It

				$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

				// Select All Data Depend On This ID

				$check = checkItem('Item_ID', 'items', $itemid);

				// If There's Such ID Show The Form

				if ($check > 0) {

					$stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ?");

					$stmt->execute(array($itemid));

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' تم بنجاح</div>';

					redirectHome($theMsg, 'back');

				} else {

					$theMsg = '<div class="alert alert-danger">هدا ال ID غير صحيح</div>';

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