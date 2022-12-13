var app = new Vue({
  el: "#app",
  data() {
    return {
      account: {
        firstname: "",
        lastname: "",
        email: "",
        username: "",
        role: 1,
        status: 1,
        date_inserted: "",
      },
      userid: "",
      vStatus: {
        name: [ 'Removed', 'Active', 'Locked', 'Deactivated' ],
        class: [ 'bg-danger', 'bg-success', 'bg-warning', 'bg-secondary' ],
      },
      showPassword: false,
      hasChanged: false,
      oldPassword: { value: "", isValid: true },
      newPassword: { value: "", isValid: true },
      confirmPassword: { value: "", isValid: true },
      passwordsMatch: false,
      changePassValidated: false
    }
  },
  created() {
    this.userid = userID;
    document.querySelector('#userIDHolder').remove();


    this.fetchUserDetails();
  },
  methods: {
    fetchUserDetails() {
      const formData = new FormData();
      formData.append('method', 'fetchUserData');
      formData.append('userid', this.userid);

      const vue = this;

      axios
        .post("api/", formData)
        .then(res => {
          if(res.data) {
            const user = res.data;

            vue.account.firstname = user.firstname;
            vue.account.lastname = user.lastname;
            vue.account.email = user.email;
            vue.account.username = user.username;
            vue.account.role = user.role;
            vue.account.status = user.status;
            vue.account.date_inserted = user.date_inserted;

          }
        });
    },
    updateProfile() {
      const formData = new FormData();
      formData.append('method', 'updateProfile');
      formData.append('userid', this.userid);
      formData.append('firstname', this.account.firstname);
      formData.append('lastname', this.account.lastname);

      const vue = this;

      axios
        .post("api/", formData)
        .then(res => {
          if(res.data == 1) {
            location.reload();
          }
        });
    },
    validateNewPasswords() {
      if(!this.changePassValidated) 
        return;

        this.passwordsMatch =  this.newPassword.value == this.confirmPassword.value;
    },
    submitChangePassword() {
      this.changePassValidated = true;
      this.validateNewPasswords();

      if(!this.passwordsMatch)
        return;
      else {
        const formData = new FormData();
        formData.append('method', 'changePassword');
        formData.append('oldPassword', this.oldPassword.value);
        formData.append('newPassword', this.newPassword.value);

        const vue = this;

        axios
          .post('api/', formData)
          .then(res => {
            if(res.data == 1) {
              Swal.fire(
                'Password changed successfully!',
                'Click to proceed',
                'success'
              ).then((result) => {
                vue.clearPasswordForm();
              })
            } else if(res.data ==0 ) {
              vue.oldPassword.isValid = false;
            }
          })
      }
    },
    clearPasswordForm() {
      this.oldPassword = { value: "", isValid: true };
      this.newPassword = { value: "", isValid: true };
      this.confirmPassword = { value: "", isValid: true };
      this.showPassword = false;
    }
  },
});