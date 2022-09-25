<div class="card bg-none card-box">
    {{ Form::model($user, array('route' => array('user.update', $user->id), 'method' => 'PUT')) }}
    <div class="row">
        <div class="form-group col-lg-6 col-md-6">
            {!! Form::label('name', __('Name'),['class'=>'form-control-label']) !!}
            {!! Form::text('name', null, ['class' => 'form-control','required' => 'required']) !!}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {!! Form::label('email', __('Email'),['class'=>'form-control-label']) !!}
            {!! Form::text('email', null, ['class' => 'form-control','required' => 'required']) !!}
        </div>

        @if(\Auth::user()->type != 'super admin')
            <div class="form-group  col-lg-6 col-md-6">
                {{ Form::label('role', __('User Role'),['class'=>'form-control-label']) }}
                {!! Form::select('role', $roles, $user->roles,array('class' => 'form-control select2 user_role','required'=>'required')) !!}
                @error('role')
                <span class="invalid-role" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
        @endif
        <div class="form-group col-lg-6 col-md-6" id="branch">
            {{ Form::label('branch', __('Branch'), ['class' => 'form-control-label']) }}
            {!! Form::select('branch', $branch, $user->branch_id, array('class' => 'form-control select2 branch', 'required' => 'required')) !!}
            @error('branch')
                <span class="invalid-role" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
            @enderror
        </div>
        @if(Auth::user()->type == "company")
                    <div class="form-group col-lg-6 col-md-6">
                        <label for="" class="form-control-label">Status</label>
                       <select name="status" id="status" class="form-control form-control-sm">
                            <option value="">Select Status</option>
                            <option value="Pending" @if ($user->status == 'Pending') selected @endif >Pending</option>
                            <option value="Active" @if ($user->status == 'Active') selected @endif>Active</option>
                            <option value="Reject" @if ($user->status == 'Reject') selected @endif>Reject</option>
                       </select>
                    </div>
                    <div class="form-group col-lg-6 col-md-6" id="note">
                        <label for=""  class="form-control-label">Note</label>
                        <textarea name="note"  id="" cols="5" rows="2" class="form-control">{{ $user->note }}</textarea>
                    </div>
                    @endif
        <div class="col-md-12">
            <input type="submit" value="{{__('Update')}}" class="btn-create badge-blue">
            <input type="button" value="{{__('Cancel')}}" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('.user_role').on('change', function() {
        if ($(this).val() == '6') {
            $('#branch').show();
        } else {
            $('#branch').hide();
        }
    })
        
    });
    </script>

<script>
    $("#branch").hide()
    $(".user_role").load("change", function() {
        $('.user_role').on('change', function() {
        if ($(this).val() == '6') {
            $('#branch').show();
        } else {
            $('#branch').hide();
        }
    })
    })

</script>

<script>
    $('#note').hide();
    $('#status').on('change', function() {
        if ($(this).val() === 'Reject') {
            $('#note').show();
        } else{
            $('#note').hide();  
        }
    })
</script>
    
    {!! Form::close() !!}
</div>
