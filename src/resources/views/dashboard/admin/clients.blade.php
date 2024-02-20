<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Clienti</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        <button type="button" class="btn btn-transparent" data-toggle="modal" data-target="#addClientModal">
                        <i class="bi bi-plus-square-fill"></i> {{__('dashboard.add_client')}}
                        </button>
                    <h4>{{__('dashboard.clients_list')}}</h4>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{__('dashboard.clients_list_table.name')}}</th>
                            <th scope="col">{{__('dashboard.clients_list_table.actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($clients as $client)
                            <tr>
                                <th scope="row">{{$client['id']}}</th>
                                <td>{{$client['name']}}</td>
                                <td>
                                    <button type="button"
                                            class="btn btn-primary editClient_btn"
                                            data-toggle="modal"
                                            data-target="#editClientModal"
                                            data-client-id="{{$client['id']}}"
                                            data-client-name="{{$client['name']}}"
                                    >
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <button type="button"
                                            class="btn btn-outline-danger deleteClient_btn"
                                            data-toggle="modal"
                                            data-target="#deleteClientModal"
                                            data-client-id="{{$client['id']}}"
                                    >
                                        <i class="bi bi-person-x-fill"></i>
                                    </button>
                                    <a class="btn btn-secondary" href="{{route('projects_index', ['id' => $client['id']])}}" role="button"><i class="bi bi-server"></i></a>
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

<div class="modal fade" id="addClientModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('dashboard.add_client')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addClientModal_form">
                    <div class="form-group">
                        <label for="newClient_name">Nome</label>
                        <input type="text" class="form-control" name="newClient_name">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('dashboard.modals.abort')}}</button>
                <button type="button" class="btn btn-primary" id="addClientModal_proceed">{{__('dashboard.modals.proceed')}}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editClientModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('dashboard.modals.edit_client')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editClientModal_form">
                    <input type="hidden" name="editClient_id">
                    <div class="form-group">
                        <label for="editClient_name">Nome</label>
                        <input type="text" class="form-control" name="editClient_name">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('dashboard.modals.abort')}}</button>
                <button type="button" class="btn btn-primary" id="editClientModal_proceed">{{__('dashboard.modals.proceed')}}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteClientModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('dashboard.modals.delete_client')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3>{{__('dashboard.modals.confirm_client_deletion')}}</h3>
                <input hidden type="text" class="form-control" name="deleteClient_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('dashboard.modals.abort')}}</button>
                <button type="button" class="btn btn-primary" id="deleteClientModal_proceed">{{__('dashboard.modals.proceed')}}</button>
            </div>
        </div>
    </div>
</div>

<script>
  $(function() {
    $('#addClientModal_proceed').click(function() {
      $.post("{{route('api_create_client')}}?api_token={{$api_token}}", {'name':$("input[name=newClient_name]").val()})
       .done(function() {
         window.location.reload();
       })
       .fail(function(data) {
         alert('{{__('dashboard.modals.check_data')}}');
       });
    });

    $(".editClient_btn").click(function () {
      $("input[name=editClient_id]").val($(this).attr('data-client-id'));
      $("input[name=editClient_name]").val($(this).attr('data-client-name'));
    });

    $('#editClientModal_proceed').click(function() {
      $.post("{{route('api_edit_client')}}?api_token={{$api_token}}", {
        'id':$("input[name=editClient_id]").val(),
        'name':$("input[name=editClient_name]").val()
      })
       .done(function() {
         window.location.reload();
       })
       .fail(function( data ) {
         alert('{{__('dashboard.modals.check_data')}}');
       });
    });

    $(".deleteClient_btn").click(function () {
      $("input[name=deleteClient_id]").val($(this).attr('data-client-id'));
    });

    $('#deleteClientModal_proceed').click(function() {
      // REST call with the mixed content issue
      $.ajax({
        type: "DELETE",
        url: "api/v1/client/" + $("input[name=deleteClient_id]").val(),
        headers: {
          Authorization: "Bearer {{$api_token}}"
        },
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
