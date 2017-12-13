<template>
<div class="container is-fluid">
  <table class="table is-bordered is-striped is-narrow is-fullwidth">
  <thead>
    <tr>
      <th colspan="2">BALANCE</th>
      <th colspan="3">CONVERSION</th>
      <th ></th>
    </tr>
    <tr>
        <th>Currency</th>
        <th>Amount</th>
        <!--th>Instrument</th-->
        <th>Change</th>
        <th>Currency</th>
        <th>Amount</th>
        <th><button @click.prevent="refreshBalance()" class="button is-success">Refresh</button></th>
        
    </tr>

    
  </thead>
  <tfoot>
    <tr>
        <th>Currency</th>
        <th>Amount</th>
        <!--th>Instrument</th-->
        <th>Change</th>
        <th>Currency</th>
        <th>{{ total }}</th>
        <th></th>
    </tr>
    </tr>
  </tfoot>
    <tbody>
    <tr v-for="(item, index) in this.balances">
        <td>{{ item.currency }}</td>
        <td>{{ item.balance }}</td>
        <!--td>{{ item.final_instrument }}</td-->
        <td>{{ item.final_change }}</td>
        <td>{{ item.final_currency }}</td>
        <td>{{ item.final_value }}</td>
        <td ><button @click.prevent="selectItem(item)" class="button is-success">
      {{ item.currency }}
    </button></td>
    </tr>
    </tbody>
  </table>
          <p v-for="(item, index) in this.tickers['tickers']">
            
             {{ item.fund_id }} ({{ item.bid }}) <!--b>{{ item.last }}</b--> ({{ item.ask }})<b>{{ differenceBidAsk(index) }}</b> <!--small>{{ item.date }}</small-->
        </p>
  <div v-if="selected != null">
    <currencydetail :currency="selected.currency"></currencydetail>
  </div>
</div>
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
                balances: [],
                sum:0,
                selected: null,
                tickers: []
            }
        },
        computed: {
            total: function() {
                if (!this.balances) {
                    return 0;
                }

                return this.balances.reduce(function (total, value) {
                    return total + Number(value.final_value);
                }, 0);
            }
        },

        methods: {
            differenceBidAsk: function(i) {
                console.log(i);
                var t = this.tickers['tickers'][i];
                console.log(t);
                return Math.abs(1 - (t.ask / t.bid)) *100;
            },

            selectItem(item) {
                this.selected = item
            },
            fetchBalanceList(){
                axios.get('/api/balances').then( (response) => {
                    this.balances = response.data 
                    
                })
                
            },
            fetchTickers() {
                axios.get('/api/rock/tickers').then( (response) => {
                    this.tickers = response.data 
                })
            },
            refreshBalance(){
                axios.get('/api/balances/refresh').then( (response) => {
                    return this.fetchBalanceList();
                    
                })
                
            }

        },
        mounted() {
            this.fetchBalanceList();
            this.fetchTickers();
        }
    }
</script>