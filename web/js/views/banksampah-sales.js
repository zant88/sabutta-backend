var vm = new Vue({
  el: "#app",
  data: {
    selected: 2,
    weight: 0,
    total: 0,
    sampah: '',
    vendor_id: 0,
    sales_date: '',
    items: [],
    waste_list: [],
  },
  methods: {
    add() {
      if (this.weight == 0 || this.weight == '') {
        Swal.fire({
          title: 'Error!',
          text: 'Anda belum memasukan jumlah sampah!',
          icon: 'error',
          confirmButtonText: 'Ok'
        });
      }else {
        var strData = this.$refs.jenissampah.options[this.$refs.jenissampah.selectedIndex].text;
        var strID = this.$refs.jenissampah.options[this.$refs.jenissampah.selectedIndex].value;
        console.log(strID);
        var price = strID.split(' - ')[1];
        var total = parseInt(price) * this.weight;
        this.total = this.total + total;
        var id = strID.split('-')[0];
        this.items.push({ id: id, name: strData, weight: this.weight, harga: price, total: total });
      }
    },
    remove(index) {
      this.items.splice(index, 1);
    },
    numberWithCommas(x) {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
    getWaste() {
      axios.get(`/jenissampah/sampah-vendor/?id=${this.vendor_id}`).then(response => {
        console.log(response.data);
        const that = this;
        that.waste_list = [];
        response.data.forEach(el => {
          that.waste_list.push({
            'id': `${el.id}-${el.price}`,
            'waste_name': el.waste_name,
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
        console.log('this is from sales');
        console.log(this.$refs.sales_date);
        // formData.append('vendor_id', this.vendor_id);
        formData.append('sales_date', this.$refs.sales_date.value);
        formData.append('total', this.total);
        formData.append('items', JSON.stringify(this.items));
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        formData.append('_csrf', csrfToken);
        axios.post('/banksampah-sales/submit/', formData).then(response => {
          console.log(response.data);
          if (response.data.success == true) {
            Swal.fire({
              title: 'Sukses!',
              text: 'Data telah berhasil disimpan!',
              icon: 'success',
              confirmButtonText: 'Ok'
            }).then(() => {
              window.location.href = '/banksampah-sales/';
            });
          }
        })
      }
    }
  }
});