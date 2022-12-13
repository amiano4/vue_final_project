<?php
  $userData = $_SESSION['user-data'];
?>

<div class="main-wrapper">

  <div class="header">

    <div class="header-left">
      <a href="index.html" class="logo">
        <img src="assets/img/logo.png" alt="Logo">
      </a>
      <a href="index.html" class="logo logo-small">
        <img src="assets/img/logo-small.png" alt="Logo" width="30" height="30">
      </a>
    </div>

    <div class="menu-toggle">
      <a href="javascript:void(0);" id="toggle_btn">
        <span class="feather-menu"></span>
      </a>
    </div>

    <a class="mobile_btn" id="mobile_btn">
      <i class="fas fa-bars"></i>
    </a>

    <ul class="nav user-menu">

      <li class="nav-item dropdown has-arrow new-user-menus">
        <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
          <span class="user-img">
            <?php if(isUser()): ?>
            <img class="rounded-circle" src="assets/img/user.webp" width="31" alt="User Image">
            <?php else: ?>
            <img class="rounded-circle" src="assets/img/admin.png" width="31" alt="Admin">
            <?php endif; ?>
            <div class="user-text">
              <h6><?= $userData['firstname'] . " " . $userData['lastname'] ?></h6>
              <p class="text-muted mb-0">
                <?= isAdmin() ? "Admin" : "User" ?>
              </p>
            </div>
          </span>
        </a>
        <div class="dropdown-menu">
          <div class="user-header">
            <div class="avatar avatar-sm">
              <?php if(isUser()): ?>
              <img src="assets/img/user.webp" alt="User Image" class="avatar-img rounded-circle">
              <?php else: ?>
              <img src="assets/img/admin.png" alt="Admin Image" class="avatar-img rounded-circle">
              <?php endif; ?>
            </div>
            <div class="user-text">
              <h6><?= $userData['firstname'] . " " . $userData['lastname'] ?></h6>
              <p class="text-muted mb-0">
                <?= isAdmin() ? "Admin" : "User" ?>
              </p>
            </div>
          </div>
          <a class="dropdown-item" href="./profile">My Profile</a>
          <div class="dropdown-item" onclick="$('.LF').submit()">
            <form class="w-100 h-100 LF" action="./api/" method="POST">
              <input type="hidden" name="method" value="logout">
              <input type="hidden" name="redirect" value="./">
              <button type="submit" style="
                  width: 100%;
                  height: 100%;
                  text-align: left;
                  border: none;
                  padding: 0;
                  background-color:transparent;
                ">Logout</button>
            </form>
          </div>
        </div>
      </li>

    </ul>

  </div>

  <div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
      <div id="sidebar-menu" class="sidebar-menu">
        <ul>
          <li class="menu-title">
            <span>Main Menu</span>
          </li>
          <li class="<?= $url == "/dashboard" ? "active" : "" ?>">
            <a href="./dashboard"><i class="feather-grid"></i> <span>Dashboard</span></a>
          </li>
          <?php if(isAdmin()): ?>
          <li class="<?= $url == "/users" ? "active" : "" ?>">
            <a href="./users"><i class="feather-sliders"></i> <span>Manage Users</span></a>
          </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </div>

  <div class="page-wrapper">
    <div class="content container-fluid">