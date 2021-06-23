<?php

use Illuminate\Support\Facades\Route;
use Rafiur\Controllers\TaskController;
use Rafiur\Controllers\AgentController;
//use Rafiur\TaskManager\Controller\TaskController;

Route::get('/task-list', [TaskController::class, 'show_task']);
Route::get('/add-task-with-assing', [TaskController::class, 'new_task_with_assing']);
Route::post('/update-task', [TaskController::class, 'update_task']);

Route::get('/delete-task/{id}',[TaskController::class, 'delete_task']);

Route::post('/change-task-status',[TaskController::class,'task_state_chage']);

Route::get('/agent-list', [AgentController::class, 'agent_list']);



