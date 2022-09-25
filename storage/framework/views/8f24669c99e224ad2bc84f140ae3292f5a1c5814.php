<div class="card bg-none card-box">
    <?php echo e(Form::model($field,array('route' => array('employee-field.update', $field->id), 'method' => 'PUT'))); ?>

   <input type="hidden" name="id" value="<?php echo e($field->id); ?>">
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <?php echo e(Form::label('name',__('Name'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::text('name',$field->field_name,array('class'=>'form-control','placeholder'=>__('Enter Field Name')))); ?>

                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="invalid-name" role="alert">
                    <strong class="text-danger"><?php echo e($message); ?></strong>
                </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <?php echo e(Form::label('name',__('type'),['class'=>'form-control-label'])); ?>

                <select class="form-control select2 select2-hidden-accessible" id="type" name="type" data-select2-id="type" tabindex="-1" aria-hidden="true">
                    <option selected="selected" value="">Select Type</option>
                    <option value="text" <?php
                    if ($field->type=='text') {
                         echo "Selected";
                     } ?>>Text</option>
                    <option value="number" <?php
                    if ($field->type=='number') {
                         echo "Selected";
                     } ?>>Number</option>
                     <option value="date" <?php
                    if ($field->type=='date') {
                         echo "Selected";
                     } ?>>Date</option>
                    <option value="file" <?php
                    if ($field->type=='file') {
                         echo "Selected";
                     } ?>>File</option>
                     <option value="radio" <?php
                    if ($field->type=='radio') {
                         echo "Selected";
                     } ?>>Radio</option>
                     <option value="checkbox"  <?php
                    if ($field->type=='checkbox') {
                         echo "Selected";
                     } ?>>Checkbox</option>
                    <option value="select"  <?php
                    if ($field->type=='select') {
                         echo "Selected";
                     } ?>>Drop Drown</option>
                </select>

                <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="invalid-name" role="alert">
                    <strong class="text-danger"><?php echo e($message); ?></strong>
                </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
        <!-- add new -->
        <?php if ($field->type=='radio' or $field->type=='checkbox' or $field->type=='select') {
            foreach ($fields_atribute as $value) {
            
          ?>
        <div class="col-md-6 atribute">
            <div class="form-group">
                <?php echo e(Form::label('name',__('option name'),['class'=>'form-control-label'])); ?>

                <input type="text" name="option_name[]" class="form-control" value="<?php echo e($value->option_name); ?>">
            
                <?php $__errorArgs = ['option_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="invalid-name" role="alert">
                    <strong class="text-danger"><?php echo e($message); ?></strong>
                </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
        <div class="col-md-6 atribute">
            <div class="form-group">
                <?php echo e(Form::label('name',__('option value'),['class'=>'form-control-label'])); ?>

                <input type="text" name="option_value[]" class="form-control" value="<?php echo e($value->option_value); ?>">
            
                <?php $__errorArgs = ['option_value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="invalid-name" role="alert">
                    <strong class="text-danger"><?php echo e($message); ?></strong>
                </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <?php }  ?>
        <div class="col-md-1 atribute_multiple" style="display: none;">
            <div class="form-group">
                <?php echo e(Form::label('name',__('multiple'),['class'=>'form-control-label'])); ?>

                <input type="checkbox" <?php if ($field->multiple=='1') {
                  echo "checked";
                } ?> value="1" name="multiple" class="form-control">
            </div>
        </div>
        <div class="col-md-2 atribute">
            <input type="button" class="btn-create bg-gray add_field_button" name="add_attribute" value="add_attribute" id='add_field_button'>
        </div>
        <?php  } ?>
        <div class="col-md-12 input_fields_wrap atribute" id="input_fields_wrap"></div>
        <!-- end -->
         <div class="col-md-6 ">
        <div class="form-group ">
            <?php echo Form::label('status', __('Status'),['class'=>'form-control-label']); ?><span class="text-danger pl-1">*</span>
            <div class="d-flex radio-check">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="status" value="1" name="status" class="custom-control-input" <?php 
                    if ($field->status=='1') {
                         echo "checked";
                     } ?>>
                    <label class="custom-control-label" for="status"><?php echo e(__('Active')); ?></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="status_" value="0" name="status" class="custom-control-input" <?php 
                    if ($field->status=='0') {
                         echo "checked";
                     } ?>>
                    <label class="custom-control-label" for="status_"><?php echo e(__('Inactive')); ?></label>
                </div>
            </div>
            <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="invalid-name" role="alert">
                    <strong class="text-danger"><?php echo e($message); ?></strong>
                </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </div>
     <div class="col-md-6 ">
        <div class="form-group ">
            <?php echo Form::label('mandatory', __('Mandatory'),['class'=>'form-control-label']); ?><span class="text-danger pl-1">*</span>
            <div class="d-flex radio-check">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="mandatory" value="1" name="mandatory" class="custom-control-input" <?php 
                    if ($field->mandatory=='1') {
                         echo "checked";
                     } ?>>
                    <label class="custom-control-label" for="mandatory"><?php echo e(__('Mandatory')); ?></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="mandatory_not" value="0" name="mandatory" class="custom-control-input" <?php 
                    if ($field->mandatory=='0') {
                         echo "checked";
                     } ?>>
                    <label class="custom-control-label" for="mandatory_not"><?php echo e(__('Mandatory Not')); ?></label>
                </div>
            </div>
            <?php $__errorArgs = ['mandatory'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="invalid-name" role="alert">
                    <strong class="text-danger"><?php echo e($message); ?></strong>
                </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </div>
        <div class="col-12">
            <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>
<script type="text/javascript">
$(document).ready(function() {
    value=$('#type').val();
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
</script><?php /**PATH /var/www/html/resources/views/employee_field/edit.blade.php ENDPATH**/ ?>