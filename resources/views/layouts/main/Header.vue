<template>
    <div class="layout--main-header" :style="{left:menuTotalSpace+'px',height:navbar.height+'px'}">
        <div v-if="menu.fullSearchBar && ShowFullSearch" class="w100 flx">
            <div class="flx-auto"><CcMainsearch v-model="select" label="Search" /></div>
            <div class="center pointer" style="padding:0px 10px" @click="ShowFullSearch = !ShowFullSearch"><img src="/icons/close.svg" style="width:20px" /></div>
        </div>
        <div class="flx w100" v-if="!ShowFullSearch">
            <div class="flx-auto hide flx-md">
                <div class="center pointer" @click="toggleMenu()"><img src="/icons/list.svg" style="width:30px" /></div>
                <div class="center pointer" style="padding-left:20px" @click="ShowFullSearch = !ShowFullSearch"><img src="/icons/f-search.svg" style="width:25px" /></div>
            </div>
            <div style="flex:3" class="hide-md">
                <CcMainsearch v-model="select" label="Search" />
            </div>
            <div style="flex:2; display:flex">
                <div style="flex:1"></div>
                <div class="header-notification-container">
                    <CcNotification :iconWIdth="20" :totalNotification="3" />
                </div>
                <div class="header-propic-container">
                    <CcProfileImage :height="45" image="https://avatars.githubusercontent.com/u/4?v=4" status="active" title="James Anderson" />
                </div>            
            </div>
        </div>
    </div>
</template>
 
<script setup>
    import CcMainsearch from '../../components/cc-mainsearch.vue'
    import CcProfileImage from '../../components/cc-profile-image.vue'
    import CcNotification from '../../components/cc-notification.vue'

    import controller from './controller.js'
    const { menu, navbar, toggleMenu, menuTotalSpace} = controller;
    import { ref  } from 'vue'
    const select = ref(null)
    const ShowFullSearch = ref(false)
</script>

<style lang="scss">
    .header-notification-container{
        display: flex;
        align-items: center;
        padding: 0px 30px;
    }
    .header-propic-container{
        display: flex;
        align-items: center;
    }
</style>