<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="dashboard.php"><?php echo lang('HOME_ADMIN') ?></a>
    </div>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav">
        <li><a href="categories.php"><?php echo lang('CATEGORIES') ?></a></li>
        <li><a href="items.php"><?php echo lang('ITEMS') ?></a></li>
        <li><a href="members.php"><?php echo lang('MEMBERS') ?></a></li>
        <li><a href="comments.php"><?php echo lang('COMMENTS') ?></a></li>
        <li><a href="contact.php"> المدكرات    </a></li>
        <li><a href="orders.php"> الطلبات     </a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			  <?php echo $_SESSION['Username']; ?>
			  <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="../index.php">زيارة المتجر </a></li>
            <li><a href="members.php?do=Edit&userid=<?php echo $_SESSION['ID'] ?>">تعديل الحساب </a></li>
            <li><a href="settings.php">الاعدادات</a></li>
            <li><a href="logout.php">تسجيل الخروج</a></li>
          </ul>
        </li>
      </ul>
    </div>
	  
	  
  </div>
</nav>