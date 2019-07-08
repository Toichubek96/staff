

<ul class="nav nav-tabs">
    <li class="nav-item">
        <?= $this->tag->linkTo(['users', 'Home', 'class' => 'nav-link']) ?>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
           aria-expanded="false"><?= $this->auth->getName() ?></a>
        <div class="dropdown-menu">
            <?= $this->tag->linkTo(['users/changePassword', 'Change Password', 'class' => 'dropdown-item']) ?>
        </div>
    </li>
    <li class="nav-item">
        <?= $this->tag->linkTo(['users/logout', 'Logout', 'class' => 'nav-link']) ?>
    </li>
</ul>
<div class="content">
    <?= $this->getContent() ?>
</div>