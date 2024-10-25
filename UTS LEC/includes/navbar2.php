<nav>
    <div class="container">
        <a href="/" class="logo">Event Registration</a>
        
        <ul class="nav-links">
            <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
                <div class="container">
                    <a class="navbar-brand" href="../dashboard.php">Dashboard</a>
                    <button
                        class="navbar-toggler"
                        type="button"
                        data-mdb-toggle="collapse"
                        data-mdb-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent"
                        aria-expanded="false"
                        aria-label="Toggle navigation">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto align-items-center">
                            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === 1): ?>
                            <!-- Admin-specific links -->
                            <li class="nav-item">
                            <a class="nav-link mx-2" href="../admin/create_event.php"><i class="fas fa-plus-circle pe-2"></i>Create Event</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link mx-2" href="../admin/event_management.php"><i class="fas fa-plus-circle pe-2"></i>Event Management</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link mx-2" href="../admin/manage_users.php"><i class="fas fa-bell pe-2"></i>Manage User</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link mx-2" href="../admin/event_registration.php"><i class="fas fa-heart pe-2"></i>Event Registration</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link mx-2" href="../admin/debug_mode.php"><i class="fas fa-heart pe-2"></i>Debug Mode</a>
                            </li>

                            <?php else: ?>
                            <!-- User-specific links -->
                            <li class="nav-item">
                            <a class="nav-link mx-2" href="../user/event_registered.php"><i class="fas fa-heart pe-2"></i>Event Registered</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link mx-2" href="../dashboard.php"><i class="fas fa-heart pe-2"></i>Available Event</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link mx-2" href="../user/account_edit.php"><i class="fas fa-heart pe-2"></i>Edit Profile</a>
                            </li>

                            <?php endif; ?>
                            <li class="nav-item dropdown">
                                <a
                                    class="nav-link dropdown-toggle d-flex align-items-center"
                                    href="#"
                                    id="navbarDropdownMenuLink"
                                    role="button"
                                    data-mdb-toggle="dropdown"
                                    data-mdb-auto-close="true"
                                    aria-expanded="false">
                                    <img
                                        src="user.png"
                                        class="rounded-circle"
                                        height="30"
                                        alt=""
                                        loading="lazy" />
                                </a>
                                <!-- Common links -->
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="../account_detail.php">My profile</a></li>
                                    <li><a class="dropdown-item" href="../account_logout.php">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </ul>
    </div>
</nav>
