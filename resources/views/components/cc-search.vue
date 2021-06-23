<template>
    <div>
        <div class="cc-search-container">
            <div :style="{width:'30px'}"></div>
            <div style="flex:auto"><input class="cc-search" type="text" @focus="handleFocus" @blur="handleBlur" :placeholder="props.label" :value="props.modelValue" v-on:input="updateValue($event.target.value)"/></div>
            <div class="cc-search-icon-container">
                <img src="/icons/loupe.svg" alt="*">
            </div>
        </div>
        <div class="cc-select-options-container">
            <transition name="cc-select-options-animation">
                <div class="cc-select-options" v-if="toggleOptions">
                    <div class="cc-select-option-item-container">
                        <div class="cc-select-option" v-for="(item, index) in props.options" :key="index" @click="selectedItem(item)">
                            <div class="cc-select-option-image"><img :src="item.avatar_url" style="width:50px" /></div>
                            <div class="cc-select-option-text">{{item.login}}</div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>

<script setup>
    import { defineProps, defineEmit, computed, ref } from 'vue'
    const props = defineProps({
        label: String,
        modelValue: String,
        size: String,
        options: Array,
        select:Object,
    })
    const emit = defineEmit(['update:modelValue'])
    const toggleOptions = ref(false);
    const updateValue = (value) => {
        emit('update:modelValue',value)
    }
    
    const size = computed(() => {
      return props.size ? props.size : 'md'
    })

    const handleFocus = (e) => {
        toggleOptions.value = true
    }
    const handleBlur = (e) => {
        toggleOptions.value = false
    }
    const selectedItem = (item) => {
        updateValue('');
        emit('select',item)
    }    

</script>

<style lang="scss">
    .cc-search-container{
        display: flex;
        position: relative;
        background-color: #FFFFFF;
        border-radius: 10px;
        border-width: 1px;
        border-color: #EFF1F6;
        border-style: solid;
    }
    .cc-search-icon-container{
        position: absolute;
        top: 0px;
        left: 0px;
        padding: 12px 0px 5px 20px;
    }
    .cc-search-icon-container img{
        width:15px
    }
    .cc-search{
        padding: 10px 15px;
        font-size: 16px;
        background-color: #FFFFFF;
        color: #000000;
        border-radius: 10px;
        width:100%;
        border-width: 0px;
    }
    .cc-search:focus {
        outline:none;
    }
    .cc-search-lebel{
        padding: .5em 0em;
        font-weight: bold;
        font-size: 1rem;
    }
    .cc-select-options-container{
        position: relative;
        width:100%;
    }
    .cc-select-options{
        position: absolute;
        top:2px;
        left:0px;
        right:0px;
        z-index: 28888888;
    }
    .cc-select-option-item-container{
        border-radius: 10px;
        overflow:hidden;
        border: 1px solid #EFF1F6;
        max-height:300px;
        overflow-y: auto;
    }
    .cc-select-option{
        padding: .8em;
        font-size: 1rem;
        background-color: rgb(255, 255, 255);
        cursor: pointer;
        display:flex;
    }
    .cc-select-option-text{
        display: flex;
        align-items: center;
        padding:0px 15px;
        flex:auto;
        font-size:14px;
        color: #4d4d64;
    }
    .cc-select-option-image{
        border-radius: 50%;
        overflow: hidden;
    }
    .cc-select-option:hover{
        background-color: #F9FAFC;
    }
    .cc-select-options-animation-enter-active,
    .cc-select-options-animation-leave-active {
        transition: opacity 0.3s ease;
    }
    .cc-select-options-animation-enter-from,
    .cc-select-options-animation-leave-to {
        opacity: 0;
    }


</style>