<?php
namespace Rafiur\Controllers;
use Illuminate\Routing\Controller;

//use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
// use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Rafiur\model\Task;
use Rafiur\model\Sorting;

class TaskController extends Controller
{
    public function __construct()
    {
        //echo "I ama contructor";
    }
    public function show_task()
    {
        $to_do=[];
        $inprogress=[];
        $done=[];

        $sortings=Sorting::get()->keyBy('id');
        $sorting_array=json_decode($sortings[1]['sorting']);
        $tasks=Task::orderBy('id')->whereIn('id',$sorting_array)->orderByRaw('FIELD(id, '.implode(", " , $sorting_array).')')->get();
        foreach($tasks as $key=>$task)
        {
            $to_do[$key]['title']=$task->title;
            $to_do[$key]['description']=$task->description;
            $to_do[$key]['id']=$task->id;
            $to_do[$key]['type']=$task->project_types->name;
        }
        //in progress
        $tasks=Task::orderBy('id')->whereIn('id',json_decode($sortings[2]['sorting']))->get();
        foreach($tasks as $key=>$task)
        {
            $inprogress[$key]['title']=$task->title;
            $inprogress[$key]['description']=$task->description;
            $inprogress[$key]['id']=$task->id;
            $inprogress[$key]['type']=$task->project_types->name;
        }
        //done
        $tasks=Task::orderBy('id')->whereIn('id',json_decode($sortings[3]['sorting']))->get();
        foreach($tasks as $key=>$task)
        {
            $done[$key]['title']=$task->title;
            $done[$key]['description']=$task->description;
            $done[$key]['id']=$task->id;
            $done[$key]['type']=$task->project_types->name;
        }

        $task_lists['todo']=$to_do;
        $task_lists['inprogress']=$inprogress;
        $task_lists['done_task']=$done;
        return $task_lists;
    }
    public function new_task_with_assing(Request $request)
    {
        $rules = array(
            'title'=> 'required',
            'description'=> 'nullable',
            'project_type'=> 'required'
        );
        $response = $this->validationWithJson($request->all(),$rules);
        

        if($response === true)
        {
            $task_save=new Task;
            $task_save->title=$request->title;
            $task_save->description=$request->description;
            $task_save->task_status=1;
            $task_save->type_id=1;

            $task_save->save();

            //sorting 
            $sorting=Sorting::find(1);
            $array=json_decode($sorting->sorting);
            array_push($array,$task_save->id);

            $sorting=Sorting::find(1);
            $sorting->sorting=json_encode($array);
            $sorting->save();


            return $this->responseWithSuccess('Task Saved Successfully',$task_save);
        }else{
            return $this->responseWithError('Found Something wrong',$response); 
        }
        
        //dd($errors);
        
        
        

        //user_id json
    }
    public function task_state_chage(Request $request)
    {
        //dd($request);
        $rules = array(
            'task_id'=> 'required',
            'state'=> 'required',
            'type'=> 'required',
            'new_index' => 'nullable',
            'old_index' => 'nullable'
        );
        $response = $this->validationWithJson($request->all(),$rules);
        

        if($response === true)
        {
            $task=Task::find($request->task_id);
            $task->task_status=$request->state;
            $task->save();

            if($request->type == 'added' || $request->type == 'moved')
            {
                
                $sorting=Sorting::where('id',$request->state)->get()->first();
                $sorting=json_decode($sorting->sorting);
                
                
                if($request->type == 'moved')
                {
                    $this->moveElement($sorting, $request->old_index, $request->new_index);
                }else{
                    array_push($sorting,$request->task_id);
                    $this->moveElement($sorting, count($sorting)-1, $request->new_index);
                }
                $sorting=json_encode($sorting);

                Sorting::where('id', $request->state)->update(array('sorting' => $sorting));
                    
            }
            if($request->type == 'removed')
            {
                $sorting=Sorting::where('id',$request->state)->get()->first();
                $sorting=json_decode($sorting->sorting);
                
                unset($sorting[$request->old_index]);
                $sorting=array_values($sorting);
                $sorting=json_encode($sorting);
                Sorting::where('id', $request->state)->update(array('sorting' => $sorting));
            }

        }else{
            return $this->responseWithError('Found Something wrong',$response); 
        }
    }
    private function moveElement(&$array, $a, $b) {
        $out = array_splice($array, $a, 1);
        array_splice($array, $b, 0, $out);
    }
    public function update_task(Request $request)
    {
        $rules = array(
            'id'=> 'required',
            'title'=> 'required',
            'description'=> 'nullable',
            'project_type'=> 'required'
        );
        $response = $this->validationWithJson($request->all(),$rules);
        

        if($response === true)
        {
            $task_save=Task::find($request->id);
            $task_save->title=$request->title;
            $task_save->description=$request->description;
            $task_save->task_status=0;
            $task_save->type_id=1;

            $task_save->save();

            return $this->responseWithSuccess('Task Updated Successfully',$task_save);
        }else{
            return $this->responseWithError('Found Something wrong',$response); 
        }
    }
    public function delete_task($id)
    {
        $sortings=Sorting::get();
        foreach($sortings as $sorting)
        {   
            $array=json_decode($sorting->sorting);
            // echo "Main array<pre>"; print_r($array);
            
            $key=array_search($id, $array);
            // echo "key="; echo $key;
            if($key === 0 || $key > 0)
            {
                // echo "In if=<pre>"; print_r($array);
                unset($array[$key]);
                // echo "<pre>"; print_r($array);
                $array=array_values($array);
                // echo "<pre>"; print_r($array); 
                $array=json_encode($array);
                // echo  $array;
                // break;
                $update=Sorting::find($sorting->id);
                $update->sorting=$array;
                $update->save();
            }
        }
        Task::where('id',$id)->delete();
    }
    protected function validationWithJson( $data=[],$rules=[],$message=[] )
    {
        
        $validator = Validator::make( $data, $rules,$message);

        if ($validator->fails()){
            //return $validator->errors();
            return $validator->messages()->all();

        }else{
            return true;
        }
    }
    protected function responseWithSuccess($message='',$data=[],$code=200)
    {
        return response()->json([
            'success'=> true,
            'message'=> $message,
            'data'   => $data
        ],$code);
    }
    protected function responseWithError($message='',$data=[],$code=400)
    {
        return response()->json([
            'error'   => true,
            'message' => $message,
            'data'    => $data
        ],$code);
    }
    
}
