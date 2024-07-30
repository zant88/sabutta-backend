// import Autocomplete from '@trevoreyre/autocomplete-vue';

var vm = new Vue({
  el: "#app",
  data: {
    waste_list: [],
  },
  // components: {
  //   Autocomplete
  // },
  mounted() {
    // const that = this;
    // setTimeout(function(){
    //   that.getWaste();
    // }, 1000)
    
  },
  methods: {
    add() {
      
    },
    remove(index) {
      this.items.splice(index, 1);
    },
    numberWithCommas(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
    getWaste() {
      axios.get(`/jenissampah/waste-list/`).then(response => {
        console.log(response.data);
        const that = this;
        that.waste_list = [];
        response.data.results.forEach(el => {
          that.waste_list.push({
            'idsampah': el.idsampah,
            'nama': el.nama,
          })
        });
        console.log(that.waste_list);
      })
    },
    save() {
      if (this.items.length == 0) {
        Swal.fire({
          title: 'Error!',
          text: 'Anda belum memilih sampah!',
          icon: 'error',
          confirmButtonText: 'Ok'
        });
      } else {
        const formData = new FormData();
        formData.append('vendor_id', this.vendor_id);
        formData.append('sales_date', this.$refs.sales_date.value);
        formData.append('total', this.total);
        formData.append('items', JSON.stringify(this.items));
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        formData.append('_csrf', csrfToken);
        axios.post('/sales/submit-sales/', formData).then(response => {
          console.log(response.data);
          if (response.data.success == true) {
            Swal.fire({
              title: 'Sukses!',
              text: 'Data telah berhasil disimpan!',
              icon: 'success',
              confirmButtonText: 'Ok'
            }).then(() => {
              window.location.href = '/sales/surat-jalan/?id=' + response.data.id;
            });
          }
        })
      }
    }
  }
});