<div class="login-right" id="app">
  <div class="login-right-wrap">
    <h1>
      <?= isset($_COOKIE['vfp_admin_action_create_user']) ? "Create user account" : "Sign Up" ?>
    </h1>
    <p class="account-subtitle">
      <?= !isset($_COOKIE['vfp_admin_action_create_user']) ? "Enter details to create your account" : "" ?>
    </p>
    <form @submit.prevent="submitForm">
      <div class="alert alert-danger alert-dismissible fade" :class="{ show : !validFields }" role="alert"
        v-if="!validFields">
        Please input valid data in each field
        <button type="button" class="btn-close btn-sm collapse" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <div class="form-group">
        <label>First Name <span class="login-danger">*</span></label>
        <input class="form-control" type="text" v-model="form.firstname.value"
          :class="{ 'is-invalid': !form.firstname.isValid }" required>
        <span class="profile-views" v-if="form.firstname.isValid"><i class="fas fa-user-circle"></i></span>
      </div>
      <div class="form-group">
        <label>Last Name <span class="login-danger">*</span></label>
        <input class="form-control" type="text" v-model="form.lastname.value"
          :class="{ 'is-invalid': !form.lastname.isValid }" required>
        <span class="profile-views" v-if="form.lastname.isValid"><i class="fas fa-user-circle"></i></span>
      </div>
      <div class="form-group">
        <label>Email <span class="login-danger">*</span></label>
        <input class="form-control" type="email" v-model="form.email.value"
          :class="{ 'is-invalid': !form.email.isValid }" required>
        <div class="invalid-feedback" v-if="returnMessage && !form.email.isValid">
          This email already exists! Get another one
        </div>
        <span class="profile-views" v-if="form.email.isValid"><i class="fas fa-envelope"></i></span>
      </div>
      <div class="form-group">
        <label>Username <span class="login-danger">*</span></label>
        <input class="form-control" type="text" v-model="form.username.value" minlength="6"
          :class="{ 'is-invalid': !form.username.isValid }" required>
        <div class="invalid-feedback" v-if="returnMessage && !form.username.isValid">
          Username was already taken by someone else
        </div>
        <span class="profile-views" v-if="form.username.isValid"><i class="fas fa-user"></i></span>
      </div>
      <div class="form-group">
        <label>Password <span class="login-danger">*</span></label>
        <input class="form-control pass-confirm" :type="showPassword ? 'text' : 'password'"
          @keyup="passwordConfirmed = passwordsMatch()" v-model="form.password.value" minlength="6"
          :class="(!form.password.isValid || (!passwordConfirmed && wasValidated)) ? 'is-invalid' : ''" required>
        <div class="invalid-feedback" v-if="!passwordConfirmed">
          Password do not match!
        </div>
        <span class="profile-views feather-eye" :class="{ 
            'pe-4 pb-4': (!form.password.isValid || (!passwordConfirmed && wasValidated)),
            'feather-eye-off': showPassword
           }" @click="showPassword = !showPassword"></span>
      </div>
      <div class="form-group">
        <label>Confirm Password <span class="login-danger">*</span></label>
        <input class="form-control pass-confirm" :type="showPassword ? 'text' : 'password'"
          @keyup="passwordConfirmed = passwordsMatch()" v-model="form.password_confirmation.value" minlength="6"
          :class="(!form.password_confirmation.isValid || (!passwordConfirmed && wasValidated)) ? 'is-invalid' : ''"
          required>
        <div class="invalid-feedback" v-if="!passwordConfirmed">
          Password do not match!
        </div>
        <span class="profile-views feather-eye" :class="{ 
            'pe-4 pb-4': (!form.password_confirmation.isValid || (!passwordConfirmed && wasValidated)),
            'feather-eye-off': showPassword
           }" @click="showPassword = !showPassword"></span>
      </div>

      <?php if(!isset($_COOKIE['vfp_admin_action_create_user'])): ?>
      <div class=" dont-have">Already Registered? <a href="./login">Login</a></div>
      <?php endif; ?>
      <div class="form-group <?= !isset($_COOKIE['vfp_admin_action_create_user']) ? "mb-0" : "" ?>">
        <button class="btn btn-primary btn-block" type="submit">Register</button>
      </div>

      <?php if(isset($_COOKIE['vfp_admin_action_create_user'])): ?>
      <div class="form-group mb-0">
        <a href="./users" class="btn btn-link">Back</a>
      </div>
      <?php endif; ?>

    </form>
  </div>
</div>