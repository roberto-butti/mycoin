<template>
    <div class="container">
        With {{ currency }} you can:
        <div v-if="currency=='LTC'">
            <b>SELL</b> LTC via LTCEUR with {{ this.balance }} {{ this.currency }}.
            I suggest to SELL {{ this.balance }} {{ this.currency }}
            at price 
        </div>
        <div v-if="currency=='EUR'">
            <b>BUY</b> LTC.
            You can buy LTC (via LTCEUR) with {{ this.balance }} {{ this.currency }}.
            
            
        </div>
        <div v-if="currency=='PPC'">
            <b>SELL {{ this.balance }}</b> PPC for EUR.
            You can buy LTC (via LTCEUR).
            
            
        </div>

    </div>
</template>

<script>

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
            },
            'balance': {
                type: Number,
                default: 0
                
            }
        },
        methods: {
            fetchInstrument(instrument) {
                axios.get('/api/rock/tickers/'+instrument).then( (response) => {
                    this.tickers = response.data 
                })
            },
            fetchTickers() {
                axios.get('/api/rock/tickers').then( (response) => {
                    this.tickers = response.data 
                })
            },
        },
        mounted() {
            
            console.log('Component Currency mounted.'+this.currency)
        }
    }
</script>
