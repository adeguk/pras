<div id="masthead">
    <div class="masthead">
        <ul class="nav nav-pills pull-right">
            <li <?php echo check_class('home'); ?>><a href="<?php echo site_url(); ?>"><?php e( lang('bf_home') ); ?></a></li>
            <?php if (empty($current_user)) :?>
                <li><a href="<?php echo site_url('/login'); ?>">Sign In</a></li>
            <?php else: ?>
                <li>
                    <?php if (isset($current_user->email)) : ?>
                        <a href="<?php echo site_url(SITE_AREA) ?>" class="btn btn-small btn-success">Go to Dashboard</a>
                    <?php #else :?>
                        <!--a href="<?php echo site_url('login'); ?>" class="btn btn-large btn-primary"><?php echo lang('bf_action_login'); ?></a-->
                    <?php endif;?>
                </li>
                <li <?php echo check_method('profile'); ?>><a href="<?php echo site_url('/users/view_profile'); ?>"> <?php e(lang('bf_user_settings')); ?> <!--(<?php e($current_user->username); ?>)--></a></li>
                <li <?php echo check_method('profile'); ?>><a href="<?php echo site_url('/users/edit_profile'); ?>"> <?php e('Edit'); ?> </a></li>
                <li><a href="<?php echo site_url('/logout') ?>"><?php e( lang('bf_action_logout')); ?></a></li>
            <?php endif; ?>
        </ul>

        <h3 class="muted"><?php if (class_exists('Settings_lib')) e(settings_item('site.title')); else echo 'Bonfire'; ?></h3>
    </div>
</div>