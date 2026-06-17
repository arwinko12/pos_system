<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

  
        
        <div class="row">
            <div class="col-md-4">
                <div class="card bg-primary text-white p-3">
                    <h5>Total Sales</h5>
                    <h3>₱12,500</h3>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-success text-white p-3">
                    <h5>Orders</h5>
                    <h3>320</h3>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-warning text-white p-3">
                    <h5>Users</h5>
                    <h3>1,240</h3>
                </div>
            </div>
        </div>



<?= $this->endSection() ?>