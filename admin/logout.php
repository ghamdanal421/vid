<?php
	ob_start();
	session_start();
	$pageTitle = 'أكمال عملية الدفع ';
	include 'init.php';

	if(isset($_SESSION['user'])){
		
	$checkout = true;
		
	$getUser = $con->prepare("SELECT * FROM users WHERE Username = ?");
	$getUser->execute(array($sessionUser));
	$info = $getUser->fetch();
		
	if ($info['approve'] == 1) {
		
?>

<!-- Start checkout  -->

    
<div class="gha-cart-checkout">
	<div class="container">
       <h2 class="post-title">تفاصيل الفاتوره  </h2>
        <div class="gha-cart-checkout-wrap new-item ">
            <p class="gha-checkout-details">تأكيد بيانات العنوان    </p>
			
			<div class="from">
					<div class="form-group">
						<label> العنوان   </label>
						<input requir1ed="required" id="setdataadress"  type="text" class="form-control"  value=""  >
						

						<!-- display google map -->
						<div id="geomap"></div>

						<!-- display selected location information -->
						<p>المكان : <input type="text" class="search_addr form-control" size="45"></p>
						<p>خط الطول: <input type="text" class="search_latitude form-control" size="30"></p>
						<p>خط العرض: <input type="text" class="search_longitude form-control" size="30"></p>
						
					</div>				
		
					
			
			
			<div class="sora-checkout-wrap">
				<div class="simpleCart_items checkout">
					<div>
						<div class="headerRow">
							<div class="item-thumb"></div>
							<div class="item-name"></div>
							<div class="item-price"></div>
							<div class="item-decrement"></div>
							<div class="item-quantity"></div>
							<div class="item-increment"></div>
							<div class="item-total"></div>
							<div class="item-remove"></div>
						</div>
						<div class="itemRow row-0 odd" id="cartItem_SCI-5">

						</div> 
					</div>
				</div>
				<div class="cart-bot-element">
					<div class="ammount"><span class="sora-cart-subtotal">المبلغ المستحق :</span><span class="simpleCart_total"></span></div>
					
				</div>
			</div>
		<div class="form-group">
				<button id="formsubmit" type="submit" >    الشروع بدفع   </button>
			</div>
		</div>
		</div>
    </div>
</div>

<!-- End checkout  -->

<?php
		
	}else {?>
		
		<div class="alert alert-info">يرجي تأكيد معلومات الحساب لنتمكن من عملية الدفع <a href="settings"> تأكيد الحساب  </a></div>
<?php
		
	}
	}else { ?>
		
		<div class="alert alert-info">يرجي تسجيل الدخول <a href="login.php"> تسجيل الدخول </a></div>
<?php	}				

	include $tpl . 'footer.php';
	ob_end_flush();
?>