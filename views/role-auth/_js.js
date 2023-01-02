var vm = new Vue({
  el: "#app",
  data: {
    price: 0,
    items: [],
  },
  mounted() {
    console.log('test satu dua tiga');
  },
  methods: {
    add() {
      var strData = this.$refs.vendor.options[this.$refs.vendor.selectedIndex].text;
      var strID = this.$refs.vendor.options[this.$refs.vendor.selectedIndex].value;
      var id = strID.split('-')[0];
      var isAvailable = false;
      this.items.forEach(el => {
        if (el.id == id) {
          Swal.fire({
            title: 'Error!',
            text: 'Anda sudah memilih vendor ini!',
            icon: 'error',
            confirmButtonText: 'Ok'
          });
          isAvailable = true;
        }
      });
      if (!isAvailable) {
        this.items.push({ id: id, name: strData, price: this.price, str_price: this.numberWithCommas(this.price) });
      }
    },
    remove(index) {
      this.items.splice(index, 1);
    },
    numberWithCommas(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
    getVendorWaste(idSampah){
      var self = this;
      axios.get('/jenissampah/get-vendor-waste/?idsampah='+idSampah)
      .then(function (response) {
        var items = response.data;
        items.forEach(el => {
          self.items.push({ id: el.id, name: el.name, price: el.price_kg, str_price: self.numberWithCommas(el.price_kg) });
        });
        
      })
      .catch(function (error) {
        console.log(error);
      });
    },
    save() {
      const formData = new FormData();
      formData.append('idsampah', this.$refs.idsampah.value);
      formData.append('items', JSON.stringify(this.items));
      var csrfToken = $('meta[name="csrf-token"]').attr("content");
      formData.append('_csrf', csrfToken);
      // axios.defaults.headers.post['X-CSRF-Token'] = response.data._csrf;
      axios.post('/jenissampah/save-data/', formData).then(response => {
        console.log(response.data);
        if (response.data.success == true) {
          Swal.fire({
            title: 'Sukses!',
            text: 'Data telah berhasil disimpan!',
            icon: 'success',
            confirmButtonText: 'Ok'
          }).then(() => {
            window.location.href = '/jenissampah/';
          });
        }
      })
    }
  }
});