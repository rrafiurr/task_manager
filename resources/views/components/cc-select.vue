<template>
  <div>
    <div class="cc-select-lebel">{{props.label}}</div>
    <div><input class="cc-select" @focus="handleFocus" @blur="handleBlur" type="text" :placeholder="props.label" :value="props.modelValue" v-on:input="updateValue($event.target.value)"/></div>
    <div class="cc-select-options-container">
        <transition name="cc-select-options-animation">
            <div class="cc-select-options" v-if="toggleOptions">
                <div class="cc-select-option-item-container">
                    <div class="cc-select-option" v-for="(item, index) in props.options" :key="index" @click="selectedItem(item)">
                        {{item}}
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
        options: Array,
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
        updateValue(item);
    }

</script>

<style lang="scss">
    .cc-select{
        padding: 10px 15px;
        font-size: 16px;
        border-width: 1px;
        border-color: #EFF1F6;
        background-color: #FFFFFF;
        color: #000000;
        border-style: solid;
        border-radius: 10px;
        width: 100%;
    }
    .cc-select:focus {
        outline:none;
    }
    .cc-select-lebel{
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
    }
    .cc-select-option{
        padding: .8em;
        font-size: 1rem;
        background-color: rgb(255, 255, 255);
        cursor: pointer;
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