<template>
    <div class="container">
{{ this.instrument }}
    </div>
</template>

<script>
    export default {
        props: {
            'instrument':{
                type:String,
                default: "BTCEUR"
            }
        },
        mounted() {
            console.log('Component mounted.'+this.instrument)
        }
    }
</script>
