<template>
    <div class="container">
{{ this.instrument }}
<p v-for="(item, index) in orderbook_bids">
    {{ item.amount}}
    {{ item.depth}}
    {{ item.price}}
</p>

--------
<p v-for="(item, index) in this.newtrade">
        {{ item['symbol'] }}
        {{ item['value'] }}
    </p>
    </div>
</template>

<script>
import Pusher from 'pusher-js' // import Pusher
    export default {
        props: {
            'instrument':{
                type:String,
                default: "BTCEUR"
            }
        },
        data() {
            return {
                orderbook_bids: [],
                orderbook_asks: [],
                orderbook_loading: false,
                newtrade: []

            }
        },
        methods: {
            loadOrderbook(){
                this.loadingOrderBook=true;
                axios.get('api/rock/orderbook/'+this.instrument+'/5').then( (response) => {
                    console.log(response.data.bids);
                    this.orderbook_loading=false;
                    this.orderbook_bids = response.data.bids;
                    this.orderbook_asks = response.data.asks;

                    return response.data;
                    
                })
                
            },
            subscribe () {
                this.newtrade=[];
                let pusher = new Pusher('bb1fafdf79a00453b5af');
                pusher.subscribe('currency')
                
                pusher.bind('last_trade', data => {
                    //console.log(data);
                    console.log(this.newtrade);
                    this.newtrade.unshift(data /*{ "symbol": data["symbol"], "value": data["value"]}*/);
                    if (this.newtrade.length >10) {
                        this.newtrade.pop();
                    }
                });

            }

        },
        mounted() {
            
            this.subscribe();
            console.log('Component mounted.'+this.instrument);
            console.log(this.loadOrderbook());
        }
    }
</script>
