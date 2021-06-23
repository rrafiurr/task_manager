<template>
    <div class="cc-title-container">
        <div class="cc-title-status">
            <div class="cc-title-status-icon" :style="{backgroundColor:statusColor}"></div>
        </div>
        <div class="cc-title" :style="{fontSize:props.fontSize+'px'}">{{ props.title }}</div>
    </div>
</template>
<script setup>
import { defineProps, ref, computed } from 'vue'
const props = defineProps({
    fontSize:Number,
    title:String,
    status:String,
})

const statusColor = computed(()=>{
    if(props.status == 'Importent'){
        return '#0049C6'
    }else if(props.status == 'Irrelevant'){
        return '#FCC865'
    }else{
        return '#E0E2E8'
    }
})
</script>


<style lang="scss">
    .cc-title-container{
        display: flex;
    }
    .cc-title-status{
        display: flex;
        align-items: center;
    }
    .cc-title{
        flex:auto;
        color: #0E0E0E;
        padding-left:10px;
        font-weight: bold;
    }
    .cc-title-status-icon{
        padding:3px;
        border-radius: 50%;
    }
</style>