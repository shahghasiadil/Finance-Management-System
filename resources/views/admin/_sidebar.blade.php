<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title"> 
                    <span>Main</span>
                </li>
                <li class="submenu">
                    <a class="menu" href="#"><i class="la la-dashboard"></i> <span> {{__('dashboard')}}</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><router-link class="menu"  to="/dashboard">Owner Dashboard</router-link></li>
                    </ul>
                </li>
                
                <li class="submenu">
                    <a href="#"><i class="la la-users"></i> <span> {{__('projects')}} </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                       <li>
                        <router-link to="/projects"> Projects</router-link>
                       </li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-edit"></i> <span> Chart of Account </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li>
                            <router-link to="/budgetcode"> Budget Code</router-link>
                        </li>
                        <li>
                            <router-link to="/budgetcatcode"> Budget Category Code</router-link>
                        </li>
                        <li>
                            <router-link to="/expensecode"> Expense Code</router-link>
                        </li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-crosshairs"></i> <span> Transactions </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="">{{__('Transaction')}}</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-cube"></i> <span> Vouchers </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><router-link to="/voucher"> Vouchers</router-link></li>
                        <li><router-link to="/journal"> Journals</router-link></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-pie-chart"></i> <span> {{__('report')}} </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        
                        <li>
                            <router-link to="/allocationreport"> Report</router-link>
                        </li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-user-plus"></i> <span> {{__('users')}} </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li>
                            <router-link to="/users"> Users</router-link>
                        </li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-bell"></i> <span> {{__('activity_log')}} </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                      
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-cog"></i> <span> {{__('settings')}} </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                       
                    </ul>
                </li>
                
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->