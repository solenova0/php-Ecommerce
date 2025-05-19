<div class="col-md-3">
    <div class="sidebar-nav-fixed affix">
        <div class="well">
            <ul class="nav">
                <?php if (isset($_SESSION['TYPE']) && $_SESSION['TYPE'] === 'Administrator'): ?>
                    <li>
                        <a href="<?php echo web_root; ?>admin/modules/setting/index.php">
                            <span class="glyphicon glyphicon-cog"></span> Settings
                        </a>
                    </li>
                <?php endif; ?>
                <!-- Add more admin links below as needed -->
                <li>
                    <a href="<?php echo web_root; ?>admin/modules/dashboard/index.php">
                        <span class="glyphicon glyphicon-dashboard"></span> Dashboard
                    </a>
                </li>
                <li>
                    <a href="<?php echo web_root; ?>admin/modules/users/index.php">
                        <span class="glyphicon glyphicon-user"></span> Users
                    </a>
                </li>
                <li>
                    <a href="<?php echo web_root; ?>admin/modules/products/index.php">
                        <span class="glyphicon glyphicon-th-list"></span> Products
                    </a>
                </li>
                <li>
                    <a href="<?php echo web_root; ?>admin/logout.php">
                        <span class="glyphicon glyphicon-log-out"></span> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>