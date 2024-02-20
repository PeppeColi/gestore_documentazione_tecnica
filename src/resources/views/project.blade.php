@extends('layouts.app')

@section('style')

@endsection

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{$client['name']}} - {{$project['name']}}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <button type="button" class="btn btn-transparent" data-toggle="modal" data-target="#addDocumentModal">
                            <i class="bi bi-plus-square-fill"></i> {{__('dashboard.add_document')}}
                        </button>
                        <h4>{{__('dashboard.document_list')}}</h4>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{__('dashboard.document_list_table.name')}}</th>
                                <th scope="col">{{__('dashboard.document_list_table.path')}}</th>
                                <th scope="col">{{__('dashboard.document_list_table.approved')}}</th>
                                @if($user['is_admin'])<th scope="col">{{__('dashboard.document_list_table.actions')}}</th>@endif
                            </tr>
                            </thead>
                            <tbody>
                            @php /** @var \App\Document $document */ @endphp
                            @foreach($documents as $document)
                                <tr>
                                    <th scope="row">{{$document->id}}</th>
                                    <td>{{$document->name}}</td>
                                    <td>{{$document->path}}</td>
                                    <td>
                                        @if(is_null($document->approved)) -
                                        @elseif($document->approved) {{__('dashboard.document_list_table.yes')}}
                                        @else {{__('dashboard.document_list_table.no')}}
                                        @endif
                                    </td>
                                    @if($user['is_admin'] && is_null($document->approved))
                                        <td>
                                            <button class="btn btn-secondary approveDocumentModal_btn" data-toggle="modal" data-target="#approveDocumentModal" data-document-id="{{$document->id}}"><i class="bi bi-hand-thumbs-up-fill"></i><i class="bi bi-hand-thumbs-down-fill"></i></button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addDocumentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('dashboard.add_document')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addDocumentModal_form">
                        <div class="form-group">
                            <label for="addProject_name">Nome</label>
                            <input type="text" class="form-control" name="addDocument_name">
                        </div>
                        <div class="form-group">
                            <label for="addDocument_file">{{__('dashboard.add_document')}}</label>
                            <input type="file" class="form-control" name="addDocument_file">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('dashboard.modals.abort')}}</button>
                    <button type="button" class="btn btn-primary" id="addDocumentModal_proceed">{{__('dashboard.modals.proceed')}}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="approveDocumentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('dashboard.approve_document')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <button class="btn btn-secondary btn-lg validateDocument_btn" data-approved="1">
                        <i class="bi bi-hand-thumbs-up-fill"></i>
                    </button>
                    <button class="btn btn-secondary btn-lg validateDocument_btn" data-approved="0">
                        <i class="bi bi-hand-thumbs-down-fill"></i>
                    </button>
                    <form id="approveDocumentModal_form">
                        <input hidden name="validateDocument_id">
                        <input hidden name="validateDocument_approved">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
      $(function() {
        $('#addDocumentModal_proceed').click(function() {

          var formData = new FormData();

          formData.append("project_id", "{{$project['id']}}");
          formData.append("name", $("input[name=addDocument_name]").val());
          formData.append('file', $('input[name=addDocument_file]')[0].files[0]);

          $.ajax({
            type: "POST",
            url: "{{route('api_create_document', [], false)}}",
            headers: {
              Authorization: "Bearer {{$user['api_token']}}"
            },
            data: formData,
            contentType: false,
            processData: false
          })
           .done(function() {
             window.location.reload();
           })
           .fail(function(data) {
             alert('{{__('dashboard.modals.check_data')}}');
           });
        });

        $('.approveDocumentModal_btn').click(function () {
          $("input[name=validateDocument_id]").val($(this).attr('data-document-id'));
        });

        $(".validateDocument_btn").click(function () {
          $("input[name=validateDocument_approved]").val($(this).attr('data-approved'));

          $.ajax({
            type: "POST",
            url: "/api/v1/document/" + $("input[name=validateDocument_id]").val() + "/validate",
            headers: {
              Authorization: "Bearer {{$user['api_token']}}"
            },
            data: {
              approved:$("input[name=validateDocument_approved]").val()
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
