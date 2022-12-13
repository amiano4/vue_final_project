var app = new Vue({
  el: "#app",
  data() {
    return {
      user: { value: "", isValid: true, message: "" },
      pass: { value: "", isValid: true, message: "" },
      showPassword: false,
      rememberMe: false,
      wasValidated: false
    }
  },
  created() {
    const rememberedUser = JSON.parse(localStorage.getItem("vue-final-project-remember-user") || "{}");

    if(rememberedUser.user && rememberedUser.pass) {
      this.user.value = rememberedUser.user;
      this.pass.value = rememberedUser.pass;
      this.rememberMe = true;
    } 
  },
  methods: {
    isEmpty(str) {
      return (str.replace(/\s+/g, '').length == 0);
    },
    submitLogin() {
      this.wasValidated = true;

      this.user.isValid = !this.isEmpty(this.user.value);
      this.pass.isValid = !this.isEmpty(this.pass.value);

      // clear messages
      this.user.message = "";
      this.pass.message = "";

      if(!(this.user.isValid && this.pass.isValid)) 
        return;
      
      if(this.user.isValid && this.pass.isValid) {
        const formData = new FormData();
        formData.append('method', 'login');
        formData.append('user', this.user.value);
        formData.append('pass', this.pass.value);

        const vue = this;

        axios
          .post('api/', formData)
          .then(res => {
            vue.processResponse(res);
          })
          .catch(err => {
            console.log(err)
          });
      }
    },
    processResponse(res) {
      switch(res.data.status) {
        case 0: // username not exist
          this.user.isValid = false;
          this.user.message = res.data.message;
          break;
        case 1: // ok
          if(this.rememberMe) {
            localStorage.setItem("vue-final-project-remember-user", JSON.stringify({
              user: this.user.value,
              pass: this.pass.value
            }));
          } else {
            localStorage.removeItem("vue-final-project-remember-user");
          }
          location.href = "./dashboard";
          break;
        case 2: // invalid pass
          this.pass.isValid = false;
          this.pass.message = res.data.message;
          break;
        case 3: // locked
          if(res.data['incorrect-password']) {
            this.pass.isValid = false;
            this.pass.message = 'Password is incorrect';
          }
          
          Swal.fire(
            res.data.message,
            'Due to multiple login fails',
            'info'
          );
          break;
        case 4: // banned
          Swal.fire(
            res.data.message,
            '',
            'error'
          )
          break;
      }
    }
  },
});