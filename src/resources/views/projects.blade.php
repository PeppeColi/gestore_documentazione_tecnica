@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{__('dashboard.projects', ['client' => $client['name']])}}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <button type="button" class="btn btn-transparent" data-toggle="modal" data-target="#addProjectModal">
                            <i class="bi bi-plus-square-fill"></i> {{__('dashboard.add_project')}}
                        </button>
                        <h4>{{__('dashboard.project_list')}}</h4>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{__('dashboard.project_list_table.name')}}</th>
                                <th scope="col">{{__('dashboard.project_list_table.actions')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php /** @var \App\Project $project */ @endphp
                            @foreach($projects as $project)
                                <tr>
                                    <th scope="row">{{$project->id}}</th>
                                    <td>{{$project->name}}</td>
                                    <td>
                                        <a class="btn btn-secondary" href="{{route('project', ['id' => $project->id])}}" role="button"><i class="bi bi-kanban"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addProjectModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('dashboard.add_project')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addProjectModal_form">
                        <div class="form-group">
                            <label for="addProject_name">Nome</label>
                            <input type="text" class="form-control" name="addProject_name">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('dashboard.modals.abort')}}</button>
                    <button type="button" class="btn btn-primary" id="addProjectModal_proceed">{{__('dashboard.modals.proceed')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
  $(function() {
    $('#addProjectModal_proceed').click(function() {
      $.ajax({
        type: "PUT",
        url: "{{route('api_create_project', [], false)}}",
        headers: {
          Authorization: "Bearer {{$user['api_token']}}"
        },
        data: {
          client_id:{{$client['id']}},
          name:$("input[name=addProject_name]").val()
        }
      })
       .done(function() {
         window.location.reload();
       })
       .fail(function( data ) {
         alert('{{__('dashboard.modals.check_data')}}');
       });
    });
  });
</script>
@endsection
