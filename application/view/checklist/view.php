<div class="container">
<?php $this->renderFeedbackMessages(); ?>
    
    <div class="row">
        <div class="col-8">
            <h2><?php echo $this->singleList->name; ?></h2>
            <span>Last edited:</span> <?php echo $list->singleList->changed ?? 'Never'; ?>
            
        </div>
        <div class="col-4">
            <h2>Author</h2>
            
            <span>Name:</span> <?php echo $this->singleListCreator->userName; ?> <br />
            <span>Lists:</span> <?php echo $this->singleListCreator->countLists; ?>

            <hr>

            <H2>Add task</H2>
            <div class="login-page-box">
                <div class="table-wrapper">
                    <div class="register-box">
                        <form action="<?php echo URL; ?>checklist/edit/<?php echo $this->singleList->id;?>" method="post">
                            <input type="text" name="task_name" placeholder="Task name" required />
                            <input type="number" name="task_duration" placeholder="Task duration in minutes" min="0" required />

                            <input type="submit" class="login-submit-button" value="Add Task!" />
                        </form>
                    </div>
                </div>
            </div>

            <HR>

            <h2>Options</h2>
            <div class="login-page-box">
                <div class="table-wrapper">
                    <div class="register-box">
                        <form action="<?php echo URL; ?>checklist/edit/<?php echo $this->singleList->id;?>" method="post">
                            <input type="text" name="list_name" placeholder="List name" value="<?php echo $this->singleList->name;?>" required />
                            <input type="submit" class="login-submit-button" value="Edit list" />
                        </form>
                    </div>
                </div>
            </div>
            <a href="<?php echo URL; ?>checklist/delete/<?php echo $this->singleList->id;?>">Delete list</a>
        </div>
    </div>
</div>