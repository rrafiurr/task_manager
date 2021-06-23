<template>
    <div>
        <div class="body-header">
            <div class="flx">
                <div><CcPropicList :height="40" :list="userList" listTarget="avatar_url" /></div>
                <div class="body-header-invite"><CcButton label="Invite People" :border="2" :textSize="16" icon="add-user" :padding=".8" /></div>
            </div>
            <div class="body-header-status-container">
                <div class="body-header-status"><CcTitle :fontSize="14" status="Importent" title="Importent" /></div>
                <div class="body-header-status"><CcTitle :fontSize="14" status="Irrelevant" title="Irrelevant" /></div>
                <div class="body-header-status"><CcTitle :fontSize="14" status="Default" title="Default" /></div>
            </div>
        </div>

        <div style="height:30px"></div>
        <div class="todo-items flx block-lg w100-lg">
            <!-- Item Container -->
            <div class="w30 w100-lg">
                <div class="todo-items-header">
                    <div class="f-16 f-bold flx-auto h-center">
                        To Do <span class="todo-items-title-count">({{toDoCount}})</span>
                    </div>
                    <div><CcButton label="New Task" color="#E0E2E8" :textSize="12" icon="plus" @click="newTaskEvent('todo')" :padding="1.2" /></div>
                </div>
                <div class="dragable-box">
                    <draggable class="dragArea list-group" :list="toDo" group="task" item-key="id" @change="todo_draggablelog">
                        <template #item="{ element }">
                            <div class="list-group-item todo-todo">
                                <CcTaskCard :cardDetail="element" :userList="userList" />
                            </div>
                        </template>
                    </draggable>
                </div>
            </div>
            <!-- Item Container -->
            <div class="w30 w100-lg">
                <div class="todo-items-header">
                    <div class="f-16 f-bold flx-auto h-center">
                        In progress <span class="todo-items-title-count">({{inPogressCount}})</span>
                    </div>
                    <div><CcButton label="New Task" color="#E0E2E8" :textSize="12" icon="plus" @click="newTaskEvent('prog')" :padding="1.2" /></div>
                </div>
                <div class="dragable-box">
                    <draggable class="dragArea list-group inPogress" :list="inPogress" group="task" item-key="id" @change="inprogress_draggablelog">
                        <template #item="{ element }">
                            <div class="list-group-item progress-todo">
                                <CcTaskCard :cardDetail="element" :userList="userList" />
                            </div>
                        </template>
                    </draggable>
                </div>
            </div>
            <!-- Item Container -->
            <div class="w30 w100-lg">
                <div class="todo-items-header">
                    <div class="f-16 f-bold flx-auto h-center">
                        Done <span class="todo-items-title-count">({{doneTaskCount}})</span>
                    </div>
                    <div></div>
                </div>
                <div class="dragable-box">
                    <draggable class="dragArea list-group" :list="doneTask" group="task" item-key="id" @change="done_draggablelog" >
                        <template #item="{ element }">
                            <div class="list-group-item done-todo">
                                <div><CcTaskCard :cardDetail="element" :userList="userList" /></div>
                            </div>
                        </template>
                    </draggable>
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
                        <div class="tsm-button-name" @click="newTaskPage = 'gen'" :style="{color: newTaskPage == 'gen' ? '#0049C6' : '#5D5D7A'}">General Info</div>
                        <div class="tsm-button-marker-container">
                            <div class="tsm-button-marker" :style="{backgroundColor: newTaskPage == 'gen' ? '#0049C6' : '#F5F8FC'}"></div>
                        </div>
                    </div>
                    <div class="tsm-button-spacer"></div>
                    <div class="tsm-button-container">
                        <div class="tsm-button-name" @click="newTaskPage = 'assign'" :style="{color: newTaskPage == 'assign' ? '#0049C6' : '#5D5D7A'}">Assigned To</div>
                        <div class="tsm-button-marker-container">
                            <div class="tsm-button-marker" :style="{backgroundColor: newTaskPage == 'assign' ? '#0049C6' : '#F5F8FC'}"></div>
                        </div>
                    </div>
                    <div class="tsm-button-spacer"></div>
                </div>
                <div v-if="newTaskPage == 'gen'">
                    <div class="tsm-title">
                        <CcInput v-model="taskItem.title" class="form-control is-invalid" label="Title" placeHolder="Web Design"  />
                        <div v-if="error_list.title" class="invalid-feedback text-danger">
                            Please enter a title
                        </div>
                    </div>
                    <div class="tsm-description">
                        <CcTextarea v-model="taskItem.description" :rows="4" label="Description" />
                        <div v-if="error_list.description" class="invalid-feedback text-danger">
                            Please enter a description.
                        </div>
                    </div>
                    <div class="tsm-project-type">
                        <CcSelect v-model="taskItem.type" :options="options" :rows="10" label="Project Type" />
                    </div>
                    <div v-if="error_list.type" class="invalid-feedback text-danger">
                        Please select a project type.
                    </div>     
                </div>
                <div  v-if="newTaskPage == 'assign'">
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
                      <div v-if="error_list.assignedUser" class="invalid-feedback text-danger">
                            Please choose a assinge.
                      </div>
                  </div>
                </div>
                <div class="tsm-save-button">
                    <CcButton :label="newTaskPage == 'gen' ? 'Next' : 'save'" @click="savetaskItem()" color="#0049C6" :textSize="14" textColor="#FFFFFF" :padding="1.5" />
                </div> 
            </div>
        </CcModal>

    </div>
