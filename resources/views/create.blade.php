@include('includes.header')
<!-- Page content-->
<div class="container">
    <div class="row mt-5">
        <div class="p-5">
            <div class="p-3 ps-0">
                <h1>Create Webhook</h1>
            </div>
            @if(!empty($errors->all()))
                @foreach ($errors->all() as $error)
                    <div class="col-8">
                        <div class="alert alert-danger">{{ $error }}</div>
                    </div>
                @endforeach
            @endif
            <div class="row ">
                <div class="col-8">
                    <form class="form" action="{{ route('store-webhook') }}" method="Post">
                        @csrf
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Webhook Title</label>
                                <input type="text" class="form-control" name="title" required
                                       placeholder="Enter Title">
                                @error('title')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Webhook Description</label>
                                <input type="text" name="description" class="form-control" required
                                       placeholder="Enter Description">
                                @error('description')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <button class="btn btn-primary btn-small" type="submit">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('includes.footer')
