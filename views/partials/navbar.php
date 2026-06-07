
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <span class="nav-link text-dark font-weight-bold">
                Welcome, <?php echo Auth::user('user_name'); ?> (<?php echo ucfirst(Auth::user('user_role')); ?>)
            </span>
        </li>
    </ul>
</nav>