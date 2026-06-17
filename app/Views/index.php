<?= $this->extend('layouts/default') ?>

<?= $this->section('content') ?>
<div class="login-form">
    <div class="card ">
        <div class="card-body">
            <div class="mb-3">
        

         
            
             
                <div class="text-center">
                    <img src="/uploads/system/logo.png" class="h-25 w-25">
                </div>
                <h4 class="text-center">Point Of Sales</h4>
                <p class="lead text-center">Let's build something great!</p>
            </div>
            <form action="<?= base_url('login') ?>" method="post">
            <div class="mb-3">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
                  </div>
                  <input type="text" class="form-control" name="username" id="username" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                </div>
            </div>

             <div class="mb-3">
                     <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-key"></i></span>
                  </div>
                  <input type="password" class="form-control" name="user_password" id="user_password" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1">
                  <div class="input-group-append">
                    <span class="input-group-text" onclick="showpassword()"><i id="icons" class="fas fa-eye"></i></span>
                  </div>
                </div>
            </div>
            <button type="submit" class="btn mb-3 btn-primary btn-lg font-weight-bold w-100">Login <i class="fa fa-sign-in"></i></button>
            </form>
               <?php if (session()->getFlashdata('errors')): ?>
                  <div class="alert alert-danger" role="alert">
                      <?php if (is_array(session()->getFlashdata('errors'))): ?>
                          <?php foreach (session()->getFlashdata('errors') as $error): ?>
                           <small class="text-center"><?= $error ?></small>   
                          <?php endforeach ?>
                      <?php endif ?>
                  </div>
              <?php endif ?>
              <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger" role="alert">
                  <small class="text-center"><?= session()->getFlashdata('error') ?></small> 
              </div>
              <?php endif ?>
        </div>
        <div class="card-footer border-0">
            <p class="text-center">All rights reserved 2026</p>
        </div>
    </div>

</div>
<?= $this->endSection() ?>