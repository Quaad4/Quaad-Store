<template>
    <div>
        <h1>Show page</h1>
    </div>
</template>
<script>
    import axios from 'axios';
    export default {
        props: [
            'id'
        ],
        mounted() {
            axios.get(`http://127.0.0.1:8000/api/orders/${this.id}`)
            .then(response => {
                console.log(response.data.data)
            })
            .catch(error => {
                console.error(error.message)
            })
        }
    }
</script>