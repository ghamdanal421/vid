<?php
	ob_start();
	session_start();
	include 'init.php';


?>
<div class="container">
	<div class="widget-ads">
	
		<img src="layout/images/gh.png" alt="APS" />
	</div>
	<div class="content-wrapper">
		<div class="main-wrapper">
			<h3>أخر الانمي </h3>
			<article>
				<div class="imgs">
					<img src="layout/images/n.png" alt="mo" />
				</div>
				<h2>ID:Invaded (Dub)</h2>
			</article>		
			<article>
				<div class="imgs">
					<img src="layout/images/n.png" alt="mo" />
				</div>
				<h2>ID:Invaded (Dub)</h2>
			</article>		
			<article>
				<div class="imgs">
					<img src="layout/images/n.png" alt="mo" />
				</div>
				<h2>ID:Invaded (Dub)</h2>
			</article>	
			<article>
				<div class="imgs">
					<img src="layout/images/n.png" alt="mo" />
				</div>
				<h2>ID:Invaded (Dub)</h2>
			</article>		
			<article>
				<div class="imgs">
					<img src="layout/images/n.png" alt="mo" />
				</div>
				<h2>ID:Invaded (Dub)</h2>
			</article>		
			<article>
				<div class="imgs">
					<img src="layout/images/n.png" alt="mo" />
				</div>
				<h2>ID:Invaded (Dub)</h2>
			</article>
		</div>
		<aside class="sidebar-wrapper">
			<section class="filter">
				<h3>فلاتر سريعة </h3>
				<ul>
					<li> التصنيف<i class="fa fa-chevron-down"></i> </li>
					<li> السنة<i class="fa fa-chevron-down"></i> </li>
					<li> الوسوم<i class="fa fa-chevron-down"></i> </li>
					<li> النوع<i class="fa fa-chevron-down"></i> </li>
					<li> الحالة<i class="fa fa-chevron-down"></i> </li>
					<li> الترتيب <i class="fa fa-chevron-down"></i> </li>
				</ul>
				<button >فلترة </button>
			</section>			
			<section class="section-ads">
				<h3>بنر اعلاني  </h3>
				<div class="ads" style=" height: 250px;text-align: center;line-height: 250px;background: #fdf0f0;">
					اعلان 
				</div>
			</section>			
			<section class="option">
				<h3>مكتبتي </h3>
				<ul>
					<li><i class="fa fa-heart"></i> مفضلاتي </li>
					<li><i class="fa fa-play-circle"></i> أكمل المشاهدة </li>
					<li><i class="fa fa-clock-o"></i> المشاهدة لاحقا </li>
					<li><i class="fa fa-comments-o"></i> رسائل </li>
					<li><i class="fa fa-trophy"></i> ترقية حسابك  </li>
				</ul>
			</section>		
			<section class="option">
				<h3>مكتبتي </h3>
				<ul>
					<li><i class="fa fa-heart"></i> مفضلاتي </li>
					<li><i class="fa fa-play-circle"></i> أكمل المشاهدة </li>
					<li><i class="fa fa-clock-o"></i> المشاهدة لاحقا </li>
					<li><i class="fa fa-comments-o"></i> رسائل </li>
					<li><i class="fa fa-trophy"></i> ترقية حسابك  </li>
				</ul>
			</section>	
			<section class="option">
				<h3>ترقية حسابي  </h3>
				<ul>
					<li><i class="fa fa-heart"></i> مفضلاتي </li>
					<li><i class="fa fa-play-circle"></i> أكمل المشاهدة </li>
					<li><i class="fa fa-clock-o"></i> المشاهدة لاحقا </li>
					<li><i class="fa fa-comments-o"></i> رسائل </li>
					<li><i class="fa fa-trophy"></i> ترقية حسابك  </li>
				</ul>
			</section>
		</aside>
	</div>

</div>
<?php
	include $tpl . 'footer.php'; 
	ob_end_flush();
?>