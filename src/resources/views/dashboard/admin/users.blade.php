<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Utenti</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        <button type="button" class="btn btn-transparent" data-toggle="modal" data-target="#addUserModal">
                            <i class="bi bi-plus-square-fill"></i> {{__('dashboard.add_user')}}
                        </button>
                        <h4>{{__('dashboard.user_list')}}</h4>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{__('dashboard.user_list_table.name')}}</th>
                                <th scope="col">{{__('dashboard.user_list_table.is_admin')}}</th>
                                <th scope="col">{{__('dashboard.user_list_table.actions')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <th scope="row">{{$user['id']}}</th>
                                    <td>{{$user['name']}}</td>
                                    <td>
                                        @if($user['is_admin']) {{__('dashboard.user_list_table.yes')}}
                                        @else {{__('dashboard.user_list_table.no')}}
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button"
                                                class="btn btn-primary editUser_btn"
                                                data-toggle="modal"
                                                data-target="#EditUserModal"
                                                data-user-name="{{$user['name']}}"
                                                data-user-email="{{$user['email']}}"
                                                data-user-admin="{{$user['is_admin']}}"
                                        >
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        <button type="button"
                                                class="btn btn-outline-danger deleteUser_btn"
                                                data-toggle="modal"
                                                data-target="#DeleteUserModal"
                                                data-user-name="{{$user['name']}}"
                                                data-user-email="{{$user['email']}}"
                                        >
                                            <i class="bi bi-person-x-fill"></i>
                                        </button>
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

<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('dashboard.add_user')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addUserModal_form">
                    <div class="form-group">
                        <label for="newUser_name">Nome</label>
                        <input type="text" class="form-control" name="newUser_name">
                    </div>
                    <div class="form-group">
                        <label for="newUser_email">Email</label>
                        <input type="email" class="form-control" name="newUser_email">
                    </div>
                    <div class="form-group">
                        <label for="newUser_password">Password</label>
                        <input type="password" class="form-control" name="newUser_password">
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" name="newUser_admin">
                        <label class="form-check-label" for="newUser_admin">{{__('dashboard.modals.admin_checkbox')}}</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('dashboard.modals.abort')}}</button>
                <button type="button" class="btn btn-primary" id="addUserModal_proceed">{{__('dashboard.modals.proceed')}}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="EditUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('dashboard.modals.edit_user')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editUserModal_form">
                    <div class="form-group">
                        <label for="editUser_name">Nome</label>
                        <input type="text" class="form-control" name="editUser_name">
                    </div>
                    <div class="form-group">
                        <label for="editUser_email">Email</label>
                        <input type="email" class="form-control" name="editUser_email">
                    </div>
                    <div class="form-group">
                        <label for="editUser_password">Password</label>
                        <input type="password" class="form-control" name="editUser_password">
                        <small class="form-text text-muted">{{__('dashboard.modals.email_untouched')}}</small>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" name="editUser_admin">
                        <label class="form-check-label" for="editUser_admin">{{__('dashboard.modals.admin_checkbox')}}</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('dashboard.modals.abort')}}</button>
                <button type="button" class="btn btn-primary" id="editUserModal_proceed">{{__('dashboard.modals.proceed')}}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="DeleteUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('dashboard.modals.delete_user')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3>{{__('dashboard.modals.confirm_user_deletion')}}</h3>
                <form id="deleteUserModal_form">
                    <input hidden="true" type="text" class="form-control" name="deleteUser_name">
                    <input hidden="true" type="email" class="form-control" name="deleteUser_email">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('dashboard.modals.abort')}}</button>
                <button type="button" class="btn btn-primary" id="deleteUserModal_proceed">{{__('dashboard.modals.proceed')}}</button>
            </div>
        </div>
    </div>
</div>

<script>
  $(function() {
    $('#addUserModal_proceed').click(function() {
      $.post( "{{route('api_create_user')}}", $( "#addUserModal_form" ).serialize())
       .done(function() {
         window.location.reload();
         // @todo improve this
       })
       .fail(function( data ) {
         alert('{{__('dashboard.modals.check_data')}}');
         // @todo improve this
       });
    });

    $(".editUser_btn").click(function () {
      $("input[name=editUser_name]").val($(this).attr('data-user-name'));
      $("input[name=editUser_email]").val($(this).attr('data-user-email'));
      $("input[name=editUser_password]").val('');
      $("input[name=editUser_admin]").prop('checked', $(this).attr('data-user-admin') === "1");
    });

    $('#editUserModal_proceed').click(function() {
      $.post( "{{route('api_edit_user')}}", $( "#editUserModal_form" ).serialize())
       .done(function() {
         window.location.reload();
         // @todo improve this
       })
       .fail(function( data ) {
         alert('{{__('dashboard.modals.check_data')}}');
         // @todo improve this
       });
    });

    $(".deleteUser_btn").click(function () {
      $("input[name=deleteUser_name]").val($(this).attr('data-user-name'));
      $("input[name=deleteUser_email]").val($(this).attr('data-user-email'));
    });

    $('#deleteUserModal_proceed').click(function() {
      $.post( "{{route('api_delete_user')}}", $( "#deleteUserModal_form" ).serialize())
       .done(function() {
         window.location.reload();
         // @todo improve this
       })
       .fail(function( data ) {
         alert('{{__('dashboard.modals.check_data')}}');
         // @todo improve this
       });
    });
  });
</script>