</template>
<script setup>
    import CcPropicList from '../components/cc-propic-list.vue'
    import CcTitle from '../components/cc-title.vue'
    import CcTaskCard from '../components/cc-task-card.vue'

    import CcModal from '../components/cc-modal.vue'
    import CcDivider from '../components/cc-divider.vue'
    import CcSearch from '../components/cc-search.vue'
    import CcButton from '../components/cc-button.vue'
    import CcInput from '../components/cc-input.vue'
    import CcTextarea from '../components/cc-textarea.vue'
    import CcSelect from '../components/cc-select.vue'

    import axios from 'axios'
    import draggable from 'vuedraggable'
    import lodash from 'lodash'

    import { ref, reactive, onMounted, computed, watch  } from 'vue'
    import {useStore} from 'vuex'

    const store = useStore()

    const userList = reactive([]);
    const modal = ref(false);

    const toDo = computed(() =>  store.state.toDo) 
    const inPogress = computed(() => store.state.inPogress) 
    const doneTask = computed(() => store.state.doneTask) 
    const toDoCount = computed(() => store.state.toDo.length) 
    const inPogressCount = computed(() => store.state.inPogress.length) 
    const doneTaskCount = computed(() => store.state.doneTask.length) 

    //New Task Create
    const newTaskPage = ref('gen');
    const srcEmployeeInput = ref('');
    const selectedEmployeeList = reactive([]);
    const options = reactive(['Importent','Irrelevant', 'Default']);
    const taskItem = reactive({
        title:null,
        description: null,
        type:'Importent',
        source:null,
        assignedUser: [],
    })
    const formerror = ref(false);  //this is for track error
    const error_list = ({
        title:false,
        description: false,
        type:false,
        assignedUser:false,
    })
    const srcEmployeeOptions = computed(()=>{
        var re = new RegExp(srcEmployeeInput.value, "i");
        return userList.filter((item) => {
            return re.test(item.login)
        })

    })

    const newTaskEvent = (source) => {
        modal.value = true;
        taskItem.assignedUser.length = 0;
        taskItem.title = null;
        taskItem.description = null;
        taskItem.source = source;
        taskItem.type = 'Importent';
        taskItem.project_type = 'Importent';
        newTaskPage.value = 'gen';
    }
    const eployeeSelected = (e) => {
        taskItem.assignedUser.push(e)
    }
    const todo_draggablelog =(e) => {
        find_the_keys("1",e)
    }
    const inprogress_draggablelog =(e) => {
        find_the_keys("2",e)
    }
    const done_draggablelog =(e) => {
        find_the_keys("3",e)
    }
    function find_the_keys(state,e)
    {
        let keys=Object.keys(e)
        console.log(e);
        //alert(keys[0]);
        
        if(keys[0] == 'added')
        {
            // console.log(e.added.element.id)
            axios.post("/change-task-status",{'task_id':e.added.element.id,'state':state,'type':keys[0],'new_index':e.added.element.newIndex

                }).then(response=>{
                    //console.log(response.data)
                    console.log(response)
                    //next task
                })
                .catch(error=>{
                    console.log(error)
                })
        }
        if(keys[0] == 'moved')
        {
            // console.log(e.added.element.id)
            axios.post("/change-task-status",{'task_id':e.moved.element.id,'state':state,'type':keys[0],'new_index':e.moved.newIndex,'old_index':e.moved.oldIndex

                }).then(response=>{
                    //console.log(response.data)
                    console.log(response)
                    //next task
                })
                .catch(error=>{
                    console.log(error)
                })
        }
        if(keys[0] == 'removed')
        {
            axios.post("/change-task-status",{'task_id':e.removed.element.id,'state':state,'type':keys[0],'old_index':e.removed.oldIndex

                }).then(response=>{
                    //console.log(response.data)
                    console.log(response)
                    //next task
                })
                .catch(error=>{
                    console.log(error)
                })
        }

        //state
    }
    const savetaskItem = () => {
        make_validation()
        if(formerror.value === true)
        {
            console.log("got error");
        }
        else{
            if(newTaskPage.value == 'gen'){
                newTaskPage.value = 'assign';
            }
            else{
                if(taskItem.source == 'todo')
                {
                    //console.log(taskItem);

                    //send to server
                    axios.get("/add-task-with-assing",{
                        params: taskItem
                    }).then(response=>{
                        //console.log(response)

                        var newToDO = toDo.value;
                        //console.log(newToDO)
                        newToDO.push(lodash.cloneDeep(taskItem));
                        store.commit('toDoUpdate', newToDO)
                    })
                    .catch(error=>{
                        console.log(error)
                    })
                }
                if(taskItem.source == 'prog'){
                    var newInPogress = inPogress.value;
                    newInPogress.push(lodash.cloneDeep(taskItem));
                    store.commit('inPogressUpdate', newInPogress)
                }
                modal.value = false;            
            }
        }
        
        

    }
    const make_validation = () => {
        //console.log("in the error function")
        //title
        if(!taskItem.title)
        {
            //console.log("got error from task title")
            error_list.title=true;
            formerror.value=true;
        }
        //description
        else if(!taskItem.description)
        {
            //console.log("got error from task title")
            error_list.description=true;
            formerror.value=true;
        }
        else if(!taskItem.type)
        {
            //console.log("got error from task title")
            error_list.type=true;
            formerror.value=true;
        }
        else if(!taskItem.assignedUser)
        {
            //console.log("got error from task title")
            error_list.assignedUser=true;
            formerror.value=true;
        }else{
            //console.log("error free from task title")
            error_list.title=false;
            error_list.description=false;
            error_list.type=false;
            error_list.assignedUser=false;
            formerror.value=false;
        }
        
    }
    watch([store.state.toDo, store.state.inPogress, store.state.doneTask], () => {
        store.commit('callSave')
    })

    //Load innitials
    const requestUserList = async () =>{
        try{
            var req = await axios.get('https://api.github.com/users')
            userList.push(...req.data);
        }catch(err){console.log(err)}
    }
    const loadInitial_data = async () =>{
        var req = await axios.get('/task-list')
        let tasks=[]
        let task_list=[]
        let user=[]
        
        //clean the previous todo
        var newToDO = [];
        store.commit('toDoUpdate', newToDO)

        //console.log(req.data.todo)
        newToDO = toDo.value;
        req.data.todo.forEach(function(row,index) {
           user={'avatar_url':'https://avatars.githubusercontent.com/u/1?v=4','id':1}
       
           tasks={'id':row.id,'title': row.title,'description': row.description,'project_type':row.type,'source':"todo",'assignedUser':[]}
           tasks.assignedUser.push(user)
           newToDO.push(lodash.cloneDeep(tasks));
        });
        store.commit('toDoUpdate', newToDO)


        //in progress
        //clean the previous inprogress
        var inprogress = [];
        store.commit('inPogressUpdate', inprogress)

        //console.log(req.data.todo)
        inprogress = inPogress.value;
        req.data.inprogress.forEach(function(row,index) {
           user={'avatar_url':'https://avatars.githubusercontent.com/u/1?v=4','id':1}
       
           tasks={'id':row.id,'title': row.title,'description': row.description,'project_type':row.type,'source':"todo",'assignedUser':[]}
           tasks.assignedUser.push(user)
           inprogress.push(lodash.cloneDeep(tasks));
        });
        store.commit('inPogressUpdate', inprogress)


        //done list
        //clean the previous inprogress
        var done_task = [];
        store.commit('doneTaskdate', done_task)

        //console.log(req.data.todo)
        done_task = doneTask.value;
        req.data.done_task.forEach(function(row,index) {
           user={'avatar_url':'https://avatars.githubusercontent.com/u/1?v=4','id':1}
       
           tasks={'id':row.id,'title': row.title,'description': row.description,'project_type':row.type,'source':"todo",'assignedUser':[]}
           tasks.assignedUser.push(user)
           done_task.push(lodash.cloneDeep(tasks));
        });
        store.commit('doneTaskdate', done_task)
        

    }

    onMounted(()=>{
        requestUserList();
        loadInitial_data()
    })
</script>

<style lang="scss">
    .body-header{
        display: flex;
        padding: 30px 0px;
        &-status{
            padding: 0px 10px;
            display: flex;
            align-items: center;
        }
        &-invite{
            padding: 0px 20px;
        }
        &-status-container{
            padding-top: 0px;
            display: flex;
            justify-content: flex-end;
            flex:auto;
        }
    }
    @media (max-width:850px) {
        .body-header{
            display: block;
            &-status-container{
                padding-top: 30px;
                justify-content: flex-start;
            }
        }
    }
    .todo-items{
        justify-content: space-between;
        &-header{
            display: flex;
            height: 35px;
        }
        &-title-count{
            font-size:18px;
            color:#8F909F;
            padding-left:10px ;
        }
    }
    .dragable-box{
        padding-top: 25px;
        padding-bottom: 25px;
    }
    .list-group{
        min-height: 250px;
    }
    .list-group-item{
        padding: 10px 0px;
    }
    @media (max-width:1000px) {
        .dragable-box{
            padding-top: 5px;
            padding-bottom: 35px;
        }
    }





</style>