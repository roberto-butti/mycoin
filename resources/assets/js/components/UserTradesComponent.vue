<template>
    <div>
        <button v-on:click="this.fetchUserTradesList" class="button is-primary">UPDATE {{ instrument }}</button>
        
        <p v-for="(item, index) in this.usertrades['trades']">
            
            ({{ item.side }} - {{ item.fund_id }}) <b>{{ item.amount }}</b> ({{ item.price }}) <small>{{ item.date }}</small>
        </p>
    </div>

</template>

<script>
    export default {
        props: {
            'instrument':{
                type: String,
                default: "BTCEUR"
            }
        },
        data() {
            return {
                loading: false,
                usertrades: []
            }
        },
        methods: {
            fetchUserTradesList(){
                axios.get('/api/rock/trades/'+this.instrument).then( (response) => {
                    this.usertrades = response.data 
                })
            }
        },
        mounted() {
            this.fetchUserTradesList();
        }
    }
</script>
