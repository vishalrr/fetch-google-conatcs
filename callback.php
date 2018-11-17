<?php
session_start();
?>


                            <?php
                            $accesstoken = '';
                            $client_id = '792612258076-76l3g9aimdcr58f8ul67n7heutdn6m8q.apps.googleusercontent.com';
                            $client_secret = 'Y9VoflT63PZDiLMnNbPQJpcU';
                            $redirect_uri = 'http://localhost/export/callback.php';
                            $simple_api_key = 'AIzaSyB_IOM7pfIAc3OEFZZBC5LpoACPPgwJ_hg';
                            $max_results = 500;
                            $auth_code = $_GET["code"];

                            function curl_file_get_contents($url) {
                                $curl = curl_init();
                                $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';

                                curl_setopt($curl, CURLOPT_URL, $url);   //The URL to fetch. This can also be set when initializing a session with curl_init().
                                curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);    //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
                                curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);   //The number of seconds to wait while trying to connect.    

                                curl_setopt($curl, CURLOPT_USERAGENT, $userAgent); //The contents of the "User-Agent: " header to be used in a HTTP request.
                                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);  //To follow any "Location: " header that the server sends as part of the HTTP header.
                                curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE); //To automatically set the Referer: field in requests where it follows a Location: redirect.
                                curl_setopt($curl, CURLOPT_TIMEOUT, 10);   //The maximum number of seconds to allow cURL functions to execute.
                                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); //To stop cURL from verifying the peer's certificate.
                                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

                                $contents = curl_exec($curl);
                                curl_close($curl);
                                return $contents;
                            }

                            $fields = array(
                                'code' => urlencode($auth_code),
                                'client_id' => urlencode($client_id),
                                'client_secret' => urlencode($client_secret),
                                'redirect_uri' => urlencode($redirect_uri),
                                'grant_type' => urlencode('authorization_code')
                            );
                            $post = '';
                            foreach ($fields as $key => $value) {
                                $post .= $key . '=' . $value . '&';
                            }
                            $post = rtrim($post, '&');

                            $curl = curl_init();
                            curl_setopt($curl, CURLOPT_URL, 'https://accounts.google.com/o/oauth2/token');
                            curl_setopt($curl, CURLOPT_POST, 5);
                            curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
                            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                            $result = curl_exec($curl);

                            curl_close($curl);

                            $response = json_decode($result);
                            if (isset($response->access_token)) {
                                $accesstoken = $response->access_token;
                                $_SESSION['access_token'] = $response->access_token;
                            }


                            if (isset($_GET['code'])) {


                                $accesstoken = $_SESSION['access_token'];
                            }

                            if (isset($_REQUEST['logout'])) {
                                unset($_SESSION['access_token']);
                            }












                            $url = 'https://www.google.com/m8/feeds/contacts/default/full?max-results=' . $max_results . '&oauth_token=' . $accesstoken;
                            $xmlresponse = curl_file_get_contents($url);

                            if ((strlen(stristr($xmlresponse, 'Authorization required')) > 0) && (strlen(stristr($xmlresponse, 'Error ')) > 0)) {
                                echo "<h2>OOPS !! Something went wrong. Please try reloading the page.</h2>";
                                exit();
                            }

                            //echo " <a href ='http://127.0.0.1/gmail_contact/callback.php?downloadcsv=1&code=4/eK2ugUwI_qiV1kE3fDa_92geg7s1DusDsN9BHzGrrTE# '><img src='images/excelimg.jpg' alt=''id ='downcsv'/></a>";
                            // echo "<h3>Email Addresses:</h3>";
                            $xml = new SimpleXMLElement($xmlresponse);
                            $xml->registerXPathNamespace('gd', 'http://schemas.google.com/g/2005/Atom');

                            $result = $xml->xpath('//gd:email');





                            foreach ($result as $title) {
                                $arr[] = $title->attributes()->address;
                                echo $title->attributes()->displayName;
                            }
                            //print_r($arr);
                            foreach ($arr as $key) {
                                //echo $key."<br>";
                            }

                            $response_array = json_decode(json_encode($arr), true);

                            // echo "<pre>";
                            // print_r($response_array);
                            //echo "</pre>";

                            $email_list = '';
                            foreach ($response_array as $value2) {

                                $email_list = ($value2[0] . ",") . $email_list;
                            }


                            //echo $abc;
                            // $final_array[] = $abc;
                            // $farr =$final_array;
                            //echo "<pre>";
                            //print_r($final_array);
                            // echo "</pre>";
                            //<input type="text" value="<?php echo ($abc);?" name="email">
                            ?>


<html>
    <head>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
        <link href="css/table.css" rel="stylesheet" type="text/css"/>
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro|Open+Sans+Condensed:300|Raleway' rel='stylesheet' type='text/css'>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
        <title>Export Google Contacts Using PHP</title>
        <meta name="robots" content="noindex, nofollow">
        <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-43981329-1']);
        _gaq.push(['_trackPageview']);
        (function () {
        var ga = document.createElement('script');
        ga.type = 'text/javascript';
        ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(ga, s);
        })();
        </script>


    </head>
    <body>

        <div id="main" >

            <div class="col-sm-6 col-md-4 col-lg-2">
                <div id="envelope" class="col-sm-6 col-md-4 col-lg-2">

                    <header id="sign_in">
                        <h2> <form action='csvdownload.php' method='post'>
                                <input type='text' value= '<?php echo $email_list; ?>' name='email' style='display: none'>

                                <input type='image' width='100' value='submit' src='images/excelimg1.gif' alt='submit Button' id ='btnimg'>
                            </form>Export Gmail Contacts<a  href='https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://www.formget.com/tutorial/export-gmail-contacts-in-php/index.php' ><img src='images/logoutimg1.png' alt=''id ='logoutimg'/></a></h2>
                    </header>
                    <hr>
                    <div id="content" class="col-sm-6 col-md-4 col-lg-2">
                        <div class="col-sm-6 col-md-4 col-lg-2">



                            <div class="col-sm-6 col-md-4 col-lg-2">

                                <table cellspacing='0'>
                                    <thead>
                                    <td id="name">S.No</td>
                                    <td>Email Addresses</td>
                                    </thead>
<?php
$count = 0;
foreach ($result as $title) {
    ?>
                                        <tr>
                                            <td><?php echo $count;
    $count++ ?></td>
                                        <link href="style.css" rel="stylesheet" type="text/css"/>
                                        <td><?php echo $title->attributes()->address; ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                </table>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body></html>



