<template>
    <div>
        <button v-on:click="this.fetchTickersList" class="button is-primary">UPDATE {{ currency }}</button>
        <h1 class="title" v-if="this.lasttickers[0]">{{ this.lasttickers[0]['last'] }} {{ this.lasttickers[0]['fund_id'] }}</h1>
        <p v-for="(item, index) in this.lasttickers">
            
             ({{ item.bid }}) <b>{{ item.last }}</b> ({{ item.ask }}) <small>{{ item.date }}</small>
        </p>
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
                lasttickers: []
            }
        },
        methods: {
            fetchTickersList(){
                axios.get('/api/tickers/list').then( (response) => {
                    this.lasttickers = response.data 
                })
            }
        },
        mounted() {
            this.fetchTickersList();
        }
    }
</script>
