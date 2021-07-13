<div class="mobile-menu md:hidden">
    <div class="mobile-menu-bar">
        <a href="" class="flex mr-auto">
            <img alt="Auto Wash" class="w-6" src="/admin-assets/dist/images/logo.svg">
        </a>
        <a href="javascript:;" id="mobile-menu-toggler"> <i data-feather="bar-chart-2" class="w-8 h-8 text-white transform -rotate-90"></i> </a>
    </div>
    <ul class="border-t border-theme-24 py-5 hidden">
        <!-- <li>
            <a href="index.html" class="menu menu--active">
                <div class="menu__icon"> <i data-feather="home"></i> </div>
                <div class="menu__title"> Dashboard </div>
            </a>
        </li> -->
        <li>
            <a href="/agent/dashboard" class="menu dashboard">
                <div class="menu__icon"> <i data-feather="home"></i> </div>
                <div class="menu__title"> Dashboard </div>
            </a>
        </li>
        <li>
            <a href="/agent/booking" class="menu booking">
                <div class="menu__icon"> <i data-feather="credit-card"></i> </div>
                <div class="menu__title"> Booking </div>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="menu menu-service">
                <div class="menu__icon"> <i data-feather="box"></i> </div>
                <div class="menu__title"> Service <i data-feather="chevron-down" class="menu__sub-icon"></i> </div>
            </a>
            <ul class="">
                <li>
                    <a href="/agent/service" class="menu service">
                        <div class="menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="menu__title"> Service </div>
                    </a>
                </li>
                <li>
                    <a href="/agent/package" class="menu package">
                        <div class="menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="menu__title"> Package </div>
                    </a>
                </li>
                <li>
                    <a href="/agent/product" class="menu product">
                        <div class="menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="menu__title"> Product </div>
                    </a>
                </li>
                <li>
                    <a href="/agent/new-service" class="menu new-service">
                        <div class="menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="menu__title"> New Service </div>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="/agent/reviews" class="menu reviews">
                <div class="menu__icon"> <i data-feather="box"></i> </div>
                <div class="menu__title"> Reviews </div>
            </a>
        </li>
        <li>
            <a href="/agent/coupon" class="menu coupon">
                <div class="menu__icon"> <i data-feather="box"></i> </div>
                <div class="menu__title"> Coupon </div>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="menu menu-settings">
                <div class="menu__icon"> <i data-feather="box"></i> </div>
                <div class="menu__title"> Settings <i data-feather="chevron-down" class="menu__sub-icon"></i> </div>
            </a>
            <ul class="">
                <li>
                    <a href="/agent/staff" class="menu staff">
                        <div class="menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="menu__title"> Add Staff </div>
                    </a>
                </li>
                <li>
                    <a href="/agent/store-time" class="menu store-time">
                        <div class="menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="menu__title"> Shop Time </div>
                    </a>
                </li>
                @if(Auth::user()->role_id == 'admin')
                <li>
                    <a href="/agent/profile" class="menu profile">
                        <div class="menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="menu__title"> Profile </div>
                    </a>
                </li>
                @endif
                <li>
                    <a href="/agent/change-password" class="menu change-password">
                        <div class="menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="menu__title"> Change Password </div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>