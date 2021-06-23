<template>
<div class="cc-propic-list-container" :style="{height:props.height+'px',width:containerWidth+'px'}">
    <div class="cc-propic-list-item" v-for="index in loopLenght" :key="index" :style="{height:props.height+'px', width:props.height+'px',left:(shift*(index-1))+'px' }">
        <img :src="props.list[index-1][props.listTarget]" :style="{height:props.height+'px', width:props.height+'px', display:'block'}"/>
    </div>
    <div v-if="(extImgList > 0)" class="cc-propic-list-item cc-propic-list-item-ext" :style="{height:props.height+'px', width:props.height+'px',left:(shift*3)+'px' }">
        <div>{{extImgList}}+</div>
    </div>

</div>
</template>


<script setup>
import { defineProps, ref, computed } from 'vue'
const props = defineProps({
    height:Number,
    list:Array,
    listTarget:String,
})


var shiftSize = .6;
const shift = computed(() => props.height * shiftSize)
const extImgList = computed(() => props.list.length - 3)
const loopLenght = computed(() => {
    if(props.list.length > 3){
        return 3
    }else{
        return props.list.length
    }
})

const containerWidth = computed(() => {
    if(props.list.length > 3){
        return 4*props.height*shiftSize+props.height*shiftSize
    }else{
        return props.list.length*props.height*shift+props.height*shift
    }
})
</script>
<style lang="scss">
    .cc-propic-list-container{
        position: relative;
    }
    .cc-propic-list-item{
        position: absolute;
        top:0px;
        border-radius: 50px;
        overflow: hidden;
        border: 2px solid rgb(255, 255, 255);
    }
    .cc-propic-list-item-ext{
        background-color: #E7FAFF;
        display: flex;
        align-items:center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
        color: #5F75EE;
    }
</style>