<div class="card bg-none card-box">
    {{Form::open(array('url'=>'employee-field','method'=>'post'))}}
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                {{Form::label('name',__('Name'),['class'=>'form-control-label'])}}
                {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Field Name')))}}
                @error('name')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                {{Form::label('name',__('type'),['class'=>'form-control-label'])}}
                <select class="form-control select2 select2-hidden-accessible" id="type" name="type" data-select2-id="type" tabindex="-1" aria-hidden="true">
                    <option selected="selected" value="">Select Type</option>
                    <option value="text">Text</option>
                    <option value="number">Number</option>
                    <option value="date">Date</option>
                    <option value="file">File</option>
                    <option value="radio">Radio</option>
                    <option value="checkbox">Checkbox</option>
                    <option value="select">Drop Drown</option>
                    
                </select>

                @error('type')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
         <div class="col-md-4 atribute" style="display: none;">
            <div class="form-group">
                {{Form::label('name',__('option name'),['class'=>'form-control-label'])}}
                <input type="text" name="option_name[]" class="form-control">
            
                @error('option_name')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-md-4 atribute" style="display: none;">
            <div class="form-group">
                {{Form::label('name',__('option value'),['class'=>'form-control-label'])}}
                <input type="text" name="option_value[]" class="form-control">
            
                @error('option_value')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-md-1 atribute_multiple" style="display: none;">
            <div class="form-group">
                {{Form::label('name',__('multiple'),['class'=>'form-control-label'])}}
                <input type="checkbox" value="1" name="multiple" class="form-control">
            </div>
        </div>
        <div class="col-md-2 atribute" style="display: none;">
            <input type="button" class="btn-create bg-gray add_field_button" name="add_attribute" value="add_attribute" id='add_field_button'>
        </div>
        <div class="col-md-12 input_fields_wrap" id="input_fields_wrap"></div>
        <div class="col-md-6 ">
        <div class="form-group ">
            {!! Form::label('status', __('Status'),['class'=>'form-control-label']) !!}<span class="text-danger pl-1">*</span>
            <div class="d-flex radio-check">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="status" value="1" name="status" class="custom-control-input">
                    <label class="custom-control-label" for="status">{{__('Active')}}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="status_" value="0" name="status" class="custom-control-input">
                    <label class="custom-control-label" for="status_">{{__('Inactive')}}</label>
                </div>
            </div>
            @error('status')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
        </div>
    </div>
     <div class="col-md-6 ">
        <div class="form-group ">
            {!! Form::label('mandatory', __('Mandatory'),['class'=>'form-control-label']) !!}<span class="text-danger pl-1">*</span>
            <div class="d-flex radio-check">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="mandatory" value="1" name="mandatory" class="custom-control-input">
                    <label class="custom-control-label" for="mandatory">{{__('Mandatory')}}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="mandatory_not" value="0" name="mandatory" class="custom-control-input">
                    <label class="custom-control-label" for="mandatory_not">{{__('Mandatory Not')}}</label>
                </div>
            </div>
            @error('mandatory')
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
<script type="text/javascript">
$(document).ready(function() {
    $('#type').change(function() {
      value=$(this).val();
      if (value=='radio') {
        $('.atribute').show();
        $('.atribute_multiple').hide();
      }
      else if (value=='checkbox') {
        $('.atribute').show();
        $('.atribute_multiple').show();
      }
      else if (value=='select') {
        $('.atribute').show();
        $('.atribute_multiple').show();
      }
      else{
         $('.atribute').hide();
         $('.atribute_multiple').hide();
      } 
    });
  });  
</script>
<script type="text/javascript">
$(document).ready(function() {
var max_fields      = 4; //maximum input boxes allowed
var wrapper         = $(".input_fields_wrap"); //Fields wrapper
var add_button      = $(".add_field_button"); //Add button ID

var x = 1; //initlal text box count
$(add_button).click(function(e){ //on add input button click
e.preventDefault();
if(x < max_fields){ //max input box allowed
x++; //text box increment
$(wrapper).append('<div class="row"><div class="col-md-6 atribute"><div class="form-group"><label class="form-control-label">Option Name</label><input type="text" name="option_name[]" class="form-control"></div></div><div class="col-md-6 atribute"><div class="form-group"><label class="form-control-label">Option Value</label><input type="text" name="option_value[]" class="form-control"></div></div><a href="#" class="remove_field">Remove</a></div>'); //add input box
}
});

$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
e.preventDefault(); $(this).parent('div').remove(); x--;
})
});
</script>