<div class="card bg-none card-box">
    {{Form::open(array('url'=>'company-unit','method'=>'post'))}}
    <div class="row ">
        <div class="col-12">
            <div class="form-group">
                {{Form::label('company_id',__('Company'),['class'=>'form-control-label'])}}
                {{Form::select('company_id',$company,null,array('class'=>'form-control select2','placeholder'=>__('Select Company')))}}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                {{Form::label('name',__('Name'),['class'=>'form-control-label'])}}
                {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Company Unit Name')))}}
                @error('name')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <input type="submit" value="{{__('Create')}}" class="btn-create badge-blue">
            <input type="button" value="{{__('Cancel')}}" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    {{Form::close()}}
</div>
