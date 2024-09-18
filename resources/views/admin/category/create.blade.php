@extends('admin.layouts.app')

@section('title','Category List')


@section('content')


<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">

            </div>
            <div class="col-lg-6 offset-3">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h3 class="text-center title-2">Category Form</h3>
                        </div>
                        <hr>
                        <form action="{{route('category#create')}}" method="post" novalidate="novalidate">
                            @csrf
                            <div class="form-group">
                                <label class="control-label mb-1">Name</label>
                                <input id="cc-pament" name="categoryName" type="text" value="{{old('categoryName')}}" class="form-control @error('categoryName')is-invalid @enderror" placeholder="Tops/Bottoms/Outwear etc..." aria-required="true" aria-invalid="false" placeholder="Tops/Bottoms/Outwear etc...">
                                @error('categoryName')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <br>
                            <div class="d-flex justify-content-between">
                                <a href="{{route('category#list')}}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left me-2"></i> Back
                                </a>
                                <button id="payment-button" type="submit" class="btn btn-info btn-block">
                                    <span id="payment-button-amount">Create</span>
                                    <i class="fa fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
