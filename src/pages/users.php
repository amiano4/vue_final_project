<?php include "src/layouts/UserHeaderLayout.php"; ?>

<div class="page-header">
  <div class="row">
    <div class="col">
      <h3 class="page-title">Manage Users</h3>
    </div>
  </div>
</div>

<div class="row" id="app">
  <div class="col-sm-12">
    <div class="card card-table comman-shadow">
      <div class="card-body">

        <div class="page-header">
          <div class="row align-items-center">
            <div class="col">
              <h3 class="page-title">User list</h3>
            </div>
            <div class="col-auto text-end float-end ms-auto download-grp">
              <a href="add-student.html" class="btn btn-primary" @click.prevent="createUserAccount">
                <i class="fas fa-plus"></i> Add user
              </a>
            </div>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table star-student table-hover table-striped userstable">
            <thead>
              <tr>
                <th class="ord">ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Username</th>
                <th>Date Inserted</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="user in users">
                <td>{{ addLeadingZeros(user.userid) }}</td>
                <td>{{ user.fullname }}</td>
                <td>{{ user.email }}</td>
                <td><span style="
                  color: #aaa;
                  user-select: none;
                  font-size: 0.875rem;
                  ">@</span>{{ user.username }}</td>
                <td>{{ user.date_inserted }}</td>
                <td>
                  <span class="badge badge-label" :class="[ vStatus.class[user.status] ]">
                    <i class="mdi mdi-circle-medium"></i>
                    {{ vStatus.name[user.status] }}
                  </span>
                </td>
                <td>
                  <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Choose
                    </a>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="#" v-if="user.status == 1 || user.status == 2"
                        @click.prevent="deactivateUser(user.userid)">Deactivate</a>
                      <a class="dropdown-item" href="#" v-if="user.status == 3"
                        @click.prevent="activateUser(user.userid)">Activate</a>
                      <a class="dropdown-item" href="#" v-if="user.status == 2"
                        @click.prevent="unlockUser(user.userid)">Unlock</a>
                    </div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include "src/layouts/UserFooterLayout.php"; ?>