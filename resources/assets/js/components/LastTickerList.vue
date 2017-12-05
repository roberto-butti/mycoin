<template>
    <div>
        <h1 class="title" v-if="this.lasttickers[0]">{{ this.lasttickers[0]['last'] }}</h1>
        <p v-for="(item, index) in this.lasttickers">
            
            {{ index}} {{ item.date }} - {{ item.last }} - {{ item.fund_id }}
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
