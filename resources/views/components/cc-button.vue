<template>
    <div class="cc-button" :style="{borderWidth: props.border == undefined ? '0px' : props.border+'px', backgroundColor:props.color, fontSize:props.textSize+'px', padding:padding}">
        <div style="display:flex">
            <div v-if="props.icon != undefined" class="cc-button-icon-container"><img :src="`/icons/${props.icon}.svg`" :style="{width:props.textSize+'px'}"></div>
            <div :style="{color:textColor}">{{props.label}}</div>
        </div>
    </div>
</template>
<script setup>
import { defineProps, defineEmit, computed } from 'vue'
const props = defineProps({
    label: String,
    color:String,
    icon:String,
    border:Number,
    textSize:Number,
    textColor:String,
    size: String,
    padding:Number,
})

const padding = computed(() => {
    if(props.padding == undefined){
        return '.6em 1.1em'
    }else{
        return `${.6*props.padding}em ${1.1*props.padding}em`
    }
})

</script>
<style lang="scss">
    .cc-button{
        border-radius: 50px;
        border-color: #dfdfdf;
        border-style: solid;
        display: inline-block;
        cursor: pointer;
    }
    .cc-button-icon-container{
        display: flex;
        padding-right: .5em;
    }
</style>