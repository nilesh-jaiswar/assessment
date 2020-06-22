<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <title>Router Details</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
    </head>

    <body>
        <div class="container">
            <div class="row pt-5">
                <div class="col-12 text-center">
                    <h1>Router Details</h1>
                </div>
            </div>
            <div class="row pt-3 add-route-btn-div">
                <div class="col-12">
                    <div class="float-right">
                        <button class="btn btn-md btn-success add-route-btn"><i class="fas fa-plus"></i> Add Route</button>
                    </div>
                </div>
            </div>
            <div class="insert-route-div pt-3 d-none">
                <form name="route_form">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="sapid">Sapid</label>
                                <input type="text" class="form-control" name="sapid" maxlength="18" minlength="3" placeholder="eg: 1313123" required />
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="hostname">Hostname</label>
                                <input type="text" class="form-control" name="hostname" maxlength="14" minlength="3" placeholder="eg: nilesh" required />
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="loopback">Loopback</label>
                                <input type="text" class="form-control" name="loopback" maxlength="15" minlength="7" placeholder="eg: 127.0.0.1" required />
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group">
                                <label for="mac_address">Mac Address</label>
                                <input type="text" class="form-control" name="mac_address" maxlength="17" minlength="7" placeholder="eg: 127.0.0.1" required />
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <input type="hidden" id="routeId" value="" />
                            <button type="submit" class="btn btn-primary insert-btn" >Submit</button>
                            <button type="submit" class="btn btn-primary update-btn d-none" >Update</button>
                            <button class="btn btn-primary close-btn" >Close</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row pt-3">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr class="bg-info">
                                    <th scope="col">#</th>
                                    <th scope="col">Sapid</th>
                                    <th scope="col">Hostname</th>
                                    <th scope="col">Loopback (ipv4)</th>
                                    <th scope="col">Mac Address</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="route-body">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <script src="<?php echo base_url('assets/js/jquery-3.5.1.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/custom.js'); ?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/js/all.min.js"></script>
    </body>

</html>