<template>
<div class="container">
    <div class="columns is- is-marginless">
        <div class="column is-4">
            <table class="table is-bordered is-striped is-narrow is-fullwidth">
            <thead>
            <tr>
                <th colspan="3">BID / BUY {{ this.instrument }}</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Quantity</th>
                <th>Value</th>
                <th>Depth</th>
            </tr>
            </tfoot>
            <tbody >
                <tr v-for="(item, index) in orderbook_bids">
                     <td>{{ item.price}}</td>
                    <td>{{ item.amount}}</td>
                    <td>{{ item.depth}}</td>
                </tr>
            </tbody>
            </table>
        </div>
        <div class="column is-4">
            <table class="table is-bordered is-striped is-narrow is-fullwidth">
            <thead>
            <tr>
                <th colspan="3">ASKS / SELL {{ this.instrument }}</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Quantity</th>
                <th>Value</th>
                <th>Depth</th>
            </tr>
            </tfoot>
            <tbody >
                <tr v-for="(item, index) in orderbook_asks">
                     <td>{{ item.price}}</td>
                    <td>{{ item.amount}}</td>
                    <td>{{ item.depth}}</td>
                </tr>
            </tbody>
            </table>
        </div>
    </div>
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
                orderbook: [],
                orderbook_bids: [],
                orderbook_asks: [],
                orderbook_loading: false,
                newtrade: [ ]

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
                console.log("Subscribe to orderbook:"+this.instrument);
                pusher.subscribe(this.instrument);
                
                pusher.bind('orderbook', data => {
                    console.log(data);
                    console.log(this.orderbook);
                    this.orderbook.unshift(data /*{ "symbol": data["symbol"], "value": data["value"]}*/);
                    if (this.orderbook.length >10) {
                        this.orderbook.pop();
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
