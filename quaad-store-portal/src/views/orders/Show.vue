<template>
    <div>
        <h1>Show page</h1>
    </div>
</template>
<script>
    export default {
        props: [
            'id'
        ],
        mounted() {
            console.log(this.id)
        }
    }
</script>