<div class="container">
<?php $this->renderFeedbackMessages(); ?>
    
    <div class="row">
        <div class="col-8">
            <h2><?php echo $this->singleTask->listName . ' -> ' . $this->singleTask->taskName; ?></h2>
            <span>Task description: </span> <?php echo $this->singleTask->description; ?> <br />
            <span>Task duration: </span> <?php echo $this->singleTask->duration; ?> Minute(s) <br />
            <span>Task status: </span> <?php echo $this->singleTask->status; ?>
         
        </div>
        <div class="col-4">
            <h2>Options</h2>
            <div class="login-page-box">
                <div class="table-wrapper">
                    <div class="register-box">
                        <form action="<?php echo URL; ?>checklist/taskEdit/<?php echo $this->singleTask->listId;?>/<?php echo $this->singleTask->id;?>" method="post">
                            <input type="text" name="task_name" placeholder="Task name" value="<?php echo $this->singleTask->taskName; ?>" required />
                            <input type="text" name="task_description" placeholder="Task description" value="<?php echo $this->singleTask->description; ?>" required />
                            <input type="number" name="task_duration" placeholder="Task duration in minutes" min="0" value="<?php echo $this->singleTask->duration; ?>" required />
                            <select name="task_status">
                                <option value="1" <?php echo ($this->singleTask->numStatus == 1 ? 'selected' : ''); ?>>Not done</option>
                                <option value="2" <?php echo ($this->singleTask->numStatus == 2 ? 'selected' : ''); ?>>Working</option>
                                <option value="3" <?php echo ($this->singleTask->numStatus == 3 ? 'selected' : ''); ?>>Done</option>
                            </select>
                            <input type="submit" class="login-submit-button" value="Edit Task" />
                        </form>
                        <form action="<?php echo URL; ?>checklist/taskDelete/<?php echo $this->singleTask->listId;?>/<?php echo $this->singleTask->id;?>" method="post">
                            <input type="submit" class="login-submit-button" value="Delete Task" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>