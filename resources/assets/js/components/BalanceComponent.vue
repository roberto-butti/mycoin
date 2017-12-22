<template>
<div class="container">
    <div class="columns is- is-marginless">
        <div class="column is-4">
            <table class="table  is-striped is-narrow is-fullwidth">
            <thead>
            <tr>
                <th >Your Balance</th>
                <th><button @click.prevent="refreshBalance()" class="button is-small" v-bind:class="{ 'is-loading': loading }">Refresh</button></th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th colspan="2" class="cellnumber">{{ total }}</th>
                
            </tr>
            </tfoot>
            <tbody>
            <tr class="is-small" v-for="(item, index) in this.balances">
                <td class="numbercell">
                    {{ item.currency }} {{ item.balance }}<br>
                    Avail. {{ item.trading_balance.toFixed(8) }}
                </td>
                <!--td>{{ item.final_instrument }}</td-->
                <td class="is-small">{{ item.final_currency }}
                {{ item.final_value.toFixed(8) }}
                <br>
                @ {{ item.final_change }}
                </td>
                
                
            </tr>
            </tbody>
            </table>

        </div>
        <div class="column is-4">
            <table class="table  is-striped is-narrow is-fullwidth">
            <thead>
            <tr>
                <th colspan="2">
                    Ticker and Spread
                </th>
                <th>
                    <button @click.prevent="fetchTickers()" class="button is-small">refresh</button>
                </th>
            </tr>
            </thead>
            <tbody>
            <tr class="is-small" v-for="(item, index) in this.tickers">
                <td class="is-small">
                    {{ item.fund_id }} 
                    <br>
                     <b>{{ item.last }}</b>
                </td>
                <td>
                    ({{ item.bid }})<br>({{ item.ask }})
                </td>
                <td>
                    <span class="tag" v-bind:class="{ 'is-warning':differenceBidAsk(index)>3 && differenceBidAsk(index)<=5,  'is-success': differenceBidAsk(index)>5 }">{{ differenceBidAsk(index) }}</span>
                </td>
            </tr>
            </tbody>
            </table>
        
        </div>
        <div class="column is-4">
            <table class="table  is-striped is-narrow is-fullwidth">
            <thead>
            <tr>
                <th colspan="5">
                    Realtime Trade
                </th>
                <th>
                    
                </th>
            </tr>
            </thead>
            <tbody>
                <tr class="is-small" v-for="(item, index) in this.newtrade">
                    <td>
                    {{ item['symbol'] }}
                    </td>
                    <td>
                        {{ item['value'] }}<br />
                        {{ item['quantity'] }}<br />
                        {{ item['volume'] }}
                    </td>
                    <td>
                        {{ item['diff'] }}
                    </td>
                    <td>
                        {{ item['side'] }}
                    </td>
                    <td>
                        <small>{{ item['time'] }}</small>
                    </td>
                    <!-- {{ item['dark'] }} -->
                    
                </tr>
            </tbody>
            </table>
            
        </div>
        
       

    </div>

    <div class="columns">
        <div class="column is-12">
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
    </div>
</div>
</template>

<script>
import Pusher from 'pusher-js' // import Pusher
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
                tickers: [],
                newtrade: []
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
                var t = this.tickers[i];
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
                    this.tickers=[];
                    //console.log(response.data['tickers']);
                    for (let j = 0; j < response.data['tickers'].length; j++) {
                        //console.log(this.tickers);
                        //console.log(response.data['tickers'][j].fund_id);
                        //console.log(this.instruments);
                        if (this.instruments.indexOf(response.data['tickers'][j].fund_id) >= 0 ){
                            this.tickers.push(response.data['tickers'][j]);
                        } else {
                            //console.log("-----"+response.data['tickers'][j].fund_id);
                        }
                        
                    }
                })
            },
            refreshBalance(){
                this.loading=true;
                axios.get('/api/balances/refresh').then( (response) => {
                    var res = this.fetchBalanceList();
                    this.loading=false;
                    return res;
                    
                })
                
            },
            subscribe () {
                this.newtrade=[];
                let pusher = new Pusher('bb1fafdf79a00453b5af');
                pusher.subscribe('currency')
                console.log("pusher activate")
                
                pusher.bind('last_trade', data => {
                    //console.log(data);
                    console.log(this.newtrade);
                    if (this.instruments.indexOf(data["symbol"]) >=0 ){
                        this.newtrade.unshift(data /*{ "symbol": data["symbol"], "value": data["value"]}*/);
                        if (this.newtrade.length >5) {
                            this.newtrade.pop();
                        }
                    }
                });

            }

        },
        mounted() {
            this.loading=false;
            this.refreshBalance();
            this.fetchTickers();
            this.subscribe();
        }
    }
</script>

<style>
th, td {
    font-size: 80%;
}

td.numbercell {
    text-align: right;
    font-size: 80%;
}
</style>