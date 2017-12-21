<template>
    <div class="columns is- is-marginless">
        <div class="column is-8">
            <table class="table is-bordered is-striped is-narrow is-fullwidth">
            <tfoot>
            <tr>
                <th>Curr</th>
                <th>Amount</th>
                <!--th>Instrument</th-->
                <th>Change</th>
                <th>{{ total }}</th>
                <th>Available</th>
                <th><button @click.prevent="refreshBalance()" class="button is-small is-success" v-bind:class="{ 'is-loading': loading }">Refresh</button></th>
            </tr>
            </tfoot>
            <tbody>
            <tr class="is-small" v-for="(item, index) in this.balances">
                <td>{{ item.currency }}</td>
                <td>{{ item.balance }}</td>
                <!--td>{{ item.final_instrument }}</td-->
                <td>{{ item.final_change }}</td>
                <td class="is-small">{{ item.final_currency }}
                {{ item.final_value.toFixed(8) }}</td>
                <td>{{ item.trading_balance.toFixed(8) }}</td>
                <td ><button @click.prevent="selectItem(item)" class="button  is-small">
                {{ item.currency }}
            </button></td>
            </tr>
            </tbody>
            </table>
            <div class="tabs">
                <ul>
                <li v-for="(instrument, index) in this.instruments">
                    <a @click.prevent="selectInstrument(instrument)" class="  is-small">
                    {{ instrument }}</a></li>

                </ul>
            </div>

            <div v-if="selectedInstrument != null">
                <instrumentdetail :instrument="selectedInstrument" ></instrumentdetail>
            </div>

            <div v-if="selected != null">
                <currencydetail :balanceitem="selected" ></currencydetail>
            </div>

        </div>
        <div class="column is-4">
            <h2 class="title">Ticker and Spread</h2>
            <button @click.prevent="fetchTickers()" class="button">refresh</button>
            <p v-for="(item, index) in this.tickers['tickers']">
                {{ item.fund_id }} ({{ item.bid }}) <!--b>{{ item.last }}</b--> ({{ item.ask }})<span class="tag" v-bind:class="{ 'is-warning':differenceBidAsk(index)>3 && differenceBidAsk(index)<=5,  'is-success': differenceBidAsk(index)>5 }">{{ differenceBidAsk(index) }}</span> <!--small>{{ item.date }}</small-->
            </p>
        
        </div>
        <!--div class="column is-2">
            <realtime></realtime>
        </div-->
        
       

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
                selectedInstrument: null,
                instruments: ["LTCEUR", "PPCEUR", "ETHEUR", "BTCEUR"],
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
                //console.log(i);
                var t = this.tickers['tickers'][i];
                //console.log(t);
                return (Math.abs(1 - (t.ask / t.bid)) *100).toFixed(3);
            },

            selectItem(item) {
                this.selected = item
            },
            selectInstrument(instrument) {
                this.selectedInstrument = instrument;
            },
            fetchBalanceList(){
                axios.get('/api/balances').then( (response) => {
                    this.balances = response.data 
                    this.loading=false;
                    
                })
                
            },
            fetchTickers() {
                axios.get('/api/rock/tickers').then( (response) => {
                    this.tickers = response.data 
                })
            },
            refreshBalance(){
                this.loading=true;
                axios.get('/api/balances/refresh').then( (response) => {
                    res = this.fetchBalanceList();
                    this.loading=false;
                    return res;
                    
                })
                
            }

        },
        mounted() {
            this.loading=false;
            this.refreshBalance();
            this.fetchTickers();
        }
    }
</script>