<template>
    <div class="cc-main-serach-container">
        <div :style="{width:'35px'}"></div>
        <div style="flex:auto"><input class="cc-main-serach" type="text" :placeholder="props.label" :value="props.modelValue" v-on:input="updateValue($event.target.value)"/></div>
        <div class="cc-main-serach-icon-container">
            <img src="/icons/search.svg" alt="*">
        </div>
    </div>
</template>

<script setup>
    import { defineProps, defineEmit, computed } from 'vue'
    const props = defineProps({
        label: String,
        modelValue: String,
        size: String,
    })
    const emit = defineEmit(['update:modelValue'])

    const updateValue = (value) => {
        emit('update:modelValue',value)
    }
    
    const size = computed(() => {
      return props.size ? props.size : 'md'
    })

</script>

<style lang="scss">
    .cc-main-serach-container{
        display: flex;
        position: relative;
        background-color: #FFFFFF;
        border-radius: 50px;
        padding: 20px 25px;
    }
    .cc-main-serach-icon-container{
        position: absolute;
        top: 0px;
        left: 0px;
        padding: 20px 0px 25px 20px;
    }
    .cc-main-serach-icon-container img{
        width:20px
    }
    .cc-main-serach{
        font-size: 18px;
        border-width: 0px;
        background-color: #FFFFFF;
        color: #000000;
        width: 100%;
    }
    .cc-main-serach:focus {
        outline:none;
    }
</style>