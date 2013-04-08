<%-- 
    Document   : index
    Created on : Apr 8, 2013, 4:35:12 PM
    Author     : enjella melissa
--%>

<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%
if (session.getAttribute("myusername")!= null){
response.sendRedirect("dashboard.jsp");
}
int status=0;
boolean message;
if (request.getParameter("status") != null){
status = Integer.parseInt(request.getParameter("status"));
message = true;
} else {
message = false;
}

//if(isset( $_SESSION['myusername'])){
//header("location:dashboard.php");
//}
//if (isset($_GET['status'])) {
//$status = $_GET['status'];
//$message = true;
//} else {
//$message = false;
//}
%>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/php; charset=utf-8" />
        <title>TUGASKU</title>
        <link rel="stylesheet" type="text/css" href="style.css" title="style1" />
        <link rel="stylesheet" type="text/css" href="style2.css" title="style2" />
        <script type="text/javascript" src="script.js"></script>
    </head>

    <body id="mainpagebackground">
        <%
        if (message = true){
            if (status == 1) {
                out.print("<div id='message'>Wrong Username or Password</div>");
            } else if (status == 2){
                out.print("<div id='message'>You have successfully logged out</div>");
            } else if (status == 3){
                out.print("<div id='message'>You need to be logged in</div>");
            } else if (status == 4){
                out.print("<div id='message'>You have successfully registered</div>");
            }
        }
        
        //<?php
        //if ($message == true) {
        //if ($status == 1) echo '<div id="message">Wrong Username or Password</div>';
        //else if ($status == 2) echo '<div id="message">You have successfully logged out</div>';
        //else if ($status == 3) echo '<div id="message">You need to be logged in</div>';
        //else if ($status == 4) echo '<div id="message">You have successfully registered</div>';
        //}
        //?>
        %>
        <div id="wrapper">

            <div id="header">
                <div id="logo">
                    <img src="images/logo.png" alt="Logo" width="300" height="100" />
                </div>
                <div id="tagline">Why do it today if you can do it tomorrow?</div>

                <ul>
                    <div id="signin"><a href="javascript:loginMenu();"><img src="images/login.png" alt="Log In" /></a></div>
                </ul>
                <!--buat munculin popupbox nih-->
                <div id ="droplogin">
                    <form action="login.php" method="post">
                        <div class="popuplogin">
                            Username &nbsp;:
                            <input type ="text" name="inputusername" size ="14" id = "usernameku" autocomplete="on"/>
                            <br />
                            Password &nbsp; :
                            <input type ="password" name="inputpass" size ="14" id = "passwordku" autocomplete="on"/>
                            <br />

                            <br />
                        </div>
                        <input type="submit" value="login" name="submit"/>
                    </form>
                </div>
                <div>
                </div>

                <div id="menu">
                </div>
            </div>
            <div id ="maincontainer">
                <div id="main">
                    <div id="konten">
                        <div class="atas">
                        </div>
                        <div class="tengah">
                            <div class="judul">
                                SIGN UP
                            </div>
                            <div class="isi">
                                <form enctype="multipart/form-data" action="register.php" method="post">
                                    <div class="register-label btg-mrh" id="btg">*) wajib diisi</div>
                                    <div class="clear"></div>
                                    <div class="register-label">Username <span class="btg-mrh">*</span></div><div class="register-td">:</div><div class="register-input"><input class="register-input-input" type="text" name="username" id="form-username" onkeyup="validate()" /></div>
                                    <div class="clear" id="error-username"></div>
                                    <div class="register-label">Password <span class="btg-mrh">*</span></div><div class="register-td">:</div><div class="register-input"><input class="register-input-input" type="password" name="password" id="form-password" onkeyup="validate()" /></div>
                                    <div class="clear" id="error-password"></div>
                                    <div class="register-label">Confirm password <span class="btg-mrh">*</span></div><div class="register-td">:</div><div class="register-input"><input class="register-input-input" type="password" name="cpass" id="form-cpass" onkeyup="validate()" /></div>
                                    <div class="clear" id="error-cpass"></div>
                                    <div class="register-label">Nama lengkap <span class="btg-mrh">*</span></div><div class="register-td">:</div><div class="register-input"><input class="register-input-input" type="text" name="nama" id="form-nama" onkeyup="validate()" /></div>
                                    <div class="clear" id="error-nama"></div>
                                    <div class="register-label">Tanggal lahir <span class="btg-mrh">*</span></div><div class="register-td">:</div><div class="register-input"><input class="register-input-input" type="text" name="tgl" id="form-tgl" onkeyup="validate()" /></div><div id="caldad"><div id="calendar"></div><a href="javascript:showcal(2,2012);void(0);"><img src="images/cal.gif" alt="Calendar" /></a></div>
                                    <div class="clear" id="error-tgl"></div>
                                    <div class="register-label">Email <span class="btg-mrh">*</span></div><div class="register-td">:</div><div class="register-input"><input class="register-input-input" type="text" name="email" id="form-email" onkeyup="validate()" /></div>
                                    <div class="clear" id="error-email"></div>
                                    <div class="register-label">Avatar <span class="btg-mrh">*</span></div><div class="register-td">:</div><div class="register-input"><input class="register-input-input" type="file" name="avatar" id="form-avatar" onchange="validate()" /></div>
                                    <div class="clear" id="error-avatar"></div>
                                    <div class="register-label">Jenis kelamin <span class="btg-mrh">*</span></div><div class="register-td">:</div><div class="register-input"><input type="radio" name="sex" value="male" id="form-male" onclick="validate()" /> Male <input type="radio" name="sex" value="female" id="form-female" onclick="validate()" /> Female</div>
                                    <div class="clear" id="error-sex"></div>
                                    <div class="register-label">About me</div><div class="register-td">:</div><div class="register-input"><textarea class="register-input-input" name="about" rows="5" cols="50"></textarea></div>
                                    <div class="clear"></div>
                                    <div class="register-submit"><input type="submit" name="register" value="Daftar" disabled="disabled" id="form-button"/></div>
                                </form>
                            </div>
                        </div>
                        <div class="bawah">
                        </div>
                    </div>

                </div>
                <div class="pss_main"> <!-- main parallax scrolling slider object -->
                    <input id="r_1" type="radio" name="p" class="sel_page_1" checked="checked" /> <!-- hidden radios -->
                    <input id="r_2" type="radio" name="p" class="sel_page_2" />
                    <input id="r_3" type="radio" name="p" class="sel_page_3" />
                    <input id="r_4" type="radio" name="p" class="sel_page_4" />

                    <label for="r_1" class="pss_contr c1"></label> <!-- controls -->
                    <label for="r_2" class="pss_contr c2"></label>
                    <label for="r_3" class="pss_contr c3"></label>
                    <label for="r_4" class="pss_contr c4"></label>

                    <div class="pss_slides">
                        <div class="pss_background"></div>
                        <ul> <!-- slides -->
                            <li>
                                <img src="images/sc1.png" alt="First Function" width="400" height="300"/>
                                <div>Mengatur Jadwal</div>
                            </li>
                            <li>
                                <img src="images/sc2.png" alt="Second Function" width="400" height="300"/>
                                <div>Lihat Profile</div>
                            </li>
                            <li>
                                <img src="images/sc3.png" alt="Third Function" width="400" height="300"/>
                                <div>Memberi Komentar</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="footer">
                <div id="little">
                </div>
                <div id="siteinfo">
                    &copy; 2013. Sukasukaguelah.<br />
                    Hak cipta dilindung oleh Gue.
                </div>
                <div id="botlink">

                </div>
            </div>
        </div>
        <script type="text/javascript" src="mainpage.js"></script>
    </body>
</html>
