<template>
    <div ref="cardRoot">
        <div class="cc-task">
            <div class="cc-task-title"><CcTitle :fontSize="18" :status="props.cardDetail.type" :title="props.cardDetail.title" /></div>
            <div class="cc-task-description">{{props.cardDetail.description}}</div>
            <input type="hidden" value="{{props.cardDetail.id}}">
            <CcDivider />
            <div class="cc-task-option">
                <div class="cc-task-users">
                    <CcPropicList :height="32" :list="props.cardDetail.assignedUser" listTarget="avatar_url" />
                </div>
                <div class="cc-task-btn">
                    <CcButtonDropdown>
                        <div class="cc-button-dropdown-item" @click="editTaskEvent()">Edit</div>
                        <div class="cc-button-dropdown-item" @click="deleteData()">Delete</div>
                    </CcButtonDropdown>
                </div>
            </div>
        </div>
        <CcModal v-model="modal" :width="500">
            <div class="tsm">
                <div class="tsm-name">Create New Task</div>
                <CcDivider />
                <div class="tsm-button">
                    <div class="tsm-button-spacer"></div>
                    <div class="tsm-button-container">
                        <div class="tsm-button-name" @click="editTaskPage = 'gen'" :style="{color: editTaskPage == 'gen' ? '#0049C6' : '#5D5D7A'}">General Info</div>
                        <div class="tsm-button-marker-container">
                            <div class="tsm-button-marker" :style="{backgroundColor: editTaskPage == 'gen' ? '#0049C6' : '#F5F8FC'}"></div>
                        </div>
                    </div>
                    <div class="tsm-button-spacer"></div>
                    <div class="tsm-button-container">
                        <div class="tsm-button-name" @click="editTaskPage = 'assign'" :style="{color: editTaskPage == 'assign' ? '#0049C6' : '#5D5D7A'}">Assigned To</div>
                        <div class="tsm-button-marker-container">
                            <div class="tsm-button-marker" :style="{backgroundColor: editTaskPage == 'assign' ? '#0049C6' : '#F5F8FC'}"></div>
                        </div>
                    </div>
                    <div class="tsm-button-spacer"></div>
                </div>
                <div v-if="editTaskPage == 'gen'">
                    <div class="tsm-title">
                        <CcInput v-model="taskItem.title" label="Title" placeHolder="Web Design"  />
                    </div>
                    <div class="tsm-description">
                        <CcTextarea v-model="taskItem.description" :rows="4" label="Description" />
                    </div>
                    <div class="tsm-project-type">
                        <CcSelect v-model="taskItem.type" :options="options" :rows="10" label="Project Type" />
                    </div>     
                </div>
                <div  v-if="editTaskPage == 'assign'">
                  <div class="tsm-employee-search">
                      <CcSearch v-model="srcEmployeeInput" @select="eployeeSelected" label="Search" :options="srcEmployeeOptions" />
                  </div>
                  <div class="tsm-employee-list">
                      <div v-for="(item, index) in taskItem.assignedUser" :key="index" class="tsm-employee-list-item">
                          <div  class="tsm-employee-list-image"><img :src="item.avatar_url" style="width:40px" /></div>
                          <div class="tsm-employee-list-text">{{item.login}}</div>
                          <div class="tsm-employee-list-delete">
                              <img src="/icons/close.svg" style="width:10px" />
                          </div>
                      </div>
                  </div>
                </div>
                <div class="tsm-save-button">
                    <CcButton label="Save" @click="savetaskItem()" color="#0049C6" :textSize="14" textColor="#FFFFFF" :padding="1.5" />
                </div> 
            </div>
        </CcModal>
    </div>
</template>

<script setup>
    import CcButtonDropdown from '../components/cc-button-dropdown.vue'
    import CcPropicList from '../components/cc-propic-list.vue'
    import CcTitle from '../components/cc-title.vue'
    import CcDivider from '../components/cc-divider.vue'

    import CcModal from '../components/cc-modal.vue'
    import CcSearch from '../components/cc-search.vue'
    import CcButton from '../components/cc-button.vue'
    import CcInput from '../components/cc-input.vue'
    import CcTextarea from '../components/cc-textarea.vue'
    import CcSelect from '../components/cc-select.vue'    
    import { defineProps, reactive, computed, ref } from 'vue'

    import lodash from 'lodash'
    import {useStore} from 'vuex'
import axios from 'axios'
    const store = useStore()

    const props = defineProps({
        cardDetail: Object,
        userList:Array,
    })

    const modal = ref(false);
    const cardRoot = ref(null)
    const editTaskPage = ref('gen');
    const srcEmployeeInput = ref('');
    const taskItem = reactive({
        title:null,
        description: null,
        type:'Importent',
        source:null,
        assignedUser: [],
    })
    const options = reactive(['Importent','Irrelevant', 'Default']);
    const editTaskEvent = (source) => {
        modal.value = true;
        taskItem.assignedUser = lodash.cloneDeep(props.cardDetail.assignedUser);
        taskItem.title = props.cardDetail.title;
        taskItem.description = props.cardDetail.description;
        taskItem.type = props.cardDetail.type;
        editTaskPage.value = 'gen';
    }
    const srcEmployeeOptions = computed(()=>{
        var re = new RegExp(srcEmployeeInput.value, "i");
        return props.userList.filter((item) => {
            return re.test(item.login)
        })

    })
    const eployeeSelected = (e) => {
        taskItem.assignedUser.push(e)
    }
    const savetaskItem = async () => {
        console.log(taskItem);
        var classes = cardRoot.value.parentElement;
        if(classes.closest('.todo-todo') != null){
            var data = await store.state.toDo
        }
        if(classes.closest('.progress-todo') != null){
            var data = await store.state.inPogress
        }   
        if(classes.closest('.done-todo') != null){
            var data = await store.state.doneTask
        } 
        var index = data.indexOf(props.cardDetail)
        data[index]=lodash.cloneDeep(taskItem);
        modal.value = false;
    }
    const deleteData = async () => {
        //delete from server
         axios.get('delete-task'+"/"+props.cardDetail.id)
         .then(response=>{
                
                console.log(response);
                
         });
         //end
         var classes = cardRoot.value.parentElement;
                // console.log(classes);
                if(classes.closest('.todo-todo') != null){
                    var data = await store.state.toDo
                }
                if(classes.closest('.progress-todo') != null){
                    var data = await store.state.inPogress
                }   
                if(classes.closest('.done-todo') != null){
                    var data = await store.state.doneTask
                } 
                var index = data.indexOf(props.cardDetail)
                data.splice(index, 1); 


        
    }
</script>

<style lang="scss">
    .cc-button-dropdown-item{
        padding: 10px;
        border-radius: 10px;
        color: #808191;
        cursor: pointer;
    }
    .cc-button-dropdown-item:hover{
        background-color:#F9FAFC;
    }
    .cc-task {
        padding: 20px;
        background-color: #FFFFFF;
        border-radius: 10px;

        &-title{

        }
        &-description{
            font-size:13px;
            color: #A0A0AC;
            padding: 20px 0px;
        }
        &-option{
            display: flex;
            padding-top:20px;
        }
        &-users{
            flex:1;
        }
        &-btn{
            display: flex;
            align-items: center;
        }
    }
</style>