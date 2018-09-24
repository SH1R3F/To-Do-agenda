
@extends('layouts.master')
@section('stylesheets')
    <link href="{{asset('css/tasks.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('scripts')
    <script>
        function drag(ev){
            ev.dataTransfer.setData("text", ev.target.id);
        }
        function allowDrop(ev){
            ev.preventDefault();
        }
        function drop(ev) {
            ev.preventDefault();
            var data = ev.dataTransfer.getData("text");
            if($(ev.target).hasClass('delete-task') || $(ev.target).hasClass('fa')){
                // Send Delete Request
                axios.delete(APP_URL + '/delete/' + data).then(response => {
                    $("#" + data).fadeOut('normal');
                }).catch(error => {
                    console.log('an error happened with the request.');
                });

            }else if($(ev.target).hasClass('row')){
                var section = $(ev.target).attr('id');
                // Send Update Request
                axios.put(APP_URL + '/update/' + data, {
                    to: section
                }).then(response => {
                    var today = new Date();
                    today.setHours(0, 0, 0, 0);
                    var tomorrow = new Date(today.getTime() + 86400000);
                    var soon = new Date(today.getTime() + 172800000);
                    var overdue = new Date(today.getTime() - 86400000);
                    switch(section){
                        case 'today':
                            $("#" + data + " span").text(today.getFullYear() + '-' + (today.getMonth()+1) + '-' + today.getDate());
                        break;
                        case 'tomorrow':
                            $("#" + data + " span").text(tomorrow.getFullYear() + '-' + (tomorrow.getMonth()+1) + '-' + tomorrow.getDate());
                        break;
                        case 'soon':
                            $("#" + data + " span").text(soon.getFullYear() + '-' + (soon.getMonth()+1) + '-' + soon.getDate());
                        break;
                        case 'overdue':
                            $("#" + data + " span").text(overdue.getFullYear() + '-' + (overdue.getMonth()+1) + '-' + overdue.getDate());
                        break;
                    }
                    ev.target.prepend(document.getElementById(data));
                }).catch(error => {
                    console.error(error);
                    console.log('an error happened with the request.');
                });
            }else{
                var section = $(ev.target).parents('.row.row-eq-height').attr('id');
                // Send Update Request
                axios.put(APP_URL + '/update/' + data, {
                    to: section
                }).then(response => {
                    $(ev.target).parents('.row.row-eq-height').prepend(document.getElementById(data));
                }).catch(error => {
                    console.log('an error happened with the request.');
                });
            }
        }
    </script>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="sticky-note newTask">
                <div class="sticky-title">New Task</div>
                <textarea id="taskBody" v-model="tasks.taskBody" required maxlength="100"></textarea>
                <div class="popper" id="bodyErr"><span v-if='"body" in tasks.errors' v-text='tasks.errors.body[0]'></span></div>
                <div class="underneath">
                    <div class="popper" id="dateErr"><span v-if='"deadline" in tasks.errors' v-text='tasks.errors.deadline[0]'></span></div>
                    <input type="date" id="taskDate" v-model="tasks.taskDate" required>

                    <span class="add" :class='{addDisabled: !isTaskSbmtRdy}' @click.prevent="addTask">Add</span>
                    <span class="add" @click.prevent="closeAdder">Cancel</span>
                </div>
            </div>
            <!-- Adding Task Button -->
            <div class="add-task" @click="showAdder"><i>+</i></div>
            <div class="delete-task" ondrop="drop(event)" ondragover="allowDrop(event)"><i class="fa fa-trash"></i></div>
            <!-- Adding Task Button -->
            <div class="col-sm-12 col-md-6 section">
                <div class="sticky-note title">Today</div>
                <div class="row row-eq-height" ondrop="drop(event)" ondragover="allowDrop(event)" id="today">
                    @foreach($tasks['today'] as $task)
                        <div id="{{$task->id}}" draggable="true" class="sticky-note task col-sm-3" ondragstart="drag(event)">
                            <p>{{$task->body}}</p>
                            <span>{{$task->deadline}}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-sm-12 col-md-6 section">
                <div class="sticky-note title">Tomorrow</div>
                <div class="row row-eq-height" ondrop="drop(event)" ondragover="allowDrop(event)" id="tomorrow">
                    @foreach($tasks['tomorrow'] as $task)
                        <div id="{{$task->id}}" draggable="true" class="sticky-note task col-sm-3" ondragstart="drag(event)">
                            <p>{{$task->body}}</p>
                            <span>{{$task->deadline}}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-sm-12 col-md-6 section">
                <div class="sticky-note title">Soon</div>
                <div class="row row-eq-height" ondrop="drop(event)" ondragover="allowDrop(event)" id="soon">
                    @foreach($tasks['soon'] as $task)
                        <div id="{{$task->id}}" draggable="true" class="sticky-note task col-sm-3" ondragstart="drag(event)">
                            <p>{{$task->body}}</p>
                            <span>{{$task->deadline}}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-sm-12 col-md-6 section">
                <div class="sticky-note title">Overdue</div>
                <div class="row row-eq-height" ondrop="drop(event)" ondragover="allowDrop(event)" id="overdue">
                    @foreach($tasks['overdue'] as $task)
                        <div id="{{$task->id}}" draggable="true" class="sticky-note task col-sm-3" ondragstart="drag(event)">
                            <p>{{$task->body}}</p>
                            <span>{{$task->deadline}}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script defer>
        $(document).ready(function(){
            $(".section").niceScroll({
                cursorwidth: "2px",
                cursorborder: "0px solid #efa439"
            });
        });
    </script>
@endsection
