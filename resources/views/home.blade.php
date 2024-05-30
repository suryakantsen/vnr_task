@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    {{-- @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{ __('You are logged in!') }} --}}
                    <div>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#blogPostModal">Add Blog Post</button>
                    </div>

                    <div class="mt-4">
                        <table class="table" id="myTable">
                          <thead>
                            <tr>
                              <th scope="col">S no.</th>
                              <th scope="col">Title</th>
                              <th scope="col">Body</th>
                              <th scope="col">Created Date</th>
                              <th scope="col">Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                            @if(isset($posts[0]))
                                @foreach($posts as $post)
                                <tr>
                                  <th scope="row">{{$post->id}}</th>
                                  <td>{{$post->title}}</td>
                                  <td>{{$post->body}}</td>
                                  <td>{{date('d-m-Y H:i A', strtotime($post->created_at))}}</td>
                                  <td><button type="button" data-value="{{$post->id}}" data-action="edit" class="btn btn-sm btn-primary edit_btn">Edit</button><button type="button" data-value="{{$post->id}}" class="btn btn-sm btn-danger ml-1 delete_btn">Delete</button><button type="button" data-value="{{$post->id}}" data-action="view" class="btn btn-sm btn-info ml-1 view_btn">View</button></td>
                                </tr>
                                @endforeach
                            @endif
                          </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="blogPostModal" tabindex="-1" role="dialog" aria-labelledby="blogPostModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="blogPostModalLabel">Add Blog Post</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="post_blog_form">
            @csrf
            <input type="hidden" name="id" id="post_id">
          <div class="form-group">
            <label for="title" class="col-form-label">Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="title" id="title" placeholder="Enter title">
          </div>
          <div class="form-group">
            <label for="body" class="col-form-label">Body <span class="text-danger">*</span></label>
            <textarea class="form-control" id="body" name="body"  placeholder="Enter body"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer footer_div">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary save_btn">Save</button>
      </div>
    </div>
  </div>
</div>
@endsection
