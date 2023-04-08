var vm = new Vue({
  el: "#app-role",
  data: {
    auth_master: [],
    auth_master_selected: [],
    module: '',
    role_id: '',
  },
  mounted() {
    console.log('test satu dua tiga');
  },
  methods: {
    getCurrentRoleAuth() {
      var self = this;
      axios.get('/role-auth/get-current-list/?role=' + this.role_id)
        .then(function (response) {
          self.auth_master_selected = [];
          response.data.forEach(el => {
            self.auth_master_selected.push({
              'id': el.id,
              'name': el.name,
              'module': el.module,
              'controller': el.controller,
              'action': el.action,
              'selected': true,
              'from_server': true
            });
          });
          self.getRoleAuth();
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    getRoleAuth() {
      var self = this;
      axios.get(`/role-auth/get-list/?module=${this.module}&role=${this.role_id}`)
        .then(function (response) {
          self.auth_master = [];
          response.data.forEach(el => {
            self.auth_master.push({
              'id': el.id,
              'name': el.name,
              'module': el.module,
              'controller': el.controller,
              'action': el.action,
              'selected': false,
              'from_server': false
            });
          });
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    toggleSelection(index) {
      this.auth_master[index].selected = !this.auth_master[index].selected;
      console.log(this.auth_master);
    },
    add() {
      var self = this;
      this.auth_master.forEach(el => {
        if (el.selected) {
          var isInserted = false;
          self.auth_master_selected.forEach(elSelected=>{
            if (elSelected.id == el.id) {
              isInserted = true;
            }
          });
          if (!isInserted) {
            self.auth_master_selected.push(el);
          }
        }
      });
    },
    remove(index, fromServer) {
      console.log(fromServer);
      var self = this;
      if (fromServer) {
        Swal.fire({
          icon: 'question',
          title: 'Are you sure deleting data?',
          showCancelButton: true,
          confirmButtonText: 'Yes',
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            var item = self.auth_master_selected[index];
            self.deleteData(item.id);
            // this.processSubmit();
            // Swal.fire('Saved!', '', 'success');
          } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info');
          }
        });
      }else {
        this.auth_master_selected.splice(index, 1);
      }
    },
    numberWithCommas(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
    processSubmit() {
      const formData = new FormData();
      formData.append('auth_master_selected', JSON.stringify(this.auth_master_selected));
      formData.append('role_id', this.role_id)
      var csrfToken = $('meta[name="csrf-token"]').attr("content");
      formData.append('_csrf', csrfToken);
      axios.post('/role-auth/save-controller/', formData).then(response => {
        if (response.data.success == true) {
          Swal.fire({
            title: 'Success!',
            text: 'Data has already saved!',
            icon: 'success',
            confirmButtonText: 'Ok'
          }).then(() => {
            window.location.href = '/role-auth/';
          });
        }
      })
    },
    deleteData(id) {
      const formData = new FormData();
      formData.append('id', id);
      var csrfToken = $('meta[name="csrf-token"]').attr("content");
      formData.append('_csrf', csrfToken);
      axios.post('/role-auth/delete-item/', formData).then(response => {
        if (response.data == true) {
          Swal.fire({
            title: 'Success!',
            text: 'Data has already saved!',
            icon: 'success',
            confirmButtonText: 'Ok'
          }).then(() => {
            window.location.href = '/role-auth/';
          });
        }
      })
    },
    save() {
      if (this.role_id == '') {
        Swal.fire('Please select role!', '', 'error');
      }else if (this.auth_master_selected.length == 0) {
        Swal.fire('Please add auth item!', '', 'error');
      }else {
        Swal.fire({
          icon: 'question',
          title: 'Are you sure to submit data?',
          showCancelButton: true,
          confirmButtonText: 'Yes',
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            this.processSubmit();
            Swal.fire('Saved!', '', 'success');
          } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
          }
        });
      }
    }
  }
});