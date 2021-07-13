<nav class="top-nav">
    <ul>
        <li>
            <a href="/agent/dashboard" class="top-menu dashboard">
                <div class="top-menu__icon"> <i data-feather="home"></i> </div>
                <div class="top-menu__title"> Dashboard </div>
            </a>
        </li>
        <li>
            <a href="/agent/booking" class="top-menu booking">
                <div class="top-menu__icon"> <i data-feather="credit-card"></i> </div>
                <div class="top-menu__title"> Booking </div>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="top-menu menu-service">
                <div class="top-menu__icon"> <i data-feather="box"></i> </div>
                <div class="top-menu__title"> Service <i data-feather="chevron-down" class="top-menu__sub-icon"></i> </div>
            </a>
            <ul class="">
                <li>
                    <a href="/agent/service" class="top-menu service">
                        <div class="top-menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="top-menu__title"> Service </div>
                    </a>
                </li>
                <li>
                    <a href="/agent/package" class="top-menu package">
                        <div class="top-menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="top-menu__title"> Package </div>
                    </a>
                </li>
                <li>
                    <a href="/agent/product" class="top-menu product">
                        <div class="top-menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="top-menu__title"> Product </div>
                    </a>
                </li>
                <li>
                    <a href="/agent/new-service" class="top-menu new-service">
                        <div class="top-menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="top-menu__title"> New Service </div>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="/agent/reviews" class="top-menu reviews">
                <div class="top-menu__icon"> <i data-feather="box"></i> </div>
                <div class="top-menu__title"> Reviews </div>
            </a>
        </li>
        <li>
            <a href="/agent/coupon" class="top-menu coupon">
                <div class="top-menu__icon"> <i data-feather="box"></i> </div>
                <div class="top-menu__title"> Coupon </div>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="top-menu menu-settings">
                <div class="top-menu__icon"> <i data-feather="box"></i> </div>
                <div class="top-menu__title"> Settings <i data-feather="chevron-down" class="top-menu__sub-icon"></i> </div>
            </a>
            <ul class="">
                <li>
                    <a href="/agent/staff" class="top-menu staff">
                        <div class="top-menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="top-menu__title"> Add Staff </div>
                    </a>
                </li>
                <li>
                    <a href="/agent/store-time" class="top-menu store-time">
                        <div class="top-menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="top-menu__title"> Shop Time </div>
                    </a>
                </li>
                @if(Auth::user()->role_id == 'admin')
                <li>
                    <a href="/agent/profile" class="top-menu profile">
                        <div class="top-menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="top-menu__title"> Profile </div>
                    </a>
                </li>
                @endif
                <li>
                    <a href="/agent/change-password" class="top-menu change-password">
                        <div class="top-menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="top-menu__title"> Change Password </div>
                    </a>
                </li>
            </ul>
        </li>

    </ul>
</nav>