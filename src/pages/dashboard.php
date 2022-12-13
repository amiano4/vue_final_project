<?php include "src/layouts/UserHeaderLayout.php"; ?>

<div class="page-header">
  <div class="row">
    <div class="col">
      <h3 class="page-title">Dashboard</h3>
    </div>
  </div>
</div>

<?php if(isAdmin()): ?>
<?php require_once("./api/Connection.php"); 
  $con = new DBConnection();
?>
<div class="row">
  <div class="col-xl-3 col-sm-6 col-12 d-flex">
    <div class="card bg-comman w-100">
      <div class="card-body">
        <div class="db-widgets d-flex justify-content-between align-items-center">
          <div class="db-info">
            <h6>Users</h6>
            <h3>
              <?= $con->query("SELECT COUNT(*) as total FROM tbl_users WHERE userid <> ? AND status <> ?", [ 1, 0 ])->fetchArray()['total']; ?>
            </h3>
          </div>
          <div class="db-icon text-primary">
            <span class="feather-users"></span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6 col-12 d-flex">
    <div class="card bg-comman w-100">
      <div class="card-body">
        <div class="db-widgets d-flex justify-content-between align-items-center">
          <div class="db-info">
            <h6>Active</h6>
            <h3>
              <?= $con->query("SELECT COUNT(*) as total FROM tbl_users WHERE userid <> ? AND status = ?", [ 1, 1 ])->fetchArray()['total']; ?>
            </h3>
          </div>
          <div class="db-icon text-success">
            <span class="feather-user-check"></span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6 col-12 d-flex">
    <div class="card bg-comman w-100">
      <div class="card-body">
        <div class="db-widgets d-flex justify-content-between align-items-center">
          <div class="db-info">
            <h6>Locked</h6>
            <h3>
              <?= $con->query("SELECT COUNT(*) as total FROM tbl_users WHERE userid <> ? AND status = ?", [ 1, 2 ])->fetchArray()['total']; ?>
            </h3>
          </div>
          <div class="db-icon text-warning">
            <span class="feather-lock"></span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6 col-12 d-flex">
    <div class="card bg-comman w-100">
      <div class="card-body">
        <div class="db-widgets d-flex justify-content-between align-items-center">
          <div class="db-info">
            <h6>Deactivated</h6>
            <h3>
              <?= $con->query("SELECT COUNT(*) as total FROM tbl_users WHERE userid <> ? AND status = ?", [ 1, 3 ])->fetchArray()['total']; ?>
            </h3>
          </div>
          <div class="db-icon text-secondary">
            <span class="feather-user-x"></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<?php if(isUser()): ?>
<div class="row" id="app">
  <div class="col-sm-12">
    <div class="card card-table comman-shadow">
      <div class="card-body">

        <h1 class="text-center">Welcome back, <?= $userData['firstname']; ?>!</h1>

      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<?php $con->close(); include "src/layouts/UserFooterLayout.php"; ?>
