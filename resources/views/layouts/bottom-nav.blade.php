<!--<div class="bottom-nav">-->
<!--    <a href="{{ route('dashboard') }}" class="nav-item active">-->
<!--        <div class="nav-icon">🏠</div>-->
<!--        <div>Home</div>-->
<!--    </a>-->
<!--    <a href="{{ route('prayer.index') }}" class="nav-item">-->
<!--        <div class="nav-icon">🛐</div>-->
<!--        <div>Prayer Points</div>-->
<!--    </a>-->
<!--    <a href="{{ route('profile.index') }}" class="nav-item">-->
<!--        <div class="nav-icon">👤</div>-->
<!--        <div>Profile</div>-->
<!--    </a>-->
<!--</div>-->



<div class="bottom-nav">
    <a href="{{ route('dashboard') }}"  class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="fa-solid fa-house"></i>
        <span>Home</span>
    </a>

    <a href="{{ route('prayer.index') }}" class="nav-item {{ request()->routeIs('prayer.index') ? 'active' : '' }}">
        <!--<i class="fa-regular fa-comments"></i>-->
        <i class="fa-solid fa-church"></i>
        <span>Prayers</span>
    </a>

    <a href="#" class="nav-item">
        <i class="fa-solid fa-book"></i>
        <span>Verse</span>
    </a>

    <a href="{{ route('profile.index') }}" class="nav-item {{ request()->routeIs('profile.index') ? 'active' : '' }}">
        <!--<i class="fa-regular fa-user"></i>-->
        <i class="fa-solid fa-user"></i>
        <span>Profile</span>
    </a>

    <!--<a href="{{ route('profile.index') }}" class="nav-item">-->
    <!--    <i class="fa-solid fa-gear"></i>-->
    <!--    <span>Settings</span>-->
    <!--</a>-->
</div>
