<div class="container">
<?php $this->renderFeedbackMessages(); ?>

<div class="login-page-box">
    <div class="table-wrapper">
        <div class="login-box">
            <h2>Lists</h2>

            <table class="table table-striped table-dark table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Name</th>
                        <th>Created by</th>
                        <th>Last edited</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($this->lists as $list): ?>
                <a href="<?php echo URL; ?>task/view/<?php echo $list->id;?>">
                    <tr>
                        <td><?php echo $list->taskName; ?></td>
                        <td><?php echo $list->userName; ?></td>
                        <td><?php echo $list->changed ?? 'Never' ?></td>
                        <td><a href="<?php echo URL; ?>task/edit/<?php echo $list->id;?>">Edit</a></td>
                    </tr>
                </a>
                <?php endforeach; ?>
                </tbody>
            </table>
            
        </div>
        <div class="register-box"> 
            <h2>Create a new List</h2>

            <form action="<?php echo URL; ?>task/create" method="post">
                <input type="text" name="task_name" placeholder="List name" tabindex="1" required />
                <!--<input type="checkbox" name="set_remember_me_cookie" id="remember-me-checkbox" tabindex="3" />
                <label for="remember-me-checkbox">Remember me for 2 weeks</label> -->
                <input type="submit" class="login-submit-button" value="Create list!" tabindex="4" />
            </form>
        </div>	
    </div>
</div>

    
</div>