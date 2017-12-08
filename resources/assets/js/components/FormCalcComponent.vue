<template>
    <div>
        <div class="columns is- is-marginless">
            <div class="column is-6">
                <button v-on:click="this.fetchTickerLast" class="button is-primary">UPDATE {{ currency }}</button>
            </div>
            <div class="column is-6" v-if="loading">
                Updating
            </div>
        </div>
        <div class="columns is- is-marginless">
            <div class="column is-4">
                <div class="field">
                <label class="label">QTY </label>
                <div class="control">
                    <input class="input" type="number" placeholder="Quantity" v-model.number="qty">
                </div>
                <p class="help">Quantity</p>
                </div>
            </div>
            <div class="column is-4">
                <label class="label">Price</label>
                <div class="control">
                    <input class="input" type="number" placeholder="Price" v-model.number="price">
                </div>
                <p class="help">Price</p>
            </div>
            <div class="column is-4">
                <label class="label">Value</label>
                <div class="control">
                    <input id="currentvalue" class="input" type="number" v-model.number="currentvalue" placeholder="Current Value" >
                </div>
                <p class="help">Current Value</p>
            </div>            
        </div>
        total: {{ total }}<br>

        ESTIMATED: {{ estimatedtotal }}<br>
        DIFFERENCE: {{ difference }} <b>{{ differencepercentile }}%</b><br>
        
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
                qty:0.005,
                price:12800,
                currentvalue:0,
                loading: false
            }
        },
        methods: {
            rounded: function(number) {
                return number.toFixed(3);
            },
            fetchTickerLast(){
                this.loading=true;
            axios.get('/api/ticker/last').then( (response) => {
                this.origs = response.data
                console.log(this.origs.last)
                //document.getElementById("currentvalue").value = this.origs.last;
                this.currentvalue = this.origs.last;
                this.loading = false;

            })
        }
        },
        computed: {
            total: function () {
                //return Math.round(this.qty * this.price * 1000) / 1000;
                return this.rounded((this.qty * this.price));
                
            },
            estimatedtotal: function () {
                return this.rounded((this.qty * this.currentvalue));
                
            },
            difference: function() {
                return this.rounded((this.estimatedtotal - this.total));
            },
            differencepercentile: function() {
                return this.rounded((this.difference*100) / this.total) ;
            }
        },
        mounted() {
            console.log('Component mounted.')
            //this.$root.fetchTickerLast()
            this.fetchTickerLast()
        }
    }
</script>
