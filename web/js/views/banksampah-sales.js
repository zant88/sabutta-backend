// const {
//   createApp,
//   ref,
//   toRaw
// } = Vue;

// createApp({
  
// }).mount('#app');
var vm = new Vue({
  el: "#app",
  data(){
    return {
      selected: 2,
      weight: 0,
      total: 0,
      sampah: '',
      vendor_id: 0,
      sales_date: '',
      items: [],
      waste_list: [],
      selected_stock: 0,
      selling_price: 0,
      buying_price: 0,
      is_saving: false
    }
  },
  mounted() {
    console.log(this.is_saving);
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
      }else if (this.weight > this.selected_stock) {
        Swal.fire({
          title: 'Error!',
          text: 'Anda tidak boleh memasukan jumlah melebihi stock sambah!',
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
        this.items.push({ id: id, name: strData, weight: this.weight, harga: price, hargaBeli: this.buying_price, total: total });
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
    // checkStock() {
      
    // },
    getStock() {
      console.log(this.$refs.jenissampah.value);
      var waste_id = this.$refs.jenissampah.value.split(' - ')[0];
      var sellingPrice = this.$refs.jenissampah.value.split(' - ')[1];
      var buyingPrice = this.$refs.jenissampah.value.split(' - ')[2];
      const that = this;
      axios.get(`/banksampah-sales/get-stock/?id=${waste_id}`).then(response => {
        console.log(response.data);
        that.selected_stock = response.data;
        that.weight = 0;
      });
      this.selling_price = sellingPrice;
      this.buying_price = buyingPrice;
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