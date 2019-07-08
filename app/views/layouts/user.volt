{#<h2>user layout hi {{ auth.getName() }}</h2>#}
{#{{ content() }}#}
<ul class="nav nav-tabs">
    <li class="nav-item">
        {{ link_to('users', 'Home','class':'nav-link') }}
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
           aria-expanded="false">{{ auth.getName() }}</a>
        <div class="dropdown-menu">
            {{ link_to('users/changePassword', 'Change Password','class':'dropdown-item') }}
        </div>
    </li>
    <li class="nav-item">
        {{ link_to('users/logout', 'Logout','class':'nav-link') }}
    </li>
</ul>
<div class="content">
    {{ content() }}
</div>