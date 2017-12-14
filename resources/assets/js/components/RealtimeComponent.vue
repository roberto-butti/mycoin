<template>
<div>
    new_offer
    <p v-for="(item, index) in this.newoffer">
        {{ item['symbol'] }}
        {{ item['value'] }}
    </p>
    

    <br>
{{ orderbookdiff }}
    </div>
</template>

<script>
import Pusher from 'pusher-js' // import Pusher
    export default {
        data() {
            return {
                test: 0,
                newoffer:[],
                orderbookdiff:null
            }
        },
        props: {

        },
        methods: {
            subscribe () {
                let pusher = new Pusher('bb1fafdf79a00453b5af')
                pusher.subscribe('currency')
                pusher.bind('new_offer', data => {
                    
                    this.newoffer.unshift({ "symbol": data["symbol"], "value": data["value"]});
                    if (this.newoffer.length >10) {
                        this.newoffer.pop();
                    }
                    //console.log(this.newoffer);
                })
                /**
                var order_book_channel = pusher.subscribe('LTCEUR');
                order_book_channel.bind('orderbook_diff', function(data) {
                    this.orderbookdiff=data;
                    console.log(data);
                    //console.log("price: " + data['price']);
                    //console.log("amount: " + data['amount']);
                });
                 */
            }
        },
        mounted() {
            this.subscribe();
            //console.log('Component Realtime mounted.')
        }
    }
</script>

