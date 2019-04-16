<?php
        if(isset($_POST["signup"])) {

            $password = $_POST["password"];
            $repassword = $_POST["password-re"];
            /**
             * Check error
             */
            if (strlen($password) < 6 || strlen($repassword) < 6) {
                $passError = "* Your password must be have at least 6 character";
            }

            if ($password != $repassword) {
                $passError = "* Two passwords must be the same";
            }
        }


