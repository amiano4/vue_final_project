var app = new Vue({
  el: "#app",
  data() {
    return {
      vFields: [
        'firstname',
        'lastname',
        'email',
        'username',
        'password',
        'password_confirmation',
      ],
      form: {},
      wasValidated: false,
      passwordConfirmed: null,
      validFields: true,
      showPassword: false,
      returnMessage: false
    }
  },
  created() {
    this.form = this.recreateObjectInstance();
  },
  methods: {
    recreateObjectInstance() {
      const form = {};

      this.vFields.forEach(field => {
        form[field] = {
          value: "",
          isValid: true
        };
      });

      return form;
    },
    submitForm() {
      this.wasValidated = true;
      this.checkAllInputs();

      if(!(this.validFields && this.passwordConfirmed))
        return;
        
      if(this.validFields && this.passwordConfirmed) {
        const dataObject = {};
        const vue = this;
  
        const formData = new FormData();
        formData.append('method', 'register');
        Object.keys(this.form).forEach(key => {
          dataObject[key] = vue.form[key].value;
        });
        formData.append('data', JSON.stringify(dataObject));
  
        axios
          .post('api/', formData)
          .then(res => {
            if(res.data.status == 1) {
              vue.clearForm();
              vue.returnMessage = false;
  
              Swal.fire(
                'Account registered successfully!',
                'Click to proceed',
                'success'
              ).then((result) => {
                location.href = "./login";
              })
            } else if(res.data.status == 2) {
              vue.returnMessage = true ;
              vue.form.username.isValid = false;
            } else if(res.data.status == 3) {
              vue.returnMessage = true ;
              vue.form.email.isValid = false;
            } else if(res.data.status == 4) {
              vue.returnMessage = true ;
              vue.form.username.isValid = false;
              vue.form.email.isValid = false;
            }
          })
          .catch(err => {
            Swal.fire(
              'Error submitting data!',
              'Task not completed',
              'error'
            )
  
            console.log(err);
          });
      }
    },
    isEmpty(str) {
      return (str.replace(/\s+/g, '').length == 0);
    },
    passwordsMatch() {
      return !(this.form.password.value.localeCompare(this.form.password_confirmation.value));
    },
    checkAllInputs() {
      if(!this.wasValidated)
        return;

      const vue = this;
      this.validFields = true;
      
      Object.keys(this.form).forEach(key => {
        vue.isEmpty(vue.form[key].value) && (vue.validFields = false);
        vue.form[key].isValid = !vue.isEmpty(vue.form[key].value);
      });
    },
    clearForm() {
      const vue = this;

      this.wasValidated = false;
      this.passwordConfirmed = null;
      this.validFields = true;

      Object.keys(this.form).forEach(key => {
        vue.form[key].value = "";
      });
    },
  },
});

// vanilla js, cuz necessary?
addEventListener('unload', function() {
  if(checkACookieExists('vfp_admin_action_create_user')) {
    this.document.cookie = "vfp_admin_action_create_user= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
  }
});

addEventListener('popstate', function() {
  if(checkACookieExists('vfp_admin_action_create_user')) {
    this.document.cookie = "vfp_admin_action_create_user= ; expires = Thu, 01 Jan 1970 00:00:00 GMT";
  }
});

function checkACookieExists(name) {
  return document.cookie.split(';').some((item) => item.trim().startsWith(`${name}=`));
}