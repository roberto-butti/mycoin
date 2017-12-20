<template>
    <div class="container">
        With {{ this.balanceitem.currency }} you can:
        <div v-if="this.balanceitem.currency=='LTC'">
            <b>SELL</b> LTC via LTCEUR with {{ this.balanceitem.balance }} {{ this.balanceitem.currency }}.
            <button @click.prevent="fetchInstrument('LTCEUR')" class="button is-success">LTCEUR</button>
            <div v-if="this.ticker">
            I suggest to SELL {{ this.balanceitem.balance }} {{ this.balanceitem.currency }} for {{ this.ticker['ask'] }} {{ this.ticker.currency }}
            at price 
            </div>
            <div v-if="this.orders">
                
                <p v-for="(item, index) in this.orders['orders']">
                {{ item.fund_id }} ({{ item.side }}){{ item.price }}) {{ item.amount }})  ({{ item.amount_unfilled }})
                </p>
            </div>
            <div v-if="this.orderbook_asks">
                aa{{ this.orderbook_asks }}aa
            </div>
            
        </div>
        <div v-if="this.balanceitem.currency=='EUR'">
            <b>BUY</b> LTC.
            You can buy LTC (via LTCEUR) with {{ this.balance }} {{ this.currency }}.
            
            
        </div>
        <div v-if="this.balanceitem.currency=='PPC'">
            You have {{ this.balanceitem.balance }} {{ this.balanceitem.currency }}<br>
            You can <b>SELL {{ this.balanceitem.trading_balance }}</b> {{ this.balanceitem.currency }} for EUR.
            
        </div>

    </div>
</template>

<script>
import Pusher from 'pusher-js' // import Pusher
    export default {
        data() {
            return {
                test: 0,
                ticker: null,
                orders: null,
                orderbook_asks: []
            }
        },
        props: {
            'balanceitem':{
                type:Object,
                default: false
            }
        },
        methods: {
            subscribe (instrument) {
                console.log(instrument+" ----");
                let pusher = new Pusher('bb1fafdf79a00453b5af')
                var order_book_channel = pusher.subscribe(instrument)
                order_book_channel.bind('orderbook', data => {
                    console.log(data);
                    this.orderbook_asks.splice(0,this.orderbook_asks.length)
                    this.orderbook_asks.pop(data.asks );
                })
            },


            fetchInstrument(instrument) {
                axios.get('/api/rock/ticker/'+instrument).then( (response) => {
                    this.ticker = response.data;
                    this.fetchOrders(instrument);
                    this.subscribe(instrument);
                })
            },
            fetchTickers() {
                axios.get('/api/rock/tickers').then( (response) => {
                    this.tickers = response.data 
                })
            },
            fetchOrders(instrument) {
                axios.get('/api/rock/orders/'+instrument).then( (response) => {
                    this.orders = response.data 
                })
            },
            
        },
        mounted() {
            
            console.log('Component Currency mounted.'+this.balanceitem.currency)
        }
    }
</script>
