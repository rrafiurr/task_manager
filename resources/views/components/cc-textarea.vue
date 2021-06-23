<template>
  <div>
    <div class="cc-textarea-lebel">{{props.label}}</div>
    <div>
        <textarea class="cc-textarea" :rows="props.rows" type="text" :value="props.modelValue" v-on:input="updateValue($event.target.value)">

        </textarea>
    </div>
  </div>
</template>

<script setup>
    import { defineProps, defineEmit, computed } from 'vue'
    const props = defineProps({
        label: String,
        modelValue: String,
        size: String,
        rows: Number,
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
  .cc-textarea{
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
  .cc-textarea:focus {
     outline:none;
  }
  .cc-textarea-lebel{
    padding: .5em 0em;
    font-weight: bold;
    font-size: 1rem;
  }
</style>