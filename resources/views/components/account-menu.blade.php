<ul class="account-menu vertical-menu">
    <li class="{{ request()->routeIs('my-account') ? 'active' : '' }}">
        <a href="{{ Route('my-account') }}">Minha conta</a>
    </li>
    <li class="{{ request()->routeIs('subscriptions') ? 'active' : '' }}">
        <a href="{{ Route('subscriptions') }}">Assinatura</a>
    </li>
</ul>