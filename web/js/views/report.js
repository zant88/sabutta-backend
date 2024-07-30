var vm = new Vue({
  el: "#app",
  data: {
    is_authenticated: 0,
    amount_sorted: 0,
    waste_amount: 0,
    waste_weight: 0,
    total_sales: 0,
    total_cashout: 0,
    password: '',
    start_date: '',
    end_date: ''
  },
  methods: {
    getIncomeReport() {
      var startDate = this.$refs.start_date.value;
      var endDate = this.$refs.end_date.value;
      const self = this;
      axios.get(`/report/earning/?start_date=${startDate}&end_date=${endDate}`).then(response => {
        console.log(response.data);
        self.waste_amount = `Rp. ${this.numberWithCommas(response.data.waste_amount)},-`;
        self.waste_weight = `${this.numberWithCommas(response.data.waste_weight)} Kg`;
        self.total_sales = `Rp. ${this.numberWithCommas(response.data.total_sales)},-`;
        self.total_cashout = `Rp. ${this.numberWithCommas(response.data.total_cashout)},-`;
      })
    },
    numberWithCommas(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
    submitPassword() {
      const formData = new FormData();
      formData.append('password', this.password);
      var csrfToken = $('meta[name="csrf-token"]').attr("content");
      formData.append('_csrf', csrfToken);
      axios.post('/report/submit-password/', formData).then(response => {
        console.log(response.data);
        this.is_authenticated = response.data;
        if (this.is_authenticated == 0) {
          this.password = '';
          Swal.fire({
            title: 'Gagal!',
            text: 'Password Salah',
            icon: 'error',
            confirmButtonText: 'Ok'
          })
        }else {
          setTimeout(function() {
            $('.datepicker').daterangepicker({
              singleDatePicker: true,
              showDropdowns: true,
              locale: {
                format: 'YYYY-MM-DD'
              }
            });
          }, 1000)
        }
        // if (response.data.success == true) {
        //   Swal.fire({
        //     title: 'Sukses!',
        //     text: 'Data telah berhasil disimpan!',
        //     icon: 'success',
        //     confirmButtonText: 'Ok'
        //   }).then(() => {
        //     window.location.href = '/sales/surat-jalan/?id=' + response.data.id;
        //   });
        // }
      });
    }
  }
});