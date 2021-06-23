<template>
    <div class="cc-notification-container">
        <div class="cc-notification-icon">
            <img :src="`/icons/notification.svg`" :style="{width:props.iconWIdth+'px'}" />
        </div>
        <div class="cc-notification-number" :style="{width:iconNumberWIdth+'px', height:iconNumberWIdth+'px'}">{{props.totalNotification}}</div>
    </div>
</template>

<script setup>
import { defineProps, ref, computed } from 'vue'
const props = defineProps({
    iconWIdth:Number,
    totalNotification:Number,
    notificationList:Array,
})

const iconNumberWIdth = computed(()=>{
    return props.iconWIdth * .8
})
</script>


<style lang="scss">
    .cc-notification-container{
        position: relative;
        display: inline-block;
    }
    .cc-notification-icon{
        cursor: pointer;
    }
    .cc-notification-number{
        position: absolute;
        top:-20%;
        right:-50%;
        border-radius: 50%;
        background-color: #ff9100;
        border: 1px solid #ffffff;
        font-size:10px;
        line-height: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color:#ffffff;
    }
</style>

