<template>
  <div>
    <div class="cc-inp-lebel">{{props.label}}</div>
    <div><input class="cc-input" type="text" :placeholder="props.placeHolder" :value="props.modelValue" v-on:input="updateValue($event.target.value)"/></div>
  </div>
</template>

<script setup>
    import { defineProps, defineEmit, computed } from 'vue'
    const props = defineProps({
        label: String,
        modelValue: String,
        placeHolder: String,
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
  .cc-input{
     padding: 10px 15px;
     font-size: 16px;
     border-width: 1px;
     border-color: #EFF1F6;
     background-color: #FFFFFF;
     color: #000000;
     border-style: solid;
     border-radius: 10px;
     width:100%;
  }
  .cc-input:focus {
     outline:none;
  }
  .cc-inp-lebel{
    padding: .5em 0em;
    font-weight: bold;
    font-size: 1rem;
  }
</style>