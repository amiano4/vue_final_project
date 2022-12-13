<?php include "src/layouts/UserHeaderLayout.php"; ?>

<div id="userIDHolder">
  <script>
  var userID = <?= $_SESSION['user-data']['id']; ?>;
  </script>
</div>

<div class="page-header">
  <div class="row">
    <div class="col">
      <h3 class="page-title">Profile</h3>
    </div>
  </div>
</div>

<div class="row" id="app">
  <div class="col-md-12">
    <div class="profile-header">
      <div class="row align-items-center">
        <div class="col-auto profile-image">
          <a href="#">
            <?php if(isAdmin()): ?>
            <img class="rounded-circle" alt="User Image" src="assets/img/admin.png">
            <?php else: ?>
            <img class="rounded-circle" alt="User Image" src="assets/img/user.webp">
            <?php endif; ?>
          </a>
        </div>
        <div class="col ms-md-n2 profile-user-info">
          <h4 class="user-name mb-0">{{ account.firstname + " " + account.lastname }}</h4>
          <h6 class="text-muted">{{ account.email }}</h6>
          <div class="about-text">{{ "@" + account.username }}</div>
        </div>
      </div>
    </div>
    <div class="profile-menu">
      <ul class="nav nav-tabs nav-tabs-solid">
        <li class="nav-item ">
          <span>&nbsp;</span>
        </li>
      </ul>
    </div>
    <div class="tab-content profile-tab-cont">

      <div class="tab-pane fade show active" id="per_details_tab">

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <h5 class="card-title d-flex justify-content-between">
                      <span>Account Details</span>
                    </h5>
                    <p style="border-bottom: 1px solid #999; margin-bottom: 2rem;"></p>
                    <form @submit.prevent="updateProfile">
                      <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Role</label>
                        <div class="col-lg-9">
                          <span class="badge badge-label bg-info" v-if="account.role == 1">
                            <i class="mdi mdi-circle-medium"></i>
                            USER
                          </span>
                          <span class="badge badge-label bg-dark" v-if="account.role == 0">
                            <i class="mdi mdi-circle-medium"></i>
                            ADMIN
                          </span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Current Status</label>
                        <div class="col-lg-9">
                          <span class="badge badge-label" :class="[ vStatus.class[account.status] ]">
                            <i class="mdi mdi-circle-medium"></i>
                            {{ vStatus.name[account.status] }}
                          </span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-lg-3 col-form-label">First Name</label>
                        <div class="col-lg-9">
                          <input type="text" class="form-control form-control-sm" v-model="account.firstname"
                            @keypress="hasChanged = true" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Last Name</label>
                        <div class="col-lg-9">
                          <input type="text" class="form-control form-control-sm" v-model="account.lastname"
                            @keypress="hasChanged = true" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Email</label>
                        <div class="col-lg-9">
                          <input type="text" class="form-control form-control-sm" v-model="account.email" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Username</label>
                        <div class="col-lg-9">
                          <input type="text" class="form-control form-control-sm" v-model="account.username" readonly>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Registered</label>
                        <div class="col-lg-9">
                          <span class="fw-bold fst-italic">*{{ account.date_inserted }}</span>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="d-flex justify-content-end gap-3">
                          <button class="btn btn-danger btn-sm">Remove account</button>
                          <button class="btn btn-primary btn-sm" :disabled="!hasChanged">Save changes</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="col-md-5 ms-auto">
                    <h5 class="card-title d-flex justify-content-between">
                      <span>Change password</span>
                    </h5>
                    <p style="border-bottom: 1px solid #999; margin-bottom: 2rem;"></p>
                    <form @submit.prevent="submitChangePassword">
                      <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Old Password</label>
                        <div class="col-sm-8">
                          <input :type="showPassword ? 'text' : 'password'" class="form-control form-control-sm"
                            v-model="oldPassword.value" :class="{ 'is-invalid': !oldPassword.isValid }" required>
                          <div class="invalid-feedback">
                            Your old password is incorrect!
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-4 col-form-label">New Password</label>
                        <div class="col-sm-8">
                          <input :type="showPassword ? 'text' : 'password'" minlength="6"
                            class="form-control form-control-sm" v-model="newPassword.value"
                            @keyup="validateNewPasswords"
                            :class="{ 'is-invalid': (!passwordsMatch && changePassValidated) }" required>
                          <div class="invalid-feedback">
                            New password do not match!
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Confirm New</label>
                        <div class="col-sm-8">
                          <input :type="showPassword ? 'text' : 'password'" class="form-control form-control-sm"
                            v-model="confirmPassword.value" @keyup="validateNewPasswords"
                            :class="{ 'is-invalid': (!passwordsMatch && changePassValidated) }" required>
                          <div class="invalid-feedback">
                            New password do not match!
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-8">
                          <div class="checkbox">
                            <label class="gap-2 d-flex align-items-center">
                              <input type="checkbox" v-model="showPassword">
                              <span style="font-size: .75rem !important;">
                                Show password
                              </span>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="d-flex justify-content-end gap-3">
                          <button class="btn btn-warning text-white btn-sm">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>
</div>

<?php include "src/layouts/UserFooterLayout.php"; ?>