<?php

	ob_start(); // Output Buffering Start

	session_start();

	if (isset($_SESSION['Username'])) {

		$pageTitle = 'الاعدادات ';

		include 'init.php';

		$getUser = $con->prepare("SELECT * FROM settings");
		$getUser->execute(array());
		$info = $getUser->fetch();
		
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			
			if(isset($_POST['newsettings'])) {
				
				$stmt = $con->prepare("UPDATE settings SET  name = ?, url = ?, description_meta = ?, new_Date = now(), command = ? , url_socia_media = ? ");

						$stmt->execute(array( $_POST['name'], $_POST['url'], $_POST['description'] , $_POST['price'], $_POST['url_socia_media']));

						// Echo Success Message

						$theMsg =  $stmt->rowCount() ;

				
				
				
			}
		}
		
		if (isset($theMsg)) {
			echo '<div class="container">';
					echo '<div class="nice-message">تم حفظ التعديلات بنجاح   </div>';
				echo '</div>';
			
		}
		?>


		<div class="home-stats">
			<div class="container text-center">
				<h1> أعدادات الموقع</h1>
						<div class="container">
				<form class="form-horizontal" action="" method="POST">
					<!-- Start Name Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">أسم الموقع </label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="name" 
								class="form-control" 
								required="required"  
								placeholder="أدخل الاسم الجديد" value="<?=$info['name']?>" />
						</div>
					</div>
					<!-- End Name Field -->
					<!-- Start Description Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">وصف الميتا تاج للموقع</label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="text" 
								name="description" 
								class="form-control" 
								required="required"  
								placeholder="ادخل وصف الطبخة" value="<?=$info['description_meta']?>" />
						</div>
					</div>
					<!-- End Description Field -->
					<!-- Start Price Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">العمولة </label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="number" 
								name="price" 
								class="form-control" 
								required="required" 
								placeholder="ادخل العمولة رقم"  value="<?=$info['command']?>"/>
						</div>
					</div>
					<!-- End Price Field -->					
					<!-- Start Price Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">رابط الموقع </label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="url" 
								name="url" 
								class="form-control" 
								required="required" 
								placeholder="ادخل  رابط الموقع" value="<?=$info['url']?>"/>
						</div>
					</div>
					<!-- End Price Field -->					
					<!-- Start Price Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-2 control-label">رابط التواصل الاجتماعي </label>
						<div class="col-sm-10 col-md-6">
							<input 
								type="url" 
								name="url_socia_media" 
								class="form-control" 
								required="required" 
								placeholder="ادخل  رابط الاجتماعي وفصل بينهما با (,)" value="<?=$info['url_socia_media']?>"/>
						</div>
					</div>
					<!-- End Price Field -->
			
				
					<!-- Start Submit Field -->
					<div class="form-group form-group-lg">
						<div class="col-sm-offset-2 col-sm-10">
							<input name="newsettings" type="submit" value="حفظ التعديلات " class="btn btn-primary btn-sm" />
						</div>
					</div>
					<!-- End Submit Field -->
				</form>
			</div>
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