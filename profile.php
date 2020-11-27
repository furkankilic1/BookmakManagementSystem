<!--Edit pagein HTML dosyası butona bastığında editUser'a gider ve id'yi editUser a gönderir.-->

<div class="container">
    <div class="col s6 offset-s3">
        <h2 class="header center">Edit User</h2>
        <div class="card horizontal">
            <div class="card-image">
                <img class="image" src="img/ofis.jpg">
            </div>
            <div class="card-stacked">
                <div class="card-content">
                    <form action="?page=editUser&id=<?= $_SESSION["user"]["id"] ?>" method="post" enctype="multipart/form-data">
     
                        <div class="input-field">
                            <i class="material-icons prefix">account_circle</i>
                            <input placeholder="<?= $_SESSION["user"]["name"] ?>" id="user_name" type="text" name="name">
                            <label for="user_name">Full Name</label>
                        </div>

                        <div class="input-field">
                        <i class="material-icons prefix">email</i>
                            <input placeholder="<?= $_SESSION["user"]["email"] ?>" id="user_email" type="text" name="email">
                            <label for="user_email">Email</label>
                        </div>

                        <div class="input-field">
                            <i class="material-icons prefix">lock</i>
                            <input placeholder="Password" id="user_pass" type="password" name="password">
                            <label for="user_pass">Password</label>
                        </div>

                        <div class="file-field input-field">
                            <div class="btn">
                                <span>File</span>
                                <input type="file" name="profile">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text">
                            </div>
                        </div>

                        <div class="input-field">
                            <button class="btn waves-effect waves-light" type="submit" name="action">Edit
                                <i class="material-icons right">send</i>
                            </button>
                        </div>
                        
                    </form> 
                </div>
            </div>
        </div>
    </div>
</div>