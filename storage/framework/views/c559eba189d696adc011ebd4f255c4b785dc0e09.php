
<?php if($viewType == 'default'): ?>
    <?php if($from_id != $to_id): ?>
    <div class="message-card" data-id="<?php echo e($id); ?>">
        <p><?php echo ($message == null && $attachment != null && @$attachment[2] != 'file') ? $attachment[1] : nl2br($message); ?>

            <sub title="<?php echo e($fullTime); ?>"><?php echo e($time); ?></sub>
            
            <?php if(@$attachment[2] == 'file'): ?>
            <a href="<?php echo e(route(config('chatify.attachments.download_route_name'),['fileName'=>$attachment[0]])); ?>" style="color: #595959;" class="file-download">
                <span class="fas fa-file"></span> <?php echo e($attachment[1]); ?></a>
            <?php endif; ?>
        </p>
    </div>
    
    <?php if(@$attachment[2] == 'image'): ?>
    <div>
        <div class="message-card">
            <div class="image-file chat-image" style="width: 250px; height: 150px;background-image: url('<?php echo e(asset('storage/'.config('chatify.attachments.folder').'/'.$attachment[0])); ?>')">
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>


<?php if($viewType == 'sender'): ?>
    <div class="message-card mc-sender" data-id="<?php echo e($id); ?>">
        <p><?php echo ($message == null && $attachment != null && @$attachment[2] != 'file') ? $attachment[1] : nl2br($message); ?>

            <sub title="<?php echo e($fullTime); ?>" class="message-time">
                <span class="fas fa-<?php echo e($seen > 0 ? 'check-double' : 'check'); ?> seen"></span> <?php echo e($time); ?></sub>
                
            <?php if(@$attachment[2] == 'file'): ?>
            <a href="<?php echo e(route(config('chatify.attachments.download_route_name'),['fileName'=>$attachment[0]])); ?>" class="file-download">
                <span class="fas fa-file"></span> <?php echo e($attachment[1]); ?></a>
            <?php endif; ?>
        </p>
    </div>
    
    <?php if(@$attachment[2] == 'image'): ?>
    <div>
        <div class="message-card mc-sender">
            <div class="image-file chat-image" style="width: 250px; height: 150px;background-image: url('<?php echo e(asset('storage/'.config('chatify.attachments.folder').'/'.$attachment[0])); ?>')">
            </div>
        </div>
    </div>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/vendor/Chatify/layouts/messageCard.blade.php ENDPATH**/ ?>