<template>
    <div class="container">
        With {{ currency }} you can:
        <div v-if="currency=='EUR'">
            <b>BUY</b> LTC.
            You can buy LTC (via LTCEUR).
            
        </div>
    </div>
</template>

<script>
import Pusher from 'pusher-js' // import Pusher
    export default {
        data() {
            return {
                test: 0
            }
        },
        props: {
            'currency':{
                type: String,
                default: ""
            }
        },
        methods: {
            subscribe () {
                let pusher = new Pusher('bb1fafdf79a00453b5af')
                pusher.subscribe('currency')
                pusher.bind('new_offer', data => {
                    //console.log(data);
                })
                var order_book_channel = pusher.subscribe('LTCEUR');
                order_book_channel.bind('orderbook_diff', function(data) {
                    console.log(data);
                    //console.log("price: " + data['price']);
                    //console.log("amount: " + data['amount']);
                });
            }
        },
        mounted() {
            //this.subscribe();
            console.log('Component Currency mounted.'+this.currency)
        }
    }
</script>
