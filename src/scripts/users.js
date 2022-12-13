var app = new Vue({
  el: "#app",
  data() {
    return {
      users: [],
      vStatus: {
        name: [ 'Removed', 'Active', 'Locked', 'Deactivated' ],
        class: [ 'bg-danger', 'bg-success', 'bg-warning', 'bg-secondary' ],
      },
    }
  },
  created() {
    this.fetchAllUsers();
  },
  mounted() {
    console.log(document.querySelector('.userstable'))
  },
  methods: {
    fetchAllUsers() {
      const formData = new FormData();
      formData.append('method', 'allUsers');

      const vue = this;

      axios
        .post('api/', formData)
        .then(res => {
          if(res.data.length > 0) {
            vue.users = res.data
          }
        })
    },
    deactivateUser(id) {
      this.vAjaxForUserUpdate('deactivateUser', id);
    },
    activateUser(id) {
      this.vAjaxForUserUpdate('activateUser', id);
    },
    unlockUser(id) {
      this.vAjaxForUserUpdate('unlockUser', id);
    },
    vAjaxForUserUpdate(method, id) {
      const formData = new FormData();
      formData.append('method', method);
      formData.append('id', id);

      const vue = this;

      axios
        .post('api/', formData)
        .then(res => {
          if(res.data == 1) {
            vue.fetchAllUsers();
          }
        })
    },
    createUserAccount() {
      document.cookie = "vfp_admin_action_create_user=true";
      location.href = "./register";
    },
    addLeadingZeros(num, length = 3) {
      return String(num).padStart(length, '0');
    }
  },
});