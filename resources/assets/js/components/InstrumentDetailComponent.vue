<template>
<div class="container">
    <div class="columns">
        <div class="column is-8">
            <table class="table  is-striped is-narrow is-fullwidth">
            <thead>
            <tr>
                <th colspan="9">
                    Lista ordini per {{ this.instrument }}
                </th>
                <th>
                    
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in myorders['orders']">
                
                <td>{{ item['id'] }}</td>
                <td>{{ item.fund_id }}</td>
                <td>{{ item['side'] }}</td>
                <td>{{ item['type'] }}</td>
                <td>{{ item['status'] }}</td>
                <td>{{ item['price'] }}</td>
                <td>{{ item['amount'] }}</td>
                <td>{{ item['amount_unfilled'] }}</td>
                <td>{{ item['date'] }}</td>

            </tr>
            </tbody>
            </table>


        </div>
        
        <div class="column is-2" v-for="(operation, index_operation) in ['bids', 'asks']">
            <table class="table  is-striped is-narrow is-fullwidth">
            <thead>
            <tr>
                <th colspan="2">
                    {{ operation }} per {{ this.instrument }}
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in orderbook[operation]">
                <td>{{ item.price }}</td>
                <td>{{ item.amount }}</td>
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
                newtrade: [ ],
                selected_instrument: "",
                loadingMyOrders: false,
                myorders: [],
                subscribed_channel: false,
                pusher: null

            }
        },
        watch: {
            // whenever question changes, this function will run
            instrument: function (newInstrument) {
                this.initInstrument(newInstrument);
                
            }
        },
        methods: {
            loadmMyOrders(instrument) {

                this.loadingMyOrders=true;
                axios.get('api/rock/orders/'+instrument).then( (response) => {
                    console.log(response.data);
                    this.loadingMyOrders=false;
                    this.myorders = response.data;
                    return response.data;
                })
            },
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
            subscribe (instrument) {
                this.newtrade=[];
                var wantBind=false;
                if (! this.pusher) {
                    this.pusher = new Pusher('bb1fafdf79a00453b5af');
                    wantBind = true;
                }
                
                console.log("Subscribe to orderbook:"+instrument);
                if (this.subscribed_channel) {
                    this.pusher.unsubscribe(this.subscribed_channel);
                    this.orderbook=[];
                }
                this.pusher.subscribe(instrument);
                this.subscribed_channel=instrument;        
                if (wantBind) {
                    this.pusher.bind('orderbook', data => {
                        this.orderbook = data;
                    });

                }
            },
            initInstrument(instrument) {
                this.selected_instrument = instrument;
                this.subscribe(instrument);
                console.log(this.loadmMyOrders(instrument));

            }

        },
        mounted() {
            

            this.initInstrument(this.instrument);
            console.log('Component mounted, with initial instrument: '+this.instrument);
        }
    }
</script>
