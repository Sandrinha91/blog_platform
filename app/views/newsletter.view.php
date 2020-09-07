<?php require('partials/admin.nav.php'); ?>

<!-- newsletter heading -->
<div class="container-fluid mt-3" style= "margin-top:70px !important;">
    <div class="col-12 bg-info w-100 text-center text-white rounded">
        <h5 class="p-2">Newsletter list</h5>
    </div>
</div>

<!-- PAGINATOR -->
<div class='col-12'>
        <?= $paginator ?>
    </div>

<!--Newsletter Table view -->
<div class="container" style= "margin-bottom:100px !important;">
    <table class="table table-striped mb-3 mt-3">
    <thead class="thead-dark">
        <tr>
            <th scope="col"></th>
            <th class='text-center' scope="col">Status</th>
            <th class='text-center' scope="col">Language</th>
            <th scope="col">Email</th>
            <th scope="col">Registered</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($emails as $email) : ?>
            <?php
                $url = 'http://saska.local/unsuscribe/me/%7B' . $email->id_email . '%7D/%7B' . $email->s_key . '%7D/%7B' . $email->v_key . '%7D/%7B' . $email->enail_language . '%7D';    
            ?>
            <tr>
                <!-- Number of post -->
                <td class="text-center"><span class="bg-info text-white rounded p-1"><?= $numberOfPost ?? '' ?></span></td>
                <td class="text-center"><span class="bg-info text-white rounded p-1"><?= $email->enail_language ?></span></td>
                <!-- Verified/Not verified email -->
                <td class='text-center'>
                    <?php if( $email->email_status == '1' ) : ?>
                        <span class="bg-success rounded p-2 text-white"> Verified </span>
                    <?php elseif( $email->email_status == '0' ) : ?>
                        <span class="bg-warning rounded p-2 text-white"> Not verified </span>
                    <?php endif; ?>
                </td>
                <!-- User email -->
                <td> <span class="btn p-0" style="cursor:auto;"><?= $email->email ?></span></td>
                <!-- Time of regitsration -->
                <td><span class="btn p-0" style="cursor:auto;"><?=$email->register_on ?></span></td>
                
                <!-- delete user script -->
                <script>
                    var username = "<?=$username?>";

                    function reply_click(obj){
                        var email_id = obj.id;
                        
                        if (window.confirm(`Do you want to Delete ${email_id}?`)) 
                            location.href=`/email/delete/%7B${username}%7D/%7B${email_id}%7D`;    
                    }
                </script>
                <!-- delete user btn -->
                <td><button id="<?=$email->id_email?>" onclick="reply_click(this);" class="text-danger btn p-0"><i class="fas fa-trash"></i> Delete user</button></td>
                <?php $numberOfPost ++ ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
</div>

<!-- footer section -->
<div class="fixed-bottom">
    <?php require('partials/footer.php'); ?>
</div>