<?php echo theme_view('header'); ?>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
      <div class="container">

          <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>

          <!-- Be sure to leave the brand out there if you want it shown -->
          <a class="brand" href="<?= site_url(); ?>"><?php e(class_exists('Settings_lib') ? settings_item('site.title') : 'Bonfire'); ?></a>

          <!-- Everything you want hidden at 940px or less, place within here -->
          <div class="nav-collapse collapse">
            <ul class="nav pull-right">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  Account
                  <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <?php if (empty($current_user)) : ?>
                    <li><a href="<?php echo site_url(LOGIN_URL); ?>">Sign In</a></li>
                    <?php else : ?>
                    <li <?php echo check_method('profile'); ?>><a href="<?php echo site_url('users/edit_profile'); ?>"><?php e('Edit Profile'); ?></a></li>
                    <li><a href="<?php echo site_url(SITE_AREA); ?>"><?php e('Go to Dashboard'); ?></a></li>
                    <li><a href="<?php echo site_url('logout'); ?>"><?php e(lang('bf_action_logout')); ?></a></li>
                    <?php endif; ?>
                </ul>
              </li>
            </ul>
          </div>
      </div>
  </div>
</div>
<?php
    echo isset($content) ? $content : Template::content();
    echo theme_view('footer', array('show' => false));
?>
