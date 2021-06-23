<template>
    <div class="cc-icon" :style="{borderWidth: props.border == undefined ? '0px' : props.border+'px', backgroundColor:props.color, fontSize:props.iconSize+'px'}">
        <img :src="`/icons/${props.icon}.svg`" :style="{width:props.iconSize+'px',display:'block'}">
    </div>
</template>
<script setup>
import { defineProps, defineEmit, computed } from 'vue'
const props = defineProps({
    color:String,
    icon:String,
    border:Number,
    iconSize:Number,
    size: String,
})
</script>
<style lang="scss">
    .cc-icon{
        border-radius: 50px;
        border-color: #EFF1F6;
        border-style: solid;
        display: inline-block;
        padding: .6em;
        cursor: pointer;
    }
</style>