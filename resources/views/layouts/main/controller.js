import { reactive, computed } from 'vue'
const menu = reactive({
    minifyMenuWidth:80,
    menuWidth:250,
    status:true,
    statusSelected:true,
    menuDetail:true,
    pinned:true,
    smBreakPoint:500,
    xlBreakPoint:1200,
    lgBreakPoint:1000,
    mdBreakPoint:700,
    windowWidth:0,
    fullSearchBar:true,
})
var navbar = reactive({
    height:90,
});
const memory = {
    status:null,
    menuDetail:null,
}
 
const menuTotalSpace = computed(() => {
    if(menu.windowWidth < menu.mdBreakPoint){
        return 0;
    }else{
        if(menu.status == true && menu.pinned == true){
            return menu.menuWidth + menu.minifyMenuWidth;
        }else if(menu.status == true && menu.pinned == false){
            return menu.minifyMenuWidth;
        }else{
            return 0;
        }
    }
})
const floatingShadow = computed(() => 
{
    if(menu.windowWidth < menu.mdBreakPoint && menu.status == true){
        return true;
    }else{
        if(menu.menuDetail == true && menu.pinned == false  && menu.status == true){
            return true;
        }
    }
    return false;
})

const pindetail = () => {
    if(menu.pinned == true){
       menu.pinned = false;
       menu.menuDetail = false;
    }else{
        menu.pinned = true;
    }
}
const toggleMenu = () => {
    if(window.innerWidth > menu.mdBreakPoint){
        menu.status == true ?  menu.menuDetail = false : menu.status = true; 
    }else{
        menu.status == true ?  menu.status = false : menu.status = true; menu.menuDetail = true
    }
   
}

const resizeController = () => {
    menu.windowWidth = window.innerWidth;
    menu.fullSearchBar = false;
    if(window.innerWidth > menu.xlBreakPoint){
        console.log('cc')
        if(memory.status == true){ menu.status = true;}
        if(memory.menuDetail == true){
            menu.menuDetail = true;
            menu.pinned = true;
        }
    }else if(window.innerWidth > menu.lgBreakPoint){
        if(memory.status == true){ menu.status = true;}
        menu.menuDetail=false;
        menu.pinned=false;
    }else if(window.innerWidth > menu.mdBreakPoint){
        if(memory.status == true){ menu.status = true;}
        menu.menuDetail=false;
        menu.pinned=false;
    }else{
        menu.status = false;
        menu.fullSearchBar = true;
    }



}

const innitialLoader = () => {
    menu.windowWidth = window.innerWidth;
    memory.status = menu.status;
    memory.menuDetail = menu.menuDetail;

    menu.fullSearchBar = false;
    if(window.innerWidth > menu.xlBreakPoint){

    }else if(window.innerWidth > menu.lgBreakPoint){
        menu.menuDetail=false;
        menu.pinned=false;
    }else if(window.innerWidth > menu.mdBreakPoint){
        menu.menuDetail=false;
        menu.pinned=false;
    }else{
        menu.status = false;
        menu.fullSearchBar = true;
    }

}

export default {
    //Variables
    menu,
    navbar,

    //Computed Properties
    floatingShadow,
    menuTotalSpace,

    //Functions
    resizeController,
    innitialLoader,
    pindetail,
    toggleMenu,
}