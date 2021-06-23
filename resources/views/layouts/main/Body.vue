<template>
    <div class="layout--main-body" :style="{marginLeft:menuTotalSpace+'px', marginTop:navbar.height+'px'}">
        <slot />
    </div>
</template>

<script setup>
    import controller from './controller.js'
    const { menu, navbar, menuTotalSpace} = controller;
</script>