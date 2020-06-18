<?php

	function lang($phrase) {

		static $lang = array(

			// Navbar Links

			'HOME_ADMIN' 	=> 'الرئيسة',
			'CATEGORIES' 	=> 'الاقسام',
			'ITEMS' 		=> 'الوجبات',
			'MEMBERS' 		=> 'المستخدمين',
			'COMMENTS'		=> 'التعليقات',
			'STATISTICS' 	=> 'الحالة',
			'LOGS' 			=> 'التسجيل',
			'' => '',
			'' => '',
			'' => '',
			'' => '',
			'' => ''
		);

		return $lang[$phrase];

	}
