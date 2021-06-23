<template>
<div>
    <div class="layout--main-menubar" v-if="menu.status == true" :style="{right:floatingShadow == true ? 0 : 'auto'}">
        <div class="layout--main-menu-icon-container"  :style="{width:menu.minifyMenuWidth+'px', height:'100vh'}" >
            <div>
                <img src="/logo.png" style="width:100%" />
            </div>
            <div class="menu-icon-container">
                <div class="menu-icon" v-for="(item, index) in menuData" :key="index" :style="{backgroundColor:selectedMenu == item.name ? '#FFFFFF' : ''}" @click="menuSelected(item.name,index)">
                    <img :src="`/icons/${item.icon}.svg`" :style="{width:'20px',filter:selectedMenu == item.name ? 'brightness(0%)' : 'brightness(100%)'}" />
                </div>
            </div>
        </div>
        <div class="layout--main-detail-container" v-if="menu.menuDetail" :style="{width:menu.menuWidth+'px'}">
            <div class="menu-detail-header">
                <div class="menu-detail-header-title">Project</div>
                <div class="menu-detail-header-icon"><CcIcon color="#0049C6" :iconSize="14" icon="plus-black" /></div>
            </div>
            <div style="height:70px"></div>
            <div v-for="(item, index) in menuItem" :key="index" class="menu-detail-container">
                <div class="menu-detail">
                    <div class="menu-detail-icon"><img :src="`/icons/${item.icon}.svg`" style="width:15px" /></div>
                    <div class="menu-detail-name">{{ item.name }}</div>
                    <div class="menu-detail-arrow"></div>
                </div>
                <div v-for="(subItem , subIndex) in item.subItem" :key="subIndex" class="menu-detail-sub">
                    <div class="menu-detail-sub-gap"></div>
                    <div class="menu-detail-sub-title">{{subItem.name}}</div>
                </div>
            </div>
        </div>
        <div @click="toggleMenu()" style="flex:auto"></div>
    </div>
</div>
</template>
 
<script setup>
    import CcIcon from '../../components/cc-icon.vue'


    import controller from './controller.js'
    import { menuData } from './menu.js'
    import { ref, reactive, onMounted, computed  } from 'vue'
    const { menu, floatingShadow, toggleMenu, pindetail } = controller;

    const selectedMenu = ref('home');
    const menuItem = reactive([])

    const menuSelected = (item,index) => {
        selectedMenu.value = item
        menuItem.length = 0;
        menuItem.push(...menuData[index].items);
        menu.menuDetail = true;
        console.log(menuItem);
    }
    onMounted(()=>{
        menuItem.push(...menuData[0].items)
    })
    
</script>

<style lang="scss">
    .menu-icon-container{
        padding: 20px 10px 10px 10px;
        display: flex;
        flex-direction: column;
    }
    .menu-icon{
        border-radius: 20px;
        width: 60px;
        height: 60px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }

    .menu-detail-header{
        display: flex;
        padding-bottom:30px;
        &-title{
            font-size: 20px;
            font-weight: bold;
            flex:auto;
            padding-top: 3px;
        }
    }
    .menu-detail{
        display: flex;
        padding: 8px 0px; 
        color: #808191;
        font-weight: bold;
        &-icon{
            width:35px;
        }
        &-name{
           
        }
    }
    .menu-detail-sub{
        display: flex;
        &-gap{
            width:35px;
        }
        &-title{
            padding: 8px 0px;
            color: #808191;
        }
    }
</style>