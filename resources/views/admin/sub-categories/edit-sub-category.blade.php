@extends('admin.layouts.app', ['title' => 'Edit Sub Category'])

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
                            <li class="breadcrumb-item"><a href="{{route('admin.categories.index')}}">{{__('admin.sub_category')}}</a></li>
                            <li class="breadcrumb-item active">{{__('admin.edit')}}</li>
                        </ol>
                    </div>
                    <h4 class="page-title">{{__('admin.sub_category')}}</h4>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('admin.sub-categories.update',['id'=>$sub_category->id])}}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            {{method_field('PATCH')}}

                            <div class="form-group custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="active"
                                       name="active" {{$sub_category->active ? "checked" : ""}}>
                                <label class="custom-control-label" for="active">{{__('admin.active')}}
                                    ({{__('admin.you_can_disable_or_enable_this_sub_category')}})</label>
                            </div>

                            <div class="form-group mt-0">
                                <label for="title">{{__('admin.sub_category')}}</label>
                                <input type="text" class="form-control"
                                       id="title" placeholder="Title" name="title" value="{{$sub_category->title}}">
                            </div>

                            <div class="form-group">
                                <label for="price">{{__('admin.price')}}</label>
                                <textarea name="price" id="price"
                                          class="form-control @if($errors->has('price')) is-invalid @endif"
                                          placeholder="price">{{$sub_category->price}}
                                </textarea>
                                @if($errors->has('price'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>
                             <div class="form-group">
                                <label for="image">{{__('admin.image')}}</label>
                                <input type="file" name="image" id="image" data-plugins="dropify"
                                       data-default-file="{{asset('storage/'.$sub_category->image_url)}}"/>
                                <p class="text-muted text-center mt-2 mb-0">{{__('admin.upload_image')}}</p>
                            </div>

                            <div>
                                <span>{{__("admin.category")}} : <a href="{{route('admin.categories.edit',['id'=>$sub_category->category->id])}}">{{$sub_category->category->title}}</a></span>
                            </div>


                            <div class="text-right">
                                <button type="submit" class="btn btn-success waves-effect waves-light">{{__('admin.update')}}</button>
                                <a type="button" href="{{route('admin.sub-categories.index')}}"
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
