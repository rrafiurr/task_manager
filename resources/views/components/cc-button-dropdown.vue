<template>
    <div class="cc-button-dropdown-container">
        <div class="cc-button-dropdown-btn" @click="toggleBtn = !toggleBtn">
            <img :src="`/icons/ellipsis.svg`" :style="{width:'20px'}">
        </div>
        <div v-if="toggleBtn" class="cc-button-dropdown-options-container">
            <div class="cc-button-dropdown-options">
                <slot />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
const toggleBtn = ref(false);
document.addEventListener('click', (e) =>{
    if(e.target.closest('.cc-button-dropdown-btn') == null){
        toggleBtn.value = false;
    }
})
</script>
<style lang="scss">
    .cc-button-dropdown-container{
        position: relative;
        display: inline-block;
    }
    .cc-button-dropdown-btn{
        cursor: pointer;
    }
    .cc-button-dropdown-options-container{
        position: absolute;
        z-index: 1;
        top:15px;
        right:0px;
    }
    .cc-button-dropdown-options{
        width:100%;
        background-color: #FFFFFF;
        border: 1px solid #f8f7f7;
        width: 120px;
        border-radius: 10px;
        padding: 10px;
    }
</style>
