<table class="table" id="users-table">
    <thead>
    <th>UID</th>
    <th>用户名</th>
    <th>邮箱</th>
    <th>操作</th>
    </thead>
    <tbody>
    <?php
    $flag = 0;
    $cnt = 0;
    for($i = 0; $i < count($users); ++$i){
        $flag = 0;
        ?>
        <tr>
            <td class="users-td-uid" id="uid-<?php echo $i;?>"><?php echo $users[$i]['id'] ?></td>
            <td class="users-td"><input type="text" class="users-input" id="username-<?php echo $i;?>" value="<?php echo $users[$i]['username'];?>"></td>
            <td class="users-td"><input type="text" class="users-input" id="email-<?php echo $i;?>" value="<?php echo $users[$i]['email'];?>"></td>
            <td>
                <button class="btn btn-green btn-reset-token" id="reset-token-<?php echo $i;?>">重置token</button>
                <button class="btn btn-green btn-reset-apply" id="apply-<?php echo $i;?>">应用更改</button>
                <?php
                if($admin_id != $users[$i]['id']){
                    ?>
                    <button class="btn btn-red btn-delete" id="delete-<?php echo $i;?>">删除用户</button>
                    <?php
                }
                else{
                    ?>
<!--                    <span>管理员无法删除</span>-->
                    <?php
                }
                ?>
                <span class="users-notice" id="notice-<?php echo $i;?>"></span>
            </td>
        </tr>
        <?php
        if(($i + 1) % 6 == 0){
            $flag = 1;
            ?>
            <tr>
                <td class="users-td-uid">-</td>
                <td class="users-td"><input type="text" class="users-input" id="username-input-<?php echo $cnt; ?>" placeholder="填写用户名"></td>
                <td class="users-td"><input type="text" class="users-input" id="email-input-<?php echo $cnt; ?>" placeholder="填写邮箱"></td>
                <td>
                    <button class="btn btn-green btn-add-user" id="add-user-<?php echo $cnt; ?>">添加用户</button>
                </td>
            </tr>
            <?php
            $cnt++;
        }
    }
    if($flag == 0){
        ?>
        <tr>
            <td class="users-td-uid">-</td>
            <td class="users-td"><input type="text" class="users-input" id="username-input-<?php echo $cnt; ?>" placeholder="填写用户名"></td>
            <td class="users-td"><input type="text" class="users-input" id="email-input-<?php echo $cnt; ?>" placeholder="填写邮箱"></td>
            <td>
                <button class="btn btn-green btn-add-user" id="add-user-<?php echo $cnt; ?>">添加用户</button>
            </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>