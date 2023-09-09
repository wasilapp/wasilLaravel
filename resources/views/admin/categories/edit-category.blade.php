@extends('admin.layouts.app', ['title' => 'Edit Category'])

@section('css')
    <link href="{{asset('assets/libs/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/libs/dropify/dropify.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{env('APP_NAME')}}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('admin.categories.index')}}">{{__('admin.category')}}</a></li>
                            <li class="breadcrumb-item active">{{__('admin.edit')}}</li>
                        </ol>
                    </div>
                    <h4 class="page-title">{{__('admin.edit_category')}}</h4>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('admin.categories.update',['id'=>$category->id])}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            {{method_field('PATCH')}}
                            <input type="hidden" name="id" value="{{$category->id}}">

                            <div class="form-group custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="active"
                                       name="active" {{$category->active ? "checked" : ""}}>
                                <label class="custom-control-label" for="active">{{__('admin.active')}}
                                    ({{__('admin.you_can_disable_or_enable_this_category')}})</label>
                            </div>


                            <div class="form-group mt-0">
                                <label for="title">{{__('admin.category')}}</label>
                                <input type="text" class="form-control"
                                       id="title" placeholder="Title" name="title" value="{{$category->title}}">
                            </div>
                            <div class="form-group mt-0">
                                <label for="type">{{__('admin.type')}}</label>
                                <select class="form-control @if($errors->has('title')) is-invalid @endif" id="type" placeholder="Title" name="type" >
                                    <option value="water" @if($category->type) == 'water') selected @endif >Water</option>
                                    <option value="gas" @if($category->type) == 'gas') selected @endif >Gas</option>
                                </select>
                                @if($errors->has('type'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group mt-0">
                                <label for="commesion">{{__('admin.commesion')}}</label>
                                <input type="text" class="form-control"
                                       id="commesion" placeholder="commesion" name="commesion" value="{{$category->commesion}}">
                            </div>
                            

  <div class="form-group mt-0">
                                <label for="delivery_fee">{{__('admin.delivery_fee')}}</label>
                                <input type="text" class="form-control @if($errors->has('delivery_fee')) is-invalid @endif" id="delivery_fee" placeholder="delivery_fee" name="delivery_fee" value="{{$category->delivery_fee}}">
                                @if($errors->has('delivery_fee'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('delivery_fee') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="image">{{__('admin.image')}}</label>
                                <input type="file" name="image" id="image" data-plugins="dropify"
                                       data-default-file="{{asset('storage/'.$category->image_url)}}"/>
                                <p class="text-muted text-center mt-2 mb-0">{{__('admin.upload_image')}}</p>
                            </div>


                            <div class="text-right">
                                <button type="submit" class="btn btn-success waves-effect waves-light">{{__('admin.update')}}</button>
                                <a type="button" href="{{route('admin.categories.index')}}"
                                   class="btn btn-danger waves-effect waves-light m-l-10">{{__('admin.cancel')}}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('assets/libs/dropzone/dropzone.min.js')}}"></script>
    <script src="{{asset('assets/libs/dropify/dropify.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/form-fileuploads.init.js')}}"></script>
@endsection
