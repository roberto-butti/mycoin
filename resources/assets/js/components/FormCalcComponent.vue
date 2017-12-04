<template>
    <div >
        <div class="field">
        <label class="label">Quantity of {{ currency }}</label>
        <div class="control">
            <input class="input" type="number" placeholder="Quantity" v-model.number="qty">
        </div>
        <p class="help">Quantity</p>

        <label class="label">Price</label>
        <div class="control">
            <input class="input" type="number" placeholder="Price" v-model.number="price">
        </div>
        <p class="help">Price</p>
        
        </div>
        total: {{ total }}<br>

        <label class="label">Current Value</label>
        <div class="control">
            <input class="input" type="number" v-model.number="currentvalue" placeholder="Current Value" >
        </div>
        <p class="help">Current Value</p>
        ESTIMATED: {{ estimatedtotal }}<br>
        
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
                qty:3.5,
                price:2.8,
                currentvalue: 3.5*2.8
                
                
            }
        },
        computed: {
            total: function () {
                return this.qty * this.price;
                
            },
            estimatedtotal: function () {
                return this.qty * this.currentvalue;
                
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
