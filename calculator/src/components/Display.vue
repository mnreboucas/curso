<template>
    <div class="display">
        {{ value }}
    </div>
</template>

<script>
export default {
    props: ['value']
}
</script>

<style>
    .display {
        grid-column: span 4;
        background-color: #0004;

        display: flex;
        justify-content: flex-start;
        align-items: center;
        padding: 20px;
        font-size: 1cm;
        overflow: visible;
    }
</style>