<template>
    <div class="cc-profile-image-main-container">
        <div class="profile-image-container">
            <div class="profile-image-box" :style="{height:props.height+'px', width:props.height+'px'}">
                <img :src="props.image" style="width:100%" />
            </div>
            <div class="profile-image-status" :style="{backgroundColor:statusColor}"></div>
        </div>
        <div class="profile-image-title">{{props.title}}</div>
    </div>
</template>
<script setup>
import { defineProps, ref, computed } from 'vue'
const props = defineProps({
    height:Number,
    title:String,
    status:String,
    image:String,
})

const statusColor = computed(() => {
    if(props.status == 'active'){
        return '#3EB75E'
    }else{
        return '#9c9c9c'
    }
})




</script>


<style lang="scss">
    .cc-profile-image-main-container{
        display: flex;
    }
    .profile-image-container{
        position: relative;

    }
    .profile-image-box{
        border-radius: 50px;
        overflow: hidden ;
        border: 1px solid rgb(230, 230, 230);
    }
    .profile-image-status{
        border-radius: 50%;
        position: absolute;
        bottom: 5%;
        right: 5%;
        width: 15px;
        height: 15px;
        border: 1px solid #FFFFFF;
    }
    .profile-image-title{
        flex: auto;
        display: flex;
        align-items:center;
        padding-left:20px;
        color: #808191;
        font-size:14px;
    }
</style>