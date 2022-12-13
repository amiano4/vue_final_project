<div class="login-right" id="app">
  <div class="login-right-wrap">
    <h1>Welcome to login</h1>
    <p class="account-subtitle">Need an account? <a href="./register">Sign Up</a></p>
    <h2>Sign in</h2>

    <form @submit.prevent="submitLogin">
      <div class="form-group">
        <label>Email/Username <span class="login-danger">*</span></label>
        <input class="form-control" type="text" v-model="user.value"
          @keyup="wasValidated && (user.isValid = !isEmpty(user.value))"
          :class="{ 'is-invalid': (wasValidated && !user.isValid) }">
        <div class="invalid-feedback">
          {{ user.message }}
        </div>
        <span class="profile-views" v-if="!(wasValidated && !user.isValid)"><i class="fas fa-user-circle"></i></span>
      </div>
      <div class="form-group">
        <label>Password <span class="login-danger">*</span></label>
        <input class="form-control pass-input" :type="showPassword ? 'text' : 'password'" v-model="pass.value"
          @keyup="wasValidated && (pass.isValid = !isEmpty(pass.value))"
          :class="{ 'is-invalid': (wasValidated && !pass.isValid) }">
        <div class="invalid-feedback">
          {{ pass.message }}
        </div>
        <span class="profile-views feather-eye" @click="showPassword = !showPassword" :class="{ 
                    'pe-4': (wasValidated && !pass.isValid), 
                    'pb-4': (wasValidated && !pass.isValid && !isEmpty(pass.message)),
                    'feather-eye-off': showPassword
                  }"></span>
      </div>
      <div class="forgotpass">
        <div class="remember-me">
          <label class="custom_check mr-2 mb-0 d-inline-flex remember-me">
            Remember me
            <input type="checkbox" v-model="rememberMe">
            <span class="checkmark"></span>
          </label>
        </div>
      </div>
      <div class="form-group">
        <button class="btn btn-primary btn-block" type="submit">Login</button>
      </div>
    </form>

  </div>
</div>