<?php
    //getting the dboperation class
    require_once '../../includes/DbOperation.php';
    require_once '../../includes/validations_functions.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    //
//     require 'vendor/phpmailer/phpmailer/src/Exception.php';
// require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
// require 'vendor/phpmailer/phpmailer/src/SMTP.php';
    //function validating all the paramters are available
    //we will pass the required parameters to this function
    function isTheseParametersAvailable($params)
    {
        //assuming all parameters are available
        $available = true;
        $missingparams = "";

        foreach ($params as $param) {
            if (!isset($_POST[$param]) || strlen($_POST[$param])<=0) {
                $available = false;
                $missingparams = $missingparams . ", " . $param;
            }
        }

        //if parameters are missing
        if (!$available) {
            $response = array();
            $response['error'] = true;
            $response['message'] = 'Parameters ' . substr($missingparams, 1, strlen($missingparams)) . ' missing';

            //displaying error
            echo json_encode($response);

            //stopping further execution
            die();
        }
    }


       $db = new DbOperation();
        //an array to display response
        $response = array();
        $errors = array();
        $message = " ";

        if (isset($_POST["submit"])) {
            // receiving the post params
            // user businessDetails$account_status = "pending approval";
            $fname = $_POST['first_name'];
            $lname = $_POST['last_name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $usertype = "Hatchery User";
            $account_status = "pending approval";


            $hatchery_name = $_POST['hatchery_name'];
            $year_established = $_POST['year_established'];

            $association_affiliation = $_POST['association_affiliation'];
            $country = $_POST['country'];
            $region = $_POST['region'];
            $district = $_POST['district'];
            $address = $_POST['address'];
            $pobox = $_POST['poboxnum'];
            $websiteurl = $_POST['websiteurl'];
            $phonenumber = $_POST['phonenumber'];

            $contact_person = $_POST['contact_person'];
            $total_incubation_capacity = $_POST['total_incubation_capacity'];




            if (isset($_POST['concerned'])) {
                $type_consern = $_POST['concerned'];

                echo "You chose the following color(s): <br>";
                foreach ($type_consern as $concerned) {
                    echo $concerned."<br />";
                }
            } // end brace for if(isset
            else {
                echo "You did not choose a color.";
            }

            // check if passwords match
            if ($password !=  $_POST['confirm_password']) {
                $message = "<div class=\"alert alert-info\" role=\"alert\">
        <strong>Match problem!</strong> <a href=\"#\" class=\"alert-link\">passwords don't match </a> and try submitting again.
      </div>";
            }

            if (empty($errors)) {
                // registerFeedManufacturers($user_id, $companyname, $year_established, $cert_of_incorporation_num, $feedbussiness_permit_num, $premise_cert_num, $gmp_cert_num, $association_affiliation, $country, $region, $district, $address, $pobox, $phonenumber, $websiteurl, $contact_person, $production_capacity, $storage_capacity, $num_products_produced, $man_power, $plant_manager);
                if ($db->doesUserEmailExist($email)) {
                    // user already existed
                    // $response["error"] = true;
                    // $response["error_msg"] = "User already exists with " . $email;
                    $message = "<div class=\"alert alert-info\" role=\"alert\">
             <strong>User Exists!</strong> <a href=\"#\" class=\"alert-link\">User with the " .$email. " </a> Already exists.
           </div>";
                // echo json_encode($response);
                } else {
                    $user = $db->registerHatcheryUser($fname, $lname, $email, $password, $usertype, $account_status);

                    if ($user) {
                        $response["error"] = false;
                        $response["uid"] = $user["user_unique_id"];
                        $response["user"]["user_id"] = $user["user_id"];
                        $response["user"]["first_name"] = $user["first_name"];
                        $response["user"]["last_name"] = $user["last_name"];
                        $response["user"]["email"] = $user["email"];
                        $response["user"]["usertype"] = $user["usertype"];
                        $response["user"]["encrypted_password"] = $user["encrypted_password"];
                        $response["user"]["usertype"] = $user["usertype"];
                        $response["user"]["account_status"] = $user["account_status"];
                        $response["user"]["salt"] = $user["salt"];
                        $response["user"]["created_at"] = $user["created_at"];
                        $response["user"]["updated_at"] = $user["updated_at"];
                    }


                    $user_id = $user["user_id"];

                    // create a new user
                    $hatchery = $db->registerNewHatchery(
                $user_id,
                $hatchery_name,
                $year_established,
                $incorporation_number,
                $business_permit_number,
                $premise_certificate_number,
                $gmp_certificate_number,
                $hatcheries_owned,
                $association_affiliation,
                $country,
                $region,
                $district,
                $pobox,
                $websiteurl,
                $address,
                $contact_person,
                $total_hatchery_capacity,
                $total_incubation_capacity,
                $num_breeds_hatched,
                $total_man_power,
                $plant_manager
                );
                    // register new manufacturer
                    if ($hatchery) {
                        // user stored successfully
                        $response["error"] = false;
                        $response["htuid"] = $hatchery["hatchery_unique_id"];
                        $response["hatchery"]["hatchery_id"] = $hatchery["hatchery_id"];
                        $response["hatchery"]["user_id"] = $hatchery["user_id"];
                        $response["hatchery"]["hatchery_name"] = $hatchery["hatchery_name"];
                        $response["hatchery"]["year_established"] = $hatchery["year_established"];
                        $response["hatchery"]["incorporation_number"] = $hatchery["incorporation_number"];
                        $response["hatchery"]["business_permit_number"] = $hatchery["business_permit_number"];
                        $response["hatchery"]["premise_certificate_number"] = $hatchery["premise_certificate_number"];
                        $response["hatchery"]["gmp_certificate_number"] = $hatchery["gmp_certificate_number"];
                        $response["hatchery"]["hatcheries_owned"] = $hatchery["hatcheries_owned"];
                        $response["hatchery"]["association_affiliation"] = $hatchery["association_affiliation"];
                        $response["hatchery"]["country"] = $hatchery["country"];
                        $response["hatchery"]["region"] = $hatchery["region"];
                        $response["hatchery"]["district"] = $hatchery["district"];
                        $response["hatchery"]["pobox"] = $hatchery["pobox"];
                        $response["hatchery"]["address"] = $hatchery["address"];
                        $response["hatchery"]["contact_person"] = $hatchery["contact_person"];
                        $response["hatchery"]["total_hatchery_capacity"] = $hatchery["total_hatchery_capacity"];
                        $response["hatchery"]["total_incubation_capacity"] = $hatchery["total_incubation_capacity"];
                        $response["hatchery"]["total_man_power"] = $hatchery["total_man_power"];
                        $response["hatchery"]["plant_manager"] = $hatchery["plant_manager"];
                        $response["hatchery"]["created_at"] = $hatchery["created_at"];
                        $response["hatchery"]["updated_at"] = $hatchery["updated_at"];


                        $message = "<div class=\"alert alert-success\" role=\"alert\">
                <strong>Well done!</strong> You successfully registered <a href=\"#\" class=\"alert-link\">a new hatchery</a>.
                </div>";
                    }
                }
            } else {
                $username = "";
                $message = "<div class=\"alert alert-info\" role=\"alert\">
         <strong>Take note!</strong> <a href=\"#\" class=\"alert-link\">When registering</a> please fill all the relevant details.
       </div>";
            }
        }


    ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="http://v4-alpha.getbootstrap.com/favicon.ico">

    <title>Livestoka | Hatchery Owners Registration </title>

    <!-- Bootstrap core CSS -->
    <link href="http://v4-alpha.getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="http://v4-alpha.getbootstrap.com/assets/js/ie10-viewport-bug-workaround.js"></script>

    <!-- Custom styles for this template -->
    <link href="http://v4-alpha.getbootstrap.com/examples/carousel/carousel.css" rel="stylesheet">

    <style>
    .card {
         border: transparent;
    }

    /* The customcheck */
.customcheck {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 22px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* Hide the browser's default checkbox */
.customcheck input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

/* Create a custom checkbox */
.checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: #eee;
    border-radius: 5px;
}

/* On mouse-over, add a grey background color */
.customcheck:hover input ~ .checkmark {
    background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.customcheck input:checked ~ .checkmark {
    background-color: #02cf32;
    border-radius: 5px;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

/* Show the checkmark when checked */
.customcheck input:checked ~ .checkmark:after {
    display: block;
}

/* Style the checkmark/indicator */
.customcheck .checkmark:after {
    left: 9px;
    top: 5px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
}


@import('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.0/css/bootstrap.min.css')

.funkyradio div {
  clear: both;
  overflow: hidden;
}

.funkyradio label {
  width: 100%;
  border-radius: 3px;
  border: 1px solid #D1D3D4;
  font-weight: normal;
}

.funkyradio input[type="radio"]:empty,
.funkyradio input[type="checkbox"]:empty {
  display: none;
}

.funkyradio input[type="radio"]:empty ~ label,
.funkyradio input[type="checkbox"]:empty ~ label {
  position: relative;
  line-height: 2.5em;
  text-indent: 3.25em;
  margin-top: 2em;
  cursor: pointer;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
}

.funkyradio input[type="radio"]:empty ~ label:before,
.funkyradio input[type="checkbox"]:empty ~ label:before {
  position: absolute;
  display: block;
  top: 0;
  bottom: 0;
  left: 0;
  content: '';
  width: 2.5em;
  background: #D1D3D4;
  border-radius: 3px 0 0 3px;
}

.funkyradio input[type="radio"]:hover:not(:checked) ~ label,
.funkyradio input[type="checkbox"]:hover:not(:checked) ~ label {
  color: #888;
}

.funkyradio input[type="radio"]:hover:not(:checked) ~ label:before,
.funkyradio input[type="checkbox"]:hover:not(:checked) ~ label:before {
  content: '\2714';
  text-indent: .9em;
  color: #C2C2C2;
}

.funkyradio input[type="radio"]:checked ~ label,
.funkyradio input[type="checkbox"]:checked ~ label {
  color: #777;
}

.funkyradio input[type="radio"]:checked ~ label:before,
.funkyradio input[type="checkbox"]:checked ~ label:before {
  content: '\2714';
  text-indent: .9em;
  color: #333;
  background-color: #ccc;
}

.funkyradio input[type="radio"]:focus ~ label:before,
.funkyradio input[type="checkbox"]:focus ~ label:before {
  box-shadow: 0 0 0 3px #999;
}

.funkyradio-default input[type="radio"]:checked ~ label:before,
.funkyradio-default input[type="checkbox"]:checked ~ label:before {
  color: #333;
  background-color: #ccc;
}

.funkyradio-primary input[type="radio"]:checked ~ label:before,
.funkyradio-primary input[type="checkbox"]:checked ~ label:before {
  color: #fff;
  background-color: #337ab7;
}

.funkyradio-success input[type="radio"]:checked ~ label:before,
.funkyradio-success input[type="checkbox"]:checked ~ label:before {
  color: #fff;
  background-color: #5cb85c;
}

.funkyradio-danger input[type="radio"]:checked ~ label:before,
.funkyradio-danger input[type="checkbox"]:checked ~ label:before {
  color: #fff;
  background-color: #d9534f;
}

.funkyradio-warning input[type="radio"]:checked ~ label:before,
.funkyradio-warning input[type="checkbox"]:checked ~ label:before {
  color: #fff;
  background-color: #f0ad4e;
}

.funkyradio-info input[type="radio"]:checked ~ label:before,
.funkyradio-info input[type="checkbox"]:checked ~ label:before {
  color: #fff;
  background-color: #5bc0de;
}
    </style>
  </head>
  <body>

    <nav class="navbar navbar-default navbar-static-top">
      <a href="../index.php" class="navbar-brand">Back To Livestoka</a>
    </nav>


    <div class="container">
      <div class="starter-template">
        <h1>Hatchery Owners Registration Area</h1>
        <p class="lead">Owner's and operators of Feed Manufactures can Register Below.<br> Please fill all the required Fields.</p>
      </div>
      <!--register section -->
      <section id="manufacturersReg">
        <!-- <form action="feed_manufacture_registry.php" method="post"> -->

   <?php //echo $message;?>
       <?php
        //echo form_errors($errors);
         ?>
        <form action="hatcher_reg.php" method="post">
    <!-- company information -->
            <div class="card">
              <div class="card-body">
                <div class="form-group">
                  <label for="formGroupExampleInput"><strong>Hatchery Description</strong></label>
                   <hr>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                    <label for="first_name">First Name</label>
                      <input type="text" class="form-control" id="first_name" name="first_name" value="<?= isset($_POST['first_name']) ? $_POST['first_name'] : ''; ?>" placeholder="First Name" onkeyup='check();'>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                     <label for="last_name">Last Name</label>
                       <input type="text" class="form-control" id="last_name" name="last_name" value="<?= isset($_POST['last_name']) ? $_POST['last_name'] : ''; ?>" placeholder="Last Name" onkeyup='check();'>
                      <!-- <span id='message'></span> -->
                     </div>
                  </div>
                </div>
                      <div class="form-group">
                        <label for="lblcompany_name">Organization/Hatchery Name</label>
                        <input type="text" class="form-control" id="companyname" name="hatchery_name" value="<?= isset($_POST['hatchery_name']) ? $_POST['hatchery_name'] : ''; ?>" placeholder="">
                      </div>
                      <div class="form-group">
                        <label for="lblyear_established">Year of Establishment</label>
                        <input type="text" class="form-control" id="year_established" onblur="yearValidation(this.value,event)" onkeypress="yearValidation(this.value,event" name="year_established"  value="<?= isset($_POST['year_established']) ? $_POST['year_established'] : ''; ?>" placeholder="">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="formGroupExampleInput2">Hatchery Association Affiliation. <small>e.g TAFMA, TCPA or TPBA</small></label>
                        <input type="text" class="form-control" id="association_affiliation" name="association_affiliation" value="<?= isset($_POST['association_affiliation']) ? $_POST['association_affiliation'] : ''; ?>" placeholder="">
                      </div>

              </div>
            </div>
            <!-- end of company information -->
              <!-- <hr> -->
            <br />
            <!-- company information -->
            <div class="container">
                    <div class="card">
                      <div class="card-body">

                        <div class="form-group">
                          <label for="formGroupExampleInput"><strong>Hatchery Address and Location</strong></label>
                        <hr>
                        </div>
                        <div class="form-group">
                          <label for="formGroupExampleInput2">Country</label>
                           <select class="form-control" id="country" name="country" value="<?= isset($_POST['country']) ? $_POST['country'] : ''; ?>">
                             <option>SELECT</option>
                             <option>Tanzania</option>
                             <option>Uganda</option>
                             <option>Kenya</option>
                             <option>Rwanda</option>
                           </select>

                        </div>
                        <div class="form-group">
                          <label for="formGroupExampleInput2">Region</label>
                          <input type="text" class="form-control" id="region" name="region" value="<?= isset($_POST['region']) ? $_POST['region'] : ''; ?>" placeholder="">
                        </div>
                        <div class="form-group">
                          <label for="formGroupExampleInput2">District</label>
                          <input type="text" class="form-control" id="district" name="district" value="<?= isset($_POST['district']) ? $_POST['district'] : ''; ?>" placeholder="">
                        </div>
                        <div class="form-group">
                          <label for="exampleTextarea">Address</label>
                          <textarea class="form-control" id="address" name="address" rows="3" value="<?= isset($_POST['address']) ? $_POST['address'] : ''; ?>"></textarea>
                        </div>
                        <!-- <div class="form-group">
                          <label for="exampleTextarea">Address 2</label>
                          <textarea class="form-control" id="txt_address_two" name="" rows="3"></textarea>
                        </div> -->
                        <div class="form-group">
                                <label for="formGroupExampleInput2">P.O.Box</label>
                                <input type="text" class="form-control" id="pobox" name="poboxnum" placeholder="" value="<?= isset($_POST['poboxnum']) ? $_POST['poboxnum'] : ''; ?>">
                              </div>
                        <div class="form-group">
                                <label for="formGroupExampleInput2">Office Phone Number:</label>
                                <input type="text" class="form-control" id="phonenumber" name="phonenumber" value="<?= isset($_POST['phonenumber']) ? $_POST['phonenumber'] : ''; ?>" placeholder=" ">
                              </div>

                         </div>
                         </div>
                         </div>
                           <br />
                            <br />
                            <!-- company information -->
                            <div class="container">
                <div class="card">
                  <div class="card-body">

                    <div class="form-group">
                      <label for="formGroupExampleInput"><strong>Establishment Declaration</strong></label>
                      <hr>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                             <h4>select your Establishment declaration.</h4>
                             <p>facility type</p>
                            <select class="form-control form-control-lg">
                              <option>Select type of establishment</option>
                              <option>Hatchery Establishment</option>
                              <option>Breeding Establishment</option>
                              <option>Pedigree breeding Establishment</option>
                            </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="formGroupExampleInput"><strong>Establishment Information</strong></label>
                      <hr>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                          <p>*select your Establishment concerned.</p>
                          <div class="form-check">
                              <label class="customcheck">Fowls
                                <input type="checkbox" checked="checked" name="concerned[]" id="concerned" value="fowls">
                                <span class="checkmark"></span>
                              </label>
                              <label class="customcheck"> Turkey
                                <input type="checkbox" name="concerned[]" id="concerned" value="turkey">
                                <span class="checkmark"></span>
                              </label>
                              <label class="customcheck">Ducks
                                <input type="checkbox" name="concerned[]" id="concerned" value="ducks">
                                <span class="checkmark"></span>
                              </label>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-check" style="padding-top: 26px;">
                          <label class="customcheck">Geese
                            <input type="checkbox" name="concerned[]" id="concerned" value="geese">
                            <span class="checkmark"></span>
                          </label>
                          <label class="customcheck">Guinea fowls
                            <input type="checkbox" name="concerned[]" id="concerned" value="guinea_fowls">
                            <span class="checkmark"></span>
                          </label>
                          </div>
                          <div class="form-group">
                            <label for="formGroupExampleInput2">Total incubation setting Capacity</label>
                            <input type="text" class="form-control" id="total_incubation_capacity" name="total_incubation_capacity" value="<?= isset($_POST['total_incubation_capacity']) ? $_POST['total_incubation_capacity'] : ''; ?>" placeholder=" ">
                          </div>
                        </div>
                        </div>
                      </div>
                    </div>
                
                  <div class="form-group">
                    <label for="formGroupExampleInput"><strong>Establishment Activities</strong></label>
                    <hr>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <p>*Type of Hatching activtiy.</p>
                        <select class="form-control form-control-lg" id="hatching_activity">
                          <option  value="0">Select Hatching activtiy.</option>
                          <option  value="1">Utility Chicks </option>
                          <option  value="2">grandparent stock chicks</option>
                          <option  value="3">parent stock chicks</option>

                        </select>
                      </div>

                      <p id="para_utilitya" style="display: none; font-size: 24px;"><small>i.) Production of eggs for hatching for the production of selected strain, grandparent
                        stock or commercial chicks.</small></p>
                      </br>

                      <p id="para_utilityb" style="display: none; font-size: 24px;"> <small>  ii.) Egg production chicks:  ii.) Egg production chicks:
                        chicks intended to be raised for the production of eggs for consumption.
                      </small></p>
                      </br>

                      <p id="para_utilityc" style="display: none; font-size: 24px;">  <small>iii.) Dual purpose chicks:
                          (chicks intended either for laying or for the table).
                            </small></p>
                      </br>

                      <p id="para_utilitygrandpastock" style="display: none; font-size: 24px;">Chicks intended for the production of commercial chicks.</p>
                      </br>

                      <p id="para_utility_parentstock" style="display: none; font-size: 24px;">Chicks intended for the production of commercial chicks.</p>
                      </br>

                      </div>
                    </div>


                     <div class="form-group">
                       <label for="formGroupExampleInput2">website</label>
                       <input type="text" class="form-control" id="websiteurl" name="websiteurl" value="<?= isset($_POST['websiteurl']) ? $_POST['websiteurl'] : ''; ?>" placeholder=" ">
                     </div>
                     <div class="form-group">
                       <label for="formGroupExampleInput2">Contact email</label>
                       <input type="email" class="form-control" id="email" name="email" value="<?= isset($_POST['email']) ? $_POST['email'] : ''; ?>" placeholder=" ">
                     </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                          <input type="password" class="form-control" id="password" name="password" value="<?= isset($_POST['password']) ? $_POST['password'] : ''; ?>" placeholder="Password" onkeyup='check();'>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                         <label for="exampleInputConfirmPassword2">Confirm Password</label>
                           <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="<?= isset($_POST['confirm_password']) ? $_POST['confirm_password'] : ''; ?>" placeholder="Password" onkeyup='check();'>
                           <span id='message'></span>
                         </div>
                      </div>
                    </div>
                      <div class="form-group">
                      <button type="submit"  name="submit" class="btn btn-primary btn-lg" value="Submit">Register</button>
                          </div>
                       </form>
                  </div>
                </div>
                <hr>
               </div>
      </section>

      <!--end of registeration section -->

    </div> <!-- /.container-->

    <!--scripts -->
    <!-- jQuery first, then Bootstrap JS. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js" integrity="sha384-vZ2WRJMwsjRMW/8U7i6PWi6AlO1L79snBrmgiDpgIWJ82z8eA5lenwvxbMV1PAh7" crossorigin="anonymous"></script>

    <script>
    function yearValidation(year,ev) {

  var text = /^[0-9]+$/;
  if(ev.type=="blur" || year.length==4 && ev.keyCode!=8 && ev.keyCode!=46) {
    if (year != 0) {
        if ((year != "") && (!text.test(year))) {

            alert("Please Enter Numeric Values Only");
            document.getElementById("year_established").focus();
            document.getElementById('year_established').value = '';
            return false;
        }

        if (year.length != 4) {
            alert("Year is not proper. Please check");
            document.getElementById("year_established").focus();
            document.getElementById('year_established').value = '';
            return false;

        }
        var current_year=new Date().getFullYear();
        if((year < 1920) || (year > current_year))
            {
            alert("Year should be in range 1920 to current year");
            document.getElementById("year_established").focus();
            document.getElementById('year_established').value = '';
            return false;

            }
        return true;
    } }
  }


  var check = function() {
       if (document.getElementById('password').value ==
           document.getElementById('confirm_password').value) {
           document.getElementById('message').style.color = 'green';
           document.getElementById('message').innerHTML = 'matching';
       } else {
       		document.getElementById('message').style.color = 'red';
           document.getElementById('message').innerHTML = 'not matching';
       }
   }

    </script>
<!-- para_utilitygrandpastock -->
    <script>
  $(document).ready(function(){
      $('#hatching_activity').on('change', function() {
        if ( this.value == '1')
        {
          $("#para_utilitya").show();
          $("#para_utilityb").show();
          $("#para_utilityc").show();

          $("#para_utility_parentstock").hide();
          $("#para_utilitygrandpastock").hide();

           }else if (this.value == '2') {
                   $("#para_utilitygrandpastock").show();

                   $("#para_utilitya").hide();
                   $("#para_utilityb").hide();
                   $("#para_utilityc").hide();
                   $("#para_utility_parentstock").hide();


          }else if (this.value == '3') {
                   $("#para_utility_parentstock").show();

                   $("#para_utilitya").hide();
                   $("#para_utilityb").hide();
                   $("#para_utilityc").hide();
                   $("#para_utilitygrandpastock").hide();

           }else {

                   $("#para_utilitya").hide();
                   $("#para_utilityb").hide();
                   $("#para_utilityc").hide();
                   $("#para_utility_parentstock").hide();
                   $("#para_utilitygrandpastock").hide();

          }
        });
        console.log("hellow");
    });
    </script>

  </body>
</html>
