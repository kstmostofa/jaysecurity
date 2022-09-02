<div class="card bg-none card-box">
    {{Form::model($company_unit,array('route' => array('company-unit.update', $company_unit->id), 'method' => 'PUT')) }}
    <div class="row ">
        <div class="col-12">
            <div class="form-group">
                {{Form::label('company_id',__('Company'))}}
                {{Form::select('company_id',$company,null,array('class'=>'form-control select2 ','placeholder'=>__('select Company')))}}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                {{Form::label('name',__('Name'))}}
                {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Company Unit Name')))}}
                @error('name')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <input type="submit" value="{{__('Update')}}" class="btn-create badge-blue">
            <input type="button" value="{{__('Cancel')}}" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    {{Form::close()}}
</div>
