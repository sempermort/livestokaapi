<?php
    //getting the dboperation class
    require_once '../../includes/DbConnect.php';
    require_once '../../includes/DbOperation.php';
    require_once '../../includes/validations_functions.php';
    include('../../includes/layouts/public_layout_header.php');
    include '../../web/vendor/autoload.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

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


        //check if grandparent_stock_chicks is selected
        //$grandparent_stock_chicks
        if(!isset($_RESULTS['grandparent_stock_chicks']))
        {
             $grandparent_stock_chicks = false;
        } else {
             $grandparent_stock_chicks = mysqli_real_escape_string($_POST['grandparent_stock_chicks']);

             }
             //check if utility_chicks is selected
             //$utility_chicks
             if(!isset($_RESULTS['utility_chicks']))
             {
                  $utility_chicks = false;
             } else {
                  $utility_chicks = mysqli_real_escape_string($_POST['utility_chicks']);
             }


                    //check if $parent_stock_chicks is selected
                    //$parent_stock_chicks

                    if(!isset($_RESULTS['parent_stock_chicks']))
                    {
                         $parent_stock_chicks = false;
                    } else {
                         $parent_stock_chicks = mysqli_real_escape_string($_POST['parent_stock_chicks']);

                         }


                    //check if broiler is selected
                    //$broiler

                    if(!isset($_RESULTS['broiler']))
                    {
                         $broiler = false;
                    } else {
                         $broiler = mysqli_real_escape_string($_POST['broiler']);

                         }

                //     //check if layers is selected
                //     //$layers


                    if(!isset($_RESULTS['layers']))
                    {
                         $layers = false;
                    } else {
                         $layers = mysqli_real_escape_string($_POST['layers']);

                         }

                //     //check if dual_purpose is selected
                //     //$dual_purpose
                if(!isset($_RESULTS['dual_purpose']))
                {
                     $dual_purpose = false;
                } else {
                     $dual_purpose = mysqli_real_escape_string($_POST['dual_purpose']);

                     }

                //    //POULTRY TYPES
                //    //check if hatching_chicken is selected
                //    //hatching_chicken
                if(!isset($_RESULTS['hatching_chicken']))
                {
                     $hatching_chicken = false;
                } else {
                     $hatching_chicken = mysqli_real_escape_string($_POST['hatching_chicken']);

                     }


                //    //check if hatching_chicken is selected
                //    //hatching_chicken
                if(!isset($_RESULTS['hatching_turkey']))
                {
                     $hatching_chicken = false;
                } else {
                     $hatching_chicken = mysqli_real_escape_string($_POST['hatching_turkey']);

                     }


                //    //check if hatching_ducks is selected
                //    //hatching_ducks

                if(!isset($_RESULTS['hatching_ducks']))
                {
                     $hatching_ducks = false;
                } else {
                     $hatching_ducks = mysqli_real_escape_string($_POST['hatching_ducks']);

                     }

                //    //check if hatching_geese is selected
                //    //hatching_geese



                if(!isset($_RESULTS['hatching_geese']))
                {
                     $hatching_geese = false;
                } else {
                     $hatching_geese = mysqli_real_escape_string($_POST['hatching_geese']);

                     }

                //    //check if hatching_guinea_fowls is selected
                //    //hatching_guinea_fowls


                if(!isset($_RESULTS['hatching_guinea_fowls']))
                {
                     $hatching_guinea_fowls = false;
                } else {
                     $hatching_guinea_fowls = mysqli_real_escape_string($_POST['hatching_guinea_fowls']);
                     }

                //    //check if hatching_quails is selected
                //    //hatching_quails

               if(!isset($_RESULTS['hatching_quails'])){
               $hatching_quails = false;
               }else{
               $hatching_quails = mysqli_real_escape_string($_POST['hatching_quails']);
               }

                //     //check if hatching_ostrich is selected
                //     //hatching_ostrich

                if(!isset($_RESULTS['hatching_ostrich'])){
                $hatching_ostrich = false;
                }else{
                $hatching_ostrich = mysqli_real_escape_string($_POST['hatching_ostrich']);
                }

                //     //CHECK SOURCE OF HATCHING eggs
                //     //check if imported_eggs is selected
                //     //imported_eggs
                if(!isset($_RESULTS['imported_eggs'])){
                $imported_eggs = false;
                }else{
                $imported_eggs = mysqli_real_escape_string($_POST['imported_eggs']);
                }

                //     //check if owns_breeder_farm is selected
                //     //owns_breeder_farm

                if(!isset($_RESULTS['owns_breeder_farm'])){
                $owns_breeder_farm = false;
                }else{
                $owns_breeder_farm = mysqli_real_escape_string($_POST['owns_breeder_farm']);
                }

                //   //check if owns_breeder_farm is selected
                //   //owns_breeder_farm

                if(!isset($_RESULTS['owns_breeder_farm'])){
                $owns_breeder_farm = false;
                }else{
                $owns_breeder_farm = mysqli_real_escape_string($_POST['owns_breeder_farm']);
                }

                //   //check if out_growers is selected
                //   //out_growers
                if(!isset($_RESULTS['out_growers'])){
                $out_growers = false;
                }else{
                $out_growers = mysqli_real_escape_string($_POST['out_growers']);
                }

                // //check if other_local_farms is selected
                // //other_local_farms
                if(!isset($_RESULTS['other_local_farms'])){
                $other_local_farms = false;
                }else{
                $other_local_farms = mysqli_real_escape_string($_POST['other_local_farms']);
                }
                // end of checkboxes check


        if (isset($_POST["submit"])) {

            // receiving the post params
            // user businessDetails$account_status = "pending approval";
            // $fname = $_POST['first_name'];
            //$lname = $_POST['last_name'];
          //  print_r($_POST['grandparent_stock_chicks']);
            //$grandparent_stock_chicks
            // if (isset($_POST['grandparent_stock_chicks'])) {
            //     $grandparent_stock_chicks = $_POST['grandparent_stock_chicks'];
            // }


            //user details
            $email = trim($_POST['contact_email']);
            $password = trim($_POST['password']);
            //TYPE OF HATCHING ACTIVITIES
            $usertype = "Hatchery User";
            $account_status = "pending approval";
            $phoneNumber = $_POST['phonenumbers'];
            $owners_full_name = trim($_POST['owners_full_name']);


            $hatchery_name = trim($_POST['hatchery_name']);
            $type_of_ownership = trim($_POST['type_of_ownership']);
            $date_established = trim($_POST['date_established']);
            $hatch_reg_number = trim($_POST['hatch_reg_number']);
            $owners_full_name = trim($_POST['owners_full_name']);
            //$hatchery_affiliation[]
            $hatchery_affiliation = $_POST['hatchery_affiliation'];
            $hatchery_manager = trim($_POST['hatchery_manager']);
            $hatchery_veterinarian = trim($_POST['hatchery_veterinarian']);
            $vet_reg_number = trim($_POST['vet_reg_number']);
           $typeofbreeds = $_POST['typeofBreed'];




               // check if passwords match
               if ($password !=  $_POST['confirm_password']) {
                   $message = "<div class=\"alert alert-info\" role=\"alert\">
           <strong>Match problem!</strong> <a href=\"#\" class=\"alert-link\">passwords don't match </a> and try submitting again.
         </div>";
               }
            // hatching purposes
            //$utility_chicks
            if(!isset($_REQUEST['utility_chicks'])){
                 $utility_chicks = "";
            } else {
                 $utility_chicks = trim($_POST['utility_chicks']);
            }
//           $utility_chicks = $_POST['utility_chicks'];
          //  $grandparent_stock_chicks = $_POST['grandparent_stock_chicks'];
          if(!isset($_REQUEST['grandparent_stock_chicks'])){
               $grandparent_stock_chicks = "";
          } else {
               $grandparent_stock_chicks = trim($_POST['grandparent_stock_chicks']);
          }
          //  $parent_stock_chicks = $_POST['parent_stock_chicks'];
          if(!isset($_REQUEST['parent_stock_chicks'])){
               $parent_stock_chicks = "";
          } else {
               $parent_stock_chicks = trim($_POST['parent_stock_chicks']);
          }



            //type of breed
          //  $broiler = $_POST['broiler'];
          if(!isset($_REQUEST['broiler'])){
               $broiler = "";
          } else {
               $broiler = $_POST['broiler'];
          }

          //    $layers =  $_POST['layers'];
          if(!isset($_REQUEST['layers'])){
               $layers = "";
          } else {
                $layers =  trim($_POST['layers']);
          }

          //    $dual_purpose = $_POST['dual_purpose'];
          if(!isset($_REQUEST['dual_purpose'])){
               $dual_purpose = "";
          } else {
               $dual_purpose = trim($_POST['dual_purpose']);
          }


            //type of poultry hacthing
          //  $hatching_fowls = $_POST['hatching_chicken'];
          if(!isset($_REQUEST['hatching_chicken'])){
               $hatching_fowls = "";
          } else {
               $hatching_fowls = trim($_POST['broiler']);
          }

       //  $hatching_turkey = $_POST['hatching_turkey'];
          if(!isset($_REQUEST['hatching_turkey'])){
               $hatching_turkey = "";
          } else {
                $hatching_turkey =  trim($_POST['hatching_turkey']);
          }

          //  $hatching_ducks = $_POST['hatching_ducks'];
          if(!isset($_REQUEST['hatching_ducks'])){
               $hatching_ducks = "";
          } else {
               $hatching_ducks = trim($_POST['hatching_ducks']);
          }

          //  $hatching_geese = $_POST['hatching_geese'];
          if(!isset($_REQUEST['hatching_geese'])){
               $hatching_geese = "";
          } else {
               $hatching_geese = trim($_POST['hatching_geese']);
          }

          //  $hatching_guinea_fowls = $_POST['hatching_guinea_fowls'];
          if(!isset($_REQUEST['hatching_guinea_fowls'])){
               $hatching_guinea_fowls = "";
          } else {
               $hatching_guinea_fowls = trim($_POST['hatching_guinea_fowls']);
          }

          //  $hatching_quails = $_POST['hatching_quails'];
          if(!isset($_REQUEST['hatching_quails'])){
               $hatching_quails = "";
          } else {
               $hatching_quails = trim($_POST['hatching_quails']);
          }

          //  $hatching_ostrich = $_POST['hatching_ostrich'];
          if(!isset($_REQUEST['hatching_ostrich'])){
               $hatching_ostrich = "";
          } else {
               $hatching_ostrich = trim($_POST['hatching_ostrich']);
          }




            //source of eggs by the hatcher
            //  $imported_eggs = $_POST['imported_eggs'];
            if(!isset($_REQUEST['imported_eggs'])){
                 $imported_eggs = "";
            } else {
                 $imported_eggs = trim($_POST['imported_eggs']);
            }

            //$other_local_farms = $_POST['other_local_farms'];
            if(!isset($_REQUEST['other_local_farms'])){
                 $other_local_farms = "";
            } else {
                 $other_local_farms = trim($_POST['other_local_farms']);
            }

            //$out_growers = $_POST['out_growers'];
            if(!isset($_REQUEST['out_growers'])){
                 $out_growers = "";
            } else {
                 $out_growers = trim($_POST['out_growers']);
            }

            //$owns_breeder_farm = $_POST['owns_breeder_farm'];
            if(!isset($_REQUEST['owns_breeder_farm'])){
                 $owns_breeder_farm = "";
            } else {
                 $owns_breeder_farm = trim($_POST['owns_breeder_farm']);
            }


            //hatchery Capacity
            $total_incubator_capacity = trim($_POST['total_incubator_capacity']);
            $total_hatcher_capacity = trim($_POST['total_hatcher_capacity']);

             //
             $websiteurl = trim($_POST['websiteurl']);
             $contact_person = trim($_POST['contact_person']);
             $country = trim($_POST['country']);
             $region = trim($_POST['region']);
             $district = trim($_POST['district']);
             $address = trim($_POST['address']);
             $pobox = trim($_POST['pobox']);
            // $phonenumber = $_POST['phonenumbers'];

            //validations
            $fields_required= array("contact_email", "owners_full_name", "password", "hatchery_manager", "contact_person");
            foreach($fields_required as $field){
              $value = trim($_POST[$field]);
              if(!has_presence($value)){

                $message = "<div class=\"alert alert-danger\" role=\"alert\">
                  <strong>Oh snap!</strong> <a href=\"#\" class=\"alert-link\">Change a few things up</a> and try submitting again.
                </div>";

                 $errors[$field] = ucfirst($field) . " can't be blank";

              }
            }

            //check if the values are numeric
            $fields_required= array("vet_reg_number", "hatch_reg_number", "total_incubator_capacity", "total_hatcher_capacity");
            foreach($fields_required as $field){
              $value = trim($_POST[$field]);
              if(!is_numeric($value)){

                $message = "<div class=\"alert alert-info\" role=\"alert\">
                  <strong>Oh snap!</strong> <a href=\"#\" class=\"alert-link\">make sure values are numeric </a> and try submitting again.
                </div>";

                 $errors[$field] = ucfirst($field) . " should be numeric";

              }
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
                    $user = $db->registerUser($email, $password, $usertype, $account_status);

                    if ($user) {
                        $response["error"] = false;
                        $response["uid"] = $user["user_unique_id"];
                        $response["user"]["user_id"] = $user["user_id"];
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
                    $hatchery = $db->registerNewHatchery($user_id,
                        $owners_full_name,
                        $hatchery_name,
                        $type_of_ownership,
                        $date_established,
                        $hatch_reg_number,
                        $hatchery_manager,
                        $hatchery_veterinarian,
                        $vet_reg_number,
                        $total_incubator_capacity,
                        $total_hatcher_capacity,
                        $contact_person,
                        $country,
                        $region,
                        $district,
                        $pobox,
                        $websiteurl,
                        $address);
                    if ($hatchery) {
                        // user stored successfully
                           $response["error"] = false;
                           $response["htuid"] = $hatchery["hatchery_unique_id"];
                           $response["hatchery"]["hatchery_id"] = $hatchery["hatchery_id"];
                           $response["hatchery"]["user_id"] = $hatchery["user_id"];
                           $response["hatchery"]["hatchery_name"] = $hatchery["hatchery_name"];
                           $response["hatchery"]["date_established"] = $hatchery["date_established"];
                           $response["hatchery"]["type_of_ownership"] = $hatchery["type_of_ownership"];
                           $response["hatchery"]["hatch_reg_number"] = $hatchery["hatch_reg_number"];
                           $response["hatchery"]["hatchery_manager"] = $hatchery["hatchery_manager"];
                           $response["hatchery"]["hatchery_veterinarian"] = $hatchery["hatchery_veterinarian"];
                           $response["hatchery"]["vet_reg_number"] = $hatchery["vet_reg_number"];
                           $response["hatchery"]["country"] = $hatchery["country"];
                           $response["hatchery"]["region"] = $hatchery["region"];
                           $response["hatchery"]["district"] = $hatchery["district"];
                           $response["hatchery"]["pobox"] = $hatchery["pobox"];
                           $response["hatchery"]["address"] = $hatchery["address"];
                           $response["hatchery"]["contact_person"] = $hatchery["contact_person"];
                           $response["hatchery"]["total_incubator_capacity"] = $hatchery["total_incubator_capacity"];
                           $response["hatchery"]["total_hatcher_capacity"] = $hatchery["total_hatcher_capacity"];
                           $response["hatchery"]["websiteurl"] = $hatchery["websiteurl"];
                           $response["hatchery"]["created_at"] = $hatchery["created_at"];
                           $response["hatchery"]["updated_at"] = $hatchery["updated_at"];


                           $hatchery_id = $hatchery["hatchery_id"];
                          //insert the dynamic Fields
                          //hatchery Affiliation
                          $affiliation = $_POST['hatchery_affiliation'];

                          $newaffiliation = $db->multipleAffiliations($user_id, $hatchery_id, $affiliation);
                          $newphonenumber = $db->multiplePhoneNumber($user_id, $hatchery_id, $phoneNumber);
                          $newtypeofbreed = $db->multipleTypeOfBreedProduced($user_id, $hatchery_id, $typeofbreeds);



                         // hatchery activities/products
                         //$utility_chicks
                         if(!empty($utility_chicks)){
                           $hatched_products = $utility_chicks;
                           $newhatcheryproduct = $db->multipleHatcheryProducts($user_id, $hatchery_id, $hatched_products);
                         }
                          //insert $grandparent_stock_chicks
                         if(!empty($grandparent_stock_chicks)){
                           $hatched_products = $grandparent_stock_chicks;
                           $newhatcheryproduct = $db->multipleHatcheryProducts($user_id, $hatchery_id, $hatched_products);
                         }

                         if(!empty($parent_stock_chicks)){
                           $hatched_products = $parent_stock_chicks;
                           $newhatcheryproduct = $db->multipleHatcheryProducts($user_id, $hatchery_id, $hatched_products);
                         }

                     // hatchery breeding purposes
                     //$utility_chicks
                     if(!empty($broiler)){
                       $breed_purpose = $broiler;
                       $newhatcheryproduct = $db->multipleHatcheryBreedPurpose($user_id, $hatchery_id, $breed_purpose);
                     }
                      //insert $grandparent_stock_chicks
                     if(!empty($layers)){
                       $breed_purpose = $layers;
                       $newhatcheryproduct = $db->multipleHatcheryBreedPurpose($user_id, $hatchery_id, $breed_purpose);
                     }

                     if(!empty($dual_purpose)){
                       $breed_purpose = $dual_purpose;
                       $newhatcheryproduct = $db->multipleHatcheryBreedPurpose($user_id, $hatchery_id, $breed_purpose);
                     }

                     // hatching poultry TYPES
                     //what do you hatch
                     if(!empty($hatching_fowls)){
                       $poultry_type = $hatching_fowls;
                       $newpoultry_type = $db->regHatcheryPoultryTypes($user_id, $hatchery_id, $poultry_type);
                     }
                      //insert $hatching_turkey
                     if(!empty($hatching_turkey)){
                       $poultry_type = $hatching_turkey;
                       $newpoultry_type = $db->regHatcheryPoultryTypes($user_id, $hatchery_id, $poultry_type);
                     }
                         // insert $hatching_ducks
                     if(!empty($hatching_ducks)){
                       $poultry_type = $hatching_ducks;
                       $newpoultry_type = $db->regHatcheryPoultryTypes($user_id, $hatchery_id, $poultry_type);
                     }

                     //$utility_chicks
                     if(!empty($hatching_geese)){
                       $poultry_type = $hatching_geese;
                       $newpoultry_type = $db->regHatcheryPoultryTypes($user_id, $hatchery_id, $poultry_type);
                     }
                      //insert $hatching_guinea_fowls
                     if(!empty($hatching_guinea_fowls)){
                       $poultry_type = $hatching_guinea_fowls;
                       $newpoultry_type = $db->regHatcheryPoultryTypes($user_id, $hatchery_id, $poultry_type);
                     }

                     // insert $hatching_quails
                     if(!empty($hatching_quails)){
                       $poultry_type = $hatching_quails;
                       $newpoultry_type = $db->regHatcheryPoultryTypes($user_id, $hatchery_id, $poultry_type);
                     }
                     // insert $hatching_ostrich
                     if(!empty($hatching_ostrich)){
                       $poultry_type = $dual_purpose;
                       $newpoultry_type = $db->regHatcheryPoultryTypes($user_id, $hatchery_id, $poultry_type);
                     }


                     // hatching eggs sources
                     //$imported_eggs
                     if(!empty($imported_eggs)){
                       $egg_sources = $imported_eggs;
                       $neweggsource = $db->regHatcheryEggSources($user_id, $hatchery_id, $egg_sources);
                     }
                      //insert $other_local_farms
                     if(!empty($other_local_farms)){
                       $egg_sources = $other_local_farms;
                       $neweggsource = $db->regHatcheryEggSources($user_id, $hatchery_id, $egg_sources);
                     }

                      //insert $out_growers
                     if(!empty($out_growers)){
                       $egg_sources = $out_growers;
                       $neweggsource = $db->regHatcheryEggSources($user_id, $hatchery_id, $egg_sources);
                     }

                      // insert $owns_breeder_farm
                     if(!empty($owns_breeder_farm)){
                       $egg_sources = $owns_breeder_farm;
                       $neweggsource = $db->regHatcheryEggSources($user_id, $hatchery_id, $egg_sources);
                     }

                     // email verification link is sent here
                     $to = $user["email"];
                     $id = $user_id;
                      $verify_email= $db->smtpmailer($to,$id);
                      if($verify_email){
                        $message = "<div class=\"alert alert-success\" role=\"alert\">
                <strong>Well done!</strong> You successfully registered a new hatchery <a href=\"#\" class=\"alert-link\"> check you emails to verify this account</a>.
                </div>";
              } else {
                $message = "<div class=\"alert alert-info\" role=\"alert\">
         <strong>Email Error!</strong> <a href=\"#\" class=\"alert-link\">unable</a> to send you a verification email.
       </div>";
              }
       $message = "<div class=\"alert alert-success\" role=\"alert\">
 <strong>Well done!</strong> You successfully registered a new hatchery <a href=\"#\" class=\"alert-link\"> check you emails to verify this account</a>.
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="http://v4-alpha.getbootstrap.com/assets/js/ie10-viewport-bug-workaround.js"></script>

    <!-- Custom styles for this template -->
    <link href="http://v4-alpha.getbootstrap.com/examples/carousel/carousel.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="../../web/css/style2.css"> -->
    <link rel="stylesheet" href="../../web/css/bootstrap-datetimepicker.min.css">


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
.entry:not(:first-of-type)
{
    margin-top: 10px;
}

.glyphicon
{
    font-size: 12px;
}
    </style>
  </head>
  <body>

    <nav class="navbar navbar-default navbar-static-top">
      <a href="../index.php" class="navbar-brand">Back To Livestoka</a>
    </nav>


    <div class="container">
      <div class="starter-template">
        <h1>Hatchery Registration Area</h1>
        <!-- <p class="lead">Owner's and operators of Feed Manufactures can Register Below.<br> Please fill all the required Fields.</p> -->
      </div>
      <!--register section -->
      <section id="manufacturersReg">
        <!-- <form action="feed_manufacture_registry.php" method="post"> -->

       <?php echo $message;?>
       <?php
        echo form_errors($errors);
         ?>
        <form action="hatchery_registration.php" method="post">
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
                        <label for="hatchery_name">Hatchery Name</label>
                        <input type="text" class="form-control" id="hatchery_name" name="hatchery_name" value="<?= isset($_POST['hatchery_name']) ? $_POST['hatchery_name'] : ''; ?>" placeholder="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="formGroupExampleInput2">Type of Ownership</label>
                         <select class="form-control" id="type_of_ownership" name="type_of_ownership" value="<?= isset($_POST['type_of_ownership']) ? $_POST['type_of_ownership'] : ''; ?>">
                           <option >SELECT</option>
                           <option value="Sole">Sole Proprietorship (individual or family)</option>
                           <option value="liabilityco">Liability Company</option>
                           <option value="noneliabilityco">Non-Liability (NGO, Government, project etc)</option>
                         </select>

                      </div>
                    </div>
                  </div>

                <div class="row">
                  <div class="col-md-6">
                    <!-- <div class="form-group">
                      <label for="lblyear_established">Date of Establishment<small> (dd/mm/yy)</small></label>
                      <input type="text" class="form-control" id="year_established" onblur="yearValidation(this.value,event)" onkeypress="yearValidation(this.value,event" name="year_established"  value="<?= isset($_POST['year_established']) ? $_POST['year_established'] : ''; ?>" placeholder="">
                    </div> -->
                    <label for="lblyear_established">Date of Establishment<small> (dd/mm/yy)</small></label>
                    <div class="form-group input-group datetimepicker">
                        <input type="text" class="form-control"  id="date_established" name="date_established" value="<?= isset($_POST['date_established']) ? $_POST['date_established'] : ''; ?>">
                        <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="lblyear_established">Registration Number</label>
                      <input type="text" class="form-control" id="hatch_reg_number" name="hatch_reg_number"  value="<?= isset($_POST['hatch_reg_number']) ? $_POST['hatch_reg_number'] : ''; ?>" placeholder="">
                    </div>
                  </div>
                </div>

              <div class="form-group">
                <label for="lbl_owners_full_name">Owner's Full Name <small>(individual, corporate body, etc)</small></label>
                <input type="text" class="form-control" id="owners_full_name"  name="owners_full_name"  value="<?= isset($_POST['owners_full_name']) ? $_POST['owners_full_name'] : ''; ?>" placeholder="">
              </div>
              <div class="form-group col-md-6">
                <div class="form-group multiple-form-group" data-max=6>
                  <label for="formGroupExampleInput2">Hatchery Affiliations. <small>(e.g TPBA, TCPA, CTA, CTI)</small></label>
                  <div class="form-group input-group">
                    <input type="text" name="hatchery_affiliation[]" class="form-control">
                      <span class="input-group-btn"><button type="button" class="btn btn-default btn-add">+
                      </button></span>
                  </div>
                </div>
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
                    <label for="country">Country</label>
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
                    <select class="form-control" id="region" name="region" value="<?= isset($_POST['region']) ? $_POST['region'] : ''; ?>" placeholder="">
                    <option>SELECT</option>
                       <option>Dar es Salaam</option>
                       <option>Mwanza</option>
                       <option>Arusha</option>
                       <option>Dodoma</option>
                     </select>
                  </div>
                  <div class="form-group">
                    <label for="formGroupExampleInput2">District</label>
                    <select class="form-control" id="district" name="district" value="<?= isset($_POST['district']) ? $_POST['district'] : ''; ?>" placeholder="">
                    <option>SELECT</option>
                       <option>Kinondoni</option>
                       <option>Ilala</option>
                       <option>Temeke</option>
                       <option>Ubungo</option>
                     </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleTextarea">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="3" value="<?= isset($_POST['address']) ? $_POST['address'] : ''; ?>"></textarea>
                  </div>

                  <div class="form-group">
                    <label for="exampleTextarea">P.O.Box</label>
                    <input type="text" class="form-control" id="pobox" name="pobox" value="<?= isset($_POST['pobox']) ? $_POST['pobox'] : ''; ?>" placeholder="">
                  </div>
              <div class="form-group col-md-6">
                      <div class="form-group multiple-form-group" data-max=6>
                        <label for="formGroupExampleInput2">Office Phone Number:</label>
                        <div class="form-group input-group">
                          <input type="text" class="form-control" name="phonenumbers[]" id="phonenumbers" value="<?= isset($_POST['pobox']) ? $_POST['pobox'] : ''; ?>" >
                            <span class="input-group-btn"><button type="button" class="btn btn-default btn-add">+
                            </button></span>
                        </div>
                    </div>
                  </div>

                <div class="form-group">
                  <label for="formGroupExampleInput"><strong>Key Personnel</strong></label>
                  <hr>
                </div>

                <div class="form-group col-md-6">
                  <label for="formGroupExampleInput2">Hatchery Manager:</label>
                  <input type="text" class="form-control" id="hatchery_manager" name="hatchery_manager" value="<?= isset($_POST['hatchery_manager']) ? $_POST['hatchery_manager'] : ''; ?>" placeholder=" ">
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="hatchery_veterinarian">Hatchery Veterinarian:</label>
                      <input type="text" class="form-control" id="hatchery_veterinarian" name="hatchery_veterinarian" value="<?= isset($_POST['hatchery_veterinarian']) ? $_POST['hatchery_veterinarian'] : ''; ?>" placeholder=" ">
                    </div>
                  </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="lbl_vet_reg_number">Vet Reg Number (Individual or Corporate):</label>
                        <input type="text" class="form-control" id="vet_reg_number" name="vet_reg_number" value="<?= isset($_POST['vet_reg_number']) ? $_POST['vet_reg_number'] : ''; ?>" placeholder=" ">
                      </div>
                    </div>
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
                        <label for="lblestablishment_activities"><strong>Establishment Activities</strong></label>
                        <hr>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-6">
                            <p>Type of Hatching Activities.</p>
                            <div class="form-check">
                                <label class="customcheck" style="font-size: 18px;"> Utility Chicks
                                  <input type="checkbox" checked="checked" name="utility_chicks" value="Utility Chicks">
                                  <span class="checkmark"></span>
                                </label>
                                <label class="customcheck" style="font-size: 18px;"> Grandparent stock chicks
                                  <input type="checkbox" name="grandparent_stock_chicks" value="Grandparent Stock Chicks">
                                  <span class="checkmark"></span>
                                </label>
                                <label class="customcheck" style="font-size: 18px;"> Parent stock chicks
                                  <input type="checkbox" name="parent_stock_chicks" value="Parent Stock Chicks">
                                  <span class="checkmark"></span>
                                </label>
                            </div>
                          </div>
                          </div>
                        </div>
                    <div class="form-group">
                      <!-- <label for="formGroupExampleInput"><strong>Establishment Focus.</strong></label> -->
                      <hr>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                             <label for="formGroupExampleInput2">Breeding Purpose.<small>(*click to select)</small></label>
                            <div class="form-check">
                                <label class="customcheck" style="font-size: 18px;">Broilers
                                  <input type="checkbox" checked="checked" name="broiler" id="broiler" value="broilers">
                                  <span class="checkmark"></span>
                                </label>
                                <label class="customcheck" style="font-size: 18px;"> Layers
                                  <input type="checkbox" name="layers" id="layers" value="layers">
                                  <span class="checkmark"></span>
                                </label>
                                <label class="customcheck" style="font-size: 18px;">Dual purpose
                                  <input type="checkbox" name="dual_purpose" id="dual_purpose" value="dual purpose">
                                  <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>

                       <div class="col-md-6">
                         <div class="form-group col-md-6">
                                 <div class="form-group multiple-form-group" data-max=6>
                                   <label for="formGroupExampleInput2">Breed <small>(e.g. Cobb 500, Sasso, Kruoiler)</small></label>
                                   <div class="form-group input-group">
                                     <input type="text" name="typeofBreed[]" id="typeofBreed" class="form-control" >
                                       <span class="input-group-btn"><button type="button" class="btn btn-default btn-add">+
                                       </button></span>
                                   </div>
                               </div>
                             </div>
                           </div>
                         	</div>
                         </div>
                       </div>
                      </div>
                    </div>
                    <hr>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                             <label for="formGroupExampleInput2">Poultry Type(s) <small>(*click to select)</small></label>
                          <div class="form-check">
                              <label class="customcheck" style="font-size: 18px;">Chicken
                                <input type="checkbox" checked="checked" name="hatching_chicken" id="hatching_chicken" value="chicken">
                                <span class="checkmark"></span>
                              </label>
                              <label class="customcheck" style="font-size: 18px;"> Turkey
                                <input type="checkbox" name="hatching_turkey" id="hatching_turkey" value="turkey">
                                <span class="checkmark"></span>
                              </label>
                              <label class="customcheck" style="font-size: 18px;">Ducks
                                <input type="checkbox" name="hatching_ducks" id="hatching_ducks" value="ducks">
                                <span class="checkmark"></span>
                              </label>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-check" style="padding-top: 26px;">
                          <label class="customcheck" style="font-size: 18px;">Geese
                            <input type="checkbox" name="hatching_geese" id="hatching_geese" value="geese">
                            <span class="checkmark"></span>
                          </label>
                          <label class="customcheck" style="font-size: 18px;">Guinea fowls
                            <input type="checkbox" name="hatching_guinea_fowls" id="hatching_guinea_fowls" value="guinea_fowls">
                            <span class="checkmark"></span>
                          </label>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-check">
                          <label class="customcheck" style="font-size: 18px;">Quails
                            <input type="checkbox" name="hatching_quails" id="hatching_quails" value="quails">
                            <span class="checkmark"></span>
                          </label>
                          <label class="customcheck" style="font-size: 18px;">Ostrich
                            <input type="checkbox" name="hatching_ostrich" id="hatching_ostrich" value="ostrich">
                            <span class="checkmark"></span>
                          </label>
                          </div>
                        </div>

                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-6">
                               <label for="formGroupExampleInput2">Source of hatching eggs <small>(*click to select)</small></label>
                            <div class="form-check">
                                <label class="customcheck" style="font-size: 18px;">Import
                                  <input type="checkbox" checked="checked" name="imported_eggs" id="imported_eggs" value="import">
                                  <span class="checkmark"></span>
                                </label>
                                <label class="customcheck" style="font-size: 18px;"> Own Breeder flock farm
                                  <input type="checkbox" name="owns_breeder_farm" id="owns_breeder_farm" value="owns_breeder_farm">
                                  <span class="checkmark"></span>
                                </label>
                                <label class="customcheck" style="font-size: 18px;">Out-growers
                                  <input type="checkbox" name="out_growers" id="out_growers" value="out-growers">
                                  <span class="checkmark"></span>
                                </label>
                                <label class="customcheck" style="font-size: 18px;">Other local farms
                                  <input type="checkbox" name="other_local_farms" id="other_local_farms" value="Other_local_farms">
                                  <span class="checkmark"></span>
                                </label>
                            </div>
                          </div>
                          </div>
                        </div>

                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="formGroupExampleInput"><strong>Hatchery Capacity</strong></label>
                            <hr>
                          </div>
                        </div>
                        <div class="col-md-9">
                          <div class="form-group">
                            <label for="lbl_total_incubator_capacity">Total Incubator Capacity</label>
                            <input type="text" class="form-control" id="total_incubator_capacity" name="total_incubator_capacity" value="<?= isset($_POST['total_incubator_capacity']) ? $_POST['total_incubator_capacity'] : ''; ?>" placeholder=" ">
                          </div>
                          <div class="form-group">
                            <label for="lbltotal_hatcher_capacity">Total Hatcher Capacity</label>
                            <input type="text" class="form-control" id="total_hatcher_capacity" name="total_hatcher_capacity" value="<?= isset($_POST['total_hatcher_capacity']) ? $_POST['total_hatcher_capacity'] : ''; ?>" placeholder=" ">
                          </div>
                        </div>
                      </div>



                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="lbl_contacts_title"><strong>Contacts</strong></label>
                        <hr>
                      </div>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="formGroupExampleInput2">website</label>
                      <input type="text" class="form-control" id="websiteurl" name="websiteurl" value="<?= isset($_POST['websiteurl']) ? $_POST['websiteurl'] : ''; ?>" placeholder=" ">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="lbl_contact_person">contact person</label>
                      <input type="text" class="form-control" id="contact_person" name="contact_person" value="<?= isset($_POST['contact_person']) ? $_POST['contact_person'] : ''; ?>" placeholder=" ">
                    </div>
                     <div class="form-group col-md-6">
                       <label for="lbl_contact_email">Contact email</label>
                       <input type="email" class="form-control" id="contact_email" name="contact_email" value="<?= isset($_POST['contact_email']) ? $_POST['contact_email'] : ''; ?>" placeholder=" ">
                     </div>
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
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
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
<script>
(function ($) {
    $(function () {

        var addFormGroup = function (event) {
            event.preventDefault();

            var $formGroup = $(this).closest('.form-group');
            var $multipleFormGroup = $formGroup.closest('.multiple-form-group');
            var $formGroupClone = $formGroup.clone();

            $(this)
                .toggleClass('btn-default btn-add btn-danger btn-remove')
                .html('–');

            $formGroupClone.find('input').val('');
            $formGroupClone.insertAfter($formGroup);

            var $lastFormGroupLast = $multipleFormGroup.find('.form-group:last');
            if ($multipleFormGroup.data('max') <= countFormGroup($multipleFormGroup)) {
                $lastFormGroupLast.find('.btn-add').attr('disabled', true);
            }
        };

        var removeFormGroup = function (event) {
            event.preventDefault();

            var $formGroup = $(this).closest('.form-group');
            var $multipleFormGroup = $formGroup.closest('.multiple-form-group');

            var $lastFormGroupLast = $multipleFormGroup.find('.form-group:last');
            if ($multipleFormGroup.data('max') >= countFormGroup($multipleFormGroup)) {
                $lastFormGroupLast.find('.btn-add').attr('disabled', false);
            }

            $formGroup.remove();
        };

        var countFormGroup = function ($form) {
            return $form.find('.form-group').length;
        };

        $(document).on('click', '.btn-add', addFormGroup);
        $(document).on('click', '.btn-remove', removeFormGroup);

    });
})(jQuery);
</script>

<script>
$(document).ready(function (){
	$('.datetimepicker').datetimepicker({
    format:'L'
  });

});
</script>
<?php
include('../../includes/layouts/public_ly_footer.php');
?>
