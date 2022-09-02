<?php $__env->startPush('css-page'); ?>
<?php echo $__env->make('Chatify::layouts.headLinks', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Messenger')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="rounded-12">
    <div class="messenger rounded min-h-750 overflow-hidden mt-4 px-4">
        
        <div class="messenger-listView">
            
            <div class="m-header">
                <nav>
                    <nav class="m-header-right">
                        <a href="#" class="listView-x"><i class="fas fa-times"></i></a>
                    </nav>
                </nav>
                
                <input type="text" class="messenger-search" placeholder="<?php echo e(__('Search')); ?>" />
                
                <div class="messenger-listView-tabs">
                    <a href="#" <?php if($route == 'user'): ?> class="active-tab" <?php endif; ?> data-view="users">
                         <span class="fas fa-clock" title="<?php echo e(__('Recent')); ?>"></span>
                     </a>
                    <a href="#" <?php if($route == 'group'): ?> class="active-tab" <?php endif; ?> data-view="groups">
                        <span class="fas fa-users" title="<?php echo e(__('Members')); ?>"></span></a>
                </div>
            </div>
            
            <div class="m-body">
               
               
               <div class="<?php if($route == 'user'): ?> show <?php endif; ?> messenger-tab app-scroll" data-view="users">

                   
                    <p class="messenger-title">Favorites</p>
                    <div class="messenger-favorites app-scroll-thin"></div>

                   
                   <?php echo view('Chatify::layouts.listItem', ['get' => 'saved','id' => $id])->render(); ?>


                   
                   <div class="listOfContacts" style="width: 100%;height: calc(100% - 200px);position: relative;"></div>

               </div>

               
               <div class="all_members <?php if($route == 'group'): ?> show <?php endif; ?> messenger-tab app-scroll" data-view="groups">
                        <p style="text-align: center;color:grey;"><?php echo e(__('Soon will be available')); ?></p>
                    </div>

                 
               <div class="messenger-tab app-scroll" data-view="search">
                    
                    <p class="messenger-title"><?php echo e(__('Search')); ?></p>
                    <div class="search-records">
                        <p class="message-hint center-el"><span><?php echo e(__('Type to search..')); ?></span></p>
                    </div>
                 </div>
            </div>
        </div>

        
        <div class="messenger-messagingView">
            
            <div class="m-header m-header-messaging">
                <nav>
                    
                    <div style="display: inline-block;">
                            <a href="#" class="show-listView"><i class="fas fa-arrow-left"></i> </a>
                            <?php if(!empty(Auth::user()->avatar)): ?>
                                <div class="avatar av-s header-avatar" style="margin: 0px 10px; margin-top: -5px; margin-bottom: -5px;background-image: url('<?php echo e(asset('/storage/uploads/avatar/'.Auth::user()->avatar)); ?>');"></div>
                            <?php else: ?>
                                <div class="avatar av-s header-avatar" style="margin: 0px 10px; margin-top: -5px; margin-bottom: -5px;background-image: url('<?php echo e(asset('/storage/uploads/avatar/avatar.png')); ?>');"></div>
                            <?php endif; ?>
                            <a href="#" class="user-name"><?php echo e(config('chatify.name')); ?></a>
                        </div>
                    
                    <nav class="m-header-right">
                        <a href="#" class="add-to-favorite my-lg-1 my-xl-1 mx-lg-3 mx-xl-3"><i class="fas fa-star"></i></a>
                        <a href="#" class="show-infoSide my-lg-1 my-xl-1 mx-lg-3 mx-xl-3"><i class="fas fa-info-circle"></i></a>
                    </nav>
                </nav>
            </div>
            
            <div class="internet-connection">
                <span class="ic-connected"><?php echo e(__('Connected')); ?></span>
                <span class="ic-connecting"><?php echo e(__('Connecting...')); ?></span>
                <span class="ic-noInternet"><?php echo e(__('No internet access')); ?></span>
            </div>
            
            <div class="m-body app-scroll">
                <div class="messages">
                    <p class="message-hint" style="margin-top: calc(30% - 126.2px);"><span><?php echo e(__('Please select a chat to start messaging')); ?></span></p>
                </div>
                
                <div class="typing-indicator">
                    <div class="message-card typing">
                        <p>
                            <span class="typing-dots">
                                <span class="dot dot-1"></span>
                                <span class="dot dot-2"></span>
                                <span class="dot dot-3"></span>
                            </span>
                        </p>
                    </div>
                </div>
                
                <?php echo $__env->make('Chatify::layouts.sendForm', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
        
        <div class="messenger-infoView app-scroll text-center">
            
            <nav class="text-left">
                <a href="#"><i class="fas fa-times"></i></a>
            </nav>
            <?php echo view('Chatify::layouts.info')->render(); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('theme-script'); ?>
    <?php echo $__env->make('Chatify::layouts.modals', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home3/jaysecurity/sms.jaysecurity.in/resources/views/vendor/Chatify/pages/app.blade.php ENDPATH**/ ?>