<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title"> 
                    <span>Main</span>
                </li>
                <li class="submenu">
                    <a class="menu" href="#"><i class="la la-dashboard"></i> <span> Dashboard</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><router-link class="menu"  to="/dashboard">Owner Dashboard</router-link></li>
                    </ul>
                </li>
                
                <li class="submenu">
                    <a href="#"><i class="la la-users"></i> <span> Customers </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                       <li><router-link to="/customers"> Customers</router-link></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-pie-chart"></i> <span> Reports Center </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href=""> General Report </a></li>

                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->