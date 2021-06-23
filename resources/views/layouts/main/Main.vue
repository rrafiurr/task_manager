<template>
  <div class="layout--main">
    <LayoutMenubar />

    <LayourBody>
      <LayoytHeader />
      <div style="flex:auto;">
        <div><router-view /></div>
      </div>
    </LayourBody>
  </div>
</template>
 
<script setup>
    import LayoutMenubar from './Menubar.vue';
    import LayourBody from './Body.vue';
    import LayoytHeader from './Header.vue';
    import LayoutFooter from './Footer.vue';

    import {onBeforeMount} from 'vue'
    import controller from './controller.js'

    const { innitialLoader, resizeController } = controller;

    onBeforeMount(()=>{
        innitialLoader();
        window.addEventListener('resize', resizeController);
    })
</script>