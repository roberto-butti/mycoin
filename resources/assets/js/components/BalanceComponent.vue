<template>
  <table class="table">
  <thead>
    <tr>
      <th colspan="2">BALANCE</th>
      <th colspan="4">TARGET1</th>
    </tr>
    <tr>
        <th>Currency</th>
        <th>Amount</th>
        <th>Instrument</th>
        <th>Change</th>
        <th>Currency</th>
        <th>Amount</th>
        
    </tr>

    
  </thead>
  <tfoot>
    <tr>
        <th>Currency</th>
        <th>Amount</th>
        <th>Instrument</th>
        <th>Change</th>
        <th>Currency</th>
        <th>Amount</th>
    </tr>
    </tr>
  </tfoot>
    <tbody>
    <tr v-for="(item, index) in this.balances">
        <td>{{ item.currency }}</td>
        <td>{{ item.balance }}</td>
        <td>{{ item.intermediate_instrument }}</td>
        <td>{{ item.intermediate_change }}</td>
        <td>{{ item.intermediate_currency }}</td>
        <td>{{ item.intermediate_value }}</td>
        
         
    </tr>
    </tbody>
  </table>
</template>

<script>
    export default {
        props: {
            'currency':{
                type: String,
                default: "EURBTC"
            }
        },
        data() {
            return {
                loading: false,
                balances: []
            }
        },
        methods: {
            fetchBalanceList(){
                axios.get('/api/balances/BTC').then( (response) => {
                    this.balances = response.data 
                })
            }
        },
        mounted() {
            this.fetchBalanceList();
        }
    }
</script>