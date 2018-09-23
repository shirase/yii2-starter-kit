<template>
    <div class="component">

    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                loading: true,
            }
        },
        methods: {

        },
        created() {
            const data = this.$attrs.data || {};
        },
    }
</script>