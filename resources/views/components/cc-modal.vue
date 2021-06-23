<template>
    <transition name="cc-modal-animation">
        <div ref="root" class="cc-modal" v-if="props.modelValue">
            <div class="cc-modal-container" :style="{maxWidth:props.width+'px'}"><slot /></div>
        </div>
    </transition>
</template>

<script setup>
    import { defineProps, defineEmit, onMounted, ref, watch } from 'vue'
    const props = defineProps({
        modelValue: Boolean,
        width:Number,
    })
    const emit = defineEmit(['update:modelValue'])

    const root = ref(null)

    const updateValue = (value) => {
        emit('update:modelValue',value)
    }

    const setEvent = ()=>{
        if(props.modelValue == true){
            if(root.value == null){
                setTimeout(setEvent, 100);
            }else{
                root.value.addEventListener('click', (e) =>{
                    if(e.target.closest('.cc-modal-container') == null){
                        updateValue(false);
                    }
                })
            }
        }
    }

    watch(() => props.modelValue, () => {
        setEvent()
    });

    onMounted(()=>{
        setEvent()
    })
</script>

<style lang="scss">
    .cc-modal{
        position: fixed;
        top:0px;
        left:0px;
        right:0px;
        bottom:0px;
        background-color: rgb(109, 109, 109, .5);
        z-index:2;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px;
        min-width: 380px;
    }
    .cc-modal-container{
        background-color: #ffffff;
        padding: 20px;
        border-radius: 10px;
        width: 100%;
        max-height: 100vh;
    }
    .cc-modal-animation-enter-active,
    .cc-modal-animation-leave-active {
        transition: opacity 0.3s ease;
    }
    .cc-modal-animation-enter-from,
    .cc-modal-animation-leave-to {
        opacity: 0;
    }
</style>

